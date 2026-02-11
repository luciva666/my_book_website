<?php $this->load->view('partials/header', ['title' => isset($episode) ? 'Edit Episode' : 'Add Episode']); ?>

<div class="form-container">
  <h1><?php echo isset($episode) ? 'Edit Episode' : 'Add Episode'; ?></h1>
  <?php echo validation_errors('<div class="alert alert-danger">','</div>'); ?>
  <?php echo form_open(uri_string()); ?>
    <div class="mb-3">
      <label class="form-label">Content</label>
      <textarea class="form-control" name="content" rows="12"><?php echo set_value('content', isset($episode) ? $episode->content : ''); ?></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Save</button>
    <a class="btn btn-secondary" href="<?php echo site_url('stories/view/'.$story->id); ?>">Cancel</a>
  <?php echo form_close(); ?>
</div>

<?php $this->load->view('partials/footer'); ?>
