<?php

class CategoryController extends Controller {

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->model_category = new CategoryModel();
    }
    
    public function index(){
        $this->view->renderView('category/index');
    }
    
    public function xhrAddCategory(){
        $this->model_category->xhrAddCategory();
    }
}

?>
