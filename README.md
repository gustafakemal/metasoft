# MetaSoft

## Instalasi

Untuk instalasi:

- Clone project dengan perintah `git clone https://github.com/gustafakemal/metasoft.git`
- Akan ada folder `metasoft`. Silahkan rename folder tsb sesuai yang dikehendaki, misalkan `metaform`
- Jalankan perintah `composer install` untuk menginstall dependency
- Buat file `.env` dengan kode kurang lebih spt ini
```
CI_ENVIRONMENT = production

# Masukkan URL
app.baseURL = 'http://10.14.80.13/metaform/'

database.default.hostname = 10.14.80.54
database.default.database = MetaProduksi
database.default.username = developer
database.default.password = Developer2022
database.default.DBDriver = sqlsrv
database.default.port = 1433
database.default.DBPrefix =
```
- Jika ingin me-running aplikasi dengan subfolder, contohnya `http://localhost/metaform` atau `http://10.14.80.13/metaform` silahkan ubah file `.htaccess` di `public/.htaccess` menjadi spt ini:
```
# metasoft/public/.htacess

RewriteEngine on

RewriteCond $1 !^(index\.php|images|assets|css|js|robots\.txt|favicon\.ico)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule (.*) index.php/$1 [L]

<IfModule mod_headers.c>
  <FilesMatch "\.(ttf|ttc|otf|eot|woff|woff2|font.css|css|js)$">
    Header set Access-Control-Allow-Origin "*"
  </FilesMatch>
</IfModule>
```
Kemudian tambahkan pula file `.htaccess` baru di root aplikasi, dengan kode spt ini:
```
# metasoft/.htacess

DirectoryIndex index.php
Options -Indexes

RewriteEngine On

# Unconditionally rewrite everything to the "public" subdirectory
RewriteRule (.*) public/$1 [L]
```

- Untuk melakukan update atau sync aplikasi terbaru (paling mutakhir) jalankan melalui perintah `git pull origin main`
