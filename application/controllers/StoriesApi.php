<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StoriesApi extends Api {
    public function __construct() {
        parent::__construct();
        $this->load->model('Story_model');
        $this->load->model('Episode_model');
        $this->load->model('User_model');
    }

    public function index() {
        $stories = $this->Story_model->get_all();
        
        $data = [];
        foreach ($stories as $story) {
            $author = $this->User_model->get($story->user_id);
            $episode_count = count($this->Episode_model->get_by_story($story->id));
            
            $data[] = [
                'id' => $story->id,
                'title' => $story->title,
                'body' => $story->body,
                'cover_image' => $story->cover_image,
                'created_at' => $story->created_at,
                'updated_at' => $story->updated_at,
                'author' => [
                    'id' => $author->id,
                    'name' => $author->name,
                    'avatar' => $author->avatar
                ],
                'episode_count' => $episode_count
            ];
        }

        return $this->success(['stories' => $data]);
    }

    public function view($id = null) {
        if (!$id) {
            return $this->error('Story ID required');
        }

        $story = $this->Story_model->get($id);
        if (!$story) {
            return $this->error('Story not found', 404);
        }

        $author = $this->User_model->get($story->user_id);
        $episodes = $this->Episode_model->get_by_story($id);

        $episodes_data = [];
        foreach ($episodes as $episode) {
            $episodes_data[] = [
                'id' => $episode->id,
                'content' => $episode->content,
                'created_at' => $episode->created_at
            ];
        }

        return $this->success([
            'story' => [
                'id' => $story->id,
                'title' => $story->title,
                'body' => $story->body,
                'cover_image' => $story->cover_image,
                'created_at' => $story->created_at,
                'updated_at' => $story->updated_at,
                'author' => [
                    'id' => $author->id,
                    'name' => $author->name,
                    'avatar' => $author->avatar
                ]
            ],
            'episodes' => $episodes_data
        ]);
    }

    public function create() {
        if ($this->input->method() !== 'post') {
            return $this->error('Method not allowed', 405);
        }

        $user = $this->require_auth();
        $user_id = $user['user_id'];

        $input = json_decode($this->input->raw_input_stream, true);

        if (!isset($input['title']) || !isset($input['body'])) {
            return $this->error('Missing required fields: title, body');
        }

        $story_id = $this->Story_model->insert([
            'user_id' => $user_id,
            'title' => trim($input['title']),
            'body' => trim($input['body']),
            'cover_image' => isset($input['cover_image']) ? $input['cover_image'] : null
        ]);

        $story = $this->Story_model->get($story_id);
        $author = $this->User_model->get($user_id);

        return $this->success([
            'story' => [
                'id' => $story->id,
                'title' => $story->title,
                'body' => $story->body,
                'cover_image' => $story->cover_image,
                'created_at' => $story->created_at,
                'author' => [
                    'id' => $author->id,
                    'name' => $author->name,
                    'avatar' => $author->avatar
                ]
            ]
        ], 'Story created successfully');
    }

    public function update($id = null) {
        if (!$id) {
            return $this->error('Story ID required');
        }

        if ($this->input->method() !== 'post' && $this->input->method() !== 'put') {
            return $this->error('Method not allowed', 405);
        }

        $user = $this->require_auth();
        $user_id = $user['user_id'];

        $story = $this->Story_model->get($id);
        if (!$story) {
            return $this->error('Story not found', 404);
        }

        if ($story->user_id != $user_id) {
            return $this->error('Forbidden: you cannot edit this story', 403);
        }

        $input = json_decode($this->input->raw_input_stream, true);

        $update = [];
        if (isset($input['title'])) $update['title'] = trim($input['title']);
        if (isset($input['body'])) $update['body'] = trim($input['body']);
        if (isset($input['cover_image'])) $update['cover_image'] = $input['cover_image'];

        if (empty($update)) {
            return $this->error('No updates provided');
        }

        $this->Story_model->update($id, $update);
        $updated_story = $this->Story_model->get($id);
        $author = $this->User_model->get($user_id);

        return $this->success([
            'story' => [
                'id' => $updated_story->id,
                'title' => $updated_story->title,
                'body' => $updated_story->body,
                'cover_image' => $updated_story->cover_image,
                'updated_at' => $updated_story->updated_at,
                'author' => [
                    'id' => $author->id,
                    'name' => $author->name,
                    'avatar' => $author->avatar
                ]
            ]
        ], 'Story updated successfully');
    }

    public function delete($id = null) {
        if (!$id) {
            return $this->error('Story ID required');
        }

        if ($this->input->method() !== 'post' && $this->input->method() !== 'delete') {
            return $this->error('Method not allowed', 405);
        }

        $user = $this->require_auth();
        $user_id = $user['user_id'];

        $story = $this->Story_model->get($id);
        if (!$story) {
            return $this->error('Story not found', 404);
        }

        if ($story->user_id != $user_id) {
            return $this->error('Forbidden: you cannot delete this story', 403);
        }

        $this->Story_model->delete($id, $user_id);

        return $this->success([], 'Story deleted successfully');
    }
}
?>
