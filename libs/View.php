<?php

class View {

    public function __construct() {
        
    }
    /**
     * 
     * @param type $name
     * @param type $noInclude
     */
    public function renderView($name,$noInclude = false){
        
        if($noInclude==true){
            if(file_exists('view/'.$name.".php")){
                include_once 'view/'.$name.".php";
            }else{
                $error = new Error_Controller();
                $error->index();
            }
        }else{
            include_once 'view/header.php';
            if(file_exists('view/'.$name.".php")){
                include_once 'view/'.$name.".php";
            }else{
                $error = new Error_Controller();
                $error->index();
            }
            include_once 'view/footer.php';
        }
    }
}

?>
