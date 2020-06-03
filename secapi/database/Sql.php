<?php

namespace secapi\database;

/**
 * Class Sql
 * @package secapi\database
 */
class Sql
{

    /**
     * @var array
     */
    private static $instances = [];
    /**
     * @var
     */
    var $link;

    /**
     * Sql constructor.
     */
    protected function __construct() { }

    /**
     *
     */
    protected function __clone() { }

    /**
     * @throws \Exception
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * @param string $id
     * @return mixed
     */
    public static function getInstance($id = '')
    {
        $cls = static::class . $id;

        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }

        return self::$instances[$cls];
    }

}