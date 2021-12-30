<?php
class EventManager extends CI_Controller {

    public function event_index() {
        $this->load->model('event_model');
        $this->load->library('pagination');
        $this->load->helper('url');

        $data['events'] = $this->event_model->event_all();
        $this->load->view('event_index',$data);
    }
    
    public function event_add() {
        $this->load->model('event_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');

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
        $this->load->helper('url');
        $data['event'] = $this->event_model->event_get($id);
        // var_dump($data['event']);
        // exit;
        $this->load->view('event_get',$data);
    }

    public function event_edit($id) {

        $this->load->model('event_model');
        $data["event"] = $this->event_model->select($id);
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('form_validation');
        
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
        $this->load->helper('url');

        $this->event_model->delete($id);

        $this->load->view('event_delete_done');
    }

}