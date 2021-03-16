<?php

class ActorModel extends Model {

    public function __construct() {
       parent::__construct();
    }
    
    public function xhrAddActor(){
        if(isset($_POST['data'])){
            $data = json_decode($_POST['data']);
            try{
                $query = "insert into actor(name) values(:name)"; 
                $binds = array(":name"=>$data->name);
                $idactor = $this->database->insertSql($query,$binds);
                
                $movies = json_decode($_POST['movies']);
                if(count($movies)>0){
                    foreach ($movies as $idmovie) {
                        if(is_numeric($idmovie->idmovie)){
                            $query = "insert into actor_movie(idmovie,idactor)values($idmovie->idmovie,$idactor)";
                            $this->database->insertSql($query);
                        }
                    }
                }
                $obj = new stdClass();
                $obj->completed = "ok";
                $obj->idactor = $idactor;
                echo json_encode($obj);
            }  catch (Exception $e){
                $this->database->logs($e,$query);
                echo json_encode("error");
            }
        }
    }
    
    public function getActorSearch($text=null){
        try {
            $binds = array();
            if($text==null){
                $query = "select name,actor.idactor,image from actor left join actor_image 
                          on actor.idactor = actor_image.idactor 
                          order by name";
            }else{
                $query = "select name,actor.idactor,image from actor left join actor_image 
                          on actor.idactor = actor_image.idactor 
                          where name like '%' :text '%'   
                          order by name";
                
                $binds = array(":text" => $text);
            }
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
    
    public function edit($id){
        if($id){
            try {
                $query = "select actor.idactor,name,image 
                          from actor inner join actor_image on actor.idactor = actor_image.idactor
                          where actor.idactor=$id";
                $dataActor = json_decode($this->database->selectSql($query));                
                $std = new stdClass();
                $std->completed = "ok";
                $std->data = $dataActor;      
                return json_encode($std);
            } catch (Exception $e) {
                echo $query;
                $this->database->logs($e, $query);
                echo json_encode("error");
            }
        }
    }
    
    public function xhrEditActor(){
        if (isset($_POST['data'])) {
            try {
                $data = json_decode($_POST['data']);
                $query = "update actor set name=:name where idactor=$data->idactor";
                $binds = array(":name" => $data->name);
                $this->database->updateSql($query, $binds);
                
                $movies = json_decode($_POST['movies']);
                if(count($movies)>0){      
                    //delete all movies and add again
                    $query = "delete from actor_movie where idactor=$data->idactor";
                    $this->database->deleteSql($query);
                    
                    foreach ($movies as $idmovie) {
                        if(is_numeric($idmovie->idmovie)){
                            $query = "insert into actor_movie(idmovie,idactor)values($idmovie->idmovie,$data->idactor)";
                            $this->database->insertSql($query);
                        }
                    }
                }                           
                
                $obj = new stdClass();
                $obj->completed = "ok";
                $obj->idactor = $data->idactor;
                echo json_encode($obj);
            } catch (Exception $e) {
                $this->database->logs($e);
                echo json_encode("error");
            }
        }
    }

    public function getActorMovies($id){
        if ($id) {
            try {
                $query = "select title,movie.idmovie from movie inner join actor_movie
                          on movie.idmovie = actor_movie.idmovie 
                          where idactor=$id ";
                $dataMovie = json_decode($this->database->selectSql($query));         
                $std = new stdClass();
                $std->completed = "ok";
                $std->dataMovies = $dataMovie;
                return json_encode($std);
            } catch (Exception $e) {
                $this->database->logs($e,$query);
                echo json_encode("error");
            }
        }
    }
    
    public function uploadPhoto(){
        //include_once $path . 'settings/simpleimage.php';
        $dirName = ROOT."/public/images/actors/";
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
                        $id = $_POST["id_reffer"];
                        $type = $_POST['type'];
                        if($type=="add"){
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
                            $query = "insert into actor_image(image,cover,idactor)values('$name',1,$id)";
                            $this->database->insertSql($query);
                        }else if($type=="edit"){
                            $query = "select idactorimage as total from actor_image where idactor=$id and cover=1";
                            $count = $this->database->countRows($query);                            
                            if($count>0){//update
                                $query = "select idactorimage,image from actor_image where idactor=$id and cover=1";
                                $data = json_decode($this->database->selectSql($query));
                                $idimage = $data[0]->idactorimage;
                                $image = $data[0]->image;
                                $query = "update actor_image set image='$name' where idactorimage=$idimage";
                                $this->database->updateSql($query);
                                if($data[0]->image!="default.png"){
                                    unlink($dirName.$image);
                                }
                            }else{
                                $query = "insert into actor_image(image,cover,idactor)values('$name',1,$id)";
                                $this->database->insertSql($query);
                            }
                            move_uploaded_file($_FILES["image"]["tmp_name"], $target);
                        }                                                        
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
}
?>
