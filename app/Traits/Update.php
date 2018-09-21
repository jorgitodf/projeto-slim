<?php

namespace App\Traits;

trait Update
{
    public function update($attributes)
    {
        foreach ($attributes as $key => $value) {
            $attributes[$key] = str_replace('-', '', $value);
        }

        if (!isset($this->field) || !isset($this->value)) {
            throw new \Exception("Antes de fazer o update, por favor chame o find");
        }

        $sql = "UPDATE {$this->table} SET ";

        foreach($attributes as $field => $value) {
            $sql.= $field." = :{$field}, ";
        }

        $sql = substr_replace($sql, '', -2);

        $sql.= " WHERE {$this->field} = :{$this->field}";

        $attributes['id'] = (int)$this->value;

        $update = $this->connect->prepare($sql);
        $update->execute($attributes);

        return $update->rowCount();
     }
}