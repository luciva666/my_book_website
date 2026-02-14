<?php $this->load->view('partials/header', ['title' => htmlspecialchars($story->title).' — Episode']); ?>
<?php $this->load->helper('user'); ?>

<div class="container">
  <div class="row">
    <div class="col-12">
      <article class="card mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <h1 class="card-title mb-0"><?php echo htmlspecialchars($story->title); ?></h1>
                <?php if (!empty($index)): ?>
                  <div class="text-muted small">Episode <?php echo intval($index); ?></div>
                <?php endif; ?>
              </div>
              <div>
                <?php if (!empty($prev)): ?>
                  <a class="btn btn-sm btn-outline-secondary me-1" href="<?php echo site_url('episodes/view/'.$prev->id); ?>">&laquo; Previous</a>
                <?php endif; ?>
                <?php if (!empty($next)): ?>
                  <a class="btn btn-sm btn-outline-secondary" href="<?php echo site_url('episodes/view/'.$next->id); ?>">Next &raquo;</a>
                <?php endif; ?>
              </div>
            </div>
          <!-- <?php //if (!empty($story->cover_image)): ?>
            <div class="mb-3"><img src="<?php //echo base_url($story->cover_image); ?>" alt="cover" class="img-fluid rounded"></div>
          <?php //endif; ?> -->
          <div class="episode-full-content mt-3">
            <?php echo nl2br(htmlspecialchars($episode->content)); ?>
          </div>
          <div class="mt-3">
            <a class="btn btn-secondary" href="<?php echo site_url('stories/view/'.$story->id); ?>">Back to story</a>
          </div>
        </div>
      </article>
    </div>
  </div>
</div>

        <script>
        // Keyboard navigation: left (37) -> prev, right (39) -> next
        (function(){
          var prev = <?php echo !empty($prev) ? json_encode(site_url('episodes/view/'.$prev->id)) : 'null'; ?>;
          var next = <?php echo !empty($next) ? json_encode(site_url('episodes/view/'.$next->id)) : 'null'; ?>;
          if (prev || next) {
            document.addEventListener('keydown', function(e){
              // ignore if input/textarea focused
              var tag = (document.activeElement || {}).tagName || '';
              if (tag === 'INPUT' || tag === 'TEXTAREA' || document.activeElement.isContentEditable) return;
              if (e.key === 'ArrowLeft' || e.keyCode === 37) {
                if (prev) window.location.href = prev;
              } else if (e.key === 'ArrowRight' || e.keyCode === 39) {
                if (next) window.location.href = next;
              }
            });
          }
        })();
        </script>

        <?php $this->load->view('partials/footer'); ?>
