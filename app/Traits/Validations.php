<?php

namespace App\Traits;

trait Validations
{
    private $errors = [];

    protected function required($field)
    {
        if (empty($_POST[$field])) {
            $this->errors[$field][] = flash($field, error('Esse campo é obrigatório!'));
        }
    }

    protected function email($field)
    {
		if (!filter_var($_POST[$field], FILTER_VALIDATE_EMAIL)) {
			$this->errors[$field][] = flash($field, error('O E-mail informado não é válido!'));
		}        
    }

    protected function phone($field)
    {
		if (!preg_match("/[0-9]{5}\-[0-9]{4}/", $_POST[$field])) {
			$this->errors[$field][] = flash($field, error('O Número do telefone informado é inválido!'));
		}
    }

	protected function unique($field, $model) {
		$model = "App\\Models\\" . ucfirst($model);

		$model = new $model();

		$find = $model->find($field, $_POST[$field]);

		if ($find && !empty($_POST[$field])) {
			$this->errors[$field][] = flash($field, error('O E-mail informado já está cadastrado!'));
		}
	}

	protected function max($field, $max) {
		if (strlen($_POST[$field]) > $max) {
			$this->errors[$field][] = flash($field, error("O número de caracteres para esse campo não pode ser maior que {$max}"));
		}
	}

    public function hasErros()
    {
        return !empty($this->errors);
    }
}