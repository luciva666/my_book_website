<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stories extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form']);
        $this->load->model('Story_model');
    }

    protected function require_login() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }

    public function index() {
        $data['stories'] = $this->Story_model->get_all();
        $this->load->view('stories/index', $data);
    }

    public function view($id=null) {
        $data['story'] = $this->Story_model->get($id);
        if (!$data['story']) show_404();
        $this->load->view('stories/view', $data);
    }

    public function create() {
        $this->require_login();
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title','Title','trim|required');
            $this->form_validation->set_rules('body','Body','trim|required');
            if ($this->form_validation->run()) {
                $post = $this->input->post(['title','body']);
                $post['user_id'] = $this->session->userdata('user_id');
                $this->Story_model->insert($post);
                redirect('stories');
            }
        }
        $this->load->view('stories/form');
    }

    public function edit($id=null) {
        $this->require_login();
        $story = $this->Story_model->get($id);
        if (!$story) show_404();
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title','Title','trim|required');
            $this->form_validation->set_rules('body','Body','trim|required');
            if ($this->form_validation->run()) {
                $post = $this->input->post(['title','body']);
                $this->Story_model->update($id, $post);
                redirect('stories');
            }
        }
        $data['story'] = $story;
        $this->load->view('stories/form', $data);
    }

    public function delete($id=null) {
        $this->require_login();
        $this->Story_model->delete($id);
        redirect('stories');
    }
}
