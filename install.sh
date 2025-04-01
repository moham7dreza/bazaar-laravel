# Check for optional parameter
skip_composer=false
skip_horizon=true

for arg in "$@"; do
    case $arg in
        "--c")
            skip_composer=true
            ;;
        "--h")
            skip_horizon=true
            ;;
        *)
            # Unknown argument
            ;;
    esac
done

git pull
if [ "$skip_composer" = false ]; then
    ./composer.phar install --optimize-autoloader --no-dev
    #this is moved from post-install-cmd to post-install inorder to not executed automatically
    # and use docker cache to speed up build process
    ./composer.phar run-script post-install
    ./composer.phar dump-autoload --optimize
fi
php artisan clear-compiled
php artisan optimize
php artisan event:cache
php artisan view:cache
php artisan migrate --force

if [ "$skip_horizon" = false ]; then
    sudo supervisorctl restart horizon
fi
