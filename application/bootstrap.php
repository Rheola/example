<?php
/**
 * Created by PhpStorm.
 * User: Rheola
 * Date: 31.08.16
 * Time: 10:42
 */
@session_start();
require_once __DIR__.'/core/Model.php';
require_once __DIR__.'/core/DbCommand.php';
require_once __DIR__.'/core/Controller.php';
require_once __DIR__.'/core/WebUser.php';
require_once __DIR__.'/core/Route.php';
Route::start();