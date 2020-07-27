<?php

namespace src;


class Database extends \Core\ORM
{
    private static $data = ['mysql:host=localhost;dbname=mycinemapiephp', "root", ""];
    public function getDatabase()
    {
        return self::$data;
    }
}

