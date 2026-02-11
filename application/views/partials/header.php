<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo isset($title) ? $title : 'My Book Website'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light" style="background-color:#375976 !important;">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center" style="color:white;font-weight: 700;font-size: 24px;" href="<?php echo site_url('stories'); ?>">
      <img src="<?php echo base_url('assets/img/logo.png'); ?>" alt="logo" style="height:40px;margin-right:12px;object-fit:contain;">
      My Story World
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link" style="color:white;margin-right:30px;" href="<?php echo site_url('stories'); ?>">Stories</a></li>
        <?php if ($this->session->userdata('user_id')): ?>
          <li class="nav-item dropdown">
            <?php if ($this->session->userdata('user_avatar')): ?>
              <a class="nav-link p-0" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?php echo htmlspecialchars($this->session->userdata('user_name')); ?>" data-bs-tooltip="tooltip">
                <img src="<?php echo base_url($this->session->userdata('user_avatar')); ?>" alt="<?php echo htmlspecialchars($this->session->userdata('user_name')); ?>" style="width:36px;height:36px;border-radius:50%;object-fit:cover;border: 2px solid white;">
              </a>
            <?php else: ?>
              <a class="nav-link d-flex align-items-center justify-content-center p-0" href="#" id="userMenu" role="button" data-bs-toggle="dropdown" aria-expanded="false" title="<?php echo htmlspecialchars($this->session->userdata('user_name')); ?>" data-bs-tooltip="tooltip" style="width:36px;height:36px;border-radius:50%;background-color: #ff6b6b;">
                <span style="color:white;font-weight:bold;font-size:14px;"><?php echo strtoupper(substr($this->session->userdata('user_name'), 0, 1)); ?></span>
              </a>
            <?php endif; ?>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
              <li><a class="dropdown-item" href="<?php echo site_url('auth/profile'); ?>">Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="<?php echo site_url('auth/login'); ?>">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="<?php echo site_url('auth/register'); ?>">Register</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<main class="container mt-4">
