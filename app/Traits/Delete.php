<?php

namespace App\Traits;

trait Delete
{
    public function delete()
    {
        if (!isset($this->field) || !isset($this->value)) {
            throw new \Exception("Antes usar o Delete, chame o Find");
        }

        $sql = "DELETE FROM {$this->table} where {$this->field} = :{$this->field}";
        $delete = $this->connect->prepare($sql);
        $delete->bindValue($this->field,$this->value);
        $delete->execute();

        return $delete->rowCount();

    }
}