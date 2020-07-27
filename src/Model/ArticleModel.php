<?php

namespace src\Model;

class ArticleModel extends \Core\Entity
{
    public static $relations = ['has many comments'];

    public function getRelations()
    {
        return self::$relations;
    }

    public function test()
    {
        return $this->read();
    }
}
