# Laravel File Generators

Custom Laravel File Generators with a config file and publishable stubs.
You can publish the stubs. You can add your own stubs to generate.

This package is being used in the [Admin Starter Project](https://github.com/bpocallaghan/titan-starter) that focusses on test driven development and has the foundation ready for you.

```
Laravel 5.1 : v2.1.3
Laravel 5.2 - 5.3 : v3.0.3
Laravel 5.4 : v4.1.9
Laravel 5.5 - 5.8 : v5.0.0+
Laravel 6.0 : v5.1.0+
Laravel 7.0 : v6.0
Laravel 8.0 : v7.0+
```

## Commands
```bash
php artisan generate:publish-stubs
php artisan generate:model
php artisan generate:view
php artisan generate:controller
php artisan generate:migration
php artisan generate:migration:pivot
php artisan generate:seed
php artisan generate:resource
php artisan generate:repository
php artisan generate:contract
php artisan generate:notification
php artisan generate:event
php artisan generate:listener
php artisan generate:event-listener
php artisan generate:trait
php artisan generate:job
php artisan generate:console
php artisan generate:middleware
php artisan generate:factory
php artisan generate:test
php artisan generate:file
php artisan generate:exception
```

### Option for all the commands
`--force` This will override the existing file, if it exists.

### Option for all the commands, except `views` and `migration:pivot`
`--plain` This will use the .plain stub of the command (generate an empty controller)

### Customization
This is for all except the `migration` and `migration:pivot` commands

```
php artisan generate:file foo.bar --type=controller
php artisan generate:view foo.bar --stub=view_show --name=baz_show
php artisan generate:file foo.bar --type=controller --stub=controller_custom --name=BazzzController --plain --force
```

You can specify a custom name of the file to be generated.
You can add the --plain or --force options.
You can override the default stub to be used.
You can create your own stubs with the available placeholders.
You can create new settings' types, for example:
- 'exception' => ['namespace' => '\Exceptions', 'path' => './app/Exceptions/', 'postfix' => 'Exception'],

[Available placeholders](https://github.com/bpocallaghan/generators/blob/master/resources/stubs/example.stub)

## Views Custom Stubs

```
php artisan generate:view posts
php artisan generate:view admin.posts --stub=custom
php artisan generate:view admin.posts --stub=another_file
```

## Installation

Update your project's `composer.json` file.

```
composer require bpocallaghan/generators --dev
```

Add the Service Provider (Laravel 5.5+ has automatic discovery of packages)
You'll only want to use these generators for local development, add the provider in `app/Providers/AppServiceProvider.php`:

```php
public function register()
{
    if ($this->app->environment() == 'local') {
        $this->app->register(\Bpocallaghan\Generators\GeneratorsServiceProvider::class);
    }
}
```

Run `php artisan` command to see the new commands in the `generate:*` section

## Usage

- [Models](#models)
- [Views](#views)
- [Controllers](#controllers)
- [Migrations](#migrations)
- [Pivot Tables](#pivot-tables)
- [Database Seeders](#database-seeders)
- [Resource](#resource)
- [Repository](#repository)
- [Contract](#contract)
- [Notifications](#notifications)
- [Events and Listeners](#events-and-listeners)
- [Trait](#trait)
- [Job](#job)
- [Console](#console)
- [Middleware](#middleware)
- [Factory](#factory)
- [Test](#test)
- [File](#file)
- [Configuration](#configuration)

### Models

```
php artisan generate:model bar
php artisan generate:model foo.bar --plain
php artisan generate:model bar --force
php artisan generate:model bar --migration --schema="title:string, body:text"
```

### Views

```
php artisan generate:view foo
php artisan generate:view foo.bar
php artisan generate:view foo.bar --stub=view_show
php artisan generate:view foo.bar --name=foo_bar
```

### Controllers

```
php artisan generate:controller foo
php artisan generate:controller foo.bar
php artisan generate:controller fooBar
php artisan generate:controller bar --plain
php artisan generate:controller BarController --plain
```

- The `Controller` postfix will be added if needed.


### Migrations

This is very similar as [Jeffrey Way's](https://github.com/laracasts/Laravel-5-Generators-Extended)

```
php artisan generate:migration create_users_table
php artisan generate:migration create_users_table --plain
php artisan generate:migration create_users_table --force
php artisan generate:migration create_posts_table --schema="title:string, body:text, slug:string:unique, published_at:date"
```

### Pivot Tables

This is very similar as [Jeffrey Way's](https://github.com/laracasts/Laravel-5-Generators-Extended)

```
php artisan generate:migration:pivot tags posts
```

### Database Seeders

```
php artisan generate:seed bar
php artisan generate:seed BarTableSeeder
```

- The `TableSeeder` suffix will be added if needed.

### Resource

```
php artisan generate:resource bar
php artisan generate:resource foo.bar
php artisan generate:resource foo.bar_baz
php artisan generate:resource bar --schema="title:string, body:text, slug:string:unique, published_at:date"
php artisan generate:resource articles --controller=admin
```

- This will generate a Bar model, BarsController, resources views (in config), create_bars_table migration, BarTableSeeder
- In the config there is a `resource_views` array, you can specify the views that you want to generate there, just make sure the stub exist.
- This will also ask you to generate the 'repository - contract pattern' files.
- The `--controller=admin` allows you to use the controller_admin stub when generating the controller.

### Repository
```
php artisan generate:repository Posts
```
This will generate a Posts Repository file to be used in your controller.

### Contract
```
php artisan generate:contract Cache
```
This will generate a Cache Contract file to be used with your repositories.

### Notifications

```
php artisan generate:notification UserRegistered
```

This will generate a UserRegistered notification.
Laravel provides support for sending notifications across a variety of delivery channels, including mail, SMS (via Nexmo), and Slack. Notifications may also be stored in a database so they may be displayed in your web interface.

### Events and Listeners

```
php artisan generate:event InvoiceWasPaid
php artisan generate:listener NotifyUserAboutPayment --event=InvoiceWasPaid
php artisan generate:event-listener
```
This will generate the event and listener.
Laravel's events provides a simple observer implementation, allowing you to subscribe and listen for various events that occur in your application

`php artisan generate:event-listener `
Will generate all the missing events and listeners defined in your EventServiceProvider.

### Trait
```
php artisan generate:trait Http\Controllers\Traits\Bar
```
This will generate a FooBar Trait file. The command will use the name as your namespace.
`generate:trait Foo` will create a file in `app/Foo.php`, `generate:trait Foo\Bar` will create a file in `app/Foo/Bar.php`.

### Job
```
php artisan generate:job SendReminderEmail
```
This will generate a SendReminderEmail Job file.

### Console (Artisan Command)
```
php artisan generate:console SendEmails
php artisan generate:console SendEmails --command=send:emails
```
This will generate a SendEmails Artisan Command file. The --command option is optional.

### Middleware
```
php artisan generate:middleware AuthenticateAdmin
```
This will generate an AuthenticateAdmin Middleware file.

### Factory
```
php artisan generate:factory Post
php artisan generate:factory PostFactory
```
This will generate a PostFactory model file.

### Test
```
php artisan generate:test UserCanLogin
php artisan generate:test Post --unit
php artisan generate:test Auth\LoginTest
```
This will generate Feature\UserCanLogin and Unit\PostTest and Unit\Auth\LoginTest files.

### Configuration

```
php artisan generate:publish-stubs
```

This will copy the config file to `/config/generators.php`.
Here you can change the defaults for the settings of each `type`, like model, view, controller, seed.
You can also change the namespace, path where to create the file, the pre/post fix, and more.
You can also add new stubs.

This will also copy all the stubs to `/resources/stubs/`.
Here you can make changes to the current stubs, add your own boilerplate / comments to the files.
You can also add your own stubs here and specify it in the config to be used.
**Migration Stub Note**: The `migration.stub` is only the outer part and the `schema_create.stub or schema_change.stub` is where you modify the schema itself. The `schema_create.stub` has boilerplate added to it.

### File

This is the base command for the view, model, controller, seed commands.
The migration and migration:pivot uses Jeffrey's classes.
In the config there is a `settings` array, this is the 'types' and their settings. You can add more, for example, if you use repositories, you can add it here.

```
php artisan generate:file foo.bar --type=view
php artisan generate:file foo.bar --type=controller
php artisan generate:file foo.bar --type=model
php artisan generate:file foo.bar --type=model --stub=model_custom
```

## Shortcuts

```
art=php artisan
model=php artisan generate:model
view=php artisan generate:view
view:index=php artisan generate:view:index
view:create_edit=php artisan generate:view:create_edit
view:show=php artisan generate:view:show
controller=php artisan generate:controller
migration=php artisan generate:migration
migration:pivot=php artisan generate:migration:pivot
seed=php artisan generate:seed
resource=php artisan generate:resource
```
## Customizing file was created message to add support for ide opening the files

Make links for opening output.Add output_path_handler as a function to your config/generators.php.Example:

```
'output_path_handler' => static function($path){
    return 'file:///' . base_path() . $path;
},
```
This will output a file schema uri which JetBrain Products (Intellij,Php Storm,Web Storm,...) then can open directly from your terminal.

## Thank you

- Thank you [Taylor Ottwell](https://github.com/taylorotwell) for [Laravel](http://laravel.com/).
- Thank you [Jeffrey Way](https://github.com/JeffreyWay) for the awesome resources at [Laracasts](https://laracasts.com/).

## My other Packages

- [Notify](https://github.com/bpocallaghan/notify) Laravel Flash Notifications with icons and animations and with a timeout
- [Alert](https://github.com/bpocallaghan/alert) A helper package to flash a bootstrap alert to the browser via a Facade or a helper function.
- [Impersonate User](https://github.com/bpocallaghan/impersonate) This allows you to authenticate as any of your customers.
- [Sluggable](https://github.com/bpocallaghan/sluggable) Provides a HasSlug trait that will generate a unique slug when saving your Laravel Eloquent model.
