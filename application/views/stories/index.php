<?php $this->load->view('partials/header', ['title' => 'Stories']); ?>
<?php $this->load->helper('user'); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1>Stories</h1>
    <?php if ($this->session->userdata('user_name')): ?>
        <a class="btn btn-success" href="<?php echo site_url('stories/create'); ?>">Create New Story</a>
    <?php endif; ?>
</div>

<?php if (empty($stories)): ?>
    <div class="alert alert-info">No stories yet.</div>
<?php else: ?>
    <div class="row">
    <?php foreach ($stories as $s): ?>
        <div class="col-md-6">
            <div class="card card-story">
                <div class="card-body">
                    <?php if (!empty($s->cover_image)): ?>
                        <div class="mb-2"><img src="<?php echo base_url($s->cover_image); ?>" alt="cover" style="width:100%;height:150px;object-fit:cover;border-radius:4px"></div>
                    <?php endif; ?>
                    <h5 class="story-title"><a href="<?php echo site_url('stories/view/'.$s->id); ?>"><?php echo htmlspecialchars($s->title); ?></a></h5>
                    <p class="text-muted small">by <strong><?php echo htmlspecialchars(get_user_name($s->user_id)); ?></strong> — <?php echo htmlspecialchars($s->created_at); ?></p>
                    <?php if ($this->session->userdata('user_id') == $s->user_id): ?>
                        <a class="btn btn-sm btn-outline-primary" href="<?php echo site_url('stories/edit/'.$s->id); ?>">Edit</a>
                        <a class="btn btn-sm btn-outline-danger swal-delete" data-msg="Delete this story?" href="<?php echo site_url('stories/delete/'.$s->id); ?>">Delete</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php $this->load->view('partials/footer'); ?>
