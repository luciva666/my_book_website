<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form']);
        $this->load->model('User_model');
    }

    public function register() {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            $this->form_validation->set_rules('password','Password','required|min_length[6]');
            if ($this->form_validation->run()) {
                $data = $this->input->post(['name','email','password']);
                if ($this->User_model->get_by_email($data['email'])) {
                    $this->session->set_flashdata('error','Email already registered');
                } else {
                    $id = $this->User_model->create_user($data);
                    $this->session->set_userdata('user_id',$id);
                    $this->session->set_userdata('user_name',$data['name']);
                    redirect('stories');
                }
            }
        }
        $this->load->view('auth/register');
    }

    public function login() {
        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            $this->form_validation->set_rules('password','Password','required');
            if ($this->form_validation->run()) {
                $email = $this->input->post('email');
                $password = $this->input->post('password');
                $user = $this->User_model->verify_user($email, $password);
                if ($user) {
                    $this->session->set_userdata('user_id',$user->id);
                    $this->session->set_userdata('user_name',$user->name);
                    redirect('stories');
                } else {
                    $this->session->set_flashdata('error','Invalid credentials');
                }
            }
        }
        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
