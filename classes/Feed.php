<?php

class Feed {

    private $_db;
    private $_data;
    private $_id;

    public function __construct($feed = null) {
        $this->_db = DB::getInstance();

        if ($feed) {
            $this->find($feed);
            $this->_id = $feed;
        }
    }

    public function find($feed = null) {
        if ($feed) {
            $field = (is_numeric($feed)) ? 'id' : 'title';
            $data = $this->_db->get('feeds', array($field, '=', $feed));

            if ($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function getAll() {
        return $this->_data = $this->_db->getAll('feeds');
    }

    public function create($fields = array()) {
        if (!$this->_db->insert('feeds', $fields)) {
            throw new Exception('There was a problem creating account!');
        }
        return $this->_db->lastInsertId();
    }

    public function update($fields = array(), $id = null) {
        if (!$this->_db->update('feeds', $id, $fields)) {
            throw new Exception('There was a problem updating');
        }
    }

    public function data() {
        return $this->_data;
    }

    public function delete($id = null) {
        if (!$this->_db->delete('feeds', array('id', '=', $id))) {
            throw new Exception('There was a problem deleting');
        }
    }

    public function parseFeed($url) {
        $rss = simplexml_load_file($url);
        return $this->_data = $rss->channel->item;
        /*
          foreach ($rss->channel->item as $item) {
          return $this->_data = $item;
          }
         * 
         */
    }

    public function getAllByCategory($cid = null) {
        $sql = "SELECT cat_relations.feed_id, feeds.title, feeds.url "
                . "FROM cat_relations JOIN feeds "
                . "ON cat_relations.feed_id = feeds.id "
                . "WHERE cat_relations.cat_id = ?";

        if (!$this->_db->query($sql, array($cid))->error()) {
            return $this->_db->results();
        }
    }

    public function getCatId($feed_id = null) {
        $sql = "SELECT cat_id FROM cat_relations WHERE feed_id = ?";
        if (!$this->_db->query($sql, array($feed_id))->error()) {
            return $this->_db->results();
        }
    }

}
