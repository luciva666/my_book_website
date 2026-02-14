<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(200);
            exit();
        }
    }

    protected function respond($data = [], $status = 200) {
        http_response_code($status);
        echo json_encode($data);
        exit;
    }

    protected function error($message, $status = 400) {
        $this->respond(['error' => $message], $status);
    }

    protected function success($data, $message = null) {
        $response = ['success' => true];
        if ($message) $response['message'] = $message;
        if (is_array($data)) {
            $response = array_merge($response, $data);
        } else {
            $response['data'] = $data;
        }
        $this->respond($response, 200);
    }

    protected function get_authorization_token() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $parts = explode(' ', $headers['Authorization']);
            return count($parts) === 2 ? $parts[1] : null;
        }
        return null;
    }

    protected function verify_jwt($token) {
        // Simple JWT verification - in production use a proper JWT library
        if (empty($token)) return null;
        
        $parts = explode('.', $token);
        if (count($parts) !== 3) return null;
        
        $payload = json_decode(base64_decode($parts[1]), true);
        return $payload;
    }

    protected function create_jwt($user_id, $user_name, $user_email) {
        // Simple JWT creation - in production use a proper JWT library
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);
        $payload = json_encode([
            'user_id' => $user_id,
            'user_name' => $user_name,
            'user_email' => $user_email,
            'iat' => time(),
            'exp' => time() + (30 * 24 * 60 * 60) // 30 days
        ]);
        
        $header = rtrim(strtr(base64_encode($header), '+/', '-_'), '=');
        $payload = rtrim(strtr(base64_encode($payload), '+/', '-_'), '=');
        $signature = hash_hmac('sha256', "$header.$payload", 'your-secret-key', true);
        $signature = rtrim(strtr(base64_encode($signature), '+/', '-_'), '=');
        
        return "$header.$payload.$signature";
    }

    protected function require_auth() {
        $token = $this->get_authorization_token();
        $user = $this->verify_jwt($token);
        if (!$user) {
            $this->error('Unauthorized', 401);
        }
        return $user;
    }
}
?>
