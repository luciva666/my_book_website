<?php $this->load->view('partials/header', ['title' => 'Profile']); ?>
<div class="form-container">
  <h1>Your Profile</h1>
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?php echo $this->session->flashdata('success'); ?></div>
  <?php endif; ?>
  <?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
  <?php endif; ?>

  <?php echo form_open_multipart('auth/profile'); ?>
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input class="form-control" type="text" name="name" value="<?php echo set_value('name', isset($user) ? $user->name : ''); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">Email</label>
      <input class="form-control" type="email" name="email" value="<?php echo set_value('email', isset($user) ? $user->email : ''); ?>">
    </div>
    <div class="mb-3">
      <label class="form-label">New Password <small class="text-muted">(leave blank to keep current)</small></label>
      <input class="form-control" type="password" name="password">
    </div>
    <div class="mb-3">
      <label class="form-label">Avatar</label>
      <?php if (!empty($user->avatar)): ?>
        <div class="mb-2"><img src="<?php echo base_url($user->avatar); ?>" alt="avatar" style="width:80px;height:80px;border-radius:50%;object-fit:cover"></div>
      <?php endif; ?>
      <input class="form-control" type="file" name="avatar" accept="image/*">
    </div>
    <button class="btn btn-primary" type="submit">Save Changes</button>
  <?php echo form_close(); ?>
</div>

<?php $this->load->view('partials/footer'); ?>
