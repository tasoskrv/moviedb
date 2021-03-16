<?php
class ErrorController extends Controller{

    public function __construct() {
        parent::__construct();
        parent::autorized();
    }
    
    public function index(){
        $this->view->msg = "Page not exists";
        $this->view->renderView("error/index");
    }
    
    public function dbError(){
        $this->view->msg = "DB ERROR";
        $this->view->renderView("error/dberror");
    }
}
?>
