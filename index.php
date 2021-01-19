<?php
if($_SERVER['SERVER_NAME'] != 'stark.servicesweb.xyz'){
    if(substr($_SERVER['REQUEST_URI'],1,3) == 'kaa'){
        $uri = substr($_SERVER['REQUEST_URI'],4);
    }
    else{
        $uri = $_SERVER['REQUEST_URI'];
    }
    header('Location: http://stark.servicesweb.xyz'.$uri);
}
require 'Application/autoload.php';

use Application\core\App;
use Application\core\Controller;


$app = new App();
	
