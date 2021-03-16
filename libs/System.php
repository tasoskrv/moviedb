<?php

class System {

    public function __construct() {
        
        
    }
   
    public function fixDate($date,$fromDB = false) {
        if($fromDB===true){
            $dateParts = explode("-", $date);
            $day = $dateParts[2];
            $month = $dateParts[1];
            $year = $dateParts[0];
            $fixedDate = "$day/$month/$year";
        }else{
            $dateParts = explode("/", $date);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $year = $dateParts[2];
            $fixedDate = "$year-$month-$day";
        }
        return $fixedDate;
    }
    
    public static function advancedSearchValues($key){
        if(isset($_GET[$key])){
            return $_GET[$key];
        }
        return null;
    }
}
?>
