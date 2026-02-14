<?php $this->load->view('partials/header', ['title' => 'Register']); ?>
<div class="form-container">
<h1>Register</h1>
<?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<?php echo form_open('auth/register'); ?>
    <div class="mb-3">
        <label class="form-label">Name</label>
        <input class="form-control" type="text" name="name" value="<?php echo set_value('name'); ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="<?php echo set_value('email'); ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password">
    </div>
    <button class="btn btn-primary" type="submit">Register</button>
<?php echo form_close(); ?>
<p class="mt-3"><a href="<?php echo site_url('auth/login'); ?>">Already have an account? Login</a></p>
</div>
<?php $this->load->view('partials/footer'); ?>
