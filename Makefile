start:
	php artisan serve
install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests
test:
	php artisan test --testsuite=Feature
env:
	php -r "file_exists('.env') || copy('.env.example', '.env');"
key:
	php artisan key:gen --ansi
start-db:
	sudo service postgresql start
prepare-db:
	php artisan migrate:fresh --seed
setup: env install key prepare-db lint test
