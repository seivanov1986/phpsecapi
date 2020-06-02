<?php

namespace secapi\database;

class Sql
{

    private static $instances = [];
    var $link;

    protected function __construct() { }
    protected function __clone() { }
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance($id = '')
    {
        $cls = static::class . $id;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }

        return self::$instances[$cls];
    }

}