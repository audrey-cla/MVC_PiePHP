<?php

namespace src;

class Name extends \Core\Core
{
    private static $name = "MVC_PiePHP";
    public function getName()
    {
        return self::$name;
    }
}
