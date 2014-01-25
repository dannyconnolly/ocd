<?php

class User {
    private $_db;
    private $_data;
    private $_session_name;
    private $_cookie_name;
    private $_is_logged_in;
            
    
    public function __construct($user = null) {
        $this->_db = DB::getInstance();  
        
        $this->_session_name = Config::get('session/session_name');
        $this->_cookie_name = Config::get('remember/cookie_name');
        
        if(!$user){
            if(Session::exists($this->_session_name)){
                $user = Session::get($this->_session_name);
                
                if($this->find($user)){
                    $this->_is_logged_in = true;
                } else {
                    
                }
            }
        } else {
            $this->find($user);
        }
    }
    
    public function update($fields = array(), $id = null){
        
        if(!$id && $this->isLoggedIn()){
            $id = $this->data()->id;
        }
        if(!$this->_db->update('users', $id, $fields)){
            throw new Exception('There was a problem updating');
        }
    }
        
    public function create($fields = array()){  
         if(!$this->_db->insert('users', $fields)){
              throw new Exception('There was a problem creating account!');
        }
    }
    
    public function find($user = null){
        if($user){
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));
            
            if($data->count()){
                $this->_data = $data->first();
                return  true;
            }
        }
        return false;
    }
    
    public function login($username = null, $password = null, $remember = false){       
        
        if(!$username && !$password && $this->exists()){
            Session::put($this->_session_name, $this->data()->id);
        } else {
            $user = $this->find($username);
        
            if($user){
                if($this->data()->password === Hash::make($password, $this->data()->salt)){
                    Session::put($this->_session_name, $this->data()->id);

                    if($remember){
                        $hash = Hash::unique();
                        $hash_check = $this->_db->get('user_sessions', array('user_id', '=', $this->data()->id));

                        if(!$hash_check->count()){
                            $this->_db->insert('user_sessions', array(
                                'user_id' => $this->data()->id,
                                'hash' => $hash
                            ));
                        } else {
                            $hash = $hash_check->first()->hash;
                        }

                        Cookie::put($this->_cookie_name, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }        
        return false;
    }
    
    public function hasPermission($key){
        $group = $this->_db->get('groups', array('id', '=', $this->data()->group));
        
        if($group->count()){
            $permissions = json_decode($group->first()->permissions, true);
            
            if($permissions[$key] == true){
                return true;
            }
            
        }
    }
    public function exists(){
        return(!empty($this->_data)) ? true : false;
    }
    
    public function logout(){
        
        $this->_db->delete('user_sessions', array('user_id', '=', $this->data()->id));
        
        Session::delete($this->_session_name);
        Cookie::delete($this->_cookie_name);       
    }
    
    public function data(){
        return $this->_data;
    }
    
    public function isLoggedIn (){
        return $this->_is_logged_in;
    }
}