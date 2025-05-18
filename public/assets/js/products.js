function initProducts() {
  return {
    categories: [],

    async init() {
      await this.getCategoriesApi();
    },

    async getCategoriesApi() {
      const response = await fetch('/api/product/categories');
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }

      localStorage.setItem('pos_product_categories', JSON.stringify(await response.json()));
      this.categories = JSON.parse(localStorage.getItem('pos_product_categories'));
    },

    datatableListProduct() {
      return {
        filters: { name: '', category: '', price: '' },
        rows: [],
        currentPage: 1,
        totalPages: 1,
        sortField: 'id',
        sortDirection: 'asc',
        stockOutCount: 0,
        isStockOut: false,
        nonCategory: 0,
        isNonCategory: false,

        loadData() {
          const params = new URLSearchParams({
            name: this.filters.name,
            category: this.filters.category,
            price: this.filters.price,
            page: this.currentPage,
            sort: this.sortField,
            direction: this.sortDirection,
            stock_out: this.isStockOut,
            non_category: this.isNonCategory,
          });

          fetch(`/api/products-datatable?${params.toString()}`)
            .then(res => res.json())
            .then(data => {
              this.rows = data.data;
              this.currentPage = data.current_page;
              this.totalPages = data.last_page;
              this.stockOutCount = data.stock_out;
              this.nonCategory = data.non_category;
            });
        },

        setCategory(text, value) {
          this.filters.category = !value ? '' : text;
          this.currentPage = 1;
          this.loadData();
        },

        setFilterStockOut() {
          this.isStockOut = this.isStockOut === false ? true : false;
          this.currentPage = 1;
          this.loadData();
        },

        setFilterNonCategory() {
          this.isNonCategory = this.isNonCategory === false ? true : false;
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
    modalsProduct() {
      return {
        isOpen: false,
        product: {
          id: '',
          name: '',
          price: '',
          stock: '',
          category_id: '',
          category_name: '',
          image: '',
        },
        category_id: '',
        previewUrl: '',
        responseMessage: false,
        modalType: '',

        open(type, productId) {
          this.modalType = type;
          this.isOpen = true;
          if (type === 'edit') {
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
                this.previewUrl = `/assets/images/products/${data.image}`;
              });

          } else if (type === 'add') {

          }
        },

        close() {
          this.isOpen = false;
          this.reset();
        },

        reset() {
          this.product = { id: '', name: '', price: '', stock: '', image: '', category_name: '' };
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
          this.product.category_id = category_id;
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

          fetch(`/api/product/save`, {
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
    },
  }
}

function initCategories() {
  return {
    data: [],
    editCategories: [],
    async init() {
      const response = await fetch(`/api/product/categories`);
      const result = await response.json();
      this.data = result;
    },
    editCategory(id) {
      this.editCategories = this.data.find(user => user.id === id);
    },

    deleteCategory(id) {
      showSweetAlert('dialog', 'Are you sure?', 'This category will be permanently deleted! And products with this category cannot be sold', 'warning', 'Yes, delete!', 'Cancel')
        .then((result) => {
          if (result.isConfirmed) {
            fetch(`/api/product/categories/delete`, {
              method: 'DELETE',
              headers: {
                'X-CSRF-TOKEN': csrf_token,
                'Content-Type': 'application/json'
              },
              body: JSON.stringify({ id: id })
            })
              .then(res => res.json())
              .then(data => {
                if (data.success) {
                  Swal.fire('Deleted!', 'Category has been deleted.', 'success');
                  this.editCategories = [];
                  this.init();
                } else {
                  Swal.fire('Failed!', 'Failed to delete category.', 'error');
                }
              });
          }
        });
    },

    submitForm() {
      const formData = new FormData();
      formData.append('id', this.editCategories.id);
      formData.append('name', this.editCategories.name);
      formData.append('description', this.editCategories.description);

      fetch(`/api/product/categories/save`, {
        method: 'POST',
        body: formData,
        headers: {
          'X-CSRF-TOKEN': csrf_token
        }
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            Swal.fire({
              title: 'Success',
              text: 'User updated successfully',
              icon: 'success',
            })
            this.editCategories = [];
            this.init();
          } else {
            Swal.fire({
              title: 'Error',
              text: data.message,
              icon: 'error',
            });
          }
        });
    }


  }
}
