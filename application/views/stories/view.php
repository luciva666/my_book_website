<!doctype html>
<html>
<head><meta charset="utf-8"><title><?php echo htmlspecialchars($story->title); ?></title></head>
<body>
<h1><?php echo htmlspecialchars($story->title); ?></h1>
<p><?php echo nl2br(htmlspecialchars($story->body)); ?></p>
<p><a href="<?php echo site_url('stories'); ?>">Back to list</a></p>
</body>
</html>
