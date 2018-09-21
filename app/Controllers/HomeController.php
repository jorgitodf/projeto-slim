<?php

namespace App\Controllers;

use App\Src\Controller;
use App\Models\Posts;
use App\Src\Validate;
use App\Models\Users;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController extends Controller
{
    private $post;
    private $user;

    public function __construct() 
    {
        $this->post = new Posts;
        $this->user = new Users;
    }

    public function index()
    {
        $users = $this->user->select()->get();
        $this->view('home/index', ['users' => $users, 'title' => 'Página Home']);
    }

    public function store()
    {
        echo json_encode('Home Subscribe');
    }

    public function edit(Request $request, Response $response, $args)
    {
        $user = $this->user->select()->where('id', $args['id'])->first();
        $this->view('home/editar', ['user' => $user, 'title' => 'Edição Usuário']);
    }

    public function update(Request $request, Response $response, $args)
    {
        $validate = new Validate;

        $data = $validate->validate([
            'name' => 'required:max@80',
            'email' => 'required:email',
            'phone' => 'required:phone'
        ]);

        if ($validate->hasErros()) {
            $this->view('home/editar', ['title' => 'Edição Usuário' , 'user' => $data]);
        }

        $up = $this->user->find('id', $_POST['id'])->update([
            'id' => $_POST['id'],
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone
        ]);

        if ($up > 0) {
            flash('message', success('Usuário Atualizado com Sucesso!'));
            return back();
        }

        flash('error', error('Erro ao Atualizar!'));
    }

    public function delete(Request $request, Response $response, $args)
    {
        $del = $this->user->find('id', $args['id'])->delete();

        if ($del == true) {
            flash('message', success('Usuário Deletado com Sucesso!'));
            return redirect('/');
        }

        flash('error', error('Erro ao Deletar o Usuário!'));
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
            $this->view('home/create', ['title' => 'Cadastro' , 'dados' => $data]);
        } else {
            $user = $this->user->create((array)$data);
            if ($user) {
                flash('message', success('Usuário Cadastrado com Sucesso!'));
                return back();
            }
        }
    }
}   