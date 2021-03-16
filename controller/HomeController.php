<?php

class HomeController extends Controller{

    public function __construct() {
        parent::__construct();
        $this->model_home = new HomeModel();
    }

    public function index(){
        $this->view->latestmovies = $this->model_home->getLatestEntries();
        $this->view->renderView('home/index');
    }  
}


?>
