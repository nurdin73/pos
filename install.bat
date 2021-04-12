@REM pastikan database sudah di buat
@ECHO OFF
ECHO Pastikan database sudah dibuat terlebih dahulu...
PAUSE
composer update
php artisan key:generate
ECHO Migrasi database akan dibuat.. 
php artisan migrate:fresh --seed
ECHO migrate success
php artisan passport:install --force
ECHO "passport install success"
php artisan view:cache
ECHO "cache success"
php artisan storage:link
ECHO "Storage link berhasil dibuat"
PAUSE