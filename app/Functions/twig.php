<?php

use App\Src\Flash;

$message = new \Twig_SimpleFunction('message', function ($index) {
	return Flash::get($index);
});

$empty = new \Twig_SimpleFunction('message', function ($index) {
	$value = $index ?? '';
	return $value;
});

return [
	$message
];