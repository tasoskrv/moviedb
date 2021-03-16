<?php

class MainController extends Controller{

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->dashboard_model = new MainModel();
        //$this->view->js = array('main/js/dash.js');
    }

    public function index(){
        $this->view->renderView('main/index');
    }  
}


?>
