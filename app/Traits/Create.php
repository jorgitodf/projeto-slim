<?php

namespace App\Traits;

trait Create
{
    public function create($attributes)
    {
        foreach ($attributes as $key => $value) {
            $attributes[$key] = str_replace('-', '', $value);
        }

        $sql = "INSERT INTO {$this->table} (". implode(', ', array_keys($attributes)). ") VALUES (";
        $sql.= ":". implode(', :', array_keys($attributes)). ")";

        $create = $this->connect->prepare($sql);
        $create->execute($attributes);

        return $this->connect->lastInsertId();
    }
}