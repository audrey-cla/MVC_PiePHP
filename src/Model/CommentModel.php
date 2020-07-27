<?php

namespace src\Model;

use PDO;

class CommentModel extends \Core\Entity
{
    public static $relations = ['has one article'];
    public function getRelations()
    {
        return self::$relations;
    }
    public function test(){
        return $this->read();
    }

}
