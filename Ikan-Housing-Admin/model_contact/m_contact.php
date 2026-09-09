<?php
include('../components/auth.php');
include('../../config.php');

// --- SEARCH LOGIC ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination settings
$limit = 50; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// --- Search SQL ---
$searchSql = "";
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($con, $search);
    $dateSearch = date('Y-m-d', strtotime($search));

    $searchSql = "
        WHERE property LIKE '%$search_safe%' 
        OR phone_no LIKE '%$search_safe%'
        OR DATE(created_at) = '$dateSearch'
    ";
}

// Data Metrics
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM modal_contact $searchSql");
$totalRecords = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($totalRecords / $limit);

// Optimized Fetch
$query = "SELECT * FROM modal_contact $searchSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
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
              <h2 class="mb-1 text-premium">Modal Inquiries</h2>
              <p class="text-muted mb-0">Monitor and manage leads generated through property information modals.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Portal Leads</li>
                </ol>
              </nav>
            </div>
            <div class="d-flex gap-2">
              <a href="export_m_contact" class="btn btn-primary btn-round px-4 shadow-sm">
                <i class="fas fa-file-export me-2"></i>Export Dataset
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
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                                   class="form-control border-start-0 ps-0" placeholder="Aap phone ya property name se search kar sakte hain...">
                            <button class="btn btn-primary px-4" type="submit">Identify Lead</button>
                        </div>
                    </div>
                    <?php if(!empty($search)): ?>
                    <div class="col-auto">
                        <a href="m_contact" class="btn btn-light-pink text-primary border-0"><i class="fas fa-sync-alt"></i></a>
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
                <h4 class="card-title fw-bold text-premium mb-0">Engagement Database</h4>
                <div class="badge bg-light-pink text-primary fw-bold px-3 py-2 rounded-pill">Found: <?= $totalRecords ?></div>
             </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-pink">
                  <tr>
                    <th class="ps-4">Ref. ID</th>
                    <th>Contact Snapshot</th>
                    <th>Associated Interest</th>
                    <th>Timeline</th>
                    <th class="text-end pe-4">Protocol</th>
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
                                <div class="icon-circle bg-light-pink text-primary me-3" style="width: 40px; height: 40px;"><i class="fas fa-phone-alt"></i></div>
                                <div>
                                   <div class="fw-bold text-premium mb-0 fs-14"><?= htmlspecialchars($row['phone_no']) ?></div>
                                   <a href="tel:<?= $row['phone_no'] ?>" class="text-muted small">Tap to Dial</a>
                                </div>
                             </div>
                          </td>
                          <td>
                             <div class="badge bg-light border text-premium fw-normal px-3" style="border-radius: 8px;">
                                <i class="fas fa-building me-1 opacity-50"></i> <?= htmlspecialchars($row['property']) ?>
                             </div>
                          </td>
                          <td>
                             <div class="text-muted small d-flex flex-column">
                                <span class="fw-bold text-dark"><?= date("d M, Y", strtotime($row['created_at'])) ?></span>
                                <span><?= date("h:i A", strtotime($row['created_at'])) ?></span>
                             </div>
                          </td>
                          <td class="text-end pe-4">
                             <a href="https://wa.me/91<?= $row['phone_no'] ?>" target="_blank" class="btn btn-sm btn-outline-success border-0 shadow-none px-3">
                                <i class="fab fa-whatsapp me-1"></i> Connect
                             </a>
                          </td>
                        </tr>
                        <?php
                        $sr_no++;
                      }
                  } else {
                    echo "<tr><td colspan='5' class='text-center py-5'><img src='../assets/img/kaiadmin/empty.svg' height='100' class='mb-3 d-block mx-auto grayscale opacity-25'><div class='text-muted fw-bold'>Abhi koi inquiry nahi aayi hai.</div></td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Enhanced Pagination -->
            <div class="card-footer bg-white border-top-light py-4">
                <nav>
                    <ul class="pagination pagination-premium justify-content-center mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <?php 
                        $max_pages = 5;
                        $start_p = max(1, $page - 2);
                        $end_p = min($totalPages, $start_p + $max_pages - 1);
                        if ($end_p - $start_p < $max_pages - 1) $start_p = max(1, $end_p - $max_pages + 1);

                        for ($i = $start_p; $i <= $end_p; $i++): ?>
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
