<?php
require '/../../../php/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;


$capsule = new Capsule;

$settings = array(
    'driver' => 'mysql',
    'host' => '',
    'database' => 'asset',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
);


$capsule->addConnection($settings, 'rapp');
$manager = $capsule->getDatabaseManager();
$manager->setDefaultConnection('rapp');

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$input = Illuminate\Http\Request::createFromGlobals();

//current app name and menu id
define("app_name", "am");
define("menu", "3543");
