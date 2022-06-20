

Instalasi

Sebelum Proses Instalasi

pastikan komputer anda sudah terinstall composer dan npm Sudah? Ok Lanjut

jalankan git clone https://github.com/kiloo34/E-SCM masuk ke direktori app <br> 
jalankan composer install <br> 
jalankan php artisan key:generate <br>
buat database MySQL <br>
untuk app-nya copy file .env.example ke .env <br>
perbarui file .env sesuaikan dengan nama database yg telah dibuat <br>
jalankan composer dump-autoload <br>
jalankan php artisan migrate --seed <br>
jalankan npm install <br>
jalankan php artisan serve
