<!doctype html>
<html>
<head><meta charset="utf-8"><title><?php echo isset($story) ? 'Edit' : 'Create'; ?> Story</title></head>
<body>
<h1><?php echo isset($story) ? 'Edit' : 'Create'; ?> Story</h1>
<?php echo validation_errors(); ?>
<?php echo form_open(uri_string()); ?>
<p><label>Title<br><input type="text" name="title" value="<?php echo set_value('title', isset($story) ? $story->title : ''); ?>"></label></p>
<p><label>Body<br><textarea name="body" rows="10" cols="60"><?php echo set_value('body', isset($story) ? $story->body : ''); ?></textarea></label></p>
<p><button type="submit">Save</button> <a href="<?php echo site_url('stories'); ?>">Cancel</a></p>
<?php echo form_close(); ?>
</body>
</html>
