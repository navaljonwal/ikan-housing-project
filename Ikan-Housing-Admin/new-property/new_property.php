<?php
include('../components/auth.php');
include('../../config.php');

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = '';
$searchQuery = '';
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $searchQuery = "WHERE project_name LIKE '%$search%' OR location LIKE '%$search%'";
}

// Count total
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM new_property $searchQuery");
$total = mysqli_fetch_assoc($countResult)['total'];
$pages = ceil($total / $limit);

// Fetch records
$query = "SELECT * FROM new_property $searchQuery ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($con, $query);
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<style>
    .property-id-cell { font-size: 0.75rem; color: #999; font-weight: 700; width: 60px; }
    .property-name-cell { font-weight: 700; color: var(--primary-color); font-size: 1rem; margin-bottom: 2px; }
    .property-location-cell { font-size: 0.8rem; color: #777; display: flex; align-items: center; }
    .action-btn-group .btn { width: 35px; height: 35px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; border: 1px solid #eee; background: #fff; transition: all 0.3s; }
    .action-btn-group .btn:hover { background: var(--light-pink); transform: translateY(-2px); box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    .btn-status-toggle { border: none !important; box-shadow: none !important; }
</style>

<body>
<div class="wrapper">
  <?php include('../components/viewSidebar.php'); ?>

  <div class="main-panel">
    <div class="main-header">
      <?php include('../components/viewNavbar.php'); ?>
    </div>

    <div class="container text-main">
      <div class="page-inner">
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
          <div>
            <h3 class="fw-bold mb-1">Property Inventory</h3>
            <ul class="breadcrumbs p-0 bg-transparent mb-0">
              <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
              <li class="separator"><i class="fas fa-chevron-right"></i></li>
              <li class="nav-item">Management Console</li>
            </ul>
          </div>
          <div class="d-flex gap-2">
            <form method="GET" action="" class="input-group" style="width: 300px;">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control border-end-0" placeholder="Search project or city...">
                <button class="btn btn-white border border-start-0" type="submit"><i class="fas fa-search text-muted"></i></button>
            </form>
            <a href="addproperty" class="btn btn-primary btn-round shadow-sm px-4">
                <i class="fas fa-plus me-2"></i>New Listing
            </a>
          </div>
        </div>

        <div class="card card-round border-0 shadow-sm mt-4">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                  <tr class="text-muted small uppercase fw-bold">
                    <th class="ps-4">Listing</th>
                    <th>Basic Info</th>
                    <th>Availability</th>
                    <th>Progress</th>
                    <th class="text-end pe-4">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  while ($row = mysqli_fetch_assoc($result)) {
                    $statusText = $row['status'] == 1 ? 'Active' : 'Draft';
                    $statusClass = $row['status'] == 1 ? 'bg-success' : 'bg-warning';
                    
                    $completeText = $row['project_type'] == 1 ? 'Completed' : 'Ongoing';
                    $completeClass = $row['project_type'] == 1 ? 'bg-info' : 'bg-secondary';
                    
                    $img = !empty($row['main_image']) ? "../../uploads/".$row['main_image'] : "../assets/img/placeholder-house.webp";
                  ?>
                    <tr>
                      <td class="ps-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="property-id-cell">#<?= $row['id'] ?></span>
                            <img src="<?= $img ?>" class="property-thumb" alt="<?= $row['project_name'] ?>">
                        </div>
                      </td>
                      <td>
                        <div class="property-name-cell"><?= htmlspecialchars($row['project_name']) ?></div>
                        <div class="property-location-cell"><i class="fas fa-map-marker-alt me-1 opacity-50"></i> <?= htmlspecialchars($row['location']) ?></div>
                      </td>
                      <td>
                        <button class="badge badge-status-pill border-0 text-white <?= $statusClass ?> btn-status-toggle" 
                                data-bs-toggle="modal" data-bs-target="#statusModal" 
                                data-url="statusproperty.php?id=<?= $row['id'] ?>&status=<?= $row['status'] ?>">
                            <?= $statusText ?>
                        </button>
                      </td>
                      <td>
                        <button class="badge badge-status-pill border-0 text-white <?= $completeClass ?> btn-status-toggle" 
                                data-bs-toggle="modal" data-bs-target="#completionModal" 
                                data-url="complete-property.php?id=<?= $row['id'] ?>&complete=<?= $row['project_type'] ?>">
                            <?= $completeText ?>
                        </button>
                      </td>
                      <td class="text-end pe-4">
                        <div class="action-btn-group d-flex justify-content-end gap-2">
                          <a href="editproperty?id=<?= $row['id'] ?>" class="btn" title="Edit Property"><i class="fas fa-pencil-alt text-primary"></i></a>
                          <button class="btn" title="Delete listing" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="deleteproperty.php?id=<?= $row['id'] ?>"><i class="fas fa-trash-alt text-danger"></i></button>
                        </div>
                      </td>
                    </tr>
                  <?php } ?>
                  
                  <?php if (mysqli_num_rows($result) == 0): ?>
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="text-muted"><i class="fas fa-building fa-3x mb-3 opacity-25"></i></div>
                            <h5 class="fw-bold text-muted">No Properties Found</h5>
                            <p class="text-muted small">Try a different search or create a new listing.</p>
                        </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>

            <!-- Enhanced Pagination -->
            <?php if ($pages > 1): ?>
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
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
    <?php include '../components/viewFooter.php'; ?>
  </div>
</div>

<!-- Status Modal -->
<div class="modal fade" id="statusModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow card-round">
      <div class="modal-header bg-warning text-white">
        <h5 class="modal-title fw-bold">Toggle Visibility</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <i class="fas fa-eye fa-3x text-warning mb-3"></i>
        <p class="mb-0">Are you sure you want to change the public status of this property listing?</p>
      </div>
      <div class="modal-footer border-0 p-3 pt-0 justify-content-center">
        <button type="button" class="btn btn-light px-4 btn-round" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmStatusBtn" href="#" class="btn btn-warning px-4 btn-round text-white">Yes, Change Status</a>
      </div>
    </div>
  </div>
</div>

<!-- Completion Modal -->
<div class="modal fade" id="completionModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow card-round">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title fw-bold">Update Progress Status</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <i class="fas fa-tasks fa-3x text-info mb-3"></i>
        <p class="mb-0">Are you sure you want to toggle this project between <strong>Ongoing</strong> and <strong>Completed</strong>?</p>
      </div>
      <div class="modal-footer border-0 p-3 pt-0 justify-content-center">
        <button type="button" class="btn btn-light px-4 btn-round" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmCompletionBtn" href="#" class="btn btn-info px-4 btn-round text-white">Yes, Update Progress</a>
      </div>
    </div>
  </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow card-round">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">Permanent Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4 text-center">
        <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
        <p class="mb-0 text-muted">Warning: This action cannot be undone. All media and data associated with this property will be removed.</p>
      </div>
      <div class="modal-footer border-0 p-3 pt-0 justify-content-center">
        <button type="button" class="btn btn-light px-4 btn-round" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger px-4 btn-round shadow">Confirm Delete</a>
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

    $('#statusModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var url = button.attr('data-url');
      $('#confirmStatusBtn').attr('href', url);
    });

    $('#completionModal').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget);
      var url = button.attr('data-url');
      $('#confirmCompletionBtn').attr('href', url);
    });
  });
</script>
</body>
</html>
