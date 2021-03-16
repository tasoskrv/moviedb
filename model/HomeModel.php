<?php

class HomeModel extends Model {

    public function __construct() {
       parent::__construct();
    }    
    
    public function getLatestEntries(){
        try {
            $query = "select title,image,year,rating,category,imdb from category inner join movie 
                      on category.idcategory = movie.idcategory
                      left join image
                      on movie.idmovie = image.idmovie
                      where cover = 1  
                      order by movie.idmovie desc limit 0,30";
            $data = $this->database->selectSql($query);
            return $data;
        } catch (Exception $e) {
            $this->database->logs($e);
            echo json_encode("error");
        }
    }   
}
?>
