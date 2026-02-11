<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stories extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form','user']);
        $this->load->model('Story_model');
        $this->load->model('Episode_model');
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
        // load episodes for this story (if any)
        $data['episodes'] = $this->Episode_model->get_by_story($id);
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
                // handle cover image upload
                if (!empty($_FILES['cover_image']['name'])) {
                    $upload_path = FCPATH . 'assets/uploads/covers/';
                    if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);
                    $config = [
                        'upload_path' => $upload_path,
                        'allowed_types' => 'jpg|jpeg|png|gif',
                        'max_size' => 4096,
                        'file_name' => 'cover_'.time().'_'.uniqid(),
                        'overwrite' => false,
                    ];
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('cover_image')) {
                        $ud = $this->upload->data();
                        $post['cover_image'] = 'assets/uploads/covers/'.$ud['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('stories/create');
                    }
                }
                $this->Story_model->insert($post);
                $this->session->set_flashdata('success', 'Story created');
                redirect('stories');
            }
        }
        $this->load->view('stories/form');
    }

    public function edit($id=null) {
        $this->require_login();
        $story = $this->Story_model->get($id);
        if (!$story) show_404();
        // ensure only owner can edit
        $current_user = $this->session->userdata('user_id');
        if ($story->user_id != $current_user) {
            show_error('Forbidden: you are not allowed to edit this story', 403);
        }
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('title','Title','trim|required');
            $this->form_validation->set_rules('body','Body','trim|required');
            if ($this->form_validation->run()) {
                $post = $this->input->post(['title','body']);
                // enforce owner in update
                $post['user_id'] = $current_user;
                // handle cover image upload (replace existing)
                if (!empty($_FILES['cover_image']['name'])) {
                    $upload_path = FCPATH . 'assets/uploads/covers/';
                    if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);
                    $config = [
                        'upload_path' => $upload_path,
                        'allowed_types' => 'jpg|jpeg|png|gif',
                        'max_size' => 4096,
                        'file_name' => 'cover_'.time().'_'.uniqid(),
                        'overwrite' => false,
                    ];
                    $this->load->library('upload', $config);
                    if ($this->upload->do_upload('cover_image')) {
                        $ud = $this->upload->data();
                        // remove old file if present
                        if (!empty($story->cover_image) && file_exists(FCPATH.$story->cover_image)) {
                            @unlink(FCPATH.$story->cover_image);
                        }
                        $post['cover_image'] = 'assets/uploads/covers/'.$ud['file_name'];
                    } else {
                        $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        redirect('stories/edit/'.$id);
                    }
                }
                $this->Story_model->update($id, $post);
                $this->session->set_flashdata('success', 'Story updated');
                redirect('stories');
            }
        }
        $data['story'] = $story;
        $this->load->view('stories/form', $data);
    }

    public function delete($id=null) {
        $this->require_login();
        $story = $this->Story_model->get($id);
        if (!$story) show_404();
        $current_user = $this->session->userdata('user_id');
        if ($story->user_id != $current_user) {
            show_error('Forbidden: you are not allowed to delete this story', 403);
        }
        $this->Story_model->delete($id, $current_user);
        $this->session->set_flashdata('success', 'Story deleted');
        redirect('stories');
    }
}
