<?php

class Hash {
    
    public static function make($string, $salt = ''){
        return hash('sha256', $string . $salt);
    }
    
    public static function salt($length){
        $baseStr = time() . rand(0, 1000000) . rand(0, 1000000);
	$md5Hash = md5($baseStr);
	if($length < 32){
		$md5Hash = substr($md5Hash, 0, $length);
	}
	return $md5Hash;
    }
    
    public static function unique(){
        return self::make(uniqid());
    } 
}