<?php

class Cookie{
    
    public static function init(){
        
    }
    
    public static function set($key,$value){
        setcookie($key, $value, time() + (86400 * 30), "/"); // 86400 = 1 day               
    }
    
    public static function get($key){        
        if(isset($_COOKIE['auth'])){
            $cookie = urldecode($_COOKIE['auth']);
            $cookieVals = explode("?", $cookie);
            $value = null;
            switch ($key){
                case 'iduser' : 
                    $value = $cookieVals[0];
                    break;
                case 'role' : 
                    $value = $cookieVals[1];
                    break;
                case 'loggedin' :
                    $value = $cookieVals[2];
                    break;
            }  
            return $value;
        } else {
            return false;            
        }
    }
    
    public static function destroy(){
        /*
        if(isset($_COOKIE['auth'])){
            unset($_COOKIE['auth']);
            setcookie('auth', null, -1, '/');
        }
        */
        if (isset($_SERVER['HTTP_COOKIE'])) {
            $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
            }
        }        
    }
    
    
    
}


?>
