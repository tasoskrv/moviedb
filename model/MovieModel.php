<?php

class MovieModel extends Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function xhrAddMovie(){
        if (isset($_POST['data'])) {
            $data = json_decode($_POST['data']);
            try {
                $query = "insert into movie(title,year,runtime,rating,idcategory,plot,imdb,created)
                    values(:title,$data->year,:runtime,:rating,$data->idcategory,:plot,:imdb,CURDATE())";
                $binds = array(":title" => $data->title,":rating"=>$data->rating,":runtime"=>$data->runtime,":plot"=>$data->plot,":imdb"=>$data->imdb);
                $idmovie = $this->database->insertSql($query, $binds);
                $obj = new stdClass();
                $obj->completed = "ok";
                $obj->idmovie = $idmovie;
                
                if($data->poster!=""){
                    $source = file_get_contents($data->poster);
                    $poster = date('YmdHis') . rand(1, 1000) . ".jpg";
                    $query = "insert into image(image,cover,idmovie)values('$poster',1,$idmovie)";
                    $this->database->insertSql($query);
                    //Store in the filesystem.                
                    $fp = fopen("./public/images/movies/".$poster, "w");
                    fwrite($fp, $source);
                    fclose($fp);          
                }else{                    
                    $movie = new MovieModel();
                    $movie->uploadPhoto();                    
                }
                
                $obj->completed = "ok";                
                
                echo json_encode($obj);
            } catch (Exception $e) {
                $this->database->logs($e, $query);
                echo json_encode("error");
            }
        }
    }
    
    public function xhrEditMovie(){
        if (isset($_POST['data'])) {
            $data = json_decode($_POST['data']);
            try {
                $query = "update movie set title=:title,year=$data->year,idcategory=$data->idcategory,runtime=:runtime,rating=:rating,
                          imdb=:imdb,plot=:plot
                          where idmovie=$data->idmovie";
                $binds = array(":title" => $data->title,":runtime"=>$data->runtime,":rating"=>$data->rating,":plot"=>$data->plot,":imdb"=>$data->imdb);
                $this->database->updateSql($query, $binds);
                $obj = new stdClass();
                $obj->completed = "ok";
                $obj->idmovie = $data->idmovie;
                echo json_encode($obj);
            } catch (Exception $e) {
                $this->database->logs($e, $query);
                echo json_encode("error");
            }
        }
    }
    
    public function xhrGetImdb(){        
        if(isset($_POST['data'])){
            $data = json_decode($_POST['data']);            
            try{                
                $imdb = $data->imdb;                
                $url = "http://www.omdbapi.com/?i=".$imdb; 
                $contents = json_decode(file_get_contents($url));                
                $obj = new stdClass();
                foreach ($contents as $key=>$value) {  
                    switch ($key) {
                        case "Genre":
                            $obj->genres = $value;
                            break;
                        case "imdbRating":
                            $obj->rating = $value;
                            break;
                        case "Runtime":
                            $obj->runtime = $value;
                            break;
                        case "Title":
                            $obj->title = $value;
                            break;
                        case "Year":
                            $obj->year = $value;
                            break;          
                        case "Poster":
                            $obj->poster = $value;
                            break;
                        case "Plot":
                            $obj->plot = $value;
                            break;
                    }                    
                }
                echo json_encode($obj);
            }catch(Exception $e){
                $this->database->logs($e, $query);
                echo json_encode("error");
            }
        }
    }
    
    public function getMoviesSearch($text=null,$data=null){
        try {
            $iduser = Cookie::get('iduser');
            $binds = array();
            $start = 0;
            if($data!=null){
                $start = $data->start;
                $text = $data->type;
            }
            
            $where = "1=1";
            $binds = array(":text" => $text);
            $join = "left";
            $order = "movie.idmovie";
            
            if(is_object($text)){
                    $where = $this->buildFilters($text);
                    $binds = array();  
            } else if($text=="*"){    
                    $order = "title";
            }else if($text=="<>"){
                    $order = "movie.idmovie";  
            }else if(substr($text, 0, 1) === '>'){
                $where = "movie.rating>=".substr($text, 1);
            }else if(substr($text, 0, 1) === '<'){
                $where = "movie.rating<=".substr($text, 1);
            }else if($text=="1*"){//has seen
                $join = "inner";
                $order = "title";
            }else if($text=="2*"){//has not seen
                $where = " user_movies.idmovie is null";
                $order = "title";
            }else{//normal join                    
                $where = " title like '%' :text '%' or year like '%' :text '%' or category like '%' :text '%'";
                $order = "title";
            }

          $query = "select movie.idmovie,title,category,year,image.image,user_movies.idmovie as usermovie,runtime,rating,plot,imdb
                    from category inner join movie on category.idcategory = movie.idcategory 
                    left join image on movie.idmovie = image.idmovie 
                    $join join user_movies on movie.idmovie = user_movies.idmovie and user_movies.iduser=$iduser
                    where $where order by $order limit $start,".SEARCH_LIMIT;
                       
            $data = json_decode($this->database->selectSql($query, $binds));                        
            $obj = new stdClass();
            $obj->completed = "ok";
            $obj->search = $data;                        
            return json_encode($obj);
        } catch (Exception $e) {
            $this->database->logs($e, $query);
            echo json_encode("error");
        }
    }
        
    public function xhrSelectMovie(){
        if(isset($_GET['term'])){
            try {
                $term = str_replace(" ", "%", $_GET['term']);
                $term = stripslashes($term);
                $binds = array(":term" => $term);
                $query = "select idmovie,title from movie where title like '%' :term '%'";
                $data = json_decode($this->database->selectSql($query, $binds));
                $arrayJSON = array();
                foreach ($data as $key => $value) {
                    $newarray = array("value" => "$value->title", "label" => "$value->title", "idmovie" => "$value->idmovie");
                    array_push($arrayJSON, $newarray);
                    unset($newarray);        
                }
                echo json_encode($arrayJSON);
            } catch (Exception $e) {
                $this->database->logs($e, $query);
                echo json_encode("error");
            }
        }
    }
    
    public function edit($id){
        if ($id) {
            try {
                $query = "select movie.idmovie,title,year,movie.idcategory,image,rating,runtime,imdb,plot 
                         from movie left join image 
                         on movie.idmovie = image.idmovie
                         where movie.idmovie=$id";
                $data = json_decode($this->database->selectSql($query));
                $std = new stdClass();
                $std->completed = "ok";
                $std->data = $data;
                return json_encode($std);
            } catch (Exception $e) {
                $this->database->logs($e, $query);
                return json_encode("error");
            }
        }
    }
    
    public function uploadPhoto(){
        //include_once $path . 'settings/simpleimage.php';
        $dirName = ROOT."/public/images/movies/";
        if (isset($_FILES["image"]["name"])) {
            if ($_FILES["image"]["tmp_name"]) {
                $path_parts = pathinfo($_FILES["image"]["name"]);
                $name = date('YmdHis') . rand(1, 1000) . "." . $path_parts['extension'];
                $target = $dirName . $name; //target to be uploaded
                $targetIndex = $dirName . $name; //target to be uploaded
                if ((($_FILES["image"]["type"] == "image/gif")
                        || ($_FILES["image"]["type"] == "image/jpeg")
                        || ($_FILES["image"]["type"] == "image/png")
                        || ($_FILES["image"]["type"] == "image/pjpeg"))
                        && ($_FILES["image"]["size"] < 50000)) {
                    if ($_FILES["image"]["error"] > 0) {
                ?>                
                    <script>                        
                        //window.parent.newpic("<?= $target ?>","tryagain");
                    </script>                                
                        <?php
                    } else {//upload image           
                        $idmovie = $_POST["idmovie"];
                        $type = $_POST['type'];
                        if($type=="add"){
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
                            $query = "insert into image(image,cover,idmovie)values('$name',1,$idmovie)";
                            $this->database->insertSql($query);
                        }else if($type=="edit"){
                            $query = "select idimage as total from image where idmovie=$idmovie and cover=1";
                            $count = $this->database->countRows($query);
                            
                            if($count>0){//update
                                $query = "select idimage,image from image where idmovie=$idmovie and cover=1";
                                $data = json_decode($this->database->selectSql($query));
                                $idimage = $data[0]->idimage;
                                $image = $data[0]->image;
                                $query = "update image set image='$name' where idimage=$idimage";
                                $this->database->updateSql($query);
                                if($data[0]->image!="default.png"){
                                    unlink($dirName.$image);
                                }
                            }else{
                                $query = "insert into image(image,cover,idmovie)values('$name',1,$idmovie)";
                                $this->database->insertSql($query);
                            }
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
                        }
                        
                        /*//resize image
                        $image = new SimpleImage();
                        $image->load($target);
                        $image->resize(34, 34);
                        $image->save($target);*/
                        //if ($currentImage != "default.jpg") {//unlink old if exists
                          //  unlink($pathToImage . $dirName . $currentImage);
                        //}
                        //$queryNewImage = "update usersettings set valueis='$name' where typeis='userphoto' and iduser=$userID";
                        //$pdo->query($queryNewImage);
                        //kane kai topiko update                                        
                        ?>                    
                        <script>                        
                            //window.parent.newpic("<?= $targetIndex ?>","ok");
                        </script>                                        
                        <?php
                    }
                } else {
                        ?>
                        <script>                        
                            //window.parent.newpic("<?= $targetIndex ?>","wrongtype");
                        </script>
                    <?php
                }
            }
        }
    }
    
    public function getTotalMovies($type){        
        try {
            $iduser = Cookie::get('iduser');
            $binds = array();
            if($type=="*"){
                $query = "select count(idmovie) as total from movie";                
            }else{
                if($type=="1*"){//exo dei
                    $join = "inner";
                    $where = "";
                }else if($type=="2*"){//den exo dei
                    $join = "left";
                    $where = "where user_movies.idmovie is null";
                }else{//normal join                    
                    $join = "left";
                    $where = "where title like '%' :text '%' or year like '%' :text '%' or category like '%' :text '%'";
                }                
                $query = "select count(movie.idmovie) as total from 
                          category inner join movie on category.idcategory = movie.idcategory 
                          left join image on movie.idmovie = image.idmovie
                          $join join user_movies on movie.idmovie = user_movies.idmovie and user_movies.iduser=$iduser
                          $where";       
                $binds = array(":text" => $type);
            }
                        
            $data = json_decode($this->database->selectSql($query,$binds));            
            $obj = new stdClass();
            $obj->completed = "ok";
            $obj->total = $data;
                        
            return json_encode($obj);
        } catch (Exception $e) {
            $this->database->logs($e, $query);
            echo json_encode("error");
        }
    }
    
    private function buildFilters($obj){        
        $where = array();                   
        $keyword = $obj->keyword;             
        $category = $obj->category;
        $yearfrom = $obj->yearfrom;
        $yearto = $obj->yearto;
        $rating = $obj->rating;
        $searchfor = $obj->searchfor;
        
        if($keyword!=""){
            array_push ($where, "title like '%$keyword%'");                    
        }
        if(is_numeric($category) && $category != 0){
            array_push ($where, "category.idcategory=$category");
        }
        if(is_numeric($yearfrom)){
            array_push ($where, "year>=$yearfrom");
        }
        if(is_numeric($yearto)){
            array_push ($where, "year<=$yearto");
        }
        if(is_numeric($rating)){
            array_push ($where, "rating>=$rating");                    
        }
        if($searchfor == -1){
            array_push ($where, "user_movies.idmovie is null");
        }
        else if($searchfor == 1){
            array_push ($where, "user_movies.idmovie is not null");
        }
        return implode(" AND ", $where);
    }
    
}
?>
