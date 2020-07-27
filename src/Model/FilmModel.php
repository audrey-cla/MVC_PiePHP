<?php

namespace src\Model;

use PDO;

class FilmModel extends \Core\Entity
{
    public static $relations = [['has one genre']];
    public function getRelations()
    {
        return self::$relations;
    }
    public function rendu(){
        return $this->find(array("LIMIT" => "15"));
    }

    public function showmovie($id){
        return $this->find(array("WHERE" => "id_film = $id"));
    }


  
}
