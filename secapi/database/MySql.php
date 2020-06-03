<?php

namespace secapi\database;

use secapi\database\Sql;

/**
 * Class MySql
 * @package secapi\database
 */
class MySql extends Sql
{

    /**
     * @param array $params
     */
    function connect($params = [])
    {

        $host = isset($params['host']) ? $params['host'] : '';
        $user = isset($params['user']) ? $params['user'] : '';
        $password = isset($params['password']) ? $params['password'] : '';
        $database = isset($params['database']) ? $params['database'] : '';

        try {

            $this->link = @mysqli_connect(
                $host, $user, $password, $database
            );

            if ($this->link === false) {
                //echo 'mysql error' . PHP_EOL;
            }

        }
        catch(\Exception $e) {
            print_r($e->getMessage());
        }

    }

    /**
     * @return int|string
     */
    function getLastId()
    {
        return mysqli_insert_id($this->link);
    }

    /**
     * @param $query
     * @return mixed
     */
    function query($query)
    {

        return $this->link->query($query);
    }

    /**
     * @param $query
     * @return array
     */
    function getQuery($query)
    {
        $result = $this->query($query);
        $array = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $array[] = $row;
            }
        }
        return $array;
    }

    /**
     *
     */
    function __destruct()
    {
        if ($this->link) {
            mysqli_close($this->link);
        }
    }

}