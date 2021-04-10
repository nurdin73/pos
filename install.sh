# pastikan database sudah di buat
php artisan migrate:fresh --seed
echo "migrate success"
php artisan passport:install --force
echo "passport install success"
php artisan view:cache
echo "cache success"