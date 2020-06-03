<?php

/**
 * Class Loader
 */
class Loader {

    /**
     * Loader constructor.
     */
    public function __construct()
    {

        spl_autoload_register(function ($class_name)
        {

            $class_name = str_replace('\\', '/', $class_name);

            $file = __DIR__ . '/../' . $class_name . '.php';

            if(file_exists($file)) {
                require($file);
            }
            else {
                throw new \Exception("it's not allowed to load class: $class_name. >> " . $file);
            }

        });

    }

}

(new Loader());