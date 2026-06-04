# sistemperpustakaan_RPL
## Fitur Utama (Main Features)

# 1. Sistem Autentikasi Multi-Role
-Memisahkan hak akses antara Admin dan Anggota.
-Portal login yang berbeda untuk menjaga keamanan dan fokus pengalaman pengguna.
-Fitur registrasi mandiri bagi pengunjung yang ingin menjadi anggota.

# 2. Manajemen Katalog Buku (CRUD + Gambar)
-Admin dapat mengelola (Tambah, Edit, Hapus) data buku.
-Mendukung pengunggahan gambar cover buku untuk meningkatkan visualisasi katalog.
-Fitur pencarian buku berdasarkan judul atau penulis untuk memudahkan anggota.

# 3. Manajemen Keanggotaan Terintegrasi
-Admin dapat mengelola data anggota secara langsung.
-Integrasi Otomatis: Setiap kali Admin menambah anggota baru, sistem secara otomatis membuatkan -akun user agar anggota tersebut bisa langsung login.

# 4. Dashboard Statistik
-Ringkasan data berupa jumlah total buku dan jumlah anggota yang terdaftar yang ditampilkan secara real-time di halaman utama Admin.

# 5. Histori Peminjaman Mandiri
-Anggota dapat memantau buku apa saja yang sedang dipinjam, tanggal jatuh tempo, serta status pengembalian melalui halaman histori pribadi.

## Fitur Unggulan (Premium Features)
# 1. Alur Kerja Reservasi Digital (Pending Approval)
-Fitur ini memungkinkan anggota melakukan "booking" buku secara online.
-Data masuk ke Admin dalam status Pending. Admin memiliki kendali penuh untuk memverifikasi dan menyetujui reservasi tersebut sebelum buku benar-benar diserahkan (status berubah jadi Dipinjam).

# 2. Manajemen Stok Real-Time (Auto-Inventory)
-Sistem secara cerdas akan mengurangi stok buku otomatis saat peminjaman disetujui dan menambah -kembali stok saat buku dikembalikan.
-Buku yang stoknya habis akan secara otomatis tidak bisa di-reservasi oleh anggota.

# 3. Kalkulasi Denda Otomatis (Smart Fine System)
-Sistem menghitung keterlambatan secara otomatis berdasarkan perbandingan tanggal kembali dengan tanggal jatuh tempo (7 hari dari peminjaman)
-Menampilkan estimasi denda (Rp 2.000/hari) secara transparan baik kepada Admin maupun Anggota.

# 4. Proteksi Keamanan Data (SQL Injection Prevention)
-Setiap input data telah melewati fungsi filtrasi clean() yang menggunakan mysqli_real_escape_string, sehingga sistem lebih aman dari ancaman manipulasi database melalui form.
