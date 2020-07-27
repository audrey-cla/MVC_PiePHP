<?php

namespace src\Model;

class UserModel extends \Core\Entity
{   
    public static $relations = [['has one membres']];
    public function getRelations()
    {
        return self::$relations;
    }
}
