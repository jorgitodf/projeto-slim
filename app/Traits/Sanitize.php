<?php

namespace App\Traits;

trait Sanitize
{
    protected function sanitize()
    {
        $sanitized = [];

        foreach ($_POST as $key => $value) {
            $sanitized[$key] = filter_var($value, FILTER_SANITIZE_STRING);
        }

        return $sanitized;
    }

}     