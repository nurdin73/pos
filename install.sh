# pastikan database sudah di buat
composer update
php artisan key:generate
php artisan migrate:fresh --seed
echo "migrate success"
php artisan passport:install --force
echo "passport install success"
php artisan optimize
php artisan view:cache
echo "cache success"
php artisan storage:link
echo "Storage link berhasil dibuat"