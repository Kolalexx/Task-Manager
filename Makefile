start:
	php artisan serve
install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests
phpstan:
	composer exec -- phpstan analyse --memory-limit=512M
test:
	php artisan test
key:
	php artisan key:gen --ansi
start-db:
	sudo service postgresql start
prepare-db:
	php artisan migrate:fresh --seed
start-frontend:
	npm run dev
setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	@if [ -z "$$CI" ]; then sudo service postgresql start; fi
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run build
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests
	composer exec -- phpstan analyse --memory-limit=512M
	php artisan test
