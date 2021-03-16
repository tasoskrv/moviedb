<?php

class ActorController extends Controller {

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->model_actor = new ActorModel();
        //$this->view->js = array('product/js/product.js');
    }

    public function index(){
        $this->view->renderView('actor/index');
    }
    
    public function xhrAddactor(){
        $this->model_actor->xhrAddActor();
    }
    
    public function edit($idactor){
        $this->view->actor = $this->model_actor->edit($idactor);        
        $this->view->movies = $this->model_actor->getActorMovies($idactor);
        $this->view->renderView('actor/edit');
    }
    
    public function xhrEditActor(){
        $this->model_actor->xhrEditActor();
    }
    
    public function uploadPhoto(){
        $this->model_actor->uploadPhoto();
    }
    
    public function movies($id){
        $this->view->actor_movies = $this->model_actor->getActorMovies($id); 
        $this->view->actor_details = $this->model_actor->edit($id); 
        $this->view->renderView('actor/movies');
    }    
}




?>
