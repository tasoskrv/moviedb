<?php

class UserModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    
    public function xhrWatchedMovie(){
        if(isset($_POST['data'])){
            try {
                $iduser = Cookie::get('iduser');
                $data = json_decode($_POST['data']);
                $idmovie = $data->id;

                $query = "select iduser_movies from user_movies where idmovie=$idmovie and iduser=$iduser";
                $exists = $this->database->countRows($query, true);
                if ($exists == 0) {//insert
                    $query = "insert into user_movies(iduser,idmovie)values($iduser,$idmovie)";
                    $this->database->insertSql($query);
                }
                $obj = new stdClass();
                $obj->completed = "ok";
                echo json_encode($obj);
            } catch (Exception $e) {
                $this->database->logs($e,$query);
                echo json_encode("error");
            }
        }        
    }
    
    
    public function xhrNotWatchedMovie(){        
        if(isset($_POST['data'])){            
            try {
                $iduser = Session::get('iduser');
                $data = json_decode($_POST['data']);
                $idmovie = $data->id;
                $query = "delete from user_movies where idmovie=$idmovie and iduser=$iduser";
                $this->database->deleteSql($query);
                $obj = new stdClass();
                $obj->completed = "ok";
                echo json_encode($obj);
            } catch (Exception $e) {
                $this->database->logs($e, $query);
                echo json_encode("error");
            }            
        }
    }   
}

?>
