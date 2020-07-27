<?php

namespace Core;

class Entity
{
    public $id;
    public $values;
    public $add = [];
    public function __construct($params = [])
    {
        $relations = get_class($this)::getRelations();
        $this->relation = $relations;

        $table = strtolower(str_replace('Model', '', substr(get_class($this), strrpos(get_class($this), '\\') + 1))) . "s";
        $this->table = $table;

        if (array_key_exists('id', $params)) {
            $this->id = $params['id'];
            ORM::read($table, $this->id);
            return $this->id;
        } else {
            $this->fields = $params;
        }
    }

    public function save()
    {
        ORM::create($this->table, $this->fields);
    }

    public function read()
    {
        $values = [];
        if (empty(array_filter($this->relation))) {
            new ORM($this->table, $this->relation);
            $add = ORM::read($this->table, $this->id);
            if ($add !== NULL)
                $values = array_merge($values, $add);
        } else {
            for ($i = 0; $i < sizeof($this->relation); $i++) {
                new ORM($this->table, $this->relation[$i]);
                $add = ORM::read($this->table, $this->id);
                if ($add !== NULL)
                    $values = array_merge($values, $add);
            }
        }
        return $values;
    }

    public function update($id,$params)
    {
        return ORM::update($this->table, $id, $this->fields);
    }

    public function delete($id)
    {
        return ORM::delete($this->table, $id);
    }

    public function find($params = [])
    {
        $values = [];
        if (empty(array_filter($this->relation))) {
            new ORM($this->table, $this->relation);
            $add = ORM::find($this->table, $this->id, $params);
            if ($add !== NULL)
                $values = array_merge($values, $add);
        } else {
            for ($i = 0; $i < sizeof($this->relation); $i++) {
                new ORM($this->table, $this->relation[$i]);
                $add = ORM::find($this->table, $this->id, $params);
                if ($add !== NULL)
                    $values = array_merge($values, $add);
            }
        }
        return $values;
    }
}
