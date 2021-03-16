<?php

class LogoutController extends Controller{

    public function __construct() {
        parent::autorized();
    }
    
    public function index(){
        //Session::destroy();
        
        Cookie::destroy();        
        header("Location:".URL."login");
        exit;
    }
}
?>
