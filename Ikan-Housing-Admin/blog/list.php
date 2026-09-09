<?php
include('../components/auth.php');
include('../../config.php');

// Handle status update
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = $_GET['id'];
    $status = $_GET['status'] == 1 ? 0 : 1;
    mysqli_query($con, "UPDATE blog SET status = $status WHERE id = $id");
    header("Location: list");
    exit;
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = "";
$where = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $where = "WHERE name LIKE '%$search%' OR massage LIKE '%$search%'";
}

// Total records
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM blog $where");
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch data
$query = "SELECT * FROM blog $where ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<body class="premium-admin-theme">
  <div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>

    <div class="main-panel">
      <div class="main-header">
        <?php include('../components/viewNavbar.php'); ?>
      </div>

      <div class="container">
        <div class="page-inner">
          
          <!-- Premium Header Section -->
          <div class="admin-hero d-flex flex-column flex-md-row justify-content-between align-items-md-center px-4 py-4 mb-4">
            <div>
              <h2 class="mb-1">Blog Management</h2>
              <p class="mb-0">Publish and manage your latest news and updates.</p>
            </div>
            <div class="mt-3 mt-md-0 d-flex gap-2">
              <div class="position-relative">
                <form method="GET" action="" class="d-flex align-items-center">
                  <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                         class="form-control" style="border-radius: 10px; padding-left: 35px;" 
                         placeholder="Search blogs...">
                  <i class="fas fa-search position-absolute" style="left: 12px; color: var(--text-muted);"></i>
                </form>
              </div>
              <a href="add" class="btn btn-light shadow-sm">
                <i class="fas fa-plus me-1"></i> Add Blog
              </a>
            </div>
          </div>

          <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="row g-4">
              <?php
              $counter = 0;
              while ($row = mysqli_fetch_assoc($result)):
                $isChecked = $row['status'] == 1 ? 'checked' : '';
                $statusLabel = $row['status'] == 1 ? 'Active' : 'Draft';
                $badgeClass = $row['status'] == 1 ? 'bg-success' : 'bg-warning';
                $snippet = substr(strip_tags($row['massage']), 0, 120) . "...";
              ?>
                <div class="col-12" data-aos="fade-up" data-aos-delay="<?= $counter * 50 ?>">
                  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-0">
                    <div class="card-body p-0">
                      <div class="row g-0 align-items-center">
                        <div class="col-md-2 p-3">
                          <img src="../../uploads/<?= $row['image'] ?>" class="rounded-3 w-100 object-fit-cover" style="height: 100px;" alt="<?= htmlspecialchars($row['name']) ?>">
                        </div>
                        <div class="col-md-6 p-3">
                          <h5 class="fw-bold mb-1 text-dark"><?= htmlspecialchars($row['name']) ?></h5>
                          <p class="text-muted small mb-0 line-clamp-2"><?= $snippet ?></p>
                        </div>
                        <div class="col-md-2 p-3 text-center">
                           <div class="d-flex flex-column align-items-center">
                             <span class="status-label-badge <?= $row['status'] == 1 ? 'badge-active' : 'badge-draft' ?> mb-2" id="label-<?= $row['id'] ?>">
                               <?= $statusLabel ?>
                             </span>
                             <label class="premium-switch">
                               <input type="checkbox" class="status-toggle" data-id="<?= $row['id'] ?>" data-status="<?= $row['status'] ?>" <?= $isChecked ?>>
                               <span class="switch-slider"></span>
                             </label>
                           </div>
                        </div>
                        <div class="col-md-2 p-3 text-end pe-4">
                          <div class="d-flex gap-2 justify-content-end">
                            <a href="edit?id=<?= $row['id'] ?>" class="btn btn-icon btn-link btn-primary btn-lg" title="Edit">
                              <i class="fa fa-edit"></i>
                            </a>
                            <button class="btn btn-icon btn-link btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="delete-blog.php?id=<?= $row['id'] ?>" title="Delete">
                              <i class="fa fa-times"></i>
                            </button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php 
                $counter++;
              endwhile; 
              ?>
            </div>

            <!-- Enhanced Pagination -->
            <div class="card border-0 shadow-sm rounded-4 mt-4 py-3 px-4">
               <div class="d-flex justify-content-between align-items-center">
                 <span class="text-muted small">Showing <?= $start + 1 ?> to <?= $start + mysqli_num_rows($result) ?> of <?= $total_records ?> entries</span>
                 <nav>
                   <ul class="pagination pagination-primary mb-0">
                     <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                       <a class="page-link shadow-none" href="?page=<?= max(1, $page-1) ?>&search=<?= urlencode($search) ?>">
                         <i class="fas fa-chevron-left"></i>
                       </a>
                     </li>
                     <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                       <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                         <a class="page-link shadow-none" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                       </li>
                     <?php endfor; ?>
                     <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
                       <a class="page-link shadow-none" href="?page=<?= min($total_pages, $page+1) ?>&search=<?= urlencode($search) ?>">
                         <i class="fas fa-chevron-right"></i>
                       </a>
                     </li>
                   </ul>
                 </nav>
               </div>
            </div>

          <?php else: ?>
            <div class="card border-0 shadow-sm rounded-4 text-center py-5">
               <div class="mx-auto mb-4" style="width: 80px; height: 80px; background: var(--light-pink); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="fas fa-file-alt text-primary h3 mb-0"></i>
               </div>
               <h3 class="fw-bold text-dark mb-2">No blogs found</h3>
               <p class="text-muted mb-4">Start by creating your first blog post to engage your audience.</p>
               <a href="add" class="btn btn-primary px-4 py-2 rounded-pill">Create New Blog</a>
            </div>
          <?php endif; ?>
        </div> <!-- End page-inner -->
      </div> <!-- End container -->
      <?php include('../components/viewFooter.php'); ?>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg rounded-4">
        <div class="modal-body p-5 text-center">
          <div class="mx-auto mb-4" style="width: 70px; height: 70px; background: #fff5f5; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-exclamation-triangle text-danger h3 mb-0"></i>
          </div>
          <h4 class="fw-bold text-dark mb-3">Delete Blog Post?</h4>
          <p class="text-muted mb-4">Confirming will permanently remove this record. This action cannot be undone.</p>
          <div class="d-flex gap-3 justify-content-center">
             <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none" data-bs-dismiss="modal">Cancel</button>
             <a id="confirmDeleteBtn" href="#" class="btn btn-danger px-4 py-2 rounded-pill shadow-sm">Yes, Delete Post</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .object-fit-cover { object-fit: cover; }
    .btn-icon { width: 40px; height: 40px; border-radius: 10px; display: inline-flex; align-items: center; justify-content: center; }
    .status-toggle:checked { background-color: var(--primary-color); border-color: var(--primary-color); }
    .pagination-primary .page-item.active .page-link { background-color: var(--primary-color); border-color: var(--primary-color); }
    .pagination-primary .page-link { color: var(--text-main); border-radius: 8px; margin: 0 3px; }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize AOS
      AOS.init({ duration: 800, once: true });

      // AJAX Status Toggle Logic
      const toggles = document.querySelectorAll('.status-toggle');
      toggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
          const id = this.getAttribute('data-id');
          const currentStatus = this.getAttribute('data-status');
          const label = document.getElementById('label-' + id);
          
          const newStatus = currentStatus == 1 ? 0 : 1;
          label.textContent = newStatus == 1 ? 'Active' : 'Draft';
          label.className = 'status-label-badge ' + (newStatus == 1 ? 'badge-active' : 'badge-draft');
          this.setAttribute('data-status', newStatus);

          fetch(`toggle-status.php?id=${id}&status=${currentStatus}`)
            .then(response => response.json())
            .then(data => {
              if (!data.success) {
                alert('Error: ' + data.message);
                location.reload(); 
              }
            })
            .catch(error => {
              console.error('Fetch error:', error);
              alert('Network error occurred.');
              location.reload();
            });
        });
      });

      // Delete Modal Logic
      $('#deleteModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var url = button.attr('data-url');
        $('#confirmDeleteBtn').attr('href', url);
      });
    });
  </script>
</body>
</html>
