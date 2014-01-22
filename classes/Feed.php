<?php

class Feed {
    private $_db;
    private $_data;
    private $_id;
    
    public function __construct($feed = null) {
        $this->_db = DB::getInstance();         
        
    }
    
    public function find($feed = null){
         if($feed){
            $field = (is_numeric($feed)) ? 'id' : 'title';
            $data = $this->_db->get('feeds', array($field, '=', $feed));
            
            if($data->count()){
                $this->_data = $data->first();
                return  true;
            }
        }
        return false;
    }
    
    public function getAll(){
         return $this->_data = $this->_db->getAll('feeds');
    }
    
    public function create($fields = array()){
        if(!$this->_db->insert('feeds', $fields)){
              throw new Exception('There was a problem creating account!');
        }
        return $this->_db->lastInsertId();
    }
    
    public function update($fields = array(), $id = null){
        if(!$this->_db->update('feeds', $id, $fields)){
            throw new Exception('There was a problem updating');
        }
    }
    
    public function data(){
        return $this->_data;
    }
    
    public function delete($id = null){
        if(!$this->_db->delete('feeds', array('id', '=', $id))){
            throw new Exception('There was a problem deleting');
        }
    }
    
    public function checkCache($url,$name,$age = 86400) { 
        // directory in which to store cached files
        $cacheDir = "cache/";
        // cache filename constructed from MD5 hash of URL
        $filename = $cacheDir.$name;
        // default to fetch the file
        $cache = true;
        // but if the file exists, don't fetch if it is recent enough
        if (file_exists($filename))
        {
          $cache = (filemtime($filename) < (time()-$age));
        }
        // fetch the file if required
        if ($cache)
        {
          $xmlD = simplexml_load_file($url);
          $itemD = $xmlD->channel->item;
          file_put_contents($filename,serialize($itemD));
          // update timestamp to now
          touch($filename);
        }
        // return the cache filename
        return unserialize(file_get_contents($filename));
    }
    
    public function parseFeed($url){
        $rss = simplexml_load_file($url);
        
        foreach($rss->channel->item as $item){
            return $this->_data = $item;
        }
    }
    
}

