# Caravel

**DISCLAIMER: This is a work in progress! Use at your own risk! When I am happy with implementation and test coverage, I will tag version. Suggestions welcome :)**

A lightweight CMS built on Laravel.  Yes, another CMS :/

The goal of this CMS is to be super light and easy to implement, while giving you full control of Laravel's toolset.  It can be added to an existing Laravel app, or installed into a fresh Laravel installation for standalone use.  It hooks into your Eloquent Models and automatically generates resourceful routes and views for basic CRUD management.  Bring your own authentication, view customizations, field types, etc.  [View a quick demo here.](http://recordit.co/hxPb7nh3RD)

- [Installation](#installation)
- [Field Configuration](#field-configuration)
- [Available Field Types](#available-field-types)
- [Add Field Types](#add-field-types)
- [Customize Views](#customize-views)
- [Authentication](#authentication)

## Installation

### 1. Install into your Laravel.
```
composer require 'thisvessel/caravel:dev-master'
```
Note: I will tag version as soon I am happy with implementation and test coverage.

### 2. Add CaravelServiceProvider to providers array in /config/app.php.
```php
ThisVessel\Caravel\CaravelServiceProvider::class,
```

### 3. Publish Caravel's config file.
```
php artisan vendor:publish --provider="ThisVessel\Caravel\CaravelServiceProvider" --tag="config"
```

### 4. Add Eloquent Model mappings to resources array in /config/caravel.php.
```php
'resources' => [
    'products' => App\Product::class,
    'newsletters'  => App\Newsletter::class,
],
```

### 5. Copy Caravel's routes into your routes.php file.
```php
// Caravel Route Group
Route::group(['prefix' => config('caravel.prefix'), 'as' => 'caravel::'], function () {

    // Caravel Root
    Route::get(null, [
        'as' => 'root', 'uses' => '\ThisVessel\Caravel\Controllers\DashboardController@redirect'
    ]);

    // Caravel Dashboard
    Route::get('dashboard', [
        'as' => 'dashboard', 'uses' => '\ThisVessel\Caravel\Controllers\DashboardController@index'
    ]);

    // Caravel Resources
    foreach (config('caravel.resources') as $resource => $model) {
        Route::resource($resource, '\ThisVessel\Caravel\Controllers\ResourceController', [
            'names' => ThisVessel\Caravel\Helpers\Routing::resourceNamesWithoutPrefix($resource)
        ]);
    }

});
```
To inspect which routes are dynamically generated, run the following command from your project root.
```
php artisan route:list
```
If you are configuring Caravel as a standalone installation, or you are routing through a subdomain, you might prefer setting a custom route `prefix` in `/config/caravel.php`.  Can be set `null`.

*That's it!  You now have a basic working CMS.*

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
        'username',
        'password',
        'biography',
        'hometown',
        'country',
    ];

    /**
     * Caravel CMS configuration.
     *
     * @var array
     */
    public $caravel = [
        'username' => 'required',
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

Your model's `$fillable` property is very important as it tells Caravel which fields need form input rendering.

The public `$caravel` property contains field modifiers and validation rules.  These are optional, and there are two ways to approach such configuration on a field:

1. Shorthand string, which allows you to quickly specify field type (eg. `type:simplemde`), as well as Laravel validation rules.  Using pipe `|` separators for specifying multiple modifiers.

2. More advanced configuration requires nesting array elements for `type`, `rules`, `label` and `help`.

## Available Field Types

Included field types:
- `input` (Basic text input)
- `textarea` (Basic textarea)
- `simplemde` ([Simplemde markdown editor](https://github.com/NextStepWebs/simplemde-markdown-editor))

...more to come very soon! (ie. checkboxes, radios, dropdowns, etc.)

## Add Field Types

You can add your new field types simply by referencing a new `type` string in your Model's `$caravel` field configuration.  This new type does not need to be registered anywhere.  Just be sure to provide Caravel with a proper view partial for this new field type.  A few notes on field type view partials:
- Place your new view partial within `/resources/views/vendor/caravel/fields`.
- You are responsible for displaying label, help block text, validation state, etc. correctly.
- A `$field` object is automatically passed into your view partial with necessary data for your markup (ie. name, label, required, help block text, etc.).
- A `$model` object is automatically passed into your view partial, in case you need access to other model properties.
- Finally, `$form` and `$bootForm` form builder objects are also passed into your view partial.  [Form](https://github.com/adamwathan/form) and [BootForms](https://github.com/adamwathan/bootforms) are excellent packages by [Adam Wathan](https://twitter.com/adamwathan).  Feel free to make use of these packages, otherwise plain old markup will work fine as well.

## Customize Views

You can easily override Caravel's views and view partials.  First publish Caravel's views to your project's /resources/views/vendor/caravel folder.
```
php artisan vendor:publish --provider="ThisVessel\Caravel\CaravelServiceProvider" --tag="views"
```
Once these views are published, you can modify anything within this folder.  Caravel will attempt to load your views before loading from /vendor.

## Authentication

Bring your own authentication!  You can easily apply any authentication middleware to Caravel's route group.  Don't forget to inform Caravel of your logout route so that the proper link can be displayed in the menu!  This can be specified in /config/caravel.php.
