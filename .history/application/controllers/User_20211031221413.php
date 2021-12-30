<?php
class User extends CI_Controller {

	//ページネーション
    const NUM_PER_PAGE = 3;
    const TABLE = 'users';

    //権限のチェック処理
    // public function type_checker() {
    //     $type = $this->session->userdata('type_id');
    //     if($type !== 2) {
    //         $this->load->view('rejection.php');
    //     }
    // }

    //ユーザ関連処理
    public function user_index($page='') {
        if($this->session->userdata('type_id') !== 2) {
            $this->load->view('rejection.php');
        }else {
            $this->load->model('user_model');
        $this->load->model('pagination_model');

            $data['type'] = $this->session->userdata('type_id');

			//ページネーション
			if(!is_numeric($page)) {
				$page = 1;
			}
			$users = $this->event_model->user_all($page,self::NUM_PER_PAGE);
			$data['events'] = $users;
	
			$config['base_url'] = base_url('User/event_index');
			$config['total_rows'] = $this->pagination_model->total_count(self::TABLE);
			$config['per_page'] = self::NUM_PER_PAGE;
			$config['use_page_numbers'] = TRUE;
			$this->pagination->initialize($config);
            
            $data['users'] = $this->user_model->user_all();
            $this->load->view('user_index',$data);
        }
    }
    
    public function user_add() {
        if($this->session->userdata('type_id') !== 2) {
            $this->load->view('rejection.php');
        }else {
            $this->load->model('user_model');
            // $this->load->helper('url');
            // $this->load->helper('form');
            // $this->load->library('form_validation');
    
            $this->form_validation->set_rules('name','氏名','required');
            $this->form_validation->set_rules('login_id','ログインID','required');
            $this->form_validation->set_rules('login_pass','パスワード','required');
            // $this->form_validation->set_rules('group','所属グループ','required');
            // $this->form_validation->set_rules('user_type','権限','required');
    
            if($this->form_validation->run()) {
                $user['name'] = $this->input->post('name');
                $user['login_id'] = $this->input->post('login_id');
                $user['login_pass'] = sha1($this->input->post('login_pass'));
    
                $user['group_id'] = $this->input->post('group');
                $user['type_id'] = (int)$this->input->post('user_type');
    
                $user['created'] = date('Y-m-d H:i:s');
    
                $this->user_model->insert($user);

                $data['type'] = $this->session->userdata('type_id');

                $this->load->view('user_add_done',$data);
            }
            else {
                $data['type'] = $this->session->userdata('type_id');

                $data['groups'] = ['1' => '人事部', '2' => '総務部', '3' => '営業部', '4' => '技術部'];
                $data['utypes'] = ['1' => '一般', '2' => '管理'];
                $this->load->view('user_add',$data);
            }
        }
    }

    public function user_get($id) {
        if($this->session->userdata('type_id') !== 2) {
            $this->load->view('rejection.php');
        }else {
            $this->load->model('user_model');
            // $this->load->helper('url');
            // $this->load->helper('form');

            $data['type'] = $this->session->userdata('type_id');

            $data['user'] = $this->user_model->user_get($id);
            
            $this->load->view('user_get',$data);
        }
    }

    public function user_edit($id) {

        if($this->session->userdata('type_id') !== 2) {
            $this->load->view('rejection.php');
        }else {
            $this->load->model('user_model');
            $data["user"] = $this->user_model->select($id);
            // $this->load->helper('url');
            // $this->load->helper('form');
            // $this->load->library('form_validation');
            
            $this->form_validation->set_rules('name','氏名','required');
            $this->form_validation->set_rules('login_id','ログインID','required');
            $this->form_validation->set_rules('login_pass','パスワード','required');
            $this->form_validation->set_rules('group','所属グループ','required');
    
            if($this->form_validation->run()) {
    
                $user['name'] = $this->input->post('name');
                $user['login_id'] = $this->input->post('login_id');
                $user['login_pass'] = sha1($this->input->post('login_pass'));
                $user['group_id'] = $this->input->post('group');
    
                $this->user_model->update($user,$id);

                $token['type'] = $this->session->userdata('type_id');

                $token['id'] = $id;
                $this->load->view('user_edit_done',$token);
            }else {
                $data['type'] = $this->session->userdata('type_id');

                $data['groups'] = ['1' => '人事部', '2' => '総務部', '3' => '営業部', '4' => '技術部'];
                $data['utypes'] = ['1' => '一般', '2' => '管理'];
                $this->load->view('user_edit',$data);
            }
        }
    }

    public function user_delete_done($id) {
        if($this->session->userdata('type_id') !== 2) {
            $this->load->view('rejection.php');
        }else {
            $this->load->model('user_model');
            // $this->load->helper('url');
    
            $this->user_model->delete($id);

            $data['type'] = $this->session->userdata('type_id');

            $this->load->view('user_delete_done',$data);
        }
    }

}
