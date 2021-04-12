# Point Of sale 

## Minimum System Requirement
- **Sistem Operasi :** windows/linux(64 bit)
- **Processor :** I3 atau diatasnya
- **Memory :** 4GB RAM
- **Browser :** Menyesuaikan spesifikasi device. jika device dibawah minimun requirement. pakai browser terringan seperti <a href="https://www.comodo.com/home/browsers-toolbars/browser.php">comodo dragon</a> dsb.
- **PHP Version :** >= 7.3 

## Aplikasi wajib di install
- Web server seperti XAMPP, LAMPP, dsb. pilih salah satu
- Composer

## deskripsi produk

Aplikasi point of sale ini digunakan untuk memanagement stok barang, transaksi di sebuah toko meliputi pendataan suplier, cabang, pajak. 

## Feature

- management barang
- Multiple kode barang
- Point perbarang
- Mendukung penjualan eceran
- Memanagement cabang
- Management suplier
- Transaksi bisa menggunakan scanner barcode dan sudah bisa print nota transaksi
- Tambah pelanggan untuk program loyality
- Return barang
- Management kasbon pelanggan
- Perhitungan pajak
- Teporting penjualan barang, pembelian barang, modal, pajak, kasbon dan pelanggan baik perjam, perhari, perbulan ataupun pertahun
- Pengaturan profile toko
- Management Staff
- Multiple akses user
- Backup database

## Prosess Instalasi

- Install web server seperti xampp dsb. terbaru
- Pastikan versi PHP yang digunakan adalah versi 7.3 atau lebih
- Install Aplikasi Composer(jika file nya ambil dari github)
- Download project ini lalu simpan ke direktori server kamu. jika menggunakan XAMPP. extrak project ini ke folder htdoc.
- Jika sudah, pastikan file .env sudah ada. jika tidak. copy file .env.example dan simpan sebagai nama .env .. Untuk file ini biasanya di hide oleh sistem windows. maka dari itu pastikan checklis show hide file di pengaturan file manager nya
- Setting environment nya terutama bagian database setting, Seperti DB_DATABASE, DB_USERNAME, DB_PASSWORD
- Pastikan command php dan mysqldump bisa digunakan. untuk check nya. silahkan buka cmd lalu ketik php -v jika berhasil maka akan muncul versi php mu.. jika tidak. silahkan setting environment variable untuk windows tambahkan path menuju direktory php.exe yang terinstall
- Jika sudah, buka file install.bat untuk windows. install.sh untuk linux.. seluruh konfigurasi akan otomatis dijalankan.. tunggu hingga selesai
- Proses instalasi sudah selesai. aplikasi sudah bisa digunakan.
- buka browser favoritmu lalu ketikan alamat http://localhost/nama_project/public
- Ganti nama_project menjadi nama folder project ini

## Setting aplikasi
- masuk ke menu setting toko atau yang lainnya untuk mengganti nama toko, akun toko dll
- Untuk setting printer. pastikan printer yang terhubung sudah bisa test print di tanpa aplikasi. jika sudah bisa print test nya. pastikan juga printer sudah di setting sharing printer. lalu copy nama sharing printernya. untuk selebihnya ikuti instruksi di note halaman.

## Cara penggunaan
- masukan barang di menu barang. isi sesuai dengan inputan yang ada. jika barang ada barcode nya. silahkan scan kode batang nya menggunakan scanner dengan cara klik tombol hijau pada saat input barang. 
- jika harga produk bervarian. klik tampilkan lainnya dan tambahkan type harga. masukan data sesuai dengan form yang telah disediakan.
- Jika produk bisa di ecerkan. aktikan opsi eceran dan masukan harga ecerannya
- silahkan set pajak jika memang dibutuhkan. ini ada di menu pajak
- Setting seluruh data seperti toko dll yang ada di menu settings.
- jika sudah. pastikan printer nota sudah terintegrasi dengan aplikasi. untuk settingannya silahkan ikuti arahan sesuai note yang disediakan
- Jika semua sudah selesai..
- untuk melakukan transaksi silahkan masuk ke menu transaksi dan tambah transaksi. masukkan kode produk di kolom yang telah disediakan. hal ini bisa dilakukan via scanner barcode atau input manual.. jika sudah klik enter untuk memasukan ke keranjang. namun untuk scanner barcode akan otomatis ditambahkan ke keranjang. jika sudah masukkan seluruh data seperti jumlah quantity, customer(jika ada) dll. 
- jika sudah. silahkan klik prosess untuk melanjutkan. masukkan data sesuai form yg disediakan. 
- transaksi sudah selesai. dialog cetak nota akan muncul.. setelah itu transaksi sudah berhasil. untuk invoice akan tercatat di sistem. untuk melihatnya bisa di check di menu list transaksi
- untuk pengaturan produk. seperti stok dan harga dasar. ada dimenu management stok. selain itu ada di menu edit barang. untuk merubah harga dasar. silahkan klik detail produk yang ada di management stok. lalu pilih edit kemudian pilih tambah. edit harga produk dan kosongkan jumlahnya. namun jika ingin menambahkan stok nya. silahkan isi keduanya... Jika kamu ingin kurangi stok. pilih edit lalu kurangi stok. Masukan jumlah stok yang ingin dikurangi lalu proses.. 
- untuk fitur kasbon, silahkan masukan data diri pelanggan terlebih dahulu. lalu isi form kasbon yang sudah disediakan. ketika sudah, kasbon pelanggan otomatis tercatat. lalu untuk proses pembayaran kasbon. bisa melakukan cicilan dengan tempo yang sudah ditentukan. kita bisa mengirim pesan Whatsapp ke pengguna dengan cara klik icon Whatsapp pada saat klik detail kasbonnya. nanti otomatis akan diarahkan ke aplikasi whatsapp dan langsung ke nomor pengguna(jika pengguna memiliki whatsapp)
- Untuk fitur laporan. seluruh transaksi akan tercatat dan di report secara berkala mulai dari per jam sampai pertahun. mulai dari laporan barang, laporan transaksi, hingga laporan kasbon.
- untuk selebihnya. silahkan explore sendiri di demo yang telah disediakan.. **note** demo tidak bisa melakukan print, namun tenang saja, untuk aplikasi full jika di install di komputer masing masing sudah bisa digunakan

## Pembuat
- <a href="https://github.com/nurdin73">Nurdin</a>
- <a href="https://github.com/farhanalmoza">Farkhan</a>

## Thanks To
- <a href="https://laravel.com/">Laravel</a>
- <a href="https://coreui.io/">Core UI free admin template</a>
- <a href="https://getbootstrap.com/docs/4.6/getting-started/introduction/">Bootstrap 4</a>
- <a href="https://momentjs.com/">Moment JS</a>
- <a href="https://www.chartjs.org/">Chart JS</a>
- <a href="https://jquery.com/">Jquery</a>
- <a href="https://datatables.net/">Datatables Jquery</a>
- <a href="https://www.daterangepicker.com/">Daterangepicker</a>
- <a href="https://xdsoft.net/jqplugins/datetimepicker/">Datetimepicker</a>
- <a href="https://igorescobar.github.io/jQuery-Mask-Plugin/">Jquery Mask</a>
- <a href="https://jqueryvalidation.org/">Jquery Validate</a>
- <a href="https://github.com/hakimel/Ladda">LaddaSpin</a>
- <a href="https://pgwjs.com/pgwslider/">PgwSlider</a>
- <a href="https://select2.org/">Select2</a>
- <a href="https://sweetalert2.github.io/">SweetAlert 2</a>
- <a href="https://github.com/CodeSeven/toastr">Toastr</a>
- <a href="https://laravel-excel.com/">Laravel Excel</a>
- <a href="https://github.com/mike42/escpos-php">ESC-POS</a>
- <a href="https://github.com/laravel/passport">Laravel Passport</a>
- <a href="https://github.com/spatie/laravel-image-optimizer">laravel Image optimizer</a>
- <a href="https://github.com/spatie/image-optimizer">Image optimizer</a>
- <a href="https://github.com/spatie/db-dumper">Laravel DB dumper</a>

## Demo Website
- **Website :** <a href="http://demo-pos.rittercoding.com/">Demo</a>
- **Email :** admin@admin.com
- **Password** : admin

# License
Aplikasi berbayar.

## Kontak Developer
- **Whatsapp :** <a href="https://api.whatsapp.com/send?phone=6283823210947">Nurdin</a>
- **Email :** <a href="mailto:nurdin.reverse73@gmail.com">nurdin.reverse73@gmail.com</a> 