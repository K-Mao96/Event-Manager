<?php
class Event_model extends CI_Model {
    public $id;
    public $title;
    public $start;
    public $end;
    public $place;
    public $detail;
    public $registered_by;
    public $created;

    //ログイン系の処理
    public function login_select($id,$pass) {
        $query = $this->db->query("select * from users where login_id=? and login_pass=?",[$id,sha1($pass)]);
        return $query->result('Event_model');
    }

    public function insert($event) {
        $this->db->insert('events', $event);
    }

    public function event_all($page, $num_per_page) {
        $offset = ($page - 1) * $num_per_page;
        $sql = "
        select
            e.*,
            g.name as gname
        from
            events e,
            groups g
        where
            e.group_id=g.id
        limit ?,?";
        $query = $this->db->query($sql,[$offset, $num_per_page]);
        return $query->result('Event_model');
    }

    public function get_attend_events($user_id,$id) {
        $query = $this->db->query("
        select
            count=count(*) as count
        from
            attends
        where
            user_id=?
        and
            event_id=?",[$user_id,$id]);
        
        return $query->result('Event_model');
    }
 
    public function event_today($page, $num_per_page) {
        $offset = ($page - 1) * $num_per_page;
        $sql = "select * from events where DATE_FORMAT(start,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d') limit ?,?";
        $query = $this->db->query($sql,[$offset, $num_per_page]);
        return $query->result('Event_model');
    }
    
    public function event_get($id) {
        $query = $this->db->query("
        select 
            e.*,
            g.name as gname,
            u.name as uname,
			count(a.user_id) as unum
        from
            events e
        left join
            groups g
        on
            e.group_id=g.id
        left join
            users u
        on
            e.registered_by=u.id
        left join
            attends a
        on
            e.id=a.event_id
        where
            e.id=?",[$id]);
		
        return $query->result('Event_model');
    }

    public function attends_get($id) {
        $query = $this->db->query("
        select
            u.name
        from
            users u
        left join
            attends a
        on
            u.id=a.user_id
        where
            a.event_id=?",[$id]);
        
        return $query->result('Event_model');
    }

    public function attend_insert($attend) {
        $this->db->insert('attends', $attend);
    }

    public function attend_count($user_id,$id) {
        $query = $this->db->query("select count(*) as count from attends where user_id=? and event_id=?",[$user_id,$id]);
        return $query->result('Event_model');
    }

    public function attend_cancel($user_id,$id) {
        $where['event_id'] = $id;

        //ユーザIDを取得する処理に書き換える
        $where['user_id'] = $user_id;
        $this->db->delete('attends',$where);
    }

    public function select($id) {
        $query = $this->db->query("select * from events where id=?",[$id]);
        return $query->result('Event_model');
    }

    public function update($event,$id) {
        $where['id'] = $id;
        $this->db->update('events',$event,$where);
    }

    public function delete($id) {
        $where['id'] = $id;
        $this->db->delete('events',$where);
    }

}
