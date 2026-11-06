DESIGN.md --- SIMPAULA
Sistem Informasi Manajemen Pemakaian Aula
Dokumen ini menjadi panduan desain UI/UX dan implementasi untuk
menyelaraskan proyek aplikasi pemesanan aula dengan gambar referensi
yang diberikan.
1. Tujuan Desain
Membangun antarmuka website SIMPAULA (Sistem Informasi Manajemen
Pemakaian Aula) untuk Pemerintah Provinsi Kalimantan Selatan. Desain
harus terlihat resmi, modern, rapi, mudah digunakan, dan konsisten untuk
pengguna umum maupun administrator.
Prinsip utama: - Gunakan gambar referensi sebagai arah visual, bukan
untuk menyalin teks kecil yang tidak terbaca. - Pertahankan fungsi,
route, controller, model, database, validasi, dan autentikasi yang sudah
ada di proyek. Jangan mengganti arsitektur aplikasi tanpa alasan dan
tanpa persetujuan. - Utamakan tampilan desktop seperti referensi, tetapi
tetap responsif pada tablet dan ponsel. - Seluruh label dan konten
antarmuka menggunakan Bahasa Indonesia. - Jangan membuat tombol
dekoratif yang tidak berfungsi. Setiap aksi harus terhubung ke fitur
yang sesuai.
2. Arah Visual
Identitas
- Nama aplikasi: SIMPAULA
- Kepanjangan: Sistem Informasi Manajemen Pemakaian Aula
- Instansi: Pemerintah Provinsi Kalimantan Selatan
- Tagline opsional: Aula Terlaksana, Kegiatan Berjalan, Pelayanan
  Meningkat.
Palet warna
  Penggunaan                Warna                      Kode
  Biru navy sidebar         Biru tua                   #063B78
  Biru utama                Biru pemerintahan          #075BCB
  Biru tombol/aksi          Biru terang                #0D6EFD
  Biru muda latar           Biru pucat                 #EAF4FF
  Latar halaman             Abu kebiruan sangat muda   #F4F8FC
  Permukaan/kartu           Putih                      #FFFFFF
  Teks utama                Navy gelap                 #16324F
  Teks sekunder             Abu-abu biru               #64748B
  Garis/border              Abu kebiruan               #DCE7F2
  Status berhasil/aktif     Hijau                      #16A779
  Status menunggu           Oranye                     #F59E0B
  Status ditolak/nonaktif   Merah                      #EF5B67
Gunakan warna status sebagai aksen kecil pada badge, bukan sebagai latar
besar. Jaga kontras teks agar mudah dibaca.
Tipografi
- Gunakan font sans-serif modern, misalnya Inter, Poppins,
  atau font sans-serif sistem.
- Judul halaman: 20--24 px, semi-bold/bold.
- Judul kartu: 14--16 px, semi-bold.
- Isi tabel/form: 13--14 px.
- Label dan metadata: 12--13 px.
- Jangan mengecilkan tulisan hanya agar semua konten muat.
Gaya komponen
- Dashboard memakai latar putih atau biru sangat muda.
- Kartu putih dengan border tipis, radius 8--12 px, dan bayangan
  halus.
- Tombol utama biru, tombol sekunder putih dengan border biru.
- Input memiliki tinggi konsisten, label jelas, ikon seperlunya, dan
  state fokus yang terlihat.
- Sidebar navy dengan logo/identitas aplikasi, ikon sederhana, dan
  menu aktif berwarna biru terang.
- Gunakan ikon konsisten dari satu pustaka ikon yang tersedia di
  proyek.
- Hindari gradien berlebihan, efek kaca, animasi mencolok, dan terlalu
  banyak warna.
3. Tata Letak Global
Halaman setelah login
1. Sidebar kiri dengan lebar sekitar 220--250 px pada desktop.
2. Topbar putih dengan tombol buka/tutup sidebar, judul atau
   breadcrumb bila diperlukan, profil pengguna, role, dan menu akun.
3. Area konten dengan padding 20--28 px.
4. Footer sederhana bila diperlukan, memuat identitas
   SIMPAULA/Pemerintah Provinsi Kalimantan Selatan.
Sidebar dapat diciutkan. Pada ponsel, sidebar berubah menjadi drawer
yang dapat dibuka melalui tombol menu.
Struktur sidebar pengguna
- Beranda
- Pesan Aula
- Jadwal Aula
- Riwayat Pemakaian
- Profil
- Logout
Struktur sidebar admin
- Beranda
- Kelola Aula
- Kelola Pengguna
- Kelola Pemesanan
- Laporan
- Pengaturan
- Logout
Sesuaikan nama menu dengan route dan fitur yang benar-benar ada pada
proyek. Jangan membuat menu baru yang mengarah ke halaman kosong.
4. Spesifikasi Halaman
4.1 Login
Buat halaman login dua kolom: - Panel kiri: foto gedung/aula
pemerintahan atau ilustrasi arsitektur yang relevan, dengan bentuk
dekoratif gelombang biru muda. - Panel kanan: logo/identitas
Pemerintah Provinsi Kalimantan Selatan dan SIMPAULA, judul masuk, input
username/email dan password, tombol tampilkan password, opsi ingat saya,
tautan lupa password bila fitur tersedia, tombol Masuk, dan tautan
pendaftaran bila pendaftaran publik diaktifkan. - Pada layar kecil,
susun menjadi satu kolom; gambar dapat diperkecil atau dipindahkan ke
bagian atas. - Jangan menggunakan logo pemerintah palsu. Pakai aset
resmi yang sudah tersedia di proyek; jika belum ada, gunakan placeholder
yang jelas untuk diganti.
4.2 Beranda pengguna
- Sapaan dan nama pengguna.
- Kartu ringkasan: Total Aula, Pemesanan Aktif, Riwayat Pemakaian, dan
  Menunggu Persetujuan.
- Bagian Aula Tersedia berupa kartu aula dengan foto, nama aula,
  lokasi, kapasitas, status, dan tombol Pesan Sekarang.
- Tautan Lihat Semua menuju daftar aula.
- Angka ringkasan harus berasal dari data aplikasi, bukan angka
  statis.
4.3 Form pemesanan aula
Buat alur bertahap yang mudah dipahami: 1. Pilih Aula --- tampilkan
pilihan aula, foto, lokasi, dan kapasitas. 2. Tanggal & Waktu ---
pilih tanggal pemakaian, jam mulai, dan jam selesai. 3. Detail
Kegiatan --- nama kegiatan, penyelenggara/instansi, jumlah peserta,
serta kebutuhan tambahan jika memang didukung sistem. 4. Konfirmasi
--- tampilkan ringkasan sebelum pengguna mengirim permohonan.
Ketentuan: - Tanggal selesai dan jam selesai harus sesudah waktu
mulai. - Cegah bentrok jadwal berdasarkan data pemesanan yang sudah
ada. - Tampilkan validasi tepat di dekat field yang bermasalah. - Tombol
Kembali, Batal, Lanjutkan, dan Kirim Pemesanan harus
memiliki fungsi nyata. - Jangan menyatakan pemesanan disetujui otomatis
bila proses sebenarnya memerlukan persetujuan admin.
4.4 Jadwal aula
- Tampilkan kalender bulanan dengan navigasi bulan
  sebelumnya/berikutnya.
- Sediakan legenda status, misalnya Tersedia, Terisi, dan Maintenance.
- Klik tanggal untuk melihat daftar pemakaian pada tanggal tersebut.
- Tampilkan daftar agenda di bawah atau di samping kalender.
- Gunakan warna status secara konsisten dan jangan hanya mengandalkan
  warna; sertakan label teks.
4.5 Riwayat pemakaian
- Tabel berisi nomor, tanggal, nama kegiatan, aula, waktu, status, dan
  aksi.
- Sediakan pencarian, filter status, serta detail pemesanan.
- Gunakan badge status seperti Menunggu, Disetujui, Ditolak, dan
  Selesai sesuai status yang benar-benar didukung aplikasi.
- Pada ponsel, tabel boleh menjadi kartu bertumpuk atau memiliki
  scroll horizontal yang nyaman.
4.6 Detail pemesanan
- Tampilkan foto dan nama aula, kapasitas, lokasi, tanggal, jam, nama
  kegiatan, penyelenggara, jumlah peserta, serta status.
- Sediakan tombol cetak atau unduh bukti hanya jika fiturnya tersedia.
- Tombol unggah bukti atau dokumen hanya ditampilkan bila proses
  bisnis memang memerlukannya.
4.7 Profil pengguna
- Kartu profil dengan avatar/placeholder, nama, email, dan role.
- Bagian data diri berisi field yang relevan seperti nama lengkap, NIP
  jika diperlukan, instansi, nomor telepon, dan alamat.
- Tombol Ubah Profil dan Simpan Perubahan harus terhubung ke
  validasi dan penyimpanan yang sudah ada.
4.8 Dashboard admin
- Kartu ringkasan: Total Aula, Total Pengguna, Pemesanan Aktif,
  Menunggu Persetujuan.
- Grafik pemakaian aula per periode.
- Grafik/status pemesanan.
- Daftar pemesanan terbaru dan aksi cepat untuk memeriksa permohonan.
- Grafik harus memakai data nyata dari backend bila tersedia; jika
  belum ada endpoint, tandai sebagai data contoh selama pengembangan.
4.9 Kelola aula
- Tabel berisi foto, nama aula, kapasitas, lokasi, status, dan aksi.
- Sediakan tambah, ubah, detail, serta aktif/nonaktifkan aula sesuai
  izin admin.
- Form aula dapat mencakup nama, deskripsi, kapasitas, alamat/lokasi,
  fasilitas, foto, dan status.
- Konfirmasi sebelum menghapus data. Jangan menghapus aula yang masih
  terkait pemesanan tanpa aturan yang jelas.
4.10 Kelola pengguna
- Tabel berisi nomor, nama, username/email, role, status, dan aksi.
- Sediakan pencarian dan filter role/status jika didukung.
- Form tambah/ubah pengguna mengikuti validasi backend dan kebijakan
  keamanan aplikasi.
- Password tidak boleh ditampilkan dalam tabel atau log.
4.11 Kelola pemesanan
- Tabel berisi pemohon, tanggal, aula, kegiatan, status, dan aksi.
- Admin dapat membuka detail dan menyetujui/menolak pemesanan sesuai
  hak akses.
- Jika menolak, minta alasan bila proses bisnis mendukungnya.
- Tampilkan konfirmasi sebelum perubahan status dan tampilkan
  notifikasi hasil aksi.
4.12 Laporan
- Filter rentang tanggal, aula, dan status bila tersedia.
- Ringkasan total pemakaian, total pemesanan, dan statistik pendukung.
- Grafik pemakaian aula.
- Tombol cetak/ekspor hanya jika implementasinya tersedia.
- Pastikan filter laporan memengaruhi data tabel, angka ringkasan, dan
  grafik secara konsisten.
5. Responsivitas dan Aksesibilitas
- Desktop: sidebar tetap dan konten lebar.
- Tablet: sidebar dapat diciutkan.
- Ponsel: drawer sidebar, kartu satu kolom, form satu kolom, dan tabel
  yang tetap bisa dibaca.
- Gunakan label form yang terlihat; jangan mengandalkan placeholder
  saja.
- Semua tombol memiliki teks atau nama aksesibel.
- Fokus keyboard harus terlihat.
- Status memiliki label teks, bukan warna saja.
- Gambar memiliki teks alternatif yang sesuai.
- Hindari teks kecil, elemen saling bertumpuk, dan scroll horizontal
  pada seluruh halaman.
6. Ketentuan Implementasi Laravel
- Pertama, periksa struktur proyek, routes/web.php, controller,
  model, migration, Blade, CSS/JS, autentikasi, dan aset yang
  tersedia.
- Gunakan Blade layout/partial/component agar sidebar, topbar, footer,
  tombol, badge, kartu, tabel, dan form konsisten.
- Jika proyek sudah memakai Bootstrap, Tailwind, atau framework CSS
  lain, lanjutkan dengan teknologi yang sudah digunakan kecuali ada
  alasan kuat untuk migrasi.
- Jangan memasang ulang framework atau mengubah versi dependency tanpa
  kebutuhan.
- Jangan menghapus atau mengganti route yang sudah berjalan.
- Pertahankan nama field dan relasi database yang sudah ada; sesuaikan
  UI terhadap struktur data nyata.
- Gunakan route bernama Laravel bila tersedia, CSRF protection untuk
  form, validasi server-side, dan middleware/otorisasi untuk aksi
  admin.
- Hindari menaruh data rahasia di frontend.
- Gunakan pagination, pencarian, dan filter yang sesuai untuk daftar
  panjang.
- Tampilkan state loading, data kosong, error, dan sukses.
- Jangan hardcode angka dashboard atau jadwal bila data dapat diambil
  dari database.
- Jika fitur belum tersedia, catat sebagai TODO dan jangan
  berpura-pura fitur sudah berfungsi.
7. Kriteria Penerimaan
- [ ] Warna, sidebar, topbar, kartu, tabel, badge, dan form konsisten
  dengan panduan.
- [ ] Login dan semua halaman utama terlihat rapi pada desktop dan
  ponsel.
- [ ] Menu aktif terlihat jelas.
- [ ] Seluruh tombol dan tautan mengarah ke aksi/route yang benar.
- [ ] Form menampilkan validasi yang mudah dipahami.
- [ ] Data dashboard, aula, jadwal, pengguna, pemesanan, dan laporan
  berasal dari sumber data yang sesuai.
- [ ] Status pemesanan konsisten di seluruh halaman.
- [ ] Tidak ada halaman kosong, tautan mati, atau data contoh yang
  tidak diberi penanda.
- [ ] Fungsi aplikasi yang sudah ada tetap berjalan setelah perubahan
  UI.
- [ ] Tidak ada error baru pada browser console atau log Laravel yang
  disebabkan oleh perubahan desain.
PROMPT IMPLEMENTASI --- SIMPAULA
Salin prompt berikut ke coding assistant/AI yang akan mengerjakan proyek
Laravel Anda. Sertakan folder proyek ZIP dan gambar referensi jika alat
tersebut mendukung unggahan file.
Saya ingin memperbarui tampilan proyek Laravel saya agar mengikuti
gambar referensi Rancangan UI SIMPAULA Booking Aula dan
spesifikasi dalam DESIGN.md.
Nama aplikasi: SIMPAULA --- Sistem Informasi Manajemen Pemakaian
Aula Pemerintah Provinsi Kalimantan Selatan.
Tugas utama: periksa proyek yang saya berikan terlebih dahulu,
lalu implementasikan desain UI/UX yang konsisten dengan gambar
referensi. Jangan hanya membuat mockup atau menjelaskan
langkah-langkah; lakukan perubahan pada file proyek yang relevan.
Arahan visual
- Desain dashboard pemerintahan yang modern, bersih, profesional,
  dan ringan.
- Sidebar kiri biru navy (#063B78), menu aktif biru terang
  (#0D6EFD), topbar putih, latar halaman biru/abu sangat muda
  (#F4F8FC), kartu putih, border halus, radius 8--12 px, dan
  shadow lembut.
- Gunakan tipografi sans-serif yang jelas, ikon konsisten, badge
  status, tabel rapi, kartu statistik, dan form dengan jarak yang
  teratur.
- Buat halaman login dua panel: visual gedung/aula di kiri dan
  formulir login/identitas SIMPAULA di kanan, responsif pada layar
  kecil.
- Dashboard pengguna memuat sapaan, statistik ringkas, kartu aula
  yang tersedia, foto, kapasitas, lokasi, dan tombol pemesanan.
- Form pemesanan dibuat bertahap: pilih aula, tanggal dan waktu,
  detail kegiatan, lalu konfirmasi.
- Sediakan halaman jadwal kalender, riwayat pemakaian, detail
  pemesanan, profil pengguna, dashboard admin, kelola aula, kelola
  pengguna, kelola pemesanan, serta laporan sesuai fitur dan route
  yang sudah ada di proyek.
Aturan wajib sebelum mengubah kode
1. Periksa struktur folder, routes/web.php, controller, model,
   migration, Blade, CSS/JS, sistem login, role, dan database.
2. Buat daftar singkat halaman/fitur yang ditemukan dan file yang
   akan diubah.
3. Pertahankan fitur, route, nama tabel/kolom, relasi, autentikasi,
   dan validasi yang sudah berjalan.
4. Jangan menghapus atau menulis ulang backend hanya demi
   menyesuaikan desain. Jika ada ketidaksesuaian, sesuaikan tampilan
   dengan struktur proyek yang sebenarnya.
5. Gunakan framework CSS dan pustaka yang sudah ada. Hindari migrasi
   teknologi atau instalasi dependency yang tidak diperlukan.
Aturan implementasi
- Terapkan layout bersama dan komponen/partial reusable untuk
  sidebar, topbar, footer, kartu statistik, tombol, tabel, form,
  badge status, alert, dan modal konfirmasi.
- Pastikan menu pengguna dan admin mengikuti role/otorisasi yang
  sudah diterapkan.
- Semua tombol, filter, pencarian, pagination, pemilihan tanggal,
  dan aksi persetujuan harus berfungsi dan terhubung ke
  route/backend yang benar.
- Gunakan data database untuk statistik, aula, jadwal, pengguna,
  pemesanan, dan laporan bila sumber datanya tersedia. Jangan
  mengganti data nyata dengan angka hardcode.
- Cegah konflik jadwal dan validasi rentang tanggal/jam berdasarkan
  aturan aplikasi yang ada.
- Gunakan validasi server-side, CSRF, middleware, dan otorisasi yang
  sesuai.
- Sediakan tampilan loading, data kosong, sukses, dan error. Jangan
  tampilkan tautan ke halaman yang belum dibuat.
- Gunakan aset logo resmi yang sudah ada. Jangan membuat lambang
  pemerintah palsu; bila aset tidak tersedia, gunakan placeholder
  yang mudah diganti.
- Buat desain responsif untuk desktop, tablet, dan ponsel.
- Ikuti DESIGN.md untuk detail palet, ukuran, komponen, halaman,
  dan kriteria penerimaan.
Alur kerja dan hasil akhir
1. Audit proyek dan rangkum struktur/fitur yang ada.
2. Implementasikan desain pada file yang relevan, bukan hanya
   memberikan contoh kode terpisah.
3. Jalankan pemeriksaan yang memungkinkan, misalnya route list, test
   yang tersedia, pemeriksaan Blade, dan pengecekan error.
4. Perbaiki error yang timbul akibat perubahan.
5. Berikan ringkasan file yang diubah, fitur yang berhasil, perintah
   untuk menjalankan aplikasi, serta masalah atau TODO yang belum
   terselesaikan.
Prioritas tertinggi: desain harus mendekati gambar referensi,
tetapi fungsi aplikasi yang sudah ada tidak boleh rusak. Jika gambar
referensi berbeda dengan struktur backend, pertahankan backend dan
implementasikan tampilan yang paling sesuai dengan data/fitur nyata.