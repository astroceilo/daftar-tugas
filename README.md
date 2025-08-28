Aplikasi Daftar Tugas Sederhana
Aplikasi ini adalah daftar tugas sederhana yang dibuat menggunakan CodeIgniter 4, MySQL, Ajax, dan DataTables. Aplikasi ini memungkinkan pengguna untuk membuat, melihat, mengedit, dan menghapus tugas.

Fitur Aplikasi

- Halaman Utama: Menampilkan daftar tugas dalam bentuk tabel interaktif menggunakan library DataTables. Setiap tugas memiliki judul, status (selesai/belum selesai), dan tombol aksi. Kolom status ditandai secara visual dengan kotak centang (checkbox).
- Tambah Tugas: Pengguna dapat menambahkan tugas baru melalui sebuah formulir yang hanya membutuhkan input judul tugas. Fitur
- Ajax digunakan untuk menyimpan tugas baru tanpa perlu memuat ulang halaman.
- Edit Tugas: Pengguna dapat mengedit tugas yang sudah ada melalui form yang dapat mengubah judul dan status tugas.
- Hapus Tugas: Terdapat fungsi untuk menghapus tugas dari daftar.
- Pembaruan Status dengan Ajax: Status tugas (selesai/belum selesai) dapat diperbarui secara dinamis menggunakan Ajax tanpa me-refresh halaman.

Teknologi yang Digunakan

- Framework: CodeIgniter 4
- Database: MySQL
- Libraries :
  - DataTables: Untuk menampilkan data tugas dalam format tabel yang dinamis.
  - Ajax: Untuk operasi CRUD (Create, Read, Update, Delete) yang dinamis tanpa memuat ulang halaman.
- Template: Penggunaan template dashboard seperti AdminLTE atau Sb Admin untuk tampilan.
- Lainnya: JavaScript dan jQuery digunakan untuk menangani permintaan Ajax dan memperbarui tampilan secara dinamis.

Struktur Database
Aplikasi ini menggunakan database MySQL. Silakan buat tabel bernama tasks dengan kolom-kolom berikut:

- id: int, auto_increment, primary key
- judul: varchar
- status: tinyint (0 untuk belum selesai, 1 untuk selesai)

Cara Pemasangan

1. Pastikan Anda telah menginstal framework CodeIgniter 4 dan mengatur koneksi database MySQL di file konfigurasi.
2. Lakukan kloning (clone) repositori ini ke dalam direktori lokal Anda.
3. Impor struktur tabel tasks ke database MySQL Anda.
4. Jalankan aplikasi melalui server lokal Anda.

Penggunaan

- Halaman utama akan menampilkan semua tugas yang tersimpan di database.
- Gunakan modal tambah tugas untuk memasukkan tugas baru.
- Gunakan tombol aksi yang tersedia di setiap baris tabel untuk mengedit atau menghapus tugas.
- Klik pada checkbox untuk mengubah status tugas menjadi selesai atau belum selesai secara instan.
