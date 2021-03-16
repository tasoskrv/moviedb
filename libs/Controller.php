<?php

class Controller {

    protected $view;
    
    public function __construct() {
        $this->view = new View();
        date_default_timezone_set("Europe/Athens");
    }
    
    public function autorized(){
        /*
        Session::init();
        $logged = Session::get('loggedin');
        */        
        if(isset($_COOKIE['auth'])){/*
            $cookie = $_COOKIE['iduser'];
            $cookieVals = explode("?", $cookie);*/
            $logged = Cookie::get('loggedin');
        }
        if ($logged == 0) {
            Session::destroy();
            header("Location:" . URL . "login");
            exit;
        }
    }    
}

?>
