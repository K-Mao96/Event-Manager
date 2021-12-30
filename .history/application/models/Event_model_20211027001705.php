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

    public function event_all() {
        $query = $this->db->query("select * from events");
        return $query->result('Event_model');
    }
    public function event_today() {
        $query = $this->db->query("select * from events where DATE_FORMAT(start,'%Y-%m-%d')=DATE_FORMAT(now(),'%Y-%m-%d')");
        return $query->result('Event_model');
    }
    
    public function event_get($id) {
        $query = $this->db->query("
        select 
            e.*,
            g.name as gname,
            u.name as uname,
			a.user_id
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

	public function attend_get()

    public function attend_insert($attend) {
        $this->db->insert('attends', $attend);
    }

    public function attend_count($id) {
        $query = $this->db->query("select count(*) as count from attends where user_id=1 and event_id=?",[$id]);
        return $query->result('Event_model');
    }

    public function attend_cancel($id) {
        $where['event_id'] = $id;

        //ユーザIDを取得する処理に書き換える
        $where['user_id'] = 1;
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
