<?php
require '/../../../php/vendor/autoload.php';

use Illuminate\Database\Capsule\Manager as Capsule;


$capsule = new Capsule;

$settings = array(
    'driver' => 'mysql',
    'host' => '',
    'database' => '',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
);

$ess_netwerk = array(
    'driver' => 'mysql',
    'host' => '',
    'database' => '',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => ''
);

$teleapp = array(
    'driver' => 'sqlsrv',
    'host' => '',
    'database' => '',
    'username' => '',
    'password' => ''
);


$capsule->addConnection($settings, 'rapp');
$capsule->addConnection($ess_netwerk, 'ess_netwerk');
$capsule->addConnection($teleapp, 'teleapp');
$manager = $capsule->getDatabaseManager();
$manager->setDefaultConnection('rapp');

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$input = Illuminate\Http\Request::createFromGlobals();

define("app_name", "procbuiteninkoop");
define("menu", "3522");