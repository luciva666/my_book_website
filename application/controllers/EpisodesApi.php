<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EpisodesApi extends Api {
    public function __construct() {
        parent::__construct();
        $this->load->model('Episode_model');
        $this->load->model('Story_model');
    }

    public function view($id = null) {
        if (!$id) {
            return $this->error('Episode ID required');
        }

        $episode = $this->Episode_model->get($id);
        if (!$episode) {
            return $this->error('Episode not found', 404);
        }

        $story = $this->Story_model->get($episode->story_id);
        $prev = $this->Episode_model->get_prev($id);
        $next = $this->Episode_model->get_next($id);
        $index = $this->Episode_model->get_index($id);

        return $this->success([
            'episode' => [
                'id' => $episode->id,
                'story_id' => $episode->story_id,
                'content' => $episode->content,
                'created_at' => $episode->created_at,
                'index' => $index
            ],
            'story' => [
                'id' => $story->id,
                'title' => $story->title
            ],
            'prev' => $prev ? [
                'id' => $prev->id,
                'created_at' => $prev->created_at
            ] : null,
            'next' => $next ? [
                'id' => $next->id,
                'created_at' => $next->created_at
            ] : null
        ]);
    }

    public function create($story_id = null) {
        if (!$story_id) {
            return $this->error('Story ID required');
        }

        if ($this->input->method() !== 'post') {
            return $this->error('Method not allowed', 405);
        }

        $user = $this->require_auth();

        $story = $this->Story_model->get($story_id);
        if (!$story) {
            return $this->error('Story not found', 404);
        }

        if ($story->user_id != $user['user_id']) {
            return $this->error('Forbidden: only story owner can add episodes', 403);
        }

        $input = json_decode($this->input->raw_input_stream, true);

        if (!isset($input['content'])) {
            return $this->error('Missing required field: content');
        }

        $episode_id = $this->Episode_model->insert([
            'story_id' => $story_id,
            'content' => trim($input['content'])
        ]);

        $episode = $this->Episode_model->get($episode_id);

        return $this->success([
            'episode' => [
                'id' => $episode->id,
                'story_id' => $episode->story_id,
                'content' => $episode->content,
                'created_at' => $episode->created_at
            ]
        ], 'Episode created successfully');
    }

    public function update($id = null) {
        if (!$id) {
            return $this->error('Episode ID required');
        }

        if ($this->input->method() !== 'post' && $this->input->method() !== 'put') {
            return $this->error('Method not allowed', 405);
        }

        $user = $this->require_auth();

        $episode = $this->Episode_model->get($id);
        if (!$episode) {
            return $this->error('Episode not found', 404);
        }

        $story = $this->Story_model->get($episode->story_id);
        if ($story->user_id != $user['user_id']) {
            return $this->error('Forbidden: only story owner can edit episodes', 403);
        }

        $input = json_decode($this->input->raw_input_stream, true);

        if (!isset($input['content'])) {
            return $this->error('Missing required field: content');
        }

        $this->Episode_model->update($id, [
            'content' => trim($input['content'])
        ]);

        $updated = $this->Episode_model->get($id);

        return $this->success([
            'episode' => [
                'id' => $updated->id,
                'story_id' => $updated->story_id,
                'content' => $updated->content,
                'created_at' => $updated->created_at
            ]
        ], 'Episode updated successfully');
    }

    public function delete($id = null) {
        if (!$id) {
            return $this->error('Episode ID required');
        }

        if ($this->input->method() !== 'post' && $this->input->method() !== 'delete') {
            return $this->error('Method not allowed', 405);
        }

        $user = $this->require_auth();

        $episode = $this->Episode_model->get($id);
        if (!$episode) {
            return $this->error('Episode not found', 404);
        }

        $story = $this->Story_model->get($episode->story_id);
        if ($story->user_id != $user['user_id']) {
            return $this->error('Forbidden: only story owner can delete episodes', 403);
        }

        $this->Episode_model->delete($id);

        return $this->success([], 'Episode deleted successfully');
    }
}
?>
