<?php
class Event extends CI_Controller {

    //ページネーション
    const NUM_PER_PAGE = 3;
    const TABLE = 'events';

    //ログイン機能
    public function login() {
        $this->load->model('event_model');

        $this->form_validation->set_rules('login_id','ログインID','required');
        $this->form_validation->set_rules('login_pass','パスワード','required');

        $posts = $this->input->post();

        if($this->form_validation->run()) {

            //ログイン情報とユーザ情報の照合
            if($posts['login_id'] && $posts['login_pass']) {
                 $result = $this->event_model->login_select($posts['login_id'],$posts['login_pass']);

                 if($result) {
                     //ログイン成功
                     $this->session->set_userdata('user_id',$result[0]->id);
                     $this->session->set_userdata('type_id',(int)$result[0]->type_id);
                     $this->session->set_userdata('login_id',$posts['login_id']);
                     $this->session->set_userdata('time',time());

     
                     //本日のイベントページに飛ぶ
                     header('Location: '.base_url("Event/event_today"));
                     exit();
                    // $this->load->view('login',$data);
                 }else{
     
                     //ログイン失敗
                     $data['error'] = 'faild';
                     $this->load->view('login',$data);
                 }
            }

        }else{
            $data['error'] = '';
            $this->load->view('login',$data);
        }

    }

    //ログイン状態チェック機能
    // public function login_check() {
    //     $this->load->library('session');
    //     $this->load->helper('url');

    //     $sessions = $this->session->userdata();

    //     if(isset($sessions['login_id']) && $sessions['time'] + 120 > time()) {
    //         //ログインしている
    //         $this->session->set_userdata('time',time());
    //     }else {
    //         //ログインしていない
    //         header('Location: '.base_url("Event/login"));
    //         exit();
    //     }
    // }

    //ログアウト機能
    public function logout() {

        //セッション情報を削除
        $this->session->sess_destroy();
        $this->load->view('logout');

    }


    //イベント関連処理
    public function event_index($page='') {
        $this->load->model('event_model');
        $this->load->model('pagination_model');

        $data['type'] = $this->session->userdata('type_id');

        //ページネーション
        if(!is_numeric($page)) {
            $page = 1;
        }
        $events = $this->event_model->event_all($page,self::NUM_PER_PAGE);
        $data['events'] = $events;

        $config['base_url'] = base_url('Event/event_index');
        $config['total_rows'] = $this->pagination_model->total_count(self::TABLE);
        $config['per_page'] = self::NUM_PER_PAGE;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        foreach($data['events'] as $event) {
            $data['count'][] = $this->event_model->get_attend_events($this->session->userdata('user_id'),$event->id);
        }


        $this->load->view('event_index',$data);
    }

    public function event_today($page='') {
        $this->load->model('event_model');
        $this->load->model('pagination_model');

		$data['type'] = $this->session->userdata('type_id');

        //ページネーション
        if(!is_numeric($page)) {
            $page = 1;
        }

        $events = $this->event_model->event_today($page,self::NUM_PER_PAGE);

        $data['events'] = $events;
        $total_rows_obj = $this->pagination_model->e_today_count();

        $config['base_url'] = base_url('Event/event_today');
        // $config['total_rows'] = $this->pagination_model->e_today_count();
        $config['total_rows'] = ;
        $config['per_page'] = self::NUM_PER_PAGE;
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);

        $this->load->view('event_today',$data);
    }
    
    public function event_add() {
        $this->load->model('event_model');

        $this->form_validation->set_rules('start','開始日時','required');
        $this->form_validation->set_rules('place','場所','required');

        if($this->form_validation->run()) {
            $event['title'] = $this->input->post('title');
            $event['start'] = $this->input->post('start');
            $event['end'] = $this->input->post('end');
            $event['place'] = $this->input->post('place');
            $event['detail'] = $this->input->post('detail');
            $event['group_id'] = $this->input->post('group');

            $event['registered_by'] = $this->session->userdata('user_id');

            $event['created'] = date('Y-m-d H:i:s');

            $this->event_model->insert($event);

            $data['type'] = $this->session->userdata('type_id');
            $this->load->view('event_add_done',$data);
        }
        else {
            $data['type'] = $this->session->userdata('type_id');

            $data['groups'] = ['1' => '人事部', '2' => '総務部', '3' => '営業部', '4' => '技術部'];
            $this->load->view('event_add',$data);
        }
    }

    public function event_get($id) {
        $this->load->model('event_model');
        $data['type'] = $this->session->userdata('type_id');

        $data['event'] = $this->event_model->event_get($id);
        $data['attend_users'] = $this->event_model->attends_get($id);
        $data['attend_count'] = $this->event_model->attend_count($this->session->userdata('user_id'),$id);
  
        $this->load->view('event_get',$data);
    }

    public function event_attend_done($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');

        $token['type'] = $this->session->userdata('type_id');

        $attend['user_id'] = $this->session->userdata('user_id');
        
        $attend['event_id'] = $id;
        
        $this->event_model->attend_insert($attend);

        $token['id'] = $id;
        $this->load->view('event_attend_done',$token);

    }

    public function event_cancel_attend_done($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');
    
        $this->event_model->attend_cancel($this->session->userdata('user_id'),$id);

        $token['type'] = $this->session->userdata('type_id');

        $token['id'] = $id;
        $this->load->view('event_cancel_attend_done',$token);

    }

    public function event_edit($id) {

        $this->load->model('event_model');
        $data["event"] = $this->event_model->select($id);
        // $this->load->helper('url');
        // $this->load->helper('form');
        // $this->load->library('form_validation');
        
        $this->form_validation->set_rules('start','開始日時','required');
        $this->form_validation->set_rules('place','場所','required');

        if($this->form_validation->run()) {

            $event['title'] = $this->input->post('title');
            $event['start'] = $this->input->post('start');
            $event['end'] = $this->input->post('end');
            $event['place'] = $this->input->post('place');
            $event['detail'] = $this->input->post('detail');
            $event['group_id'] = $this->input->post('group');

            $this->event_model->update($event,$id);

            $token['type'] = $this->session->userdata('type_id');

            $token['id'] = $id;
            $this->load->view('event_edit_done',$token);
        }else {
            $data['type'] = $this->session->userdata('type_id');
            $data['groups'] = ['1' => '人事部', '2' => '総務部', '3' => '営業部', '4' => '技術部'];
            $this->load->view('event_edit',$data);
        }
    }

    public function event_delete_done($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');

        $this->event_model->delete($id);

        $data['type'] = $this->session->userdata('type_id');

        $this->load->view('event_delete_done',$data);
    }

}
