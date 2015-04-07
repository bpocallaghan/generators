# Laravel 5 File Generators

Custom Laravel 5 File Generators with config and publishable stubs.
This package can be used by anyone at any given time, but keep in mind that it is optimized for my personal custom workflow.
It may not suit your workflow, but please let me know if I can help optimize this package.

## Installation

First, pull in the package through Composer.

```js
"require-dev": {
	"bpocallaghan/generators": "dev-master"
}
```

And then, include the service provider within `app/config/app.php`.

```php
'providers' => [
    'Bpocallaghan\Generators\GeneratorsServiceProvider',
];
```

## Usage

coming soon

## Commands
```bash
php artisan make:publish-stubs
php artisan make:controller FooController
php artisan make:model Foo
```

## currently in development