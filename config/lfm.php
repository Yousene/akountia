<?php

return [
    'use_package_routes' => true,
    'middlewares' => ['web', 'auth'],
    'url_prefix' => 'laravel-filemanager',
    'allow_private_folder' => true,
    'private_folder_name' => UniSharp\LaravelFilemanager\Handlers\ConfigHandler::class,
    'allow_shared_folder' => false,
    'shared_folder_name' => 'shares',
    'folder_categories' => [
        'file' => [
            'folder_name' => 'files',
            'startup_view' => 'list',
            'max_size' => 50000,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif',
                'application/pdf',
                'text/plain',
            ],
        ],
        'image' => [
            'folder_name' => 'images/formations',
            'startup_view' => 'grid',
            'max_size' => 50000,
            'valid_mime' => [
                'image/jpeg',
                'image/pjpeg',
                'image/png',
                'image/gif'
            ],
        ],
    ],
];
