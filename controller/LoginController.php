<?php

class LoginController extends Controller{

    public function __construct() {
        parent::__construct();
        $this->login_model = new LoginModel();
    }

    public function index(){
        $this->view->renderView('login/index');
    }
    
    public function authenticate(){
        $this->login_model->loginApp();
    }   
}


?>
