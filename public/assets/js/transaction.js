function initApp() {
  const app = {
    toko: {
      nama: 'PT. Toko Sukses Makmur',
      alamat: 'Jl. Raya No. 123, Jakarta, Indonesia',
      telepon: '021-12345678',
    },
    db: null,
    time: null,
    activeMenu: 'pos',
    products: [],
    keyword: "",
    cart: [],
    cash: 0,
    change: 0,
    dp: 0,
    dpPercent: 0,


    //receipt
    isShowModalReceipt: false,
    receipt_number: null,
    transaction_date: null,

    //customer
    customers: [],
    selectedCustomer: '',
    detailCustomer: [],


    async onLoad() {
      // Initialize IndexedDB

      this.getProducts();
      this.getCart();
    },

    updateCart(product, qty = 1) {

      const index = this.cart.findIndex((p) => p.id === product.id);

      if (index === -1) {

        const newItem = {
          id: product.id,
          image: product.image,
          name: product.name,
          price: product.price,
          qty: 1,
        };

        helper.saveIndexedDB('cart', newItem);
        this.cart.push(newItem);
        this.beep();

      } else {

        const afterAdd = this.cart[index].qty + qty;
        const stock = this.products.filter((p) => p.id === product.id);

        if (afterAdd > stock[0].stock) {
          return showSweetAlert('error', 'Stok tidak mencukupi', 'Stok barang tidak mencukupi', 'error');
        }

        if (afterAdd <= 0) {

          const keyToDelete = this.cart[index].id;
          helper.deleteIndexDB('cart', keyToDelete)
          this.cart.splice(index, 1);
          this.clearSound();

        } else {

          this.cart[index].qty = afterAdd;
          const updatedItem = { ...this.cart[index] };
          helper.saveIndexedDB('cart', updatedItem)
          this.beep();

        }
      }
      this.updateChange();
      this.updatePayment();
    },

    async clearCart() {
      try {
        const result = await showSweetAlert(
          'dialog',
          'Are you sure?',
          'Do you want to clear the cart?',
          'warning',
          'Yes, clear it!',
          'No, cancel!'
        );

        if (result && result.isConfirmed) {

          helper.deleteAllIndexedDB('cart')
          this.cash = 0;
          this.cart = [];
          this.receipt_number = null;
          this.transaction_date = null;
          this.updateChange();
          this.updatePayment();
          this.selectedCustomer = 0;
          this.detailCustomer = [];
          this.clearSound();
        }

      } catch (error) {
        console.error('Error in clearCart:', error);
      }
    },

    async getProducts() {
      const response = await fetch('http://localhost:8000/api/products-transaction');
      const data = await response.json();
      this.products = data;
    },

    async saveTransaction() {

      const titleBefore = document.title;
      document.title = this.receipt_number;
      window.print();
      this.isShowModalReceipt = false;
      document.title = titleBefore;

      const transaction = {
        receipt_number: this.receipt_number,
        transaction_date: this.transaction_date,
        total_price: this.getTotalPrice(),
        items: this.cart.map((item) => ({
          product_id: item.id,
          qty: item.qty,
          unit_price: item.price,
        })),
      };

      const response = await fetch('http://localhost:8000/api/transaction/save', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(transaction),
      });

      const result = await response.json();

      if (response.ok && result.status === true) {

        await showSweetAlert('success', 'Transaction saved successfully', 'Transaction has been saved successfully', 'success');
        helper.deleteAllIndexedDB('cart');
        this.cart = [];
        this.cash = 0;
        this.change = 0;
        this.receipt_number = null;
        this.transaction_date = null;
        this.selectedCustomer = 0;
        this.detailCustomer = [];
        this.isShowModalReceipt = false;
        this.updateChange();
        this.updatePayment();
        this.clearSound();
      } else {
        console.error('Transaction save failed:', result.message || 'Unknown error');
      }
    },

    async updateProducts(products) {
      for (const product of data) {
        await fetch(`http://localhost:8000/api/products/${product.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ stock: product.stock }),
        });
      }
    },

    filteredProducts() {
      const rg = this.keyword ? new RegExp(this.keyword, "gi") : null;
      return this.products.filter((p) => !rg || p.name.match(rg));
    },


    // Initialize IndexedDB and create object store if it doesn't exist
    // and get cart items from IndexedDB
    getCart() {
      const request = indexedDB.open("posDatabase", 1);
      request.onupgradeneeded = (event) => {
        const db = event.target.result;
        if (!db.objectStoreNames.contains("cart")) {
          db.createObjectStore("cart", { keyPath: "id" });
        }
      };
      request.onsuccess = (event) => {
        this.db = event.target.result;
        const tx = this.db.transaction("cart", "readonly");
        const store = tx.objectStore("cart");
        const request = store.getAll();
        request.onsuccess = (event) => {
          this.cart = event.target.result;
          this.updateChange();
          this.updatePayment();
        };
      };
      request.onerror = (event) => {
        console.error("IndexedDB initialization failed:", event.target.error);
      };

    },

    findCartIndex(product) {
      return this.cart.findIndex((p) => p.id === product.id);
    },
    addQty(item, qty) {
      const index = this.cart.findIndex((i) => i.id === item.id);
      if (index === -1) {
        return;
      }
      const afterAdd = item.qty + qty;
      if (afterAdd === 0) {
        this.cart.splice(index, 1);
        this.clearSound();
      } else {
        this.cart[index].qty = afterAdd;
        this.beep();
      }
      this.updateChange();
      this.updatePayment();
    },
    addCash(amount) {
      this.cash = (this.cash || 0) + amount;
      this.updateChange();
      this.updatePayment();
      this.beep();
    },
    getItemsCount() {
      return this.cart.reduce((count, item) => count + item.qty, 0);
    },
    updateChange() {
      this.change = this.cash - this.getTotalPrice();
    },
    updatePayment() {
      this.dp = this.cash;
      this.dpPercent = Math.round((this.cash / this.getTotalPrice()) * 100);
    },
    updateCash(value) {
      this.cash = parseFloat(value.replace(/[^0-9]+/g, ""));
      this.updateChange();
      this.updatePayment();
    },
    getTotalPrice() {
      return this.cart.reduce(
        (total, item) => total + item.qty * item.price,
        0
      );
    },
    submitable() {
      return this.change >= 0 && this.cart.length > 0;
    },
    submit() {
      const time = new Date();
      this.isShowModalReceipt = true;
      this.receipt_number = `${Math.round(time.getTime() / 1000)}`;
      this.transaction_date = this.dateFormat(time);
      // this.qrCodeGenerator(this.receipt_number);
    },
    closeModalReceipt() {
      this.isShowModalReceipt = false;
    },
    dateFormat(date) {
      const formatter = new Intl.DateTimeFormat('id', { dateStyle: 'short', timeStyle: 'medium' });
      return formatter.format(date);
    },
    numberFormat(number) {
      number = parseFloat(number).toFixed(2).slice(0, -3);
      if (typeof number === "number") {
        number = number.toFixed(0);
      }
      // return number;
      return (number || "")
        .toString()
        .replace(/^0|\./g, "")
        .replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    },
    priceFormat(number) {
      return number ? `${this.numberFormat(number)}` : `0`;
    },
    percentFormat(number) {
      return number ? `DP (${(number)}%)` : `DP`;
    },
    qrCodeGenerator(str) {
      JsBarcode('#barcode', str, {
        width: 2,
        height: 40,
        displayValue: false
      });
    },
    clear() {
      this.cash = 0;
      this.cart = [];
      this.receipt_number = null;
      this.transaction_date = null;
      this.updateChange();
      this.updatePayment();
      this.selectedCustomer = 0;
      this.detailCustomer = [];
      this.clearSound();
    },
    clearItem(item) {
      const index = this.cart.findIndex((i) => i.id === item.id);
      this.cart.splice(index, 1);
      this.clearSound();
      this.updateChange();
      this.updatePayment();
    },
    beep() {
      this.playSound("assets/sounds/beep-29.mp3");
    },
    clearSound() {
      this.playSound("assets/sounds/button-21.mp3");
    },
    playSound(src) {
      const sound = new Audio();
      sound.src = src;
      sound.play();
      sound.onended = () => delete (sound);
    },
    printAndProceed() {
      const titleBefore = document.title;
      document.title = this.receipt_number;

      window.print();
      this.isShowModalReceipt = false;
      document.title = titleBefore;

      // this.clearCart();
    },

  };

  const helper = {
    getIndexedDB: (storeName) => {
      return new Promise((resolve, reject) => {
        const request = indexedDB.open("posDatabase", 1);
        request.onsuccess = (event) => {
          const db = event.target.result;
          const tx = db.transaction(storeName, "readonly");
          const store = tx.objectStore(storeName);
          const getRequest = store.getAll();
          getRequest.onsuccess = (event) => {
            resolve(event.target.result);
          };
          getRequest.onerror = (event) => {
            reject(event.target.error);
          };
        };
      });
    },
    saveIndexedDB(storeName, data) {
      const request = indexedDB.open("posDatabase", 1);
      request.onsuccess = async (event) => {
        const db = event.target.result;
        const tx = db.transaction(storeName, "readwrite");
        const store = tx.objectStore(storeName);
        await store.put(data);
        await tx.done;
      };
    },
    deleteIndexDB(storeName, key) {
      const request = indexedDB.open("posDatabase", 1);
      request.onsuccess = async (event) => {
        const db = event.target.result;
        const tx = db.transaction(storeName, "readwrite");
        const store = tx.objectStore(storeName);
        await store.delete(key);
        await tx.done;
      };
    },
    deleteAllIndexedDB(storeName) {
      const request = indexedDB.open("posDatabase", 1);
      request.onsuccess = async (event) => {
        const db = event.target.result;
        const tx = db.transaction(storeName, "readwrite");
        const store = tx.objectStore(storeName);
        await store.clear();
        await tx.done;
      };
    }
  }

  return app;
}
