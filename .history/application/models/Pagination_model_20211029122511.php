<?php

class Pagination_model extends CI_Model {

    public function total_count($table) {
        return $this->db->count_all($table);
    }
    
    public function e_today_count() {
        $query = $this->db->query("select count(*) from events where DATE_FORMAT(start,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')");
        return $query->result('Pagination_model');
    }
}