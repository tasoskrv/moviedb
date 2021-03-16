<?php

class SearchController extends Controller {

    public function __construct() {
        parent::__construct();
        parent::autorized();
        $this->model_search = new SearchModel();
        $this->model_movie = new MovieModel();
        $this->model_user = new UserModel();
    }
    
    public function index(){
        
        $this->view->search = $this->model_search->getSearchResults();
        
        $this->view->searchType = "";
        if(isset($_GET['searchtext'])){
            $searchText = $_GET['searchtext'];
            if($searchText=="1*"){
                $this->view->searchType = "1*";
            }else if($searchText=="2*"){
                $this->view->searchType = "2*";
            }else if($searchText=="*"){
                $this->view->searchType = "*";
            }else{
                $this->view->searchType = $searchText;
            }
        }
        $this->view->total_movies = json_decode($this->model_movie->getTotalMovies($this->view->searchType));
        $this->view->renderView("search/index");
    }
    
    public function loadMoreResults(){
        $data = json_decode($_POST['data']);       
        return $this->model_search->getSearchResults($data);
    }
    
    public function loadMoreResultsHTML(){        
        if(isset($_POST['out'])){
            $response = json_decode($_POST['out']);            
            if($response->completed == "ok"){
                $this->view->loadmore = $response->search;
                $this->view->renderView('search/loadmore',true);
            }
        }
    }
}

?>
