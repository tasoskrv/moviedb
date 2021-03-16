<?php

class Logs {

    public function __construct() {
        
    }
    
    public static function writeLogs($log,$message=null){
        $handle = fopen("logs/error_log.txt", "a+");
        fwrite($handle, $log);
        if($message!=null){
            fwrite($handle, $message);
        }
        fclose($handle);
    }
    
}
?>
