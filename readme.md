# Caravel

**DISCLAIMER: This is a work in progress! Use at your own risk! When I am happy with API and test coverage, I will tag version. Suggestions welcome :)**

A lightweight CMS built on Laravel.  Wait, another CMS?  Yes, another CMS.

It can be added to an existing Laravel app, or installed into a fresh Laravel installation for standalone use.  It hooks into your Eloquent Models and automatically generates resourceful routes and views for basic CRUD management.  Bring your own auth, view customizations, field type extensions, etc.  [View a quick demo here.](http://recordit.co/hxPb7nh3RD)

## Installation

### 1. Install into your Laravel project using [Composer](https://getcomposer.org).
```
composer require 'thisvessel/caravel:dev-master'
```
Note: I will tag version as soon I've added sufficient test coverage.

### 2. Add CaravelServiceProvider to providers array in /config/app.php
```php
ThisVessel\Caravel\CaravelServiceProvider::class,
```

### 3. Publish Caravel's config file.
```
php artisan vendor:publish --provider="ThisVessel\Caravel\CaravelServiceProvider" --tag="config"
```

### 4. Add Eloquent Model mappings to resources array in /config/caravel.php
```php
'resources' => [
    'products' => App\Product::class,
    'newsletters'  => App\Newsletter::class,
],
```

### 5. Copy these routes into your routes.php file.
```php
// Caravel Route Group
Route::group(['prefix' => config('caravel.route_prefix')], function () {

    // Caravel Dashboard
    Route::get('dashboard', '\ThisVessel\Caravel\Controllers\DashboardController@page');

    // Caravel Resources
    foreach (config('caravel.resources') as $resource => $model) {
        Route::resource($resource, '\ThisVessel\Caravel\Controllers\ResourceController');
    }

});
```

That's it!  You now have a basic working CMS.

## Field Configuration

Field configuration happens in your Eloquent Model.

```php
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'password',
        'biography'
    ];

    /**
     * Caravel CMS configuration.
     *
     * @var array
     */
    public $caravel = [
        'name' => 'required',
        'password' => 'type:password|required|min:8',
        'biography' => [
            'type'  => 'simplemde',
            'rules' => 'required|min:10',
            'label' => 'Author Biography',
            'help'  => 'Help block text goes here.',
        ],
    ];
}
```

Your model's `$fillable` property is very important as it tells Caravel which fields to render.

The public `$caravel` property contains field modifiers and validation rules.  There are two ways to approach configuration on a field.

1. Shorthand string, which allows you to quickly specify field type, as well as validation rules as per Laravel spec.

2. More advanced configuration requires nesting array elements for type, rules, label and help.

## Authentication

There is none!  Bring your own authentication!  You can easily apply authentication middleware to Caravel's route group.  I may add more authentication options in the future.
