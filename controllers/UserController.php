<?php

namespace controllers;

use secapi\core\Controller;
use secapi\database\MySql;

class UserController extends Controller
{

    function actionIndex() {
        echo 'user index' . PHP_EOL;
    }

    function actionList() {

        echo 'user list' . PHP_EOL;
        $a = MySql::getInstance();

    }

}