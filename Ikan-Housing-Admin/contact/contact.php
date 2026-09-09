<?php
include('../components/auth.php');
include('../../config.php');

// --- ANALYTICS ---
$totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM contact");
$totalResult = mysqli_fetch_assoc($totalQuery);
$totalCount = $totalResult['total'] ?? 0;

$todayQuery = mysqli_query($con, "SELECT COUNT(*) as today FROM contact WHERE DATE(created_at) = CURDATE()");
$todayResult = mysqli_fetch_assoc($todayQuery);
$todayCount = $todayResult['today'] ?? 0;

$popQuery = mysqli_query($con, "SELECT business_service_name, COUNT(*) as svc_count FROM contact GROUP BY business_service_name ORDER BY svc_count DESC LIMIT 1");
$popSvcRes = mysqli_fetch_assoc($popQuery);
$popularService = $popSvcRes['business_service_name'] ?? 'General';

// --- SEARCH LOGIC ---
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Pagination variables
$limit = 10; // Records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

// Secure SQL with LIKE and prepared query
$searchSql = "";
if (!empty($search)) {
    $search = mysqli_real_escape_string($con, $search);
    $searchSql = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%' OR message LIKE '%$search%'";
}

// Total count for pagination
$countQuery = "SELECT COUNT(*) as total FROM contact $searchSql";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRecords = $countRow['total'] ?? 0;
$totalPages = ($totalRecords > 0) ? ceil($totalRecords / $limit) : 1;

// Fetch paginated data
$query = "SELECT * FROM contact $searchSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);

// Helper for initials
function getInitials($str) {
    $words = explode(" ", $str);
    $initials = "";
    $count = 0;
    foreach ($words as $w) {
        if ($count < 2) {
            $initials .= strtoupper(substr($w, 0, 1));
            $count++;
        }
    }
    return $initials ? $initials : "C";
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<style>
    /* 💎 Premium Table Enhancements */
    .table-premium { border-collapse: separate; border-spacing: 0 10px; width: 100%; }
    .table-premium thead th { border: none !important; color: #8e6f7e; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 700; padding: 15px 20px; }
    .table-premium tbody tr { background: #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.02); transition: all 0.3s ease; }
    .table-premium tbody tr:hover { transform: translateY(-3px); box-shadow: 0 10px 30px rgba(192, 42, 124, 0.08); background: #fffcfd; }
    .table-premium td { padding: 18px 20px; border: none !important; font-size: 0.9rem; vertical-align: middle; }
    .table-premium td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .table-premium td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    /* 🎨 Avatar Style */
    .avatar-circle { width: 38px; height: 38px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px; margin-right: 12px; }

    /* 🏷️ Status Badges */
    .badge-premium { border-radius: 6px; padding: 6px 12px; font-weight: 700; font-size: 10px; letter-spacing: 0.5px; text-transform: uppercase; }

    /* 📊 Analytics Cards */
    .stat-card { border-radius: 20px; border: none; overflow: hidden; position: relative; background: #fff; transition: all 0.4s ease; box-shadow: 0 10px 40px rgba(0,0,0,0.03); height: 100%; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 50px rgba(192, 42, 124, 0.08); }
    .stat-card .card-body { padding: 25px; position: relative; z-index: 2; }
    .stat-icon { width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px; margin-bottom: 20px; }
    
    .bg-light-primary { background-color: #fff0f6; }
    .bg-light-success { background-color: #f0fff4; }
    .bg-light-warning { background-color: #fffcf0; }
</style>
<body>
<div class="wrapper">
  <!-- Sidebar -->
  <?php include('../components/viewSidebar.php'); ?>
  
  <div class="main-panel">
    <div class="main-header">
      <?php include('../components/viewNavbar.php'); ?>
    </div>

    <div class="container text-main">
      <div class="page-inner">
        <!-- 🚀 Hero Dashboard View -->
        <div class="page-header d-flex justify-content-between align-items-center mb-4">
          <div data-aos="fade-right">
            <h3 class="fw-bold mb-2">Inquiry Insights</h3>
            <ul class="breadcrumbs p-0 bg-transparent">
              <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
              <li class="separator"><i class="fas fa-chevron-right"></i></li>
              <li class="nav-item">Contact Leads</li>
            </ul>
          </div>
          <div data-aos="fade-left">
            <a href="export-contact" class="btn btn-primary btn-round shadow btn-lg">
                <i class="fas fa-file-excel me-2"></i>Export All Data
            </a>
          </div>
        </div>

        <!-- 📊 Real-time Stats Cards -->
        <div class="row mb-5 g-4">
            <div class="col-md-4" data-aos="fade-down" data-aos-delay="0">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="stat-icon bg-light-primary text-primary"><i class="fas fa-users-viewfinder"></i></div>
                        <h6 class="text-muted fw-bold mb-1 small uppercase">TOTAL PIPELINE</h6>
                        <h2 class="fw-extrabold mb-0"><?= $totalCount ?> Enquiries</h2>
                        <div class="progress progress-sm mt-3" style="height: 4px;"><div class="progress-bar bg-primary" style="width: 100%"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-down" data-aos-delay="100">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="stat-icon bg-light-success text-success"><i class="fas fa-bell"></i></div>
                        <h6 class="text-muted fw-bold mb-1 small uppercase">FRESH LEADS (TODAY)</h6>
                        <h2 class="fw-extrabold mb-0">+<?= $todayCount ?> New</h2>
                        <div class="progress progress-sm mt-3" style="height: 4px;"><div class="progress-bar bg-success" style="width: <?= min(($todayCount/10)*100, 100) ?>%"></div></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-down" data-aos-delay="200">
                <div class="stat-card card">
                    <div class="card-body">
                        <div class="stat-icon bg-light-warning text-warning"><i class="fas fa-star"></i></div>
                        <h6 class="text-muted fw-bold mb-1 small uppercase">MOST DEMANDED SVC</h6>
                        <h2 class="fw-extrabold mb-0"><?= htmlspecialchars($popularService) ?></h2>
                        <div class="progress progress-sm mt-3" style="height: 4px;"><div class="progress-bar bg-warning" style="width: 75%"></div></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 💎 Inquiry Management Table -->
        <div class="row">
          <div class="col-md-12">
            <div class="card border-0 shadow-sm card-round overflow-hidden" data-aos="fade-up">
              <div class="card-header bg-white p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <h4 class="fw-bold mb-0">Management Center</h4>
                    <form method="GET" action="" class="input-group" style="max-width: 320px;">
                        <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control border-end-0 bg-light" placeholder="Search entries...">
                        <button class="btn btn-light border-start-0" type="submit"><i class="fas fa-search text-muted"></i></button>
                    </form>
                </div>
              </div>
              <div class="card-body bg-light-pink p-0">
                <div class="table-responsive p-4">
                  <table class="table table-premium mb-0">
                    <thead>
                      <tr>
                        <th>Sr.</th>
                        <th>Sender Details</th>
                        <th>Contact Points</th>
                        <th>Requested Service</th>
                        <th>Lead Message</th>          
                        <th>Timestamp</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sr_no = $offset + 1;
                      if (mysqli_num_rows($result) > 0) {
                          $colors = ['#c02a7c', '#2d0a1c', '#007bff', '#28a745', '#ffc107', '#6f42c1'];
                          while ($row = mysqli_fetch_assoc($result)) {
                              $initials = getInitials($row['name']);
                              $bgColor = $colors[array_rand($colors)] . '15';
                              $textColor = str_replace('15', '', $bgColor);
                              
                              // Badge logic
                              $svc = $row['business_service_name'] ?? 'General';
                              $badgeClass = "bg-primary text-white";
                              if(stripos($svc, 'Commercial') !== false || stripos($svc, 'Leasing') !== false) $badgeClass = "bg-dark text-white";
                              if(stripos($svc, 'Investment') !== false) $badgeClass = "bg-warning text-dark";
                              if(stripos($svc, 'Marketing') !== false) $badgeClass = "bg-info text-white";

                              echo "<tr>";
                              echo "<td><span class='text-muted small'>#" . str_pad($sr_no++, 3, "0", STR_PAD_LEFT) . "</span></td>";
                              echo "<td>
                                        <div class='d-flex align-items-center'>
                                            <div class='avatar-circle' style='background:$bgColor; color:$textColor'>$initials</div>
                                            <div class='fw-bold text-dark'>" . htmlspecialchars($row['name']) . "</div>
                                        </div>
                                    </td>";
                              echo "<td>
                                        <div class='small fw-bold text-dark'>" . htmlspecialchars($row['phone']) . "</div>
                                        <div class='text-muted tiny' style='font-size:11px'>" . htmlspecialchars($row['email']) . "</div>
                                    </td>";
                              echo "<td><span class='badge-premium badge $badgeClass'>" . htmlspecialchars($svc) . "</span></td>";
                              echo "<td style='max-width: 200px;'><div class='text-truncate text-muted small' title='".htmlspecialchars($row['message'])."'>" . htmlspecialchars($row['message']) . "</div></td>";
                              echo "<td><span class='text-muted tiny'>" . (isset($row['created_at']) ? date('M d, Y', strtotime($row['created_at'])) : 'N/A') . "</span></td>";
                              echo "</tr>";
                          }
                      } else {
                          echo "<tr><td colspan='6' class='text-center py-5'>
                                    <div class='text-muted py-4'><i class='fas fa-inbox fa-3x mb-3 opacity-25'></i><br>No matching inquiries found in the pipeline.</div>
                                </td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>

                  <!-- Modern Premium Pagination -->
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 gap-3">
                    <div class="text-muted small">Showing <b><?= $offset+1 ?></b> to <b><?= min($offset+$limit, $totalRecords) ?></b> of <?= $totalRecords ?> total entries</div>
                    <nav>
                      <ul class="pagination pagination-rounded pagination-primary mb-0">
                        <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-left"></i></a>
                        </li>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                          </li>
                        <?php endfor; ?>
                        <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                          <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><i class="fas fa-chevron-right"></i></a>
                        </li>
                      </ul>
                    </nav>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php include '../components/viewFooter.php'; ?>
  </div>
</div>

<script>
    // Initialize AOS
    document.addEventListener("DOMContentLoaded", function() {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    });
</script>
</body>
</html>
