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

    public function getAll($user_id) {
        $sql = "SELECT * FROM feeds WHERE user_id = ? ORDER BY title ASC";
        if (!$this->_db->query($sql, array($user_id))->error()) {
            return $this->_db->results();
        }
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

    public function saveFeedItems($user_id) {
        $sql = "SELECT feeds.id, feeds.url, cat_relations.cat_id "
                . "FROM feeds JOIN cat_relations "
                . "ON cat_relations.feed_id = feeds.id ";

        if (!$this->_db->query($sql, array($user_id))->error()) {
            $feeds = $this->_db->results();

            foreach ($feeds as $feed) {
                libxml_use_internal_errors(true);
                $rss_items = simplexml_load_file($feed->url);

                if (!$rss_items) {
                    echo 'Failed to load feed!<br />';
                    foreach (libxml_get_errors() as $error) {
                        echo $error->message . '<br />';
                    }
                }

                foreach ($rss_items->channel->item as $item) {

                    $fields = array(
                        'content' => $item->description,
                        'title' => $item->title,
                        'link' => $item->link,
                        'pub_date' => date("Y-m-j G:i:s", strtotime($item->pubDate)),
                        'status' => 0,
                        'cat_id' => $feed->cat_id
                    );

                    $link = $item->link;
                    $item_exists_sql = "SELECT link FROM items WHERE link = ?";
                    $item_exists = $this->_db->query($item_exists_sql, array($link))->count();
                    if ($item_exists < 1) {
                        $insert_sql = "INSERT INTO items (content, title, link, pub_date, status, cat_id ) VALUES (?, ?, ?, ?, ?, ? )";

                        if (!$this->_db->query($insert_sql, $fields)->error()) {
                            echo $fields['title'] . ' added to db<br />';
                            return $this->_db->results();
                        }
                    }
                }
            }
        }
    }

    public function feedStream($cat_id) {
        $sql = "SELECT items.*, categories.name "
                . "FROM items JOIN categories "
                . "ON categories.id = items.cat_id "
                . "WHERE cat_id = ? ORDER BY pub_date DESC";
        if (!$this->_db->query($sql, array($cat_id))->error()) {
            return $this->_db->results();
        }
    }

    public function allFeedStream() {
        $sql = "SELECT items.*, categories.name "
                . "FROM items JOIN categories "
                . "ON categories.id = items.cat_id "
                . "ORDER BY pub_date DESC";
        if (!$this->_db->query($sql)->error()) {
            return $this->_db->results();
        }
    }

}
