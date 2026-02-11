<?php $this->load->view('partials/header', ['title' => isset($story) ? 'Edit Story' : 'Create Story']); ?>
<div class="form-container">
	<h1><?php echo isset($story) ? 'Edit' : 'Create'; ?> Story</h1>
	<?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
	<?php echo form_open_multipart(uri_string()); ?>
		<div class="mb-3">
			<label class="form-label">Title</label>
			<input class="form-control" type="text" name="title" value="<?php echo set_value('title', isset($story) ? $story->title : ''); ?>">
		</div>
		<div class="mb-3">
			<label class="form-label">Body</label>
			<textarea class="form-control" name="body" rows="10"><?php echo set_value('body', isset($story) ? $story->body : ''); ?></textarea>
		</div>
		<div class="mb-3">
			<label class="form-label">Cover Image</label>
			<?php if (isset($story) && !empty($story->cover_image)): ?>
				<div class="mb-2"><img src="<?php echo base_url($story->cover_image); ?>" alt="cover" style="max-width:200px;height:auto;border-radius:4px;object-fit:cover"></div>
			<?php endif; ?>
			<input class="form-control" type="file" name="cover_image" accept="image/*">
		</div>
		<button class="btn btn-primary" type="submit">Save</button>
		<a class="btn btn-secondary" href="<?php echo site_url('stories'); ?>">Cancel</a>
	<?php echo form_close(); ?>
</div>
<?php $this->load->view('partials/footer'); ?>
