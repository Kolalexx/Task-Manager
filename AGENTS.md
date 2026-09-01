# AGENTS.md

Приложение на Laravel 12 — «Менеджер задач» (учебный проект Hexlet). Монолит. Язык интерфейса — русский. Требуется PHP ^8.2.

## Команды (Makefile — источник истины)
- `make setup` — полная настройка: composer install, копирование `.env`, key:gen, migrate, seed, npm ci, `npm run build`, lint, phpstan, feature-тесты. Пропускает запуск PostgreSQL, если задан `CI`.
- `make test` — `php artisan test --testsuite=Feature`
- `make lint` — `composer exec phpcs -- --standard=PSR12 app routes tests`
- `make phpstan` — `composer exec phpstan analyse` (level 5, конфиг `phpstan.neon`, tmpDir `storage/phpstan` в `.gitignore`)
- `make start` — `php artisan serve` (http://localhost:8000)
- `make start-frontend` — `npm run dev` (Vite/Tailwind)
- `make prepare-db` — `php artisan migrate:fresh --seed`

## CI/CD
- Репозиторий размещён на GitHub: https://github.com/Kolalexx/Task-Manager.
- При каждом push GitHub Actions запускает проверки (`.github/workflows/testAndLint.yml` — `make setup`: phpcs + phpstan + feature-тесты, Postgres поднимается как service-контейнер). Файл `hexlet-check.yml` — проверка проекта Hexlet.
- В случае успеха проверок проект автоматически деплоится на render.com.

## Важные особенности
- Структура приложения — Laravel 11+/12: конфигурация в `bootstrap/app.php` (`withRouting`/`withMiddleware`/`withExceptions`), провайдеры — в `bootstrap/providers.php`, политики регистрируются явно через `Gate::policy()` в `AppServiceProvider::boot()`. Классические `Http/Console Kernel`, `Exceptions/Handler`, `RouteServiceProvider` отсутствуют.
- Тесты работают на SQLite в памяти (принудительно задано в `phpunit.xml`) — **PostgreSQL для запуска тестов не нужен**. Для локальной разработки Postgres требуется; `make start-db` использует `sudo service postgresql start` (только Linux, на macOS не работает).
- Тесты есть только в наборе `Feature`; набор `Unit` пуст. Используйте `--testsuite=Feature`.
- Приложение локализовано на русский: `config/app.php` задаёт `locale`/`fallback_locale` = `ru`. Строки UI берутся из `lang/ru/views.php` через `__('views.task...')`. В `lang/en` **нет** `views.php` — новые ключи `views.*` нужно добавлять в `lang/ru/views.php`, иначе они не отобразятся.
- Валидация форм — в Form Requests (`app/Http/Requests`, по классу на `store` и `update` каждого ресурса) с русскими сообщениями в методе `messages()`. `ProfileUpdateRequest` — от Breeze. `authorize()` в них не задан: права проверяются политиками через `$this->authorizeResource()`.
- Ресурсные маршруты в snake_case: `tasks`, `task_statuses`, `labels` (имена маршрутов `task_statuses.index` и т.д.). Контроллеры вызывают `$this->authorizeResource()`; политики лежат в `app/Policies`.
- `Task` использует `SoftDeletes` — feature-тест на удаление проверяет `assertSoftDeleted`.
- Фабрики автосоздают связанные записи (например, `TaskFactory` создаёт `TaskStatus` и двух `User`), поэтому сидирование в тестах не требуется.
- Flash-сообщения через `laracasts/flash`: `flash(__('views.task.flash.store'))`. Успех — `->success()`, блокировку удаления — `->error()` (см. `destroy` в `LabelController`/`TaskStatusController`).
- Формы — нативный Blade/HTML (без `laravelcollective/html`): `<form method="POST">` + `@csrf` (+ `@method('PATCH')` для обновления), значения через `old($name, $model?->$name)`. Компоненты: `x-text-input-block`, `x-select-input-block`, `x-submit`.
- Статический анализ — PHPStan level 5 + Larastan (`phpstan.neon`). Контроллеры типизированы (`: View` / `: RedirectResponse`), модели имеют PHPDoc `@property`; при добавлении атрибутов/связей обновляйте аннотации моделей. Общие статические методы вроде `options()` выносятся в `app/Models/Concerns/HasOptions`.
- Фронтенд — Vite/Tailwind; `public/build` в `.gitignore`. Для проверки продакшен-сборки запускайте `npm run build`, во время разработки — `npm run dev`.
