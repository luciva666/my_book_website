<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Story_model extends CI_Model {
    protected $table = 'stories';

    public function get_all() {
        return $this->db->order_by('created_at','DESC')->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->db->where('id', $id);
        if (isset($data['user_id'])) {
            // if caller passes user_id in data, enforce it and then remove from payload
            $this->db->where('user_id', $data['user_id']);
            unset($data['user_id']);
        }
        return $this->db->update($this->table, $data);
    }

    public function delete($id, $user_id = null) {
        $this->db->where('id', $id);
        if ($user_id !== null) {
            $this->db->where('user_id', $user_id);
        }
        return $this->db->delete($this->table);
    }
}
