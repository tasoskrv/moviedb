<?php

class Router {

    public function __construct() {
        
    }
    
    public function load() {
        if (isset($_GET['url'])) {
            $url = $_GET['url'];
        } else {
            $url = null;
        }
        $url = explode("/", rtrim($url, "/"));
        
        $url[0] = ucfirst($url[0]);
        
        if (empty($url[0])) {
            $controller = new HomeController();
            $controller->index();
            return false;
        }

        $controllerName = $url[0]."Controller";
        
        $file = 'controller/' . $controllerName.".php";
        
        
        if (file_exists($file)) {
            include_once $file;
        } else {
            $controller = new ErrorController();
            $controller->index();
            return false;
        }

        $controller = new $controllerName();
        
        
        //calling methods
        if (isset($url[2])) {
            if (method_exists($controller, $url[1])) {
                $controller->{$url[1]}($url[2]);
            } else {
                $controller = new ErrorController();
                $controller->index();
            }
        } else {
            if (isset($url[1])) {
                if (method_exists($controller, $url[1])) {
                    $controller->{($url[1])}();
                } else {
                    $controller = new ErrorController();
                    $controller->index();
                }
            } else {
                $controller->index();
            }
        }        
    }        
}


?>
