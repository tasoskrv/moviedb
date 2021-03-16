<?php

class Lang {

    private static $instance;
    private static $language;
            
    private function __construct() {
        //$user = Session::get('user');
        /*if ($user != "" && $user instanceof User) {
            $language_file = $user->getLanguage() . ".php";
        } else {
            $language_file = "eng.php";
        }*/
        $language_file = "grc.php";
        
        if (file_exists(ROOT .  '/language/' . $language_file)) {
            include ROOT .  '/language/' . $language_file;
            self::$language = $lang;
            unset($lang);
        } else if (file_exists(ROOT . '/language/' . "eng.php")) {
            include ROOT .  '/language/' . "eng.php";
            self::$language = $lang;
            unset($lang);
        } else {
            self::$language = array();
        }
    }
    
    public function __destruct() {
        self::$language = null;
        self::$instance = null;
    }
    
    private function __clone() {
       //Log::error("I am trying to clone class Lang");
    }
    
    public static function load($name) {
        if (!Lang::$instance instanceof self) {
            Lang::$instance = new self();
        }
        if (isset(self::$language[$name])) {
            $value = self::$language[$name];
        } else {
            $value = $name;
            //Log::error("Variable lang[" . $name . "] doesn't exists");
        }
        return $value;
    }
}
?>
