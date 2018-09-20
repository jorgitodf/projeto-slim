<?php

namespace App\Models;

use App\Src\Connection;
use App\Models\Posts;
use App\Models\Users;

class Model
{
    protected $connect;

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
		$sql = "SELECT * FROM {$this->table} WHERE {$field} = :{$field}";
		$find = $this->connect->prepare($sql);
		$find->bindValue($field, $value);
		$find->execute();

		return $find->fetch();
	}
}