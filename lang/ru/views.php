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
                'fail' => [
                    'no-rigths' => 'Нет прав на удаление',
                ],
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
            'show' => [
                'title' => 'Метка: ',
            ],
        ],
        'flash' => [
            'store' => 'Статус успешно создан',
            'update' => 'Статус успешно изменён',
            'destroy' => [
                'success' => 'Статус успешно удалён',
                'fail' => [
                    'no-rigths' => 'Нет прав на удаление',
                    'constraint' => 'Не удалось удалить статус',
                ],
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
            'show' => [
                'title' => 'Метка: ',
            ],
        ],
        'flash' => [
            'store' => 'Метка успешно создана',
            'update' => 'Метка успешно изменена',
            'destroy' => [
                'success' => 'Метка успешно удалена',
                'fail' => [
                    'no-rigths' => 'Нет прав на удаление',
                    'constraint' => 'Не удалось удалить метку',
                ],
            ],
        ],
    ],

    'delete' => 'Удалить',
    'greeting' => 'Привет от Хекслета!',
    'actions' => [
        'column_name' => 'Действия',
        'edit' => 'Изменить',
        'delete' => 'Удалить',
        'confirmationi' => 'Вы уверены?',
    ]

];
