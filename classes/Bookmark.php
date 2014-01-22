<?php

class Bookmark {
    private $_db;
    private $_data;
    private $_id;
    
    public function __construct($bookmark = null) {
        $this->_db = DB::getInstance();         
        
        if($bookmark){
            $this->find($bookmark);
            $this->_id = $bookmark;
        }
    }
    
    public function find($bookmark = null){
         if($bookmark){
            $field = (is_numeric($bookmark)) ? 'id' : 'title';
            $data = $this->_db->get('bookmarks', array($field, '=', $bookmark));
            
            if($data->count()){
                $this->_data = $data->first();
                return  true;
            }
        }
        return false;
    }
    
    public function getAll(){
         return $this->_data = $this->_db->getAll('bookmarks');
    }
    
    public function create($fields = array()){
        if(!$this->_db->insert('bookmarks', $fields)){
              throw new Exception('There was a problem creating bookmark!');
        }
        return $this->_db->lastInsertId();
    }
    
    public function update($fields = array(), $id = null){
        if(!$this->_db->update('bookmarks', $id, $fields)){
            throw new Exception('There was a problem updating');
        }
    }
    
    public function delete($id = null){
        if(!$this->_db->delete('bookmarks', array('id', '=', $id))){
            throw new Exception('There was a problem deleting');
        }
    }
    
    public function data(){
        return $this->_data;
    }
    
}

