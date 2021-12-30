<?php
class User_model extends CI_Model {
    public $id;
    public $login_id;
    public $login_pass;
    public $name;
    public $type_id;
    // public $group_id;
    public $created;

    public function insert($user) {
        $this->db->insert('users', $user);
    }

    public function user_all($page, $num_per_page) {
		$offset = ($page - 1) * $num_per_page;
		$sql = "
		select
            u.*,
            g.name as gname
        from
            users u,
            groups g
        where
            u.group_id=g.id"
        $query = $this->db->query("
        select
            u.*,
            g.name as gname
        from
            users u,
            groups g
        where
            u.group_id=g.id");
        return $query->result('User_model');
    }
    
    public function user_get($id) {
        $query = $this->db->query("
        select
            u.*,
            g.name as gname
        from
            users u
        left join
            groups g
        on
            u.group_id=g.id
        where
            u.id=?",[$id]);
        return $query->result('User_model');
    }

    public function select($id) {
        $query = $this->db->query("select * from users where id=?",[$id]);
        return $query->result('User_model');
    }

    public function update($user,$id) {
        $where['id'] = $id;
        $this->db->update('users',$user,$where);
    }

    public function delete($id) {
        $where['id'] = $id;
        $this->db->delete('users',$where);
    }

}
