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
    $searchQuery = "WHERE sub_category.name LIKE '%$search%'";
}

// Count total
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM sub_category $searchQuery");
$total = mysqli_fetch_assoc($countResult)['total'];
$pages = ceil($total / $limit);

// Fetch records with Join
$query = "SELECT sub_category.*, category.category_name AS category_name 
          FROM sub_category 
          JOIN category ON sub_category.cat_id = category.id 
          $searchQuery 
          ORDER BY sub_category.id DESC 
          LIMIT $start, $limit";

$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<body class="bg-page">
<div class="wrapper">
  <?php include('../components/viewSidebar.php'); ?>
  <div class="main-panel">
    <div class="main-header"><?php include('../components/viewNavbar.php'); ?></div>
    
    <div class="container container-content">
      <div class="page-inner">
        <!-- 💎 Premium Hero Header -->
        <div class="admin-hero mb-4" data-aos="fade-down">
          <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
              <h2 class="mb-1 text-premium">Sub-Category Inventory</h2>
              <p class="text-muted mb-0">Manage detailed sub-classifications for your property listings.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Sub-Categories</li>
                </ol>
              </nav>
            </div>
            <div class="d-flex gap-2">
              <a href="add-subcat" class="btn btn-primary btn-round px-4 shadow-sm">
                <i class="fas fa-plus me-2"></i>New Sub-Category
              </a>
            </div>
          </div>
        </div>

        <!-- 📊 Search Bar -->
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card card-round shadow-sm border-0">
              <div class="card-body p-4">
                 <form method="GET" action="" class="row g-3 align-items-center">
                    <div class="col-auto">
                        <div class="input-group" style="min-width: 350px;">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-filter"></i></span>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                                   class="form-control border-start-0 ps-0" placeholder="Find sub-category by name...">
                            <button class="btn btn-primary px-4" type="submit">Search</button>
                        </div>
                    </div>
                 </form>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-premium shadow-sm border-0">
          <div class="card-header bg-white py-3 border-bottom-light">
             <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title fw-bold text-premium mb-0">Detailed Classifications</h4>
                <span class="badge bg-light-pink text-primary fw-bold">Records: <?= $total ?></span>
             </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-pink">
                  <tr>
                    <th class="ps-4">Sr.No</th>
                    <th>Parent Category</th>
                    <th>Sub-Category Identity</th>
                    <th class="text-center">Active Status</th>
                    <th class="text-end pe-4">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sr_no = $start + 1;
                  while ($row = mysqli_fetch_assoc($result)) {
                    $statusText = $row['status'] == 1 ? 'Active' : 'Inactive';
                    $statusClass = $row['status'] == 1 ? 'badge-active' : 'badge-draft';
                    $newStatus = $row['status'] == 1 ? 0 : 1;
                    ?>
                    <tr>
                      <td class="ps-4"><span class="text-muted fw-bold">#<?= str_pad($sr_no, 2, '0', STR_PAD_LEFT) ?></span></td>
                      <td>
                        <span class="badge bg-light-pink text-primary px-3 py-2 fw-bold" style="border-radius: 8px;">
                           <?= htmlspecialchars($row['category_name']) ?>
                        </span>
                      </td>
                      <td>
                        <div class="fw-bold text-premium fs-15"><?= htmlspecialchars($row['name']) ?></div>
                        <small class="text-muted">Ref: SC-<?= $row['id'] ?></small>
                      </td>
                      <td class="text-center">
                        <button class="btn btn-link p-0 border-0 shadow-none" data-bs-toggle="modal" data-bs-target="#statusModal" data-url="status-subcat.php?id=<?= $row['id'] ?>&status=<?= $newStatus ?>">
                           <span class="status-label-badge <?= $statusClass ?>"><?= $statusText ?></span>
                        </button>
                      </td>
                      <td class="text-end pe-4">
                        <div class="d-flex justify-content-end gap-2">
                          <a href="edit-subcat?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary px-3">
                            <i class="fas fa-edit me-1"></i> Edit
                          </a>
                          <button class="btn btn-sm btn-outline-danger px-3 shadow-none" data-bs-toggle="modal" data-bs-target="#deleteModal" data-url="delete-subcat.php?id=<?= $row['id'] ?>">
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </div>
                      </td>
                    </tr>
                    <?php
                    $sr_no++;
                  }
                  if (mysqli_num_rows($result) == 0) {
                    echo "<tr><td colspan='5' class='text-center py-5'><img src='../assets/img/kaiadmin/empty.svg' height='80' class='mb-3 d-block mx-auto opacity-50'><span class='text-muted'>No entries found in this classification.</span></td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Modern Pagination -->
            <div class="card-footer bg-white border-top-light py-4">
                <nav>
                    <ul class="pagination pagination-premium justify-content-center mb-0">
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

<!-- Modals -->
<div class="modal fade" id="statusModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
      <div class="modal-header border-bottom-0 pt-4 px-4">
        <div class="icon-circle bg-light-pink text-primary mb-0 me-3"><i class="fas fa-sync-alt"></i></div>
        <h5 class="modal-title fw-bold">Update Visibility?</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3 text-muted">Aap is sub-category ka status toggle karne ja rahe hain.</div>
      <div class="modal-footer border-top-0 pb-4 px-4">
        <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Cancel</button>
        <a id="confirmStatusBtn" href="#" class="btn btn-primary px-4 shadow-sm">Confirm Status</a>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
      <div class="modal-header border-bottom-0 pt-4 px-4">
        <div class="icon-circle bg-light-danger text-danger mb-0 me-3"><i class="fas fa-trash-alt"></i></div>
        <h5 class="modal-title fw-bold">Confirm Deletion</h5>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3 text-muted">Yeh category hamesha ke liye delete ho jayegi. Kya aap sure hain?</div>
      <div class="modal-footer border-top-0 pb-4 px-4">
        <button type="button" class="btn btn-light px-4 border" data-bs-dismiss="modal">Abhi Nahi</button>
        <a id="confirmDeleteBtn" href="#" class="btn btn-danger px-4 shadow-sm">Yes, Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
  AOS.init({ duration: 800, once: true });
  
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
  });
</script>
</body>
</html>
