<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session','form_validation']);
        $this->load->helper(['url','form']);
        $this->load->model('User_model');
    }

    protected function require_login() {
        if (!$this->session->userdata('user_id')) {
            redirect('auth/login');
        }
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
                    $this->session->set_userdata('user_avatar', isset($user->avatar) ? $user->avatar : null);
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

    public function profile() {
        $this->require_login();
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get($user_id);
        if (!$user) show_404();

        if ($this->input->method() === 'post') {
            $this->form_validation->set_rules('name','Name','trim|required');
            $this->form_validation->set_rules('email','Email','trim|required|valid_email');
            $this->form_validation->set_rules('password','Password','min_length[6]');
            if ($this->form_validation->run()) {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $password = $this->input->post('password');

                $existing = $this->User_model->get_by_email($email);
                if ($existing && $existing->id != $user_id) {
                    $this->session->set_flashdata('error','Email already in use');
                } else {
                    $update = ['name' => $name, 'email' => $email];
                    if (!empty($password)) $update['password'] = $password;
                    // handle avatar upload
                    if (!empty($_FILES['avatar']['name'])) {
                        $upload_path = FCPATH . 'assets/uploads/avatars/';
                        if (!is_dir($upload_path)) mkdir($upload_path, 0755, true);
                        $config = [
                            'upload_path' => $upload_path,
                            'allowed_types' => 'jpg|jpeg|png|gif',
                            'max_size' => 2048,
                            'file_name' => 'avatar_'.$user_id.'_'.time(),
                            'overwrite' => true,
                        ];
                        $this->load->library('upload', $config);
                        if ($this->upload->do_upload('avatar')) {
                            $ud = $this->upload->data();
                            $update['avatar'] = 'assets/uploads/avatars/'.$ud['file_name'];
                            $this->session->set_userdata('user_avatar', $update['avatar']);
                        } else {
                            $this->session->set_flashdata('error', $this->upload->display_errors('', ''));
                        }
                    }
                    $this->User_model->update_user($user_id, $update);
                    $this->session->set_userdata('user_name', $name);
                    $this->session->set_flashdata('success','Profile updated');
                    redirect('auth/profile');
                }
            }
        }

        $data['user'] = $user;
        $this->load->view('auth/profile', $data);
    }
}
