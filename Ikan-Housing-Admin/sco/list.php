<?php
include('../components/auth.php');
include('../../config.php');

// ✅ Handle status toggle
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = (int) $_GET['id'];
    $status = $_GET['status'] == 1 ? 0 : 1;
    mysqli_query($con, "UPDATE seo_pages SET status = $status WHERE id = $id");
    header("Location: list");
    exit;
}

// Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = "";
$where = "";
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($con, $_GET['search']);
    $where = "WHERE page_name LIKE '%$search%' 
              OR meta_title LIKE '%$search%' 
              OR meta_description LIKE '%$search%'";
}

// Total records
$total_result = mysqli_query($con, "SELECT COUNT(*) as total FROM seo_pages $where");
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch SEO pages
$query = "SELECT * FROM seo_pages $where ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<style>
    .page-name-badge { background: #f8f9fa; border: 1px solid #dee2e6; padding: 4px 10px; border-radius: 6px; font-weight: 700; color: #6c757d; font-size: 0.8rem; }
    .meta-preview-text { font-size: 0.85rem; color: #4d5156; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .status-toggle { cursor: pointer; transition: all 0.3s ease; }
    .status-toggle:hover { transform: scale(1.05); }
</style>

<body>

<div class="wrapper">
  <?php include('../components/viewSidebar.php'); ?>

  <div class="main-panel">
    <div class="main-header">
      <?php include('../components/viewNavbar.php'); ?>
    </div>

    <div class="container">
      <div class="page-inner">

        <div class="page-header d-flex justify-content-between align-items-center">
          <div>
            <h3 class="fw-bold mb-1">SEO Inventory</h3>
            <ul class="breadcrumbs mb-0 bg-transparent p-0">
                <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
                <li class="separator"><i class="fas fa-chevron-right"></i></li>
                <li class="nav-item">Optimization Manager</li>
            </ul>
          </div>
          <a href="add" class="btn btn-primary btn-round shadow-sm px-4">
            <i class="fas fa-plus-circle me-2"></i>New SEO Page
          </a>
        </div>

        <!-- Search & Filter Bar -->
        <div class="row mt-4 mb-4">
            <div class="col-md-12">
                <div class="card card-round border-0 shadow-sm">
                    <div class="card-body py-3">
                        <form method="GET" class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                    <input type="text" name="search" class="form-control border-start-0" 
                                           placeholder="Search by page or meta content..." value="<?= htmlspecialchars($search) ?>">
                                </div>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-secondary px-4">Filter Results</button>
                                <?php if($search): ?>
                                    <a href="list" class="btn btn-link text-muted">Clear</a>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="card card-round border-0 shadow-sm">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover mb-0 align-middle">
                <thead class="bg-light">
                  <tr>
                    <th class="ps-4 py-3" style="width: 80px;">ID</th>
                    <th class="py-3">Target Page</th>
                    <th class="py-3" style="width: 40%;">Optimization Snippet</th>
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-end pe-4">Actions</th>
                  </tr>
                </thead>

                <tbody>
                <?php
                $sr = $start + 1;
                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {

                    $statusText  = $row['status'] == 1 ? 'Live' : 'Draft';
                    $statusClass = $row['status'] == 1 ? 'btn-success' : 'btn-warning';
                    $statusUrl   = "list.php?id={$row['id']}&status={$row['status']}";

                    echo "<tr>";
                    echo "<td class='ps-4'><span class='text-muted'>#{$row['id']}</span></td>";
                    echo "<td><span class='page-name-badge'>" . htmlspecialchars($row['page_name']) . "</span></td>";
                    echo "<td>
                            <div class='fw-bold text-primary mb-1' style='font-size: 0.9rem;'>" . htmlspecialchars(substr($row['meta_title'], 0, 70)) . "</div>
                            <div class='meta-preview-text'>" . htmlspecialchars(strip_tags($row['meta_description'])) . "</div>
                          </td>";
                    echo "<td class='text-center'>
                            <a href='{$statusUrl}' 
                               class='btn btn-round btn-sm {$statusClass} px-3 status-toggle'
                               onclick=\"return confirm('Change visibility status?');\">
                               " . ($row['status'] == 1 ? '<i class="fas fa-check-circle me-1"></i>' : '<i class="fas fa-pause-circle me-1"></i>') . " {$statusText}
                            </a>
                          </td>";
                    echo "<td class='text-end pe-4'>
                            <div class='d-flex justify-content-end gap-2'>
                              <a href='edit.php?id={$row['id']}' 
                                 class='btn btn-icon btn-round btn-light border shadow-xs' title='Edit SEO'>
                                 <i class='fa fa-edit text-primary'></i>
                              </a>
                              <a href='delete.php?id={$row['id']}'
                                 class='btn btn-icon btn-round btn-light border shadow-xs'
                                 onclick=\"return confirm('Delete this SEO configuration?');\" title='Delete SEO'>
                                 <i class='fa fa-trash text-danger'></i>
                              </a>
                            </div>
                          </td>";
                    echo "</tr>";
                    $sr++;
                  }
                } else {
                  echo "<tr><td colspan='5' class='text-center py-5'>
                            <div class='text-muted mb-2'><i class='fas fa-search-minus fa-3x'></i></div>
                            <div class='fw-bold'>No SEO records found</div>
                            <small class='text-muted'>Try adjusting your search criteria</small>
                        </td></tr>";
                }
                ?>
                </tbody>
              </table>
            </div>

            <!-- Pagination Container -->
            <?php if($total_pages > 1): ?>
                <div class="card-footer bg-white border-top-0 py-4">
                    <nav>
                      <ul class="pagination pagination-primary justify-content-center mb-0">
                        <?php if($page > 1): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a></li>
                        <?php endif; ?>
                        
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                          </li>
                        <?php endfor; ?>
                        
                        <?php if($page < $total_pages): ?>
                            <li class="page-item"><a class="page-link" href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-right"></i></a></li>
                        <?php endif; ?>
                      </ul>
                    </nav>
                </div>
            <?php endif; ?>

          </div>
        </div>

      </div>
    </div>

    <?php include('../components/viewFooter.php'); ?>
  </div>
</div>

</body>
</html>
