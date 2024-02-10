start:
	php artisan serve
install:
	composer install
lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests
test:
	php artisan test --testsuite=Feature
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
	sudo service postgresql start
	php artisan migrate
	php artisan db:seed
	npm ci
	npm run build
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests
	php artisan test --testsuite=Feature
