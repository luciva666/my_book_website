<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Episode_model extends CI_Model {
    protected $table = 'episodes';

    public function get_by_story($story_id) {
        return $this->db->where('story_id', $story_id)->order_by('created_at','ASC')->get($this->table)->result();
    }

    public function get($id) {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    public function get_prev($episode_id) {
        $ep = $this->get($episode_id);
        if (!$ep) return null;
        return $this->db->where('story_id', $ep->story_id)
                        ->where('created_at <', $ep->created_at)
                        ->order_by('created_at', 'DESC')
                        ->get($this->table)
                        ->row();
    }

    public function get_next($episode_id) {
        $ep = $this->get($episode_id);
        if (!$ep) return null;
        return $this->db->where('story_id', $ep->story_id)
                        ->where('created_at >', $ep->created_at)
                        ->order_by('created_at', 'ASC')
                        ->get($this->table)
                        ->row();
    }

    public function insert($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function get_index($episode_id) {
        $ep = $this->get($episode_id);
        if (!$ep) return null;
        $count = $this->db->where('story_id', $ep->story_id)
                          ->where('created_at <=', $ep->created_at)
                          ->from($this->table)
                          ->count_all_results();
        return (int) $count;
    }

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id) {
        return $this->db->delete($this->table, ['id' => $id]);
    }
}
