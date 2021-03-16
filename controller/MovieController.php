<?php

class MovieController extends Controller {

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->model_movie = new MovieModel();
        $this->model_category = new CategoryModel();
    }

    public function index(){
        $this->view->category = $this->model_category->getCategory();
        $this->view->renderView('movie/index');
    }
    
    public function xhrAddMovie(){
        $this->model_movie->xhrAddMovie();
    }
    
    public function xhrSelectMovie(){
        echo $this->model_movie->xhrSelectMovie();
    }
    
    public function edit($idmovie){
        $this->view->movie = $this->model_movie->edit($idmovie);
        $this->view->category = $this->model_category->getCategory();
        $this->view->renderView('movie/edit');
    }
    
    public function uploadPhoto(){
        $this->model_movie->uploadPhoto();
    }
    
    public function xhrEditMovie(){
        $this->model_movie->xhrEditMovie();
    }
    
    public function addHtmlMovie(){
        $this->view->renderView('movie/moviepack',true);
    }
    
    public function xhrGetImdb(){
        echo $this->model_movie->xhrGetImdb();
    }   
}

?>
