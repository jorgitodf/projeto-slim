<?php

namespace App\Controllers;

use App\Src\Controller;
use App\Models\Posts;
use App\Src\Validate;

class HomeController extends Controller
{
    protected $post;

    public function __construct() 
    {
        $this->post = new Posts;
    }

    public function index()
    {
        $this->view('home/index', ['nome' => 'Jorgito Paiva', 'title' => 'Página Home']);
    }

    public function store()
    {
        echo json_encode('Home Subscribe');
    }

    public function posts()
    {
        $posts = $this->post->all();

        $this->view('home/index', ['posts' => $posts, 'title' => 'Página Home']);
    }

    public function new()
    {
        $this->view('home/create', ['title' => 'Cadastro']);
    }

    public function create()
    { 
        $validate = new Validate;

        $data = $validate->validate([
            'name' => 'required:max@80',
            'email' => 'required:email:unique@users',
            'phone' => 'required:phone'
        ]);

        if ($validate->hasErros()) {
            //return back();
            $this->view('home/create', ['title' => 'Cadastro' , 'dados' => $data]);
        }

        echo "Cadastrar os Dados no Banco de Dados";
    }
}   