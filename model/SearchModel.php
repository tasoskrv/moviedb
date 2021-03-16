<?php

class SearchModel extends Model {

    public function __construct() {
        parent::__construct();
        $this->model_movie = new MovieModel();
        $this->model_actor = new ActorModel();
    }

    public function getSearchResults($data=null){
        
        try {
            $obj = new stdClass();
            if (isset($_GET['searchtext'])) {
                $searchText = $_GET['searchtext'];
                if ($searchText === "*") {
                    $dataSearchMovie = json_decode($this->model_movie->getMoviesSearch("*"));
                    $dataSearchActor = json_decode($this->model_actor->getActorSearch("***"));
                }else if($searchText==="#"){
                    $dataSearchMovie = json_decode($this->model_movie->getMoviesSearch("***"));
                    $dataSearchActor = json_decode($this->model_actor->getActorSearch());                    
                }else if($searchText==="<>"){
                    $dataSearchMovie = json_decode($this->model_movie->getMoviesSearch("<>"));
                    $dataSearchActor = json_decode($this->model_actor->getActorSearch());                    
                }else {
                    $dataSearchMovie = json_decode($this->model_movie->getMoviesSearch($searchText));
                    $dataSearchActor = json_decode($this->model_actor->getActorSearch($searchText));
                }
                if($dataSearchActor->completed=="ok"){
                    $obj->actors = $dataSearchActor->search;
                }                                
            }else{                
                $obj->keyword = System::advancedSearchValues ('keyword');
                $obj->category = System::advancedSearchValues('category');
                $obj->yearfrom = System::advancedSearchValues('yearfrom');
                $obj->yearto = System::advancedSearchValues('yearto');
                $obj->rating = System::advancedSearchValues('rating');
                $obj->searchfor = System::advancedSearchValues('searchfor');                
                $dataSearchMovie = json_decode($this->model_movie->getMoviesSearch($obj,$data));                
            }            
            if($dataSearchMovie->completed=="ok"){
                $obj->movies = $dataSearchMovie->search;
            }            
            return $obj;
        } catch (Exception $e) {
            $this->database->logs($e);
            echo json_encode("error");
        }
    } 
}

?>
