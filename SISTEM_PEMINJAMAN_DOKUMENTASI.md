# 📚 SISTEM PEMINJAMAN BUKU - DOKUMENTASI IMPLEMENTASI

## 📋 Ringkasan

Sistem peminjaman buku telah berhasil diimplementasikan untuk aplikasi perpustakaan. Admin dapat mengelola data peminjaman buku, termasuk pencatatan peminjaman, pengembalian, dan tracking status peminjaman (aktif, dikembalikan, terlambat).

## 🎯 Fitur Utama yang Diimplementasikan

### 1. **Manajemen Data Peminjaman**

-   ✅ Tambah peminjaman baru
-   ✅ Lihat daftar semua peminjaman
-   ✅ Edit data peminjaman
-   ✅ Lihat detail peminjaman
-   ✅ Hapus data peminjaman
-   ✅ Kembalikan buku (mark as returned)

### 2. **Filter & Pencarian**

-   Filter berdasarkan status (Peminjaman, Dikembalikan, Terlambat)
-   Statistik real-time di halaman utama

### 3. **Manajemen Stok Otomatis**

-   Stok buku berkurang saat ada peminjaman baru
-   Stok buku bertambah saat buku dikembalikan

### 4. **Tracking Status Otomatis**

-   Status berubah menjadi "terlambat" jika melewati due date
-   Perhitungan hari keterlambatan

## 📁 File-File yang Dibuat/Dimodifikasi

### Model

-   **`app/Models/Loan.php`** - Model untuk tabel loans dengan relationships
-   **`app/Models/User.php`** - Ditambahkan relationship loans()
-   **`app/Models/Book.php`** - Ditambahkan relationship loans()

### Controller

-   **`app/Http/Controllers/LoanController.php`** - Full CRUD operations untuk peminjaman

### Database

-   **`database/migrations/2026_01_15_000000_create_loans_table.php`** - Migration untuk membuat tabel loans

### Routes

-   **`routes/web.php`** - Ditambahkan route resource dan custom route untuk return

### Views

-   **`resources/views/admin/loans/index.blade.php`** - Daftar peminjaman dengan statistik dan filter
-   **`resources/views/admin/loans/create.blade.php`** - Form tambah peminjaman baru
-   **`resources/views/admin/loans/edit.blade.php`** - Form edit data peminjaman
-   **`resources/views/admin/loans/show.blade.php`** - Detail lengkap satu peminjaman

### Navigation

-   **`resources/views/components/sidebar.blade.php`** - Ditambahkan link ke "Kelola Peminjaman"
-   **`resources/views/admin.blade.php`** - Ditambahkan button "Tambah Peminjaman" dan "Kelola Peminjaman"

## 🗄️ Struktur Tabel Loans

```sql
CREATE TABLE loans (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    book_id BIGINT UNSIGNED NOT NULL,
    loan_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE NULL,
    status ENUM('peminjaman', 'dikembalikan', 'terlambat') DEFAULT 'peminjaman',
    notes TEXT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE
);
```

## 🌐 Route API

### Kelola Peminjaman

| Metode | Route                        | Nama                | Fungsi                 |
| ------ | ---------------------------- | ------------------- | ---------------------- |
| GET    | `/admin/loans`               | admin.loans.index   | Daftar peminjaman      |
| GET    | `/admin/loans/create`        | admin.loans.create  | Form tambah            |
| POST   | `/admin/loans`               | admin.loans.store   | Simpan peminjaman baru |
| GET    | `/admin/loans/{loan}`        | admin.loans.show    | Detail peminjaman      |
| GET    | `/admin/loans/{loan}/edit`   | admin.loans.edit    | Form edit              |
| PUT    | `/admin/loans/{loan}`        | admin.loans.update  | Update peminjaman      |
| DELETE | `/admin/loans/{loan}`        | admin.loans.destroy | Hapus peminjaman       |
| PUT    | `/admin/loans/{loan}/return` | admin.loans.return  | Kembalikan buku        |

## 📱 Interface Layout

### Halaman Daftar Peminjaman

-   Header dengan tombol "Tambah Peminjaman"
-   3 Statistik card (Aktif, Terlambat, Dikembalikan)
-   Filter berdasarkan status
-   Tabel peminjaman dengan kolom:
    -   No., Peminjam, Buku, Tanggal Pinjam, Tenggat, Dikembalikan, Status, Aksi

### Halaman Tambah Peminjaman

-   Form dengan field:
    -   Pilih Peminjam (dari daftar pengunjung)
    -   Pilih Buku (hanya buku dengan stok > 0)
    -   Tanggal Peminjaman (default hari ini)
    -   Tanggal Tenggat (default 7 hari dari peminjaman)
    -   Catatan (optional)

### Halaman Edit Peminjaman

-   Form edit dengan field:
    -   Peminjam (read-only)
    -   Buku (read-only)
    -   Tanggal Peminjaman
    -   Tanggal Tenggat
    -   Tanggal Pengembalian
    -   Status
    -   Catatan

### Halaman Detail Peminjaman

-   Informasi lengkap peminjaman
-   Status badge dengan warna berbeda
-   Informasi peminjam (Nama, NPM, Email, Role)
-   Informasi buku (Cover, Judul, Penulis, ISBN, Penerbit)
-   Tanggal & durasi peminjaman
-   Info pengembalian (jika sudah dikembalikan)
-   Tombol aksi (Edit, Kembalikan, Kembali)

## 🔐 Keamanan & Validasi

### Proteksi Akses

-   Semua halaman memerlukan autentikasi (middleware `auth`)
-   Admin hanya dari role 'admin'
-   Peminjam hanya dari role 'pengunjung'

### Validasi Input

-   User ID harus valid dan ada di database
-   Book ID harus valid dan ada di database
-   Book harus memiliki stok > 0
-   Due date harus >= loan date
-   Return date harus >= loan date

### Validasi Bisnis

-   Stok otomatis dihitung
-   Status otomatis update jika overdue
-   Hari keterlambatan dihitung otomatis

## 📊 Statistik & Laporan

Halaman Daftar Peminjaman menampilkan:

-   **Peminjaman Aktif**: Jumlah peminjaman dengan status 'peminjaman'
-   **Terlambat**: Jumlah peminjaman dengan status 'terlambat'
-   **Dikembalikan**: Jumlah peminjaman dengan status 'dikembalikan'

## 🎨 Template & Styling

-   Menggunakan **Tailwind CSS** untuk styling
-   Menggunakan **Font Awesome 6.4.0** untuk icons
-   Responsive design (mobile-first)
-   Consistent dengan design admin panel yang sudah ada
-   Color scheme: Slate, Blue, Amber, Green, Red

## 🚀 Cara Menggunakan

### 1. Akses Dashboard Admin

```
http://localhost/Tugas_Akhir/Perpustakaan/public/admin
```

### 2. Navigasi ke Kelola Peminjaman

-   Klik link "Kelola Peminjaman" di sidebar
-   Atau klik tombol "Kelola Peminjaman" di dashboard

### 3. Tambah Peminjaman

-   Klik tombol "Tambah Peminjaman"
-   Pilih peminjam dari daftar pengunjung
-   Pilih buku yang tersedia
-   Atur tanggal peminjaman dan tenggat
-   Tambahkan catatan jika diperlukan
-   Klik "Simpan Peminjaman"

### 4. Lihat Detail Peminjaman

-   Klik icon mata (👁️) di kolom Aksi
-   Melihat informasi lengkap peminjaman

### 5. Edit Peminjaman

-   Klik icon pensil (✏️) di kolom Aksi
-   Ubah data sesuai kebutuhan
-   Klik "Simpan Perubahan"

### 6. Kembalikan Buku

-   Dari halaman daftar: Klik icon undo (↩️)
-   Dari halaman detail: Klik tombol "Kembalikan Buku"
-   Konfirmasi, dan status akan berubah ke "Dikembalikan"
-   Stok buku otomatis bertambah

### 7. Hapus Peminjaman

-   Klik icon tempat sampah (🗑️)
-   Konfirmasi penghapusan
-   Data akan dihapus dari sistem

## 🔍 Troubleshooting

### Jika Tabel Tidak Muncul

```bash
cd c:\xampp\htdocs\Tugas_Akhir\Perpustakaan
php artisan migrate
```

### Jika Route Tidak Ditemukan

```bash
php artisan route:clear
php artisan cache:clear
```

### Jika Ada Error di Controller

```bash
php -l app/Http/Controllers/LoanController.php
```

## 📝 Testing Checklist

-   [ ] Migration berhasil dibuat (tabel loans muncul di database)
-   [ ] Route tercatat dengan benar
-   [ ] Sidebar link berfungsi
-   [ ] Bisa membuka halaman daftar peminjaman
-   [ ] Bisa menambah peminjaman baru
-   [ ] Bisa melihat detail peminjaman
-   [ ] Bisa edit peminjaman
-   [ ] Bisa kembalikan buku
-   [ ] Bisa hapus data peminjaman
-   [ ] Status otomatis berubah terlambat
-   [ ] Stok buku otomatis berkurang/bertambah
-   [ ] Filter status berfungsi dengan baik

## 📌 Catatan Penting

1. **Peminjam**: Hanya user dengan role 'pengunjung' yang bisa menjadi peminjam
2. **Stok Buku**: Saat peminjaman dibuat, stok buku otomatis berkurang 1
3. **Pengembalian**: Saat buku dikembalikan, stok otomatis bertambah 1
4. **Overdue Tracking**: System otomatis menandai peminjaman sebagai 'terlambat' jika sudah lewat due date
5. **Catatan**: Field catatan opsional untuk mencatat informasi tambahan

## 🎓 Teknologi yang Digunakan

-   **Laravel 11** - Framework PHP
-   **Blade Templating** - Template engine
-   **Eloquent ORM** - Database ORM
-   **Tailwind CSS 3** - Utility-first CSS framework
-   **Font Awesome 6** - Icon library
-   **MySQL** - Database

---

**Terakhir diupdate**: 15 Januari 2026
**Status**: ✅ Siap Digunakan
