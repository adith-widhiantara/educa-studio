## Instalasi

Berikut
adalah
langkah-langkah
untuk
menginstal
aplikasi
ini:

1.Clone
repositori
ini
ke
dalam
direktori
lokal
Anda:

```sh
git clone https://github.com/adith-widhiantara/educa-studio.git
```

2.Pindah
ke
direktori
proyek:

```sh
cd educa-studio
```

3.Salin
file
.env.example
menjadi
.env
dan
konfigurasi
file
.env
dengan
informasi
database
dan
pengaturan
lainnya.

4.Instal
dependensi
aplikasi

```sh
composer install
```

5.Generate
key
aplikasi

```sh
php artisan key:generate
```

6.Jalankan
migrasi
dan
seeder
untuk
membuat
tabel
dan
data
awal
aplikasi

```sh
php artisan migrate --seed
```

7.Jalankan
aplikasi
dengan
menjalankan
perintah
berikut

```sh
php artisan serve
```

8.Buka
aplikasi
di
browser
dengan
URL
http://localhost:8000