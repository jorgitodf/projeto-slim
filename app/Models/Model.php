<?php

namespace App\Models;

use App\Src\Connection;
use App\Traits\Create;
use App\Traits\Read;
use App\Traits\Update;
use App\Traits\Delete;

class Model
{
    use Create, Read, Update, Delete;

    protected $connect;
    protected $field;
    protected $value;

    public function __construct()
    {
        $this->connect = Connection::connect();
    }

    public function all()
    {
        $sql = "SELECT * FROM {$this->table}";
        $all = $this->connect->query($sql);
        $all->execute();
        return $all->fetchAll();
    }

    public function find($field, $value) 
    {
		$this->field = $field;
		$this->value = $value;

		return $this;
	}

    public function destroy($field,$value){
        $sql = "DELETE FROM {$this->table} WHERE {$field} = :{$field}";
        $delete = $this->connect->prepare($sql);
        $delete->bindValue($field,$value);
        $delete->execute();

        return $delete->rowCount();
    }
}