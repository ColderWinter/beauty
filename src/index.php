<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/19
 * Time: 17:51
 */

spl_autoload_register(function($class) {
    $class = str_replace('Beauty\\', '', $class);
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class . '.php';
    include $file;
});

use Beauty\Route;
use Beauty\App;
use Beauty\Request;

Route::add('www.bcd.com', '/user/get', 'Beauty', 'User', 'get');

$app = new App();
$request = new Request();

$app->handle($request);