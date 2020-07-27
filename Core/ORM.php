<?php

namespace Core;

use PDO;

class ORM
{
    public static $join;

    public function __construct($table = '', $relations = [])
    {
        if (!empty(array_filter($relations))) {

            if (strpos($relations[0], 'has one') === 0) {
                $sing = trim(str_replace('has one', '', $relations[0]));
                $plur = $sing . 's';
                $join = " INNER JOIN $plur ON $table.id_$sing = $plur.id ";
                self::$join = $join;
            }

            if (strpos($relations[0], 'has many') === 0) {
                $plur = trim(str_replace('has many', '', $relations[0]));
                $sing = preg_replace("/s$/", '', $table);
                $join = " INNER JOIN $plur ON $plur.id_$sing = $table.id ";
                self::$join = $join;
            }
        }
    }

    public function array_push_assoc($array, $key, $value)
    {
        $array[$key] = $value;
        return $array;
    }

    public function create($table, $fields)
    {
        $field = $value = '';
        $execute = [];
        $key = array_keys($fields);

        for ($i = 0; $i < sizeof($key); $i++) {
            $field .= '`' . $key[$i] . '`,';
            $value .= ':' . $key[$i] . ',';
            $execute = self::array_push_assoc($execute, ':' . $key[$i], $fields[$key[$i]]);
        }
        $field = rtrim($field, ",");
        $value = rtrim($value, ",");

        $dbh = new \src\Database();
        $dbh = new PDO($dbh->getDatabase()[0], $dbh->getDatabase()[1], $dbh->getDatabase()[2]);
        $register_that = $dbh->prepare("INSERT INTO `" . $table . "`(" . $field . ") VALUES (" . $value . ")");
        $register_that->execute($execute);

        $query = $dbh->query("SELECT * FROM $table Order by ID desc Limit 1");
        $donnees = $query->fetch();
        return $donnees['id'];
    }
    public function read($table, $id = "")
    {
        $dbh = new \src\Database();
        $dbh = new PDO($dbh->getDatabase()[0], $dbh->getDatabase()[1], $dbh->getDatabase()[2]);
        $cond = '';
        if (!empty($id)) {

            $cond = "WHERE $table.id = $id";
        }
        $statement = "SELECT * FROM $table "  .  self::$join . $cond;
        $read = $dbh->query($statement);
        if ($read) {
            $read = $read->fetchAll();
            return $read;
        }
    }

    public function update($table, $id, $fields)
    {
        $tables = rtrim($table, "s");
        $field = '';
        $execute = [];
        $key = array_keys($fields);

        for ($i = 0; $i < sizeof($key); $i++) {
            $field .= "`$key[$i]`= :$key[$i],";
            $execute = self::array_push_assoc($execute, ':' . $key[$i], $fields[$key[$i]]);
        }

        $field = rtrim($field, ",");
        $dbh = new \src\Database();
        $dbh = new PDO($dbh->getDatabase()[0], $dbh->getDatabase()[1], $dbh->getDatabase()[2]);

        $execute = self::array_push_assoc($execute, ':id', $id);
        $update_that = $dbh->prepare("UPDATE `$table` SET $field WHERE id_$tables = :id");
        $update_that->execute($execute);
    }

    public function delete($table, $id)
    {
        $tables = rtrim($table, "s");
        $dbh = new \src\Database();
        $dbh = new PDO($dbh->getDatabase()[0], $dbh->getDatabase()[1], $dbh->getDatabase()[2]);
        $delete_that = $dbh->prepare("DELETE FROM $table WHERE id_$tables = :id");
        $delete_that->execute(array(':id' => $id));
    }

    public function find($table, $id, $params = array('WHERE' => '', 'ORDER BY' => '', 'LIMIT' => ''))
    {
        $join = self::$join;
        $options = '';
        $params = array_filter($params);
        $key = array_keys($params);
        for ($i = 0; $i < sizeof($key); $i++) {
            if ($key[$i] == "nojoin") {
                $join = '';
            } else {
                $value = $params[$key[$i]];
                $options .= "$key[$i] $value";
            }
        }
        $dbh = new \src\Database();
        $dbh = new PDO($dbh->getDatabase()[0], $dbh->getDatabase()[1], $dbh->getDatabase()[2]);
        $find = $dbh->query("SELECT * FROM $table  $join $options");


        if ($find) {
            $find = $find->fetchAll();
            return $find;
        }
    }
}
