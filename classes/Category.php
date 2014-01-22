<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Category
 *
 * @author danny
 */
class Category {
    //put your code here
    private $_db;
    private $_data;
    private $_id;
    
    public function __construct($category = null) {
        $this->_db = DB::getInstance();         
        
        if($category){
            $this->find($category);
            $this->_id = $category;
        }
    }
    public function find($category = null){
         if($category){
            $field = (is_numeric($category)) ? 'id' : 'title';
            $data = $this->_db->get('categories', array($field, '=', $category));
            
            if($data->count()){
                $this->_data = $data->first();
                return  true;
            }
        }
        return false;
    }
    
    public function getAll(){
         return $this->_data = $this->_db->getAll('categories');
    }
    
    public function create($fields = array()){
        if(!$this->_db->insert('categories', $fields)){
              throw new Exception('There was a problem creating category!');
        }
        return $this->_db->lastInsertId();
    }
    
    public function update($fields = array(), $id = null){
        if(!$this->_db->update('categories', $id, $fields)){
            throw new Exception('There was a problem updating');
        }
    }
    
    public function data(){
        return $this->_data;
    }
    
    public function delete($id = null){
        if(!$this->_db->delete('categories', array('id', '=', $id))){
            throw new Exception('There was a problem deleting');
        }
    }
    
    public function setRelationship($fields){
        if(!$this->_db->insert('cat_relations', $fields)){
              throw new Exception('There was a problem creating category relations!');
        }
    }
}
