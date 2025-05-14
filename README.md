# 🛒 Web POS - Laravel + Vite + Alpine.js + Tailwind CSS

Aplikasi Point of Sale (POS) berbasis website yang dibangun menggunakan Laravel sebagai backend framework, dipadukan dengan Vite untuk asset bundling, Alpine.js untuk interaktivitas ringan di sisi frontend, dan Tailwind CSS untuk styling yang modern dan responsif.

## ✨ Fitur Utama

- Manajemen produk (CRUD)
- Kategori dan stok barang
- Transaksi penjualan dengan sistem keranjang
- Riwayat penjualan dan laporan sederhana
- Antarmuka responsif dan ringan
- Navigasi cepat tanpa reload penuh (SPA-feel dengan Alpine.js)

## 🛠️ Stack Teknologi

- **Laravel** - Backend dan REST API
- **Vite** - Modul bundler modern dan cepat
- **Alpine.js** - Interaktivitas ringan tanpa framework besar
- **Tailwind CSS** - Utility-first styling
- **MySQL** - Penyimpanan data

## 🚀 Instalasi

```bash
git clone https://github.com/adefathudin/pos-web.git
cd nama-repo
composer install
npm install && npm run dev
cp .env.example .env
php artisan key:generate
