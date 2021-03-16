<?php

class Bootraps {
    
    public function __construct() {
        include_once 'config/paths.php';
        include_once 'config/database.php';
        include_once 'config/settings.php';
        spl_autoload_register(array($this, 'my_autoloader'));
        $router = new Router();
        $router->load();
    }
        
    private function my_autoloader($class) {
        $class = ucfirst($class);
        if(file_exists(ROOT.DS."libs/" . $class . '.php')){
            include ROOT.DS."libs/". $class . '.php';
        }else if(file_exists(ROOT.DS.'libs/pdf/' . $class . '.php')){
            include_once ROOT.DS.'libs/pdf/' . $class . '.php';
        }else if(file_exists(ROOT.DS.'controller/' . $class . '.php')){
            include_once ROOT.DS.'controller/' . $class . '.php';
        }else if(file_exists(ROOT.DS.'model/' . $class . '.php')){
            include_once ROOT.DS.'model/' . $class . '.php';
        } else if(file_exists(ROOT.DS.'language/' . $class . '.php')){
            include_once ROOT.DS.'language/' . $class . '.php';
        }else{
            header("location:".URL);
            exit;
        }
    }
}

?>
