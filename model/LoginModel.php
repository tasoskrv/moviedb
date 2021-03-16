<?php

class LoginModel extends Model{

    public function __construct() {
        parent::__construct();//database connection
    }
    
    public function loginApp(){
        try {
            $query = "select iduser,role from user where username=:username and password=md5(:password)";
            $binds = array("username" => $_POST['login'], "password" => $_POST['password']);
            $data = json_decode($this->database->selectSql($query, $binds));
            
            if ($data[0]->iduser > 0) {//login
                /*
                Session::init();
                Session::set('iduser', $data[0]->iduser);
                Session::set('role', $data[0]->role);
                Session::set('loggedin', true);                
                */
                $cookieValue = $data[0]->iduser. "?" . $data[0]->role . "?" . true;
                Cookie::set("auth", $cookieValue);                               
                header("Location:" . URL . "main");
            } else {//error
                header("Location:" . URL . "login");
            }
        } catch (Exception $e) {
            $this->database->logs($e);
            header("Location:" . URL . "login");
        }
    }
}

?>
