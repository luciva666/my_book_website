<!doctype html>
<html>
<head><meta charset="utf-8"><title>Login</title></head>
<body>
<h1>Login</h1>
<?php if ($this->session->flashdata('error')): ?>
    <p style="color:red"><?php echo $this->session->flashdata('error'); ?></p>
<?php endif; ?>
<?php echo form_open('auth/login'); ?>
<p><label>Email<br><input type="email" name="email" value="<?php echo set_value('email'); ?>"></label></p>
<p><label>Password<br><input type="password" name="password"></label></p>
<p><button type="submit">Login</button></p>
<?php echo form_close(); ?>
<p><a href="<?php echo site_url('auth/register'); ?>">Register</a></p>
</body>
</html>
