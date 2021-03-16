<?php

class UserController extends Controller {

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->model_user = new UserModel();        
    }
    
    public function xhrWatchedMovie(){
        $this->model_user->xhrWatchedMovie();
    }
    
    public function xhrNotWatchedMovie(){
        $this->model_user->xhrNotWatchedMovie();
    }   
}

?>
