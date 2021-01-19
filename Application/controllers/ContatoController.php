<?php

use Application\core\Controller;

class ContatoController extends Controller
{
    public function index(){
        $this->view('contato/index');
    }
}