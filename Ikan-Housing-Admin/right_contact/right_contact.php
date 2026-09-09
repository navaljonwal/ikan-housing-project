<?php
include('../components/auth.php');
include('../../config.php');

// --- SEARCH LOGIC ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination variables
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Secure SQL
$searchSql = "";
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($con, $search);
    $searchSql = "WHERE name LIKE '%$search_safe%' OR phone LIKE '%$search_safe%' OR email LIKE '%$search_safe%'";
}

// Data Metrics
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM right_contact $searchSql");
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);

// Optimized Fetch
$query = "SELECT * FROM right_contact $searchSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
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
              <h2 class="mb-1 text-premium">Direct Enquiries</h2>
              <p class="text-muted mb-0">Manage leads captured through the persistent sidebar contact interface.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Direct Leads</li>
                </ol>
              </nav>
            </div>
            <div class="d-flex gap-2">
              <a href="export_right_contact" class="btn btn-primary btn-round px-4 shadow-sm">
                <i class="fas fa-file-csv me-2"></i>Export Sidebar Data
              </a>
            </div>
          </div>
        </div>

        <!-- 🕵️ Filter Console -->
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card card-round shadow-sm border-0 border-start-premium">
              <div class="card-body p-4">
                 <form method="GET" action="" class="row g-3 align-items-center">
                    <div class="col-auto flex-grow-1">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-filter"></i></span>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                                   class="form-control border-start-0 ps-0" placeholder="Contact name, email, or mobile identification...">
                            <button class="btn btn-primary px-4" type="submit">Filter Leads</button>
                        </div>
                    </div>
                    <?php if(!empty($search)): ?>
                    <div class="col-auto">
                        <a href="right_contact" class="btn btn-light-pink text-primary border-0"><i class="fas fa-undo"></i></a>
                    </div>
                    <?php endif; ?>
                 </form>
              </div>
            </div>
          </div>
        </div>

        <div class="card card-premium shadow-sm border-0">
          <div class="card-header bg-white py-3 border-bottom-light">
             <div class="d-flex justify-content-between align-items-center">
                <h4 class="card-title fw-bold text-premium mb-0">Sidebar Conversion Database</h4>
                <div class="badge bg-light-pink text-primary fw-bold px-3 py-2 rounded-pill">Total: <?= $totalRecords ?></div>
             </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-pink">
                  <tr>
                    <th class="ps-4">Sequence</th>
                    <th>Identity Summary</th>
                    <th>Communication Channel</th>
                    <th class="text-end pe-4">Lead Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sr_no = $offset + 1;
                  if (mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                        <tr>
                          <td class="ps-4"><span class="text-muted small fw-bold">#<?= str_pad($sr_no, 4, '0', STR_PAD_LEFT) ?></span></td>
                          <td>
                             <div class="d-flex align-items-center">
                                <div class="avatar avatar-sm me-3">
                                   <span class="avatar-title rounded-circle bg-light-pink text-primary fw-bold"><?= strtoupper(substr($row['name'], 0, 1)) ?></span>
                                </div>
                                <div>
                                   <div class="fw-bold text-premium mb-0 fs-14"><?= htmlspecialchars($row['name']) ?></div>
                                   <div class="text-muted small">Verified User</div>
                                </div>
                             </div>
                          </td>
                          <td>
                             <div class="d-flex flex-column gap-1">
                                <div class="small"><i class="fas fa-envelope me-2 text-primary opacity-50"></i><?= htmlspecialchars($row['email']) ?></div>
                                <div class="small fw-bold"><i class="fas fa-phone-alt me-2 text-primary opacity-50"></i><?= htmlspecialchars($row['phone']) ?></div>
                             </div>
                          </td>
                          <td class="text-end pe-4">
                             <div class="d-flex justify-content-end gap-2">
                                <a href="mailto:<?= $row['email'] ?>" class="btn btn-icon btn-round btn-light shadow-none" title="Send Email">
                                   <i class="fas fa-paper-plane text-primary"></i>
                                </a>
                                <a href="https://wa.me/91<?= $row['phone'] ?>" target="_blank" class="btn btn-icon btn-round btn-light shadow-none" title="WhatsApp">
                                   <i class="fab fa-whatsapp text-success"></i>
                                </a>
                             </div>
                          </td>
                        </tr>
                        <?php
                        $sr_no++;
                      }
                  } else {
                    echo "<tr><td colspan='4' class='text-center py-5'><img src='../assets/img/kaiadmin/empty.svg' height='100' class='mb-3 d-block mx-auto opacity-25'><div class='text-muted'>Koi records nahi mile. Search term badal kar dekhein.</div></td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Enhanced Pagination -->
            <div class="card-footer bg-white border-top-light py-4 text-center">
                <nav>
                    <ul class="pagination pagination-premium justify-content-center mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <?php 
                        $show_nav = 5;
                        $s_page = max(1, $page - 2);
                        $e_page = min($totalPages, $s_page + $show_nav - 1);
                        if ($e_page - $s_page < $show_nav - 1) $s_page = max(1, $e_page - $show_nav + 1);

                        for ($i = $s_page; $i <= $e_page; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link shadow-none" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-right"></i></a>
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

<script>
  AOS.init({ duration: 800, once: true });
</script>
</body>
</html>
