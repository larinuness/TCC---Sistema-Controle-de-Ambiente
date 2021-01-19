<?php

use Application\core\Controller;

class QuemSomosController extends Controller
{
    public function index(){
        $this->view('quemsomos/index');
    }
}