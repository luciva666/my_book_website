<?php $this->load->view('partials/header', ['title' => 'Login']); ?>
<div class="form-container">
<h1>Login</h1>
<?php if ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
<?php endif; ?>
<?php echo form_open('auth/login'); ?>
    <div class="mb-3">
        <label class="form-label">Email</label>
        <input class="form-control" type="email" name="email" value="<?php echo set_value('email'); ?>">
    </div>
    <div class="mb-3">
        <label class="form-label">Password</label>
        <input class="form-control" type="password" name="password">
    </div>
    <button class="btn btn-primary" type="submit">Login</button>
<?php echo form_close(); ?>
<p class="mt-3"><a href="<?php echo site_url('auth/register'); ?>">Create an account</a></p>
</div>
<?php $this->load->view('partials/footer'); ?>
