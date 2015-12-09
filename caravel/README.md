# Caravel

Caravel is a lightweight CMS built on Laravel.  It can be added to an existing Laravel app, or installed into a fresh Laravel installation for standalone use.  It hooks into your Eloquent Models and automatically generates resourceful routes and views for basic CRUD management.  Bring your own auth, view customizations, field type extensions, etc.  [View a quick demo here.](http://recordit.co/hxPb7nh3RD)

## Installation

1. Require via Composer.
2. Add CaravelServiceProvider to app config.
3. Artisan vendor:publish config file.
4. Add resources & models to resources array in config.
5. Add public $caravel property onto each model.

## Example Model Config

```php
public $caravel = [

    // You can currently combine validation rules with type:fieldtype into shorthand string.
    'title' => 'required|min:5|type:simplemde',

    // Otherwise, nest field type, rules, label, and help as needed.
    'description' => [
        'type'  => 'simplemde',
        'rules' => 'required|min:10',
        'label' => 'Description Please',
        'help'  => 'Help block text goes here.',
    ],

];
```

## Requirements

- doctrine/dbal
- adamwathan/bootforms
