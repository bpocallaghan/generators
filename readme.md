# Laravel 5 File Generators

Custom Laravel 5 File Generators with a config file and publishable stubs.
This package can be used by anyone, but keep in mind that it is optimized for my personal custom workflow.
It may not suit your workflow, but please let me know about any issues or new features.

## Commands
```bash
php artisan generate:publish-stubs
php artisan generate:model
php artisan generate:view
php artisan generate:view:index
php artisan generate:view:add_edit
php artisan generate:view:show
php artisan generate:controller
php artisan generate:migration
php artisan generate:migration:pivot
php artisan generate:seed
php artisan generate:resource
```

### Option for all the commands
`--force` This will overide the existing file, if it exist.

## Installation

Update your project's `composer.json` file.

```js
"require-dev": {
	"bpocallaghan/generators": "1.0.*"
}
```

Download latest code from github via `composer update`

```batch
composer update --dev
```

Include the service provider within `app/config/app.php`.

```php
'providers' => [
    'Bpocallaghan\Generators\GeneratorsServiceProvider',
];
```

Run `artisan` command to see the new commands.

```bash
php artisan
```

## Usage

- [Models](#models)
- [Views](#views)
- [Controllers](#controllers)
- [Migrations](#migrations)
- [Pivot Tables](#pivot-tables)
- [Database Seeders](#database-seeders)
- [Resource](#resource)
- [Configuration](#configuration)

### Models

```
php artisan generate:model Country
php artisan generate:model Country --plain
php artisan generate:model Country --force
php artisan generate:model Country --migration --schema="title:string, body:text"
```

### Views

```
php artisan generate:view posts
php artisan generate:view posts.comments
php artisan generate:view:index posts
php artisan generate:view:add_edit posts
php artisan generate:view:show posts
```

The `.` will be used as a folder seperator, `posts.comments` will be `/resources/views/posts/comments/`

`generate:views`
 - This will generate an empty view file.

`generate:views:index`
 - This will generate an `index.blade.php` file with the index boilerplate code.

`generate:views:add_edit`
 - This will generate an `add_edit.blade.php` file with the create and edit form boilerplate code.

`generate:views:show`
- This will generate a `show.blade.php` file with the show resource boilerplate code.

## Views Custom Stubs

```
php artisan generate:view posts
php artisan generate:view admin.posts --stub=custom
php artisan generate:view admin.posts --stub=another_file
```

You can create your own custom `--stub` options.
- Publish the config file.
- Add your own view stub, eg. `'view_custom_stub' => [path_to_stubs] . 'view.custom.stub'
- Then this will generate a view file from that stub.
- For now, please refer to the [buildClass() in ViewCommand](https://github.com/bpocallaghan/generators/blob/master/src/Commands/ViewCommand.php) for the available placeholders.

### Controllers

```
php artisan generate:controller foo
php artisan generate:controller Foo
php artisan generate:controller CommentsController --plain
php artisan generate:controller Posts\CommentsController --plain --force
```

- The `\` will be used for the folder and namespace seperator
- The `Controller` postfix will be added automatically.


### Migrations

This is the same as [Jeffrey Way's](https://github.com/laracasts/Laravel-5-Generators-Extended)

```
php artisan generate:migration create_users_table
php artisan generate:migration create_users_table --plain
php artisan generate:migration create_users_table --force
php artisan generate:migration create_posts_table --schema="title:string, body:text, slug:string:unique, published_at:date"
```

- [Documentation in detail](https://github.com/laracasts/Laravel-5-Generators-Extended#migrations-with-schema)

### Pivot Tables

This is the same as [Jeffrey Way's](https://github.com/laracasts/Laravel-5-Generators-Extended)

```
php artisan generate:migration:pivot tags posts
```

- [Documentation in detail](https://github.com/laracasts/Laravel-5-Generators-Extended#pivot-tables)

### Database Seeders

```
php artisan generate:seed users
php artisan generate:seed users --plain
php artisan generate:seed users --force
```

- The `TableSeeder` will be added automatically

### Resource

```
php artisan generate:resource post
php artisan generate:resource posts.comment
```

- This will generate a Post model, PostsController, index / add_edit / show views, create_posts_table migration, PostTableSeeder
- This will generate a Comment model, Posts\Controller, index / add_edit / show views, create_comments_table migration, CommentTableSeeder

### Configuration

```
php artisan generate:publish-stubs
```

This will copy the config file to `/config/generators.php`.
Here you can change the model and controller namespace as well as the location for the stubs.

This will also copy all the stubs to `/resources/stubs/`.
Here you can make changes to the current stubs, add your own boilerplate / comments to the files.

## Shortcuts

```
art=php artisan
model=php artisan generate:model
view=php artisan generate:view
view:index=php artisan generate:view:index
view:add_edit=php artisan generate:view:add_edit
view:show=php artisan generate:view:show
controller=php artisan generate:controller
migration=php artisan generate:migration
migration:pivot=php artisan generate:migration:pivot
seed=php artisan generate:seed
resource=php artisan generate:resource
```

## Tank you

- Thank you [Jeffrey Way](https://github.com/JeffreyWay) for the awesome resources at [Laracasts](https://laracasts.com/).
- Thank you [Taylor Ottwell](https://github.com/taylorotwell) for [Laravel](http://laravel.com/).


### License
- MIT © 2015
