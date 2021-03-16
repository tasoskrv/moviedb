<?php

class Database {
    private $db;

    public function __construct() {
        $this->connect();
    }

    private function connect(){
        try {
            $this->db = new PDO(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME . '', DB_USER, DB_PASS);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->exec("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
        } catch (PDOException $e) {
            $error = new Error_Controller();
            $error->dbError();
            exit;
        }
    }
    
    public function insertSql($query,$binds=null){
        $result = $this->db->prepare($query);
        if(count($binds)>0){
            foreach ($binds as $key => $value) {
                $result->bindValue("$key", "$value");
            }
        }
        $result->execute();
        return $this->db->lastinsertid();
    }
    
    public function updateSql($query,$binds=null){
        $result = $this->db->prepare($query);
        if(count($binds)>0){
            foreach ($binds as $key => $value) {
                $result->bindValue("$key", "$value");
            }
        }
        $result->execute();
    }
    
    public function deleteSql($query){
        $result = $this->db->prepare($query);
        $result->execute();
    }

    /**
     * 
     * @param type $query
     * @param type $binds
     * @return json
     */
    public function selectSql($query,$binds=null){
        $result = $this->db->prepare($query);
        if(count($binds)>0){
            foreach ($binds as $key => $value) {
                $result->bindValue("$key", "$value");
            }
        }
        $result->execute();
        $arrayData = array();
        while($row = $result->fetch(PDO::FETCH_NAMED)){
            $obj = new stdClass();
            foreach ($row as $key=>$value) {
                $obj->$key = $value;
            }
            array_push($arrayData, $obj);
        }
        return json_encode($arrayData);
    }
    
    public function countRows($query,$countRows=false,$binds=null){
        $result = $this->db->prepare($query);
        if(count($binds)>0){
            foreach ($binds as $key => $value) {
                $result->bindValue("$key", "$value");
            }
        }
        $result->execute();
        if($countRows===true){
            $totalRows = $result->rowCount();
        }else{
            $row = $result->fetch();
            $totalRows = $row['total'];
        }
        return $totalRows;
    }
    
    public function renderModel($model){
        $classModel = $model.'Model';
        $modelObj = new $classModel();
        return $modelObj; 
    }
    
    
    public function logs($e,$messageManual=null){
        include_once 'libs/Logs.php';
        $date = "********************************************\nDATE:".date("Y-m-d H:i:s");
        $code = "CODE:".$e->getCode();
        $file = "FILE:".$e->getFile();
        $line = "LINE:".$e->getLine();
        $message = "MESSAGE:".$e->getMessage();
        $previous = "PREVIOUS:".$e->getPrevious();
        $trace = "TRACE:".$e->getTrace();
        $traceAsString = "TRACESTRING:".$e->getTraceAsString();
        $error = $date."\n".$code."\n".$file."\n".$line."\n".$message."\n".$previous."\n".$trace."\n".$traceAsString."\n\n";
        Logs::writeLogs($error,$messageManual);
    }
     
}
?>
