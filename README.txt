WEBSITE BANOM NU (LARAVEL 12)  -  folder: websitenu_new

SUDAH SIAP PAKAI: database sudah terisi (tabel + data contoh + akun admin), .env sudah ada,
APP_KEY sudah dibuat, unggah foto tidak butuh storage:link. Tidak perlu migrate.
SATU-SATUNYA YANG HARUS ANDA SIAPKAN: folder "vendor".

CARA PAKAI (tanpa perintah, cukup File Explorer)
1. Ekstrak websitenu_new.zip ke  C:\laragon\www\  (hasilnya C:\laragon\www\websitenu_new).
2. Buka C:\laragon\www\website-nu2 , klik kanan folder "vendor" > Copy.
3. Buka C:\laragon\www\websitenu_new , klik kanan di area kosong > Paste.
4. Klik dua kali  jalankan.bat   (atau di terminal: php artisan serve).
5. Browser terbuka di http://127.0.0.1:8000

LOGIN ADMIN (tidak ada tombolnya di halaman publik)
   Alamat : http://127.0.0.1:8000/login
   Email  : admin@banom.test
   Sandi  : admin123      -> segera ganti.

DATABASE: SQLite (database/database.sqlite). MySQL tidak perlu menyala.
Untuk mengulang dari nol:  php artisan migrate:fresh --seed

PEMBARUAN: pendaftar langsung mendapat kartu anggota yang bisa diunduh (PNG) setelah mengisi form.

FITUR
   Publik : Beranda, Berita (geser + daftar + detail), Struktur (klik Banom -> pengurus), Daftar anggota.
   Admin  : Dashboard, CRUD Berita (gambar), CRUD Anggota (foto), setujui pendaftar,
            cetak kartu anggota, unduh kartu PNG.
FOTO LATAR BERANDA (opsional): public/images/hero.jpg dan public/images/banner.jpg
Foto unggahan tersimpan di public/uploads/.

CATATAN: kode belum dijalankan di komputer pembuatnya (tidak ada PHP di sana).
