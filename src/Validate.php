<?php

namespace App\Src;

use App\Traits\Validations;
use App\Traits\Sanitize;

class Validate
{
    use Validations, Sanitize;

    public function validate($rules)
    {
        foreach ($rules as $key => $validation) {
            
            $validation = $this->validationWithParameter($key, $validation);

            if ($this->hasOneValidation($validation)) {
                $this->$validation($key);
            }

            if ($this->hasOneOrMoreValidation($validation)) {
                $validations = explode(':', $validation);

                foreach ($validations as $validation) {
                    $this->$validation($key);
                }
            }
        }
        return (object) $this->sanitize();
    }

    private function validationWithParameter($field, $validation) {

		$validations = [];

		if (substr_count($validation, '@') > 0) {
			$validations = explode(':', $validation);
		}

		foreach ($validations as $key => $value) {
			if (substr_count($value, '@') > 0) {

				list($validationWithParameter, $parameter) = explode('@', $value);

				$this->$validationWithParameter($field, $parameter);

				unset($validations[$key]);

				$validation = implode(':', $validations);
			}
		}

		return $validation;
	} 

    private function hasOneValidation($validate)
    {
        return substr_count($validate, ':') == 0;
    }

    private function hasOneOrMoreValidation($validate)
    {
        return substr_count($validate, ':') >= 1;
    }
}