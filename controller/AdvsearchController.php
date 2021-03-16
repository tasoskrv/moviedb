<?php

class AdvsearchController extends Controller {

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->model_advsearch = new AdvSearchModel();
        $this->model_category = new CategoryModel();
        //$this->view->js = array('product/js/product.js');
    }

    public function index(){
        $this->view->category = $this->model_category->getCategory();
        $this->view->renderView('advsearch/index');        
    }   
}




?>
