<!doctype html>
<html>
<head><meta charset="utf-8"><title>Stories</title></head>
<body>
<h1>Stories</h1>
<?php if ($this->session->userdata('user_name')): ?>
    <p>Hi <?php echo $this->session->userdata('user_name'); ?> — <a href="<?php echo site_url('auth/logout'); ?>">Logout</a></p>
    <p><a href="<?php echo site_url('stories/create'); ?>">Create New Story</a></p>
<?php else: ?>
    <p><a href="<?php echo site_url('auth/login'); ?>">Login</a> or <a href="<?php echo site_url('auth/register'); ?>">Register</a></p>
<?php endif; ?>

<?php if (empty($stories)): ?>
    <p>No stories yet.</p>
<?php else: ?>
    <ul>
    <?php foreach ($stories as $s): ?>
        <li>
            <a href="<?php echo site_url('stories/view/'.$s->id); ?>"><?php echo htmlspecialchars($s->title); ?></a>
            <?php if ($this->session->userdata('user_id') == $s->user_id): ?>
                - <a href="<?php echo site_url('stories/edit/'.$s->id); ?>">Edit</a>
                - <a href="<?php echo site_url('stories/delete/'.$s->id); ?>" onclick="return confirm('Delete?')">Delete</a>
            <?php endif; ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
</body>
</html>
