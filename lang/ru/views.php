<?php

return [
    'title' => 'Менеджер задач',
    'task' => [
        'fields' => [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание',
            'status_id' => 'Статус',
            'created_by_id' => 'Автор',
            'assigned_to_id' => 'Исполнитель',
            'created_at' => 'Дата создания',
            'labels' => 'Метки',
            'filter[status_id]' => 'Статус',
            'filter[created_by_id]' => 'Автор',
            'filter[assigned_to_id]' => 'Исполнитель',
        ],
        'pages' => [
            'create' => [
                'submit' => 'Создать',
                'title' => 'Создать задачу',
            ],
            'edit' => [
                'submit' => 'Обновить',
                'title' => 'Изменить задачу',
            ],
            'index' => [
                'title' => 'Задачи',
                'new' => 'Создать задачу',
            ],
            'show' => [
                'title' => 'Задача: ',
            ],
            'filter' => [
                'submit' => 'Применить'
            ]
        ],
        'flash' => [
            'store' => 'Задача успешно создана',
            'update' => 'Задача успешно изменена',
            'destroy' => [
                'success' => 'Задача успешно удалена',
            ],
        ],
    ],
    'status' => [
        'fields' => [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание статуса',
            'created_at' => 'Дата создания',
        ],
        'pages' => [
            'create' => [
                'submit' => 'Создать',
                'title' => 'Создать статус',
            ],
            'edit' => [
                'submit' => 'Обновить',
                'title' => 'Изменить статус',
            ],
            'index' => [
                'title' => 'Статусы задач',
                'new' => 'Создать статус',
            ],
        ],
        'flash' => [
            'store' => 'Статус успешно создан',
            'update' => 'Статус успешно изменён',
            'destroy' => [
                'success' => 'Статус успешно удалён',
                'constraint' => 'Не удалось удалить статус',
            ],
        ],
    ],
    'label' => [
        'fields' => [
            'id' => 'ID',
            'name' => 'Имя',
            'description' => 'Описание метки',
            'created_at' => 'Дата создания',
        ],
        'pages' => [
            'create' => [
                'submit' => 'Создать',
                'title' => 'Создать метку',
            ],
            'edit' => [
                'submit' => 'Обновить',
                'title' => 'Изменить метку',
            ],
            'index' => [
                'title' => 'Метки',
                'new' => 'Создать метку',
            ],
        ],
        'flash' => [
            'store' => 'Метка успешно создана',
            'update' => 'Метка успешно изменена',
            'destroy' => [
                'success' => 'Метка успешно удалена',
                'constraint' => 'Не удалось удалить метку',
            ],
        ],
    ],

    'greeting' => 'Привет от Хекслета!',
    'profile' => [
        'flash' => [
            'destroy' => [
                'constraint' => 'Не удалось удалить аккаунт: с ним связаны созданные или назначенные задачи',
            ],
        ],
    ],
    'actions' => [
        'column_name' => 'Действия',
        'edit' => 'Изменить',
        'delete' => 'Удалить',
        'confirmation' => 'Вы уверены?',
    ],
    'This is a simple task manager on Laravel' => 'Это простой менеджер задач на Laravel',
    'Push me' => 'Нажми меня'

];
