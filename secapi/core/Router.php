<?php

namespace secapi\core;

use secapi\database\MySql;

/**
 * Class Router
 * @package secapi\core
 */
class Router
{

    /**
     * @var array
     */
    private $config = [];

    /**
     * Router constructor.
     */
    function __construct()
    {
    }

    /**
     * @param $config
     * @return $this
     */
    function setConfig($config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     *
     */
    function start()
    {

        session_start();

        MySql::getInstance()->connect($this->config);

        $request_uri = $_SERVER['REQUEST_URI'];
        $parse_request = array_filter( explode('/', $request_uri) );
        $parse_request = array_values($parse_request);

        $controller = null;
        $action = null;

        if (count($parse_request) == 1) {
            $controller_name = 'controllers\\PublicController';
            $action_name = 'action' . ucfirst($parse_request[0]);
        }
        else {
            $controller_name = 'controllers\\' . ucfirst($parse_request[0]) . 'Controller';
            $action_name = 'action' . ucfirst($parse_request[1]);
        }

        try {
            $controller = new $controller_name;
        }
        catch(\Exception $e) {
            //print_r($e->getMessage());
        }

        if ($controller) {
            if (method_exists($controller, $action_name)) {
                $action = $action_name;
            }
        }

        if ($controller) {

            if ($action) {
                $controller->$action();
            }
            else {
                $controller->actionIndex();
            }

        }

    }

}