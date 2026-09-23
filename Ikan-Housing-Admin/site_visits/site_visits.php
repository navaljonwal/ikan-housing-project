<?php
include('../components/auth.php');
include('../../config.php');

// --- SEARCH & FILTER LOGIC ---
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$status_filter = isset($_GET['status']) ? trim($_GET['status']) : '';
$date_filter = isset($_GET['date_range']) ? trim($_GET['date_range']) : '';

// Handle Status Change via GET (or AJAX fallback)
if (isset($_GET['action']) && $_GET['action'] === 'update_status' && isset($_GET['id']) && isset($_GET['new_status'])) {
    $visit_id = (int)$_GET['id'];
    $allowed_statuses = ['New', 'Confirmed', 'Completed', 'Cancelled'];
    $new_status = in_array($_GET['new_status'], $allowed_statuses) ? $_GET['new_status'] : 'New';
    
    $stmt = $con->prepare("UPDATE site_visits SET status = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("si", $new_status, $visit_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: site_visits" . (!empty($search) ? "?search=" . urlencode($search) : ""));
    exit();
}

// Handle Delete via GET
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $visit_id = (int)$_GET['id'];
    $stmt = $con->prepare("DELETE FROM site_visits WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $visit_id);
        $stmt->execute();
        $stmt->close();
    }
    header("Location: site_visits");
    exit();
}

// Build Filter SQL
$whereClauses = [];
if (!empty($search)) {
    $search_safe = mysqli_real_escape_string($con, $search);
    $whereClauses[] = "(name LIKE '%$search_safe%' OR phone LIKE '%$search_safe%' OR email LIKE '%$search_safe%' OR property_name LIKE '%$search_safe%')";
}
if (!empty($status_filter)) {
    $status_safe = mysqli_real_escape_string($con, $status_filter);
    $whereClauses[] = "status = '$status_safe'";
}
if ($date_filter === 'today') {
    $today = date('Y-m-d');
    $whereClauses[] = "visit_date = '$today'";
} elseif ($date_filter === 'upcoming') {
    $today = date('Y-m-d');
    $whereClauses[] = "visit_date >= '$today'";
} elseif ($date_filter === 'past') {
    $today = date('Y-m-d');
    $whereClauses[] = "visit_date < '$today'";
}

$whereSql = !empty($whereClauses) ? "WHERE " . implode(" AND ", $whereClauses) : "";

// Pagination
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Metrics
$totalVisitsRes = mysqli_query($con, "SELECT COUNT(*) as total FROM site_visits");
$totalVisits = mysqli_fetch_assoc($totalVisitsRes)['total'] ?? 0;

$todayVisitsRes = mysqli_query($con, "SELECT COUNT(*) as total FROM site_visits WHERE visit_date = CURDATE()");
$todayVisits = mysqli_fetch_assoc($todayVisitsRes)['total'] ?? 0;

$newVisitsRes = mysqli_query($con, "SELECT COUNT(*) as total FROM site_visits WHERE status = 'New'");
$newVisits = mysqli_fetch_assoc($newVisitsRes)['total'] ?? 0;

$confirmedVisitsRes = mysqli_query($con, "SELECT COUNT(*) as total FROM site_visits WHERE status = 'Confirmed'");
$confirmedVisits = mysqli_fetch_assoc($confirmedVisitsRes)['total'] ?? 0;

// Filtered Count
$countResult = mysqli_query($con, "SELECT COUNT(*) as total FROM site_visits $whereSql");
$totalRecords = mysqli_fetch_assoc($countResult)['total'] ?? 0;
$totalPages = ceil($totalRecords / $limit);

// Records Fetch
$query = "SELECT * FROM site_visits $whereSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
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
              <h2 class="mb-1 text-premium">Site Visit Bookings</h2>
              <p class="text-muted mb-0">Track and manage prospective buyer visits, schedule confirmations, and customer tours.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Site Visits</li>
                </ol>
              </nav>
            </div>
            <div class="d-flex gap-2">
              <a href="export_site_visits" class="btn btn-primary btn-round px-4 shadow-sm">
                <i class="fas fa-file-csv me-2"></i>Export Site Visits
              </a>
            </div>
          </div>
        </div>

        <!-- 📊 Metrics Bar -->
        <div class="row g-3 mb-4">
          <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-primary">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-md bg-light-pink text-primary rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="fas fa-calendar-alt fs-5"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-0 small">Total Bookings</h6>
                  <h4 class="fw-bold mb-0 text-dark"><?= $totalVisits ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-info">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-md bg-light-info text-info rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="fas fa-calendar-day fs-5"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-0 small">Today's Visits</h6>
                  <h4 class="fw-bold mb-0 text-dark"><?= $todayVisits ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-warning">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-md bg-light-warning text-warning rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="fas fa-clock fs-5"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-0 small">New / Pending</h6>
                  <h4 class="fw-bold mb-0 text-dark"><?= $newVisits ?></h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white border-start border-4 border-success">
              <div class="d-flex align-items-center">
                <div class="avatar avatar-md bg-light-success text-success rounded-circle me-3 d-flex align-items-center justify-content-center">
                  <i class="fas fa-check-circle fs-5"></i>
                </div>
                <div>
                  <h6 class="text-muted mb-0 small">Confirmed</h6>
                  <h4 class="fw-bold mb-0 text-dark"><?= $confirmedVisits ?></h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- 🕵️ Filter Console -->
        <div class="row mb-4">
          <div class="col-md-12">
            <div class="card card-round shadow-sm border-0 border-start-premium">
              <div class="card-body p-3">
                 <form method="GET" action="" class="row g-2 align-items-center">
                    <div class="col-12 col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" 
                                   class="form-control border-start-0 ps-0" placeholder="Search by name, phone, or project...">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Statuses</option>
                            <option value="New" <?= $status_filter === 'New' ? 'selected' : '' ?>>New</option>
                            <option value="Confirmed" <?= $status_filter === 'Confirmed' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="Completed" <?= $status_filter === 'Completed' ? 'selected' : '' ?>>Completed</option>
                            <option value="Cancelled" <?= $status_filter === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-2">
                        <select name="date_range" class="form-select">
                            <option value="">All Dates</option>
                            <option value="today" <?= $date_filter === 'today' ? 'selected' : '' ?>>Today</option>
                            <option value="upcoming" <?= $date_filter === 'upcoming' ? 'selected' : '' ?>>Upcoming</option>
                            <option value="past" <?= $date_filter === 'past' ? 'selected' : '' ?>>Past</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-primary px-3" type="submit"><i class="fas fa-filter me-1"></i>Filter</button>
                    </div>
                    <?php if(!empty($search) || !empty($status_filter) || !empty($date_filter)): ?>
                    <div class="col-auto">
                        <a href="site_visits" class="btn btn-light text-primary border-0" title="Reset Filters"><i class="fas fa-undo"></i></a>
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
                <h4 class="card-title fw-bold text-premium mb-0">Scheduled Visits</h4>
                <div class="badge bg-light-pink text-primary fw-bold px-3 py-2 rounded-pill">Total Matches: <?= $totalRecords ?></div>
             </div>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0">
                <thead class="bg-light-pink">
                  <tr>
                    <th class="ps-4">Seq</th>
                    <th>Customer Details</th>
                    <th>Target Property</th>
                    <th>Scheduled Slot</th>
                    <th>Status</th>
                    <th class="text-end pe-4">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sr_no = $offset + 1;
                  if ($result && mysqli_num_rows($result) > 0) {
                      while ($row = mysqli_fetch_assoc($result)) {
                        $visitDateFormatted = date('d M, Y', strtotime($row['visit_date']));
                        $isToday = (date('Y-m-d') === $row['visit_date']);
                        
                        $statusClass = 'bg-secondary';
                        if ($row['status'] === 'New') $statusClass = 'bg-warning text-dark';
                        elseif ($row['status'] === 'Confirmed') $statusClass = 'bg-success text-white';
                        elseif ($row['status'] === 'Completed') $statusClass = 'bg-primary text-white';
                        elseif ($row['status'] === 'Cancelled') $statusClass = 'bg-danger text-white';
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
                                   <div class="small fw-bold text-dark"><i class="fas fa-phone-alt me-1 text-primary opacity-50"></i><?= htmlspecialchars($row['phone']) ?></div>
                                   <?php if (!empty($row['email'])): ?>
                                     <div class="text-muted small"><i class="fas fa-envelope me-1 text-primary opacity-50"></i><?= htmlspecialchars($row['email']) ?></div>
                                   <?php endif; ?>
                                </div>
                             </div>
                          </td>
                          <td>
                             <div class="fw-bold text-dark"><?= htmlspecialchars($row['property_name']) ?></div>
                             <?php if (!empty($row['property_slug'])): ?>
                               <a href="../../property-detail-for?slug=<?= urlencode($row['property_slug']) ?>" target="_blank" class="small text-primary text-decoration-none">
                                 <i class="fas fa-external-link-alt me-1"></i>View Project
                               </a>
                             <?php endif; ?>
                          </td>
                          <td>
                             <div class="fw-bold <?= $isToday ? 'text-danger' : 'text-dark' ?>">
                               <i class="far fa-calendar-alt me-1"></i><?= $visitDateFormatted ?>
                               <?php if ($isToday): ?>
                                 <span class="badge bg-danger ms-1">TODAY</span>
                               <?php endif; ?>
                             </div>
                             <div class="small text-muted"><i class="far fa-clock me-1"></i><?= htmlspecialchars($row['time_slot']) ?></div>
                          </td>
                          <td>
                             <div class="dropdown">
                               <button class="btn btn-sm <?= $statusClass ?> dropdown-toggle rounded-pill px-3 fw-bold" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                 <?= htmlspecialchars($row['status']) ?>
                               </button>
                               <ul class="dropdown-menu shadow border-0" style="border-radius: 12px;">
                                 <li><a class="dropdown-item py-2" href="site_visits?action=update_status&id=<?= $row['id'] ?>&new_status=New"><span class="badge bg-warning text-dark me-2">New</span> Mark as New</a></li>
                                 <li><a class="dropdown-item py-2" href="site_visits?action=update_status&id=<?= $row['id'] ?>&new_status=Confirmed"><span class="badge bg-success me-2">Confirmed</span> Mark Confirmed</a></li>
                                 <li><a class="dropdown-item py-2" href="site_visits?action=update_status&id=<?= $row['id'] ?>&new_status=Completed"><span class="badge bg-primary me-2">Completed</span> Mark Completed</a></li>
                                 <li><a class="dropdown-item py-2" href="site_visits?action=update_status&id=<?= $row['id'] ?>&new_status=Cancelled"><span class="badge bg-danger me-2">Cancelled</span> Mark Cancelled</a></li>
                                </ul>
                             </div>
                          </td>
                          <td class="text-end pe-4">
                             <div class="d-flex justify-content-end gap-1">
                                <a href="tel:<?= $row['phone'] ?>" class="btn btn-icon btn-round btn-light shadow-none" title="Call Customer">
                                   <i class="fas fa-phone text-primary"></i>
                                </a>
                                <a href="https://wa.me/91<?= $row['phone'] ?>?text=<?= urlencode("Hello " . $row['name'] . ", this is Ikan Housing regarding your scheduled site visit for " . $row['property_name'] . ".") ?>" target="_blank" class="btn btn-icon btn-round btn-light shadow-none" title="WhatsApp Message">
                                   <i class="fab fa-whatsapp text-success"></i>
                                </a>
                                <?php if (!empty($row['email'])): ?>
                                <a href="mailto:<?= $row['email'] ?>" class="btn btn-icon btn-round btn-light shadow-none" title="Send Email">
                                   <i class="fas fa-paper-plane text-info"></i>
                                </a>
                                <?php endif; ?>
                                <a href="site_visits?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Kya aap is site visit record ko delete karna chahte hain?');" class="btn btn-icon btn-round btn-light shadow-none" title="Delete Record">
                                   <i class="fas fa-trash-alt text-danger"></i>
                                </a>
                             </div>
                          </td>
                        </tr>
                        <?php
                        $sr_no++;
                      }
                  } else {
                    echo "<tr><td colspan='6' class='text-center py-5'><div class='text-muted fs-5 fw-semibold'>Abhi koi site visit booking nahi mili.</div><p class='text-muted small'>Website par visitor dwara schedule ki gayi visit yahan display hogi.</p></td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>

            <!-- Enhanced Pagination -->
            <?php if ($totalPages > 1): ?>
            <div class="card-footer bg-white border-top-light py-4 text-center">
                <nav>
                    <ul class="pagination pagination-premium justify-content-center mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status_filter) ?>&date_range=<?= urlencode($date_filter) ?>"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <?php 
                        $show_nav = 5;
                        $s_page = max(1, $page - 2);
                        $e_page = min($totalPages, $s_page + $show_nav - 1);
                        if ($e_page - $s_page < $show_nav - 1) $s_page = max(1, $e_page - $show_nav + 1);

                        for ($i = $s_page; $i <= $e_page; $i++): ?>
                            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                                <a class="page-link shadow-none" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status_filter) ?>&date_range=<?= urlencode($date_filter) ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                            <a class="page-link shadow-none" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>&status=<?= urlencode($status_filter) ?>&date_range=<?= urlencode($date_filter) ?>"><i class="fas fa-chevron-right"></i></a>
                        </li>
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
