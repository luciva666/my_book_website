<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light mt-5 py-4 border-top" style="border-color: #375976 !important;">
      <div class="container">
        <div class="text-center small text-secondary">
          <p style="font-size: 0.85rem;margin-bottom:0px;color:white;">© <?php echo date('Y'); ?> My Story World. All rights reserved.</p>
        </div>
      </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-tooltip="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Read more toggle for episode content
        document.addEventListener('DOMContentLoaded', function(){
            document.querySelectorAll('.read-more-toggle').forEach(function(link){
                link.addEventListener('click', function(e){
                    e.preventDefault();
                    var parent = link.parentElement;
                    var shortDiv = parent.querySelector('.episode-content-short');
                    var fullDiv = parent.querySelector('.episode-content-full');
                    if (!fullDiv) return;
                    if (fullDiv.classList.contains('d-none')) {
                        fullDiv.classList.remove('d-none');
                        if (shortDiv) shortDiv.classList.add('d-none');
                        link.textContent = 'Show less';
                    } else {
                        fullDiv.classList.add('d-none');
                        if (shortDiv) shortDiv.classList.remove('d-none');
                        link.textContent = 'Read more';
                    }
                });
            });

            // intercept delete links with SweetAlert2
            document.querySelectorAll('a.swal-delete').forEach(function(link){
                link.addEventListener('click', function(e){
                    e.preventDefault();
                    var href = link.getAttribute('href');
                    var msg = link.getAttribute('data-msg') || 'Are you sure you want to delete this item?';
                    Swal.fire({
                        title: 'Confirm',
                        text: msg,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it',
                    }).then(function(result){
                        if (result.isConfirmed) {
                            window.location.href = href;
                        }
                    });
                });
            });

            // show flash messages via Swal
            <?php if ($this->session->flashdata('success')): ?>
                Swal.fire({icon: 'success', title: 'Success', text: <?php echo json_encode($this->session->flashdata('success')); ?>});
            <?php endif; ?>
            <?php if ($this->session->flashdata('error')): ?>
                Swal.fire({icon: 'error', title: 'Error', text: <?php echo json_encode($this->session->flashdata('error')); ?>});
            <?php endif; ?>
        });
        </script>
        </body>
        </html>
