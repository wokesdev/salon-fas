## Aplikasi Sistem Informasi Akuntansi Salon Berbasis Web

### Silakan ikuti langkah-langkah di bawah ini untuk menginstall aplikasi ini pada server kalian.

Instal semua packages dengan menggunakan composer, jika belum pernah menginstal composer, bisa download di https://getcomposer.org.

    composer install
    
Salin file `.env.example`, lalu paste di folder yang sama, kemudian ganti nama file-nya menjadi `.env`.

Edit file `.env` tersebut dan gantilah `APP_*`, `DB_*`, dan `MAIL_*` sesuai kebutuhan.

Setelah itu, buat key baru untuk aplikasi ini.

    php artisan key:generate
    
Terakhir, migrasikan seluruh tabel ke database-mu sesuai yang telah diatur di `.env` sebelumnya.

    php artisan migrate
    
Setelah selesai, aplikasi sudah dapat digunakan dengan mengakses folder `public`.

##
### Di bawah ini adalah detail dari aplikasi ini.

**Framework PHP: Laravel 8**<br>
**Database: MySQL**<br>
**Front-End Template: Atlantis Lite Bootstrap Dashboard**

Library:
1. jQuery 3.2.1
2. Bootstrap 4
3. Yajra DataTables
4. SweetAlert

Fitur:
1. Multilevel user
2. Master data lengkap
3. CRUD dengan AJAX
4. Insert nomor rincian akuntansi otomatis berdasarkan nomor akuntansi yang dipilih
5. Insert kode supplier dan kode pelanggan otomatis
6. Transaksi berdasarkan ketentuan akuntansi
7. Laporan

Fitur Multilevel:<br>
Level 1:
1. Dapat mengelola daftar akuntansi
2. Dapat mengelola daftar rincian akuntansi
3. Dapat mengelola data admin
4. Dapat mengelola data pelanggan
5. Dapat mengelola data supplier
6. Dapat mengelola data paket
7. Dapat mengelola transaksi pembelian
8. Dapat mengelola transaksi penjualan
9. Dapat mengelola jurnal umum
10. Dapat mengelola pengeluaran kas
11. Dapat mengelola buku besar
12. Dapat mengelola laporan pembelian
13. Dapat mengelola laporan penjualan
14. Dapat mengelola laporan laba rugi
15. Dapat mengelola laporan posisi keuangan
16. Dapat mengelola neraca saldo

Level 2:
1. Dapat mengelola transaksi pembelian
2. Dapat mengelola transaksi penjualan
3. Dapat mengelola jurnal umum
4. Dapat mengelola pengeluaran kas

Level 3:
1. Dapat mengelola buku besar
2. Dapat mengelola laporan pembelian
3. Dapat mengelola laporan penjualan
4. Dapat mengelola laporan laba rugi
5. Dapat mengelola laporan posisi keuangan
6. Dapat mengelola neraca saldo

##
***Developed by Andy Kho.***
