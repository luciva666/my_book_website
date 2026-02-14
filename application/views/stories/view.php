<?php $this->load->view('partials/header', ['title' => htmlspecialchars($story->title)]); ?>
<?php $this->load->helper('user'); ?>
	<article class="card">
		<div class="card-body">
			<?php $ep_count = !empty($episodes) ? count($episodes) : 0; ?>
			<h1 class="card-title"><?php echo htmlspecialchars($story->title); ?> <small class="text-muted">&mdash; Episodes (<?php echo $ep_count; ?>)</small></h1>
			<p class="text-muted small">by <strong><?php echo htmlspecialchars(get_user_name($story->user_id)); ?></strong> — <?php echo htmlspecialchars($story->created_at); ?></p>
			<?php if (!empty($story->cover_image)): ?>
				<div class="mb-3"><img src="<?php echo base_url($story->cover_image); ?>" alt="cover" class="img-fluid rounded"></div>
			<?php endif; ?>
			<?php if (!empty($episodes)): ?>
				<hr>
				<section id="episodes">
					<?php foreach ($episodes as $idx => $ep): ?>
						<?php
							$limit = 600; // characters to show in collapsed view
							$plain = $ep->content;
							$short = mb_substr($plain, 0, $limit);
							$needs_toggle = mb_strlen($plain) > $limit;
						?>
						<div class="episode mb-4">
								<?php if ($needs_toggle): ?>
								<div class="episode-content-short">
									<?php echo nl2br(htmlspecialchars($short)); ?>
									<span class="ellipsis">&hellip;</span>
								</div>
								<div class="episode-content-full d-none">
									<?php echo nl2br(htmlspecialchars($plain)); ?>
								</div>
									<a href="#" class="read-more-toggle">Read more</a>
									<a class="btn btn-sm btn-outline-primary ms-2" href="<?php echo site_url('episodes/view/'.$ep->id); ?>">Episode <?php echo $idx+1; ?></a>
									<?php if ($this->session->userdata('user_id') == $story->user_id): ?>
										<a class="btn btn-sm btn-outline-secondary ms-2" href="<?php echo site_url('episodes/edit/'.$ep->id); ?>">Edit</a>
										<a class="btn btn-sm btn-outline-danger ms-2 swal-delete" data-msg="Delete this episode?" href="<?php echo site_url('episodes/delete/'.$ep->id); ?>">Delete</a>
									<?php endif; ?>
							<?php else: ?>
								<div class="episode-content">
									<a class="btn btn-sm btn-outline-primary ms-2" href="<?php echo site_url('episodes/view/'.$ep->id); ?>">Episode <?php echo $idx+1; ?></a>
									<?php if ($this->session->userdata('user_id') == $story->user_id): ?>
										<a class="btn btn-sm btn-outline-secondary ms-2" href="<?php echo site_url('episodes/edit/'.$ep->id); ?>">Edit</a>
										<a class="btn btn-sm btn-outline-danger ms-2 swal-delete" data-msg="Delete this episode?" href="<?php echo site_url('episodes/delete/'.$ep->id); ?>">Delete</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</section>
			<?php endif; ?>
			<div class="mt-3">
				<a class="btn btn-sm btn-secondary" href="<?php echo site_url('stories'); ?>">Back to list</a>
				<?php if ($this->session->userdata('user_id') == $story->user_id): ?>
					<a class="btn btn-sm btn-success" href="<?php echo site_url('episodes/create/'.$story->id); ?>">Add Episode</a>
				<?php endif; ?>
			</div>
		</div>
	</article>
<?php $this->load->view('partials/footer'); ?>
    