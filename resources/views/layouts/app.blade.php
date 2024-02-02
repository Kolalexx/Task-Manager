<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Менеджер задач</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link rel="preload" as="style" href="https://php-task-manager-ru.hexlet.app/build/assets/app.8ad19020.css">
        <link rel="modulepreload" href="https://php-task-manager-ru.hexlet.app/build/assets/app.42df0f0d.js">
        <link rel="stylesheet" href="https://php-task-manager-ru.hexlet.app/build/assets/app.8ad19020.css">
        <script type="module" src="https://php-task-manager-ru.hexlet.app/build/assets/app.42df0f0d.js"></script>

    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <header class="fixed w-full">
                <nav class="bg-white border-gray-200 py-2.5 dark:bg-gray-900 shadow-md">
                    <div class="flex flex-wrap items-center justify-between max-w-screen-xl px-4 mx-auto">
                        <a href="/" class="flex items-center">
                            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">Менеджер задач</span>
                        </a>

                        <div class="flex items-center lg:order-2">
                            <a href="/login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Вход
                            </a>
                            <a href="/register" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2">
                                    Регистрация
                            </a>
                        </div>

                        <div class="items-center justify-between hidden w-full lg:flex lg:w-auto lg:order-1">
                            <ul class="flex flex-col mt-4 font-medium lg:flex-row lg:space-x-8 lg:mt-0">
                                <li>
                                    <a href="https://php-task-manager-ru.hexlet.app/tasks" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                    Задачи                                </a>
                                </li>
                                <li>
                                    <a href="/task_statuses" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                    Статусы                                </a>
                                </li>
                                <li>
                                    <a href="https://php-task-manager-ru.hexlet.app/labels" class="block py-2 pl-3 pr-4 text-gray-700 hover:text-blue-700 lg:p-0">
                                    Метки                                </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </header>

            <!-- Page Content -->
            <main>
                <section class="bg-white dark:bg-gray-900">
                    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
                        <div class="grid col-span-full">

                            @include('flash::message')

                            @yield('content')
    
                        </div>
                    </div>
                </section> 
            </main>
        </div>
    </body>
</html>
