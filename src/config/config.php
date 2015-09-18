<?php

return [

    /*
    |--------------------------------------------------------------------------
    | The default keys and values for the settings of each type to be generated
    |--------------------------------------------------------------------------
    */

    'defaults'              => [
        'namespace'           => '',
        'path'                => '.app/',
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

    'settings'              => [
        'view'       => ['path' => './resources/views/', 'file_type' => '.blade.php', 'directory_format' => 'strtolower', 'directory_namespace' => true],
        'model'      => ['namespace' => '\Models', 'path' => './app/Models/'],
        'controller' => [
            'namespace'           => '\Http\Controllers',
            'path'                => './app/Http/Controllers/',
            'postfix'             => 'Controller',
            'directory_namespace' => true,
            'dump_autoload'       => true
        ],
        'seed'       => ['path' => './database/seeds/', 'postfix' => 'TableSeeder'],
        'migration'  => ['path' => './database/migrations/'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resource Views [stub_key | name of the file]
    |--------------------------------------------------------------------------
    */

    'resource_views'        => [
        'view_index'    => 'index',
        'view_add_edit' => 'add_edit',
        'view_show'     => 'show',
    ],

    /*
    |--------------------------------------------------------------------------
    | Where the stubs for the generators are stored
    |--------------------------------------------------------------------------
    */

    'example_stub'          => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/example.stub',
    'model_stub'            => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/model.stub',
    'model_plain_stub'      => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/model.plain.stub',
    'migration_stub'        => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/migration.stub',
    'migration_plain_stub'  => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/migration.plain.stub',
    'controller_stub'       => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/controller.stub',
    'controller_plain_stub' => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/controller.plain.stub',
    'pivot_stub'            => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/pivot.stub',
    'seed_stub'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/seed.stub',
    'seed_plain_stub'       => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/seed.plain.stub',
    'view_stub'             => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.stub',
    'view_index_stub'       => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.index.stub',
    'view_add_edit_stub'    => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.add_edit.stub',
    'view_show_stub'        => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/view.show.stub',
    'schema_create_stub'    => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/schema-create.stub',
    'schema_change_stub'    => base_path() . '/vendor/bpocallaghan/generators/resources/stubs/schema-change.stub',
];
