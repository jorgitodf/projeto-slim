<?php

namespace App\Traits;

use App\Models\Paginate;

trait Read 
{
	private $binds;
	private $isPaginate = false;
	private $paginate;

    public function select($fields = '*') 
    {
		$this->sql = "SELECT {$fields} FROM {$this->table}";
		return $this;
	}

    public function where() 
    {
		$num_args = func_num_args();
		$args = func_get_args();
		$args = $this->whereArgs($num_args, $args);
		$this->sql .= " WHERE {$args['field']} {$args['sinal']} :{$args['field']}";

		$this->binds = [
			$args['field'] => $args['value'],
		];

		return $this;
	}

    private function whereArgs($num_args, $args) 
    {
		if ($num_args < 2) {
			throw new \Exception("Opa, algo errado aconteceu, o where precisa de no mínimo 2 argumentos");
		}

		if ($num_args == 2) {
			$field = $args[0];
			$sinal = '=';
			$value = $args[1];
		}

		if ($num_args == 3) {
			$field = $args[0];
			$sinal = $args[1];
			$value = $args[2];
		}

		if ($num_args > 3) {
			throw new \Exception("Opa, algo errado aconteceu, o where não pode ter mais que 3 argumentos");
		}

		return [
			'field' => $field,
			'sinal' => $sinal,
			'value' => $value,
		];
	}

    public function paginate($perPage) 
    {
		$this->paginate = new Paginate;
		$this->paginate->records($this->count());
		$this->paginate->paginate($perPage);
		$this->sql .= $this->paginate->sqlPaginate();

		return $this;
	}

    public function links() 
    {
		return $this->paginate->links();
	}

	public function busca($fields)
	{
		$fields = explode(',', $fields);

		$this->sql.= " WHERE";

		foreach ($fields as $field) {
			$this->sql.= " {$field} LIKE :{$field} OR";
			$this->binds[$field] = "%".busca()."%";
		}
		
		$this->sql = substr_replace($this->sql, '', -2);

		return $this;
	}

    public function get() 
    {
		$select = $this->bindAndExecute();
		return $select->fetchAll();
	}

    public function first() 
    {
		$select = $this->bindAndExecute();
		return $select->fetch();
	}

    public function count() 
    {
		$select = $this->bindAndExecute();
		return $select->rowCount();
	}

    private function bindAndExecute() 
    {
		$select = $this->connect->prepare($this->sql);
		$select->execute($this->binds);
		return $select;
	}
}