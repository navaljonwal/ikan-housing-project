<?php
include('../../config.php');

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = '';
$searchQuery = '';
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $searchQuery = "WHERE name LIKE '%$search%' OR about_our_testimonial LIKE '%$search%'";
}

// Count total
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM testimonial $searchQuery");
$total = mysqli_fetch_assoc($countResult)['total'];
$pages = ceil($total / $limit);

// Fetch records
$query = "SELECT * FROM testimonial $searchQuery ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<body>
<div class="wrapper">
  <?php include('../components/viewSidebar.php'); ?>
  <div class="main-panel">
    <div class="main-header"><?php include('../components/viewNavbar.php'); ?></div>
    <div class="container">
      <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
          <div>
            <h3 class="fw-bold mb-2">Testimonial List</h3>
            <ul class="breadcrumbs mb-2">
              <li class="nav-home"><a href="#"><i class="icon-home"></i></a></li>
              <li class="separator"><i class="icon-arrow-right"></i></li>
              <li class="nav-item"><a href="add">Add Testimonial</a></li>
            </ul>
          </div>
          <form method="GET" action="" class="input-group" style="max-width: 300px;">
            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control border-end-0" placeholder="Search testimonials...">
            <button class="btn btn-white border border-start-0" type="submit"><i class="fas fa-search text-muted"></i></button>
          </form>
        </div>

        <div class="card">
          <div class="card-header"><h4 class="card-title">All Testimonials</h4></div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped table-hover align-middle">
                <thead>
                  <tr>
                    <th>Sr.no</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>About</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sr_no = $start + 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                      $statusText = $row['status'] == 1 ? 'Active' : 'Inactive';
                        $statusUrl = "list.php?id={$row['id']}&status={$row['status']}";
                        $statusClass = $row['status'] == 1 ? 'btn-success' : 'btn-warning';

                    echo "<tr>
                            <td>{$sr_no}</td>
                            <td><img src='../../uploads/{$row['image']}' width='80' height='60'></td>
                            <td>{$row['name']}</td>
                            <td>" . substr(strip_tags($row['desc']), 0, 50) . "...</td>
                            <td>
                            <a href='{$statusUrl}' class='btn btn-sm {$statusClass}' onclick=\"return confirm('Are you sure to change status?');\">{$statusText}</a>
                            </td>
                            <td>
                              <div class='d-flex gap-1'>
                                <a href='edit.php?id={$row['id']}' class='btn btn-primary btn-sm'>Edit</a>
                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#deleteModal' data-url='delete-testimonial.php?id={$row['id']}'>Delete</button>
                              </div>
                            </td>
                          </tr>";
                    $sr_no++;
                  }
                  if (mysqli_num_rows($result) == 0) {
                    echo "<tr><td colspan='6' class='text-center'>No testimonials found.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Unified Premium Pagination -->
            <div class="d-flex justify-content-center mt-4">
              <nav>
                <ul class="pagination pagination-primary mb-0">
                  <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a>
                  </li>
                  <?php for ($i = 1; $i <= $pages; $i++): ?>
                    <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                      <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                    </li>
                  <?php endfor; ?>
                  <li class="page-item <?= ($page >= $pages) ? 'disabled' : '' ?>">
                    <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-right"></i></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include '../components/viewFooter.php'; ?>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">Are you sure you want to delete this testimonial?</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger">Yes, Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#deleteModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var url = button.attr('data-url');
      $('#confirmDeleteBtn').attr('href', url);
    });
  });
</script>
</body>
</html>
