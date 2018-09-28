<?php

namespace App\Controllers;

use App\Src\Controller;
use App\Src\Validate;
use App\Src\Email;
use App\Templates\Contato;

class ContatoController extends Controller
{
    public function index()
    {
        $this->view('contato/index', ['title' => 'Contato', 'name' => 'Jorgito Paiva']);
    }

    public function store()
    {
        $validate = new Validate;

        $data = $validate->validate([
            'name' => 'required',
            'email' => 'required',
            'assunto' => 'required',
            'mensagem' => 'required'
        ]);

        if ($validate->hasErros()) {
            return back();
        }

        $email = new Email;
        $email->data([
            'fromName' => $data->name,
            'fromEmail' => $data->email,
            'toName' => 'Jorgito Paiva',
            'toEmail' => 'jspaiva.1977@gmail.com',
            'assunto' => $data->assunto,           
            'mensagem' => $data->mensagem
        ])->template(new Contato)->send();

    }
}