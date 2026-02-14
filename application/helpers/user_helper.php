<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Cache for user lookups to avoid repeated DB queries
$_user_cache = array();

/**
 * Get user name by user_id
 * @param int $user_id User ID
 * @return string User name or 'Unknown User' if not found
 */
function get_user_name($user_id) {
    global $_user_cache;
    
    // Return from cache if available
    if (isset($_user_cache[$user_id])) {
        return $_user_cache[$user_id];
    }
    
    // Get CodeIgniter instance
    $CI = get_instance();
    $CI->load->model('User_model');
    
    // Query for user
    $user = $CI->User_model->get($user_id);
    $name = ($user && !empty($user->name)) ? $user->name : 'Unknown User';
    
    // Cache result
    $_user_cache[$user_id] = $name;
    
    return $name;
}

/**
 * Get user avatar by user_id
 * @param int $user_id User ID
 * @return string Avatar path or null if not found
 */
function get_user_avatar($user_id) {
    $CI = get_instance();
    $CI->load->model('User_model');
    $user = $CI->User_model->get($user_id);
    return ($user && !empty($user->avatar)) ? $user->avatar : null;
}
