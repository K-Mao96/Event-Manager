<?php
class Event extends CI_Controller {

    //ログイン機能
    public function login() {
        $this->load->model('event_model');
        // $this->load->helper('url');
        // $this->load->library('session');
        // $this->load->helper('form');
        // $this->load->library('form_validation');

        $this->form_validation->set_rules('login_id','ログインID','required');
        $this->form_validation->set_rules('login_pass','パスワード','required');

        $posts = $this->input->post();

        if($this->form_validation->run()) {

            //ログイン情報とユーザ情報の照合
            if($posts['login_id'] && $posts['login_pass']) {
                 $result = $this->event_model->login_select($posts['login_id'],$posts['login_pass']);

                 if($result) {
                     //ログイン成功
                     $this->session->set_userdata('login_id',$posts['login_id']);
                     $data['id'] = $result[0]->id;
                     $this->session->set_userdata('time',time());
					 $data['result'] = $result;
     
                     //本日のイベントページに飛ぶ
                    //  header('Location: '.base_url("Event/event_today"));
                    //  exit();
                    $this->load->view('login',$data);
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
        // $this->load->library('session');
        // $this->load->helper('url');


        //セッション情報を削除
        $this->session->sess_destroy();
        $this->load->view('logout');

    }

    //イベント関連処理
    public function event_index() {
        $this->load->model('event_model');
        // $this->load->library('pagination');
        // $this->load->helper('url');


        $data['events'] = $this->event_model->event_all();
        $this->load->view('event_index',$data);
    }

    public function event_today() {
        $this->load->model('event_model');
        // $this->load->library('pagination');
        // $this->load->helper('url');

        $data['events'] = $this->event_model->event_today();
        $this->load->view('event_today',$data);
    }
    
    public function event_add() {
        $this->load->model('event_model');
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

            //後で登録者情報を取得する処理に書き直す
            $event['registered_by'] = 1;

            $event['created'] = date('Y-m-d H:i:s');

            $this->event_model->insert($event);
            $this->load->view('event_add_done');
        }
        else {
            $data['groups'] = ['1' => '人事部', '2' => '総務部', '3' => '営業部', '4' => '技術部'];
            $this->load->view('event_add',$data);
        }
    }

    public function event_get($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');
        // $this->load->helper('form');
        $data['event'] = $this->event_model->event_get($id);
        $data['attend_count'] = $this->event_model->attend_count($id);
  
        $this->load->view('event_get',$data);
    }

    public function event_attend_done($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');

        //後で登録者情報を取得する処理に書き直す
        // $attend['user_id'] = 1;
        $attend['user_id'] = $this->session->userdata('');
        
        $attend['event_id'] = $id;
        
        $this->event_model->attend_insert($attend);

        $token['id'] = $id;
        $this->load->view('event_attend_done',$token);

    }

    public function event_cancel_attend_done($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');
    
        $this->event_model->attend_cancel($id);

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
            $token['id'] = $id;
            $this->load->view('event_edit_done',$token);
        }else {
            $data['groups'] = ['1' => '人事部', '2' => '総務部', '3' => '営業部', '4' => '技術部'];
            $this->load->view('event_edit',$data);
        }
    }

    public function event_delete_done($id) {
        $this->load->model('event_model');
        // $this->load->helper('url');

        $this->event_model->delete($id);

        $this->load->view('event_delete_done');
    }

}
