function initProducts() {
  return {
    categories: [],
    sub_categories: [],
    menus: ['Products', 'Category'],
    activeMenu: 'Products',

    async init() {
      await this.getCategoriesApi();
      await this.getSubCategoriesApi();
    },

    async getCategoriesApi() {
      const response = await fetch('/api/product/categories');
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      localStorage.setItem('pos_product_categories', JSON.stringify(await response.json()));
      this.categories = JSON.parse(localStorage.getItem('pos_product_categories'));
    },

    async getSubCategoriesApi() {
      const response = await fetch('/api/product/subcategories');
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      localStorage.setItem('pos_product_subcategories', JSON.stringify(await response.json()));
    },

    getSubCategories(categoryId) {
      if (localStorage.getItem('pos_product_subcategories')) {
        let subCategories = JSON.parse(localStorage.getItem('pos_product_subcategories'));
        subCategories = subCategories.filter(sub => sub.category_id == categoryId);
        this.sub_categories = subCategories;
        return subCategories;
      }
    },

    datatableListProduct() {
      return {
        filters: { name: '', category: '', price: '', sub_category: '' },
        rows: [],
        currentPage: 1,
        totalPages: 1,
        sortField: 'id',
        sortDirection: 'asc',
        stockOutCount: 0,
        subCategories: [],
        isStockOut: false,

        loadData() {
          const params = new URLSearchParams({
            name: this.filters.name,
            category: this.filters.category,
            sub_category: this.filters.sub_category,
            price: this.filters.price,
            page: this.currentPage,
            sort: this.sortField,
            direction: this.sortDirection,
            stock_out: this.isStockOut
          });

          fetch(`/api/products-datatable?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
              this.rows = data.data;
              this.currentPage = data.current_page;
              this.totalPages = data.last_page;
              this.stockOutCount = data.stock_out;
            });
        },

        setCategory(text, value) {
          this.subCategories = initProducts().getSubCategories(value);
          this.filters.category = !value ? '' : text;
          this.filters.sub_category = !value ? '' : this.filters.sub_category;
          this.currentPage = 1;
          this.loadData();
        },

        setSubCategory(value) {
          this.filters.sub_category = value === 'All' ? '' : value;
          this.currentPage = 1;
          this.loadData();
        },

        setFilterStockOut() {
          this.isStockOut = this.isStockOut === false ? true : false;
          this.currentPage = 1;
          this.loadData();
        },

        sortBy(field) {
          if (this.sortField === field) {
            this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
          } else {
            this.sortField = field;
            this.sortDirection = 'asc';
          }
          this.loadData();
        },

        changePage(page) {
          if (page >= 1 && page <= this.totalPages) {
            this.currentPage = page;
            this.loadData();
          }
        }
      }
    },
    editProductModal() {
      return {
        isOpen: false,
        product: {
          id: '',
          name: '',
          price: '',
          stock: '',
          category_id: '',
          category_name: '',
          sub_category_id: '',
          sub_category_name: '',
          image: '',
        },
        sub_categories: [],
        category_id: '',
        sub_category_id: '',
        previewUrl: '',
        responseMessage: false,

        open(productId) {
          this.isOpen = true;
          fetch(`/api/product`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrf_token,
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: productId })
          })
            .then(res => res.json())
            .then(data => {
              this.product = { ...data };
              this.category_id = data.category_id;
              this.sub_category_id = data.sub_category_id;
              this.sub_categories = initProducts().getSubCategories(this.product.category_id);
              this.previewUrl = `/assets/images/products/${data.image}`;
            });
        },

        close() {
          this.isOpen = false;
          this.reset();
          this.sub_categories = [];
        },

        reset() {
          this.product = { id: '', name: '', price: '', stock: '', image: '', category_name: '', sub_category_name: '' };
          this.previewUrl = '';
          this.responseMessage = false;
        },

        previewImage(event) {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = (e) => this.previewUrl = e.target.result;
            reader.readAsDataURL(file);
          } else {
            this.previewUrl = '';
          }
        },

        setCategoryId(category_id) {
          this.sub_categories = initProducts().getSubCategories(category_id);
          this.product.category_id = category_id;
        },

        setSubCategoryId(sub_category_id) {
          this.product.sub_category_id = sub_category_id;
        },

        submitForm() {
          const formData = new FormData();
          for (const key in this.product) {
            formData.append(key, this.product[key]);
          }
          const fileInput = this.$refs?.imageInput || document.querySelector('input[type="file"]');

          if (fileInput?.files?.[0]) {
            formData.append('image', fileInput.files[0]);
          }

          fetch(`/api/product/update`, {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrf_token
            },
            body: formData,
          })
            .then(response => {
              if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
              }
              return response.json();
            })
            .then(data => {
              if (data.success) {
                Swal.fire('Berhasil!', 'Produk berhasil diperbarui.', 'success');
                Alpine.store('datatableListProduct')?.loadData();
                this.close();
              } else {
                Swal.fire('Gagal!', data.message || 'Terjadi kesalahan saat memperbarui produk.', 'error');
              }
            })
            .catch(error => {
              console.error('Error updating product:', error);
              Swal.fire('Gagal!', 'Terjadi kesalahan saat memperbarui produk.', 'error');
            });
        },


        deleteProduct() {
          showSweetAlert('dialog', 'Apakah Anda yakin?', 'Produk ini akan dihapus secara permanen!', 'warning', 'Ya, hapus!', 'Batal')
            .then((result) => {
              if (result.isConfirmed) {
                fetch(`/api/product/delete`, {
                  method: 'DELETE',
                  headers: {
                    'X-CSRF-TOKEN': csrf_token,
                    'Content-Type': 'application/json'
                  },
                  body: JSON.stringify({ id: this.product.id })
                })
                  .then(res => res.json())
                  .then(data => {
                    if (data.success) {
                      Swal.fire('Terhapus!', 'Produk telah dihapus.', 'success');
                      Alpine.store('datatableListProduct').loadData();
                      this.close();
                    } else {
                      Swal.fire('Gagal!', 'Gagal menghapus produk.', 'error');
                    }
                  });
              }
            });
        }
      };
    }
  }
}
