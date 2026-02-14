<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AuthApi extends Api {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
    }

    public function register() {
        if ($this->input->method() !== 'post') {
            return $this->error('Method not allowed', 405);
        }

        $input = json_decode($this->input->raw_input_stream, true);
        
        if (!isset($input['name']) || !isset($input['email']) || !isset($input['password'])) {
            return $this->error('Missing required fields: name, email, password');
        }

        $name = trim($input['name']);
        $email = trim($input['email']);
        $password = $input['password'];

        if (strlen($password) < 6) {
            return $this->error('Password must be at least 6 characters');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->error('Invalid email format');
        }

        if ($this->User_model->get_by_email($email)) {
            return $this->error('Email already registered');
        }

        $user_id = $this->User_model->create_user([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        $user = $this->User_model->get($user_id);
        $token = $this->create_jwt($user->id, $user->name, $user->email);

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar
            ],
            'token' => $token
        ], 'Registration successful');
    }

    public function login() {
        if ($this->input->method() !== 'post') {
            return $this->error('Method not allowed', 405);
        }

        $input = json_decode($this->input->raw_input_stream, true);

        if (!isset($input['email']) || !isset($input['password'])) {
            return $this->error('Missing required fields: email, password');
        }

        $email = trim($input['email']);
        $password = $input['password'];

        $user = $this->User_model->verify_user($email, $password);
        if (!$user) {
            return $this->error('Invalid email or password', 401);
        }

        $token = $this->create_jwt($user->id, $user->name, $user->email);

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar
            ],
            'token' => $token
        ], 'Login successful');
    }

    public function profile() {
        if ($this->input->method() === 'get') {
            $user = $this->require_auth();
            $user_data = $this->User_model->get($user['user_id']);
            return $this->success([
                'user' => [
                    'id' => $user_data->id,
                    'name' => $user_data->name,
                    'email' => $user_data->email,
                    'avatar' => $user_data->avatar
                ]
            ]);
        }

        if ($this->input->method() === 'post') {
            $user = $this->require_auth();
            $user_id = $user['user_id'];
            $input = json_decode($this->input->raw_input_stream, true);

            $update = [];

            if (isset($input['name'])) {
                $update['name'] = trim($input['name']);
            }

            if (isset($input['email'])) {
                $email = trim($input['email']);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return $this->error('Invalid email format');
                }
                $existing = $this->User_model->get_by_email($email);
                if ($existing && $existing->id != $user_id) {
                    return $this->error('Email already in use');
                }
                $update['email'] = $email;
            }

            if (isset($input['password']) && !empty($input['password'])) {
                if (strlen($input['password']) < 6) {
                    return $this->error('Password must be at least 6 characters');
                }
                $update['password'] = $input['password'];
            }

            if (!empty($update)) {
                $this->User_model->update_user($user_id, $update);
            }

            $updated_user = $this->User_model->get($user_id);
            return $this->success([
                'user' => [
                    'id' => $updated_user->id,
                    'name' => $updated_user->name,
                    'email' => $updated_user->email,
                    'avatar' => $updated_user->avatar
                ]
            ], 'Profile updated');
        }

        return $this->error('Method not allowed', 405);
    }

    public function logout() {
        return $this->success([], 'Logout successful');
    }
}
?>
