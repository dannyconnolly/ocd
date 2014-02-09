<?php

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

        if ($category) {
            $this->find($category);
            $this->_id = $category;
        }
    }

    public function find($category = null) {
        if ($category) {
            $field = (is_numeric($category)) ? 'id' : 'title';
            $data = $this->_db->get('categories', array($field, '=', $category));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function getAll($user_id) {
        $sql = "SELECT * FROM categories WHERE user_id = ? ORDER BY name ASC";
        if (!$this->_db->query($sql, array($user_id))->error()) {
            return $this->_db->results();
        }
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('categories', $fields)) {
            throw new Exception('There was a problem creating category!');
        }
        return $this->_db->lastInsertId();
    }

    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('categories', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

    public function data() {
        return $this->_data;
    }

    public function delete($id = null) {
        if (!$this->_db->delete('categories', array('id', '=', $id))) {
            throw new Exception('There was a problem deleting');
        }
    }

    public function setRelationship($fields) {
        if (!$this->_db->insert('cat_relations', $fields)) {
            throw new Exception('There was a problem creating category relations!');
        }
    }

    public function bookmarkCount($cid) {
        $sql = "SELECT count(cat_id) AS cat_count FROM cat_relations WHERE cat_id = ? AND bookmark_id != ''";
        if (!$this->_db->query($sql, array($cid))->error()) {
            $count = $this->_db->results();
            return $count[0]->cat_count;
        }
    }

    public function feedCount($cid) {
        $sql = "SELECT count(cat_id) AS cat_count FROM cat_relations WHERE cat_id = ? AND feed_id != ''";
        if (!$this->_db->query($sql, array($cid))->error()) {
            $count = $this->_db->results();
            return $count[0]->cat_count;
        }
    }

}
