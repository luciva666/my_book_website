<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Episodes extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(['url','form']);
        $this->load->model('Episode_model');
        $this->load->model('Story_model');
        $this->load->library(['session','form_validation']);
    }

    public function view($id = null) {
        $episode = $this->Episode_model->get($id);
        if (!$episode) show_404();

        $story = $this->Story_model->get($episode->story_id);
        if (!$story) show_404();

        $data['story'] = $story;
        $data['episode'] = $episode;
        // previous / next
        $data['prev'] = $this->Episode_model->get_prev($id);
        $data['next'] = $this->Episode_model->get_next($id);
        // episode number within story
        $data['index'] = $this->Episode_model->get_index($id);
        $this->load->view('episodes/view', $data);
    }

    public function create($story_id = null) {
        // only story owner can add episodes
        $this->require_login();
        $story = $this->Story_model->get($story_id);
        if (!$story) show_404();
        $current = $this->session->userdata('user_id');
        if ($story->user_id != $current) show_error('Forbidden', 403);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('content','Content','trim|required');
            if ($this->form_validation->run()) {
                $data = [
                    'story_id' => $story_id,
                    'content' => $this->input->post('content')
                ];
                $id = $this->Episode_model->insert($data);
                $this->session->set_flashdata('success', 'Episode added');
                redirect('episodes/view/'.$id);
            }
        }
        $data['story'] = $story;
        $this->load->view('episodes/form', $data);
    }

    public function edit($id = null) {
        $this->require_login();
        $ep = $this->Episode_model->get($id);
        if (!$ep) show_404();
        $story = $this->Story_model->get($ep->story_id);
        if (!$story) show_404();
        $current = $this->session->userdata('user_id');
        if ($story->user_id != $current) show_error('Forbidden', 403);

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('content','Content','trim|required');
            if ($this->form_validation->run()) {
                $this->Episode_model->update($id, ['content' => $this->input->post('content')]);
                $this->session->set_flashdata('success', 'Episode updated');
                redirect('episodes/view/'.$id);
            }
        }
        $data['story'] = $story;
        $data['episode'] = $ep;
        $this->load->view('episodes/form', $data);
    }

    public function delete($id = null) {
        $this->require_login();
        $ep = $this->Episode_model->get($id);
        if (!$ep) show_404();
        $story = $this->Story_model->get($ep->story_id);
        $current = $this->session->userdata('user_id');
        if ($story->user_id != $current) show_error('Forbidden', 403);
        $this->Episode_model->delete($id);
        $this->session->set_flashdata('success', 'Episode deleted');
        redirect('stories/view/'.$story->id);
    }

    protected function require_login() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
    }
}
