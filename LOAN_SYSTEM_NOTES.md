# Sistem Peminjaman - Catatan Implementasi

FITUR YANG DITAMBAHKAN:

1. Model Loan - Untuk menyimpan data peminjaman buku
2. Migration - Membuat tabel 'loans' di database
3. Controller - LoanController untuk mengelola CRUD peminjaman
4. Routes - Route lengkap untuk admin peminjaman
5. Views - Interface untuk manage peminjaman (index, create, edit, show)
6. Sidebar - Link ke halaman kelola peminjaman

FIELD DALAM TABEL LOANS:

-   id: Primary key
-   user_id: Foreign key ke users table (peminjam)
-   book_id: Foreign key ke books table (buku yang dipinjam)
-   loan_date: Tanggal peminjaman
-   due_date: Tanggal tenggat pengembalian
-   return_date: Tanggal pengembalian (nullable jika belum dikembalikan)
-   status: Status peminjaman (peminjaman, dikembalikan, terlambat)
-   notes: Catatan peminjaman (optional)
-   timestamps: created_at dan updated_at

FITUR UTAMA:
✓ Tambah Peminjaman - Admin dapat menambah data peminjaman baru
✓ Lihat Daftar Peminjaman - Menampilkan semua peminjaman dengan filter status
✓ Edit Peminjaman - Mengubah data peminjaman (kecuali user dan book)
✓ Lihat Detail Peminjaman - Informasi lengkap satu peminjaman
✓ Kembalikan Buku - Tombol untuk menandai buku sebagai dikembalikan
✓ Hapus Peminjaman - Menghapus data peminjaman dari sistem
✓ Auto Status Update - Status otomatis berubah jadi 'terlambat' jika melewati due_date
✓ Stock Management - Stok buku otomatis berkurang saat peminjaman dan bertambah saat pengembalian

AKSES HALAMAN:

-   Dashboard Admin: http://localhost/Tugas_Akhir/Perpustakaan/public/admin
-   Kelola Peminjaman: http://localhost/Tugas_Akhir/Perpustakaan/public/admin/loans
-   Tambah Peminjaman: http://localhost/Tugas_Akhir/Perpustakaan/public/admin/loans/create

TEMPLATE:
Menggunakan template yang sama dengan halaman admin lainnya:

-   Sidebar navigasi
-   Header dengan judul dan aksi
-   Tailwind CSS untuk styling
-   Font Awesome untuk icons

FITUR KEAMANAN:

-   Hanya admin yang dapat mengakses (middleware 'auth')
-   Peminjam hanya dari role 'pengunjung'
-   Validasi form input
-   CSRF protection

STATUS PEMINJAMAN:

1. "peminjaman" - Buku masih dalam peminjaman
2. "dikembalikan" - Buku sudah dikembalikan tepat waktu
3. "terlambat" - Buku dikembalikan atau belum dikembalikan melebihi tenggat

STATISTIK DI HALAMAN INDEX:

-   Peminjaman Aktif: Total peminjaman dengan status 'peminjaman'
-   Terlambat: Total peminjaman dengan status 'terlambat'
-   Dikembalikan: Total peminjaman dengan status 'dikembalikan'
