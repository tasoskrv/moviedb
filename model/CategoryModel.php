<?php

class CategoryModel extends Model {

    public function __construct() {
       parent::__construct();
    }
    
    public function xhrAddCategory(){
        if(isset($_POST['data'])){
            $data = json_decode($_POST['data']);
            try{
                $query = "insert into category(category) values(:category)"; 
                $binds = array(":category"=>$data->category);
                $this->database->insertSql($query,$binds);
                $obj = new stdClass();
                $obj->completed = "ok";
                echo json_encode($obj);
            }  catch (Exception $e){
                $this->database->logs($e,$query);
                echo json_encode("error");
            }
        }
    }
    
    
    public function getCategory(){
        try {
            $query = "select idcategory,category from category order by category";
            $data = $this->database->selectSql($query);
            return $data;
        } catch (Exception $e) {
            $this->database->logs($e);
            echo json_encode("error");
        }
    }  
}
?>
