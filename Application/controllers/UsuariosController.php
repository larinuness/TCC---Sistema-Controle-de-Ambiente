<?php

use Application\core\controller;

class UsuariosController extends Controller{
	
	public function index(){
        $Usuarios = $this->model('Usuarios');
		$data = $Usuarios::buscarTodos();
		$this->view('user/index',['users' => $data]);
	}
	
	public function show($id = null){
		if(is_numeric($id)) {
			$Usuarios = $this->model('Usuarios');
			$data = $Usuarios::buscaPorId($id);
			$this->view('user/show', ['user' => $data]);
		}
		else {
			$this->pageNotFound();
		}
	}
}