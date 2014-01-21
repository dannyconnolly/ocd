<?php

class Session {
    
    /**
     * Check if session already exists
     * 
     * @param type $name
     * @return type boolean
     */
    public static function exists($name){
        return (isset($_SESSION[$name])) ? true : false;
    }

    /**
     * Create the session
     * 
     * @param type $name
     * @param type $value
     * @return type
     */
    public static function put($name, $value){
        return $_SESSION[$name] = $value;
    }
    
    /**
     * Get the session name
     * @param type $name
     * @return type
     */
    public static function get($name){
        return $_SESSION[$name];
    }
    
    
    /**
     * Delete the session
     * 
     * @param type $name
     */
    public static function delete($name){
        if(self::exists($name)){
            unset($_SESSION[$name]);
        }
    }
    
    /**
     * Show flash message 
     * 
     * @param type $name
     * @param type $string
     * @return type
     */
    public static function flash($name, $string = ''){
        if(self::exists($name)){
            $session = self::get($name);
            self::delete($name);
            return $session;
        } else {
            self::put($name, $string);
        }
    }
}
