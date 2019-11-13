<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The singular resource words that will not be pluralized
    | For Example: $ php artisan generate:resource admin.bar
    | The url will be /admin/bars and not /admins/bars
    |--------------------------------------------------------------------------
    */

    'reserve_words' => ['app', 'website', 'admin'],

    /*
    |--------------------------------------------------------------------------
    | The default keys and values for the settings of each type to be generated
    |--------------------------------------------------------------------------
    */

    'defaults' => [
        'namespace'           => '',
        'path'                => './app/',
        'prefix'              => '',
        'postfix'             => '',
        'file_type'           => '.php',
        'dump_autoload'       => false,
        'directory_format'    => '',
        'directory_namespace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Types of files that can be generated
    |--------------------------------------------------------------------------
    */

    'settings' => [
        'view'         => [
            'path'                => './resources/views/',
            'file_type'           => '.blade.php',
            'directory_format'    => 'strtolower',
            'directory_namespace' => true
        ],
        'model'        => ['namespace' => '\Models', 'path' => './app/Models/'],
        'controller'   => [
            'namespace'           => '\Http\Controllers',
            'path'                => './app/Http/Controllers/',
            'postfix'             => 'Controller',
            'directory_namespace' => true,
            'dump_autoload'       => true,
            'repository_contract' => false,
        ],
        'seed'         => ['path' => './database/seeds/', 'postfix' => 'TableSeeder'],
        'migration'    => ['path' => './database/migrations/'],
        'notification' => [
            'directory_namespace' => true,
            'namespace'           => '\Notifications',
            'path'                => './app/Notifications/'
        ],
        'event'        => [
            'directory_namespace' => true,
            'namespace'           => '\Events',
            'path'                => './app/Events/'
        ],
        'listener'     => [
            'directory_namespace' => true,
            'namespace'           => '\Listeners',
            'path'                => './app/Listeners/'
        ],
        'trait'        => [
            'directory_namespace' => true,
        ],
        'job'          => [
            'directory_namespace' => true,
            'namespace'           => '\Jobs',
            'path'                => './app/Jobs/'
        ],
        'console'      => [
            'directory_namespace' => true,
            'namespace'           => '\Console\Commands',
            'path'                => './app/Console/Commands/'
        ],
        'middleware'   => [
            'directory_namespace' => true,
            'namespace'           => '\Http\Middleware',
            'path'                => './app/Http/Middleware/'
        ],
        'repository'   => [
            'directory_namespace' => true,
            'postfix'             => 'Repository',
            'namespace'           => '\Repositories',
            'path'                => './app/Repositories/'
        ],
        'contract'     => [
            'directory_namespace' => true,
            'namespace'           => '\Contracts',
            'postfix'             => 'Repository',
            'path'                => './app/Contracts/',
        ],
        'factory'      => [
            'postfix' => 'Factory',
            'path'    => './database/factories/',
        ],
        'test'         => [
            'directory_namespace' => true,
            'namespace'           => '\Tests\Feature',
            'postfix'             => 'Test',
            'path'                => './tests/Feature/',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Views [stub_key | name of the file]
    |--------------------------------------------------------------------------
    */

    'resource_views' => [
        'view_index'       => 'index',
        //'view_create'      => 'create',
        //'view_edit'        => 'edit',
        'view_show'        => 'show',
        'view_create_edit' => 'create_edit',
    ],

    /*
    |--------------------------------------------------------------------------
    | Where the stubs for the generators are stored
    |--------------------------------------------------------------------------
    */

    'stubs' => [
        'example'                => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/example.stub',
        'model'                  => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/model.stub',
        'model_plain'            => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/model.plain.stub',
        'migration'              => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/migration.stub',
        'migration_plain'        => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/migration.plain.stub',
        'controller'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/controller.stub',
        'controller_plain'       => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/controller.plain.stub',
        'controller_admin'       => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/controller_admin.stub',
        'controller_repository'  => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/controller_repository.stub',
        'pivot'                  => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/pivot.stub',
        'seed'                   => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/seed.stub',
        'seed_plain'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/seed.plain.stub',
        'view'                   => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.stub',
        'view_index'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.index.stub',
        'view_show'              => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.show.stub',
        //'view_create'            => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.create.stub',
        //'view_edit'              => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.edit.stub',
        'view_create_edit'       => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.create_edit.stub',
        'schema_create'          => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/schema_create.stub',
        'schema_change'          => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/schema_change.stub',
        'notification'           => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/notification.stub',
        'event'                  => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/event.stub',
        'listener'               => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/listener.stub',
        'many_many_relationship' => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/many_many_relationship.stub',
        'trait'                  => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/trait.stub',
        'job'                    => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/job.stub',
        'console'                => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/console.stub',
        'middleware'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/middleware.stub',
        'repository'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/repository.stub',
        'contract'               => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/contract.stub',
        'factory'                => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/factory.stub',
        'test'                   => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/test.stub',
    ]
];
