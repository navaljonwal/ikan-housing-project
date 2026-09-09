<?php
include('../components/auth.php');
include('../../config.php');

// --- ANALYTICS ---
$totalQuery = mysqli_query($con, "SELECT COUNT(*) as total FROM chatbot_leads");
$totalResult = mysqli_fetch_assoc($totalQuery);
$totalCount = $totalResult['total'] ?? 0;

$todayQuery = mysqli_query($con, "SELECT COUNT(*) as today FROM chatbot_leads WHERE DATE(created_at) = CURDATE()");
$todayResult = mysqli_fetch_assoc($todayQuery);
$todayCount = $todayResult['today'] ?? 0;

// --- SEARCH LOGIC ---
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $limit;

$searchSql = '';
if (!empty($search)) {
    $search = mysqli_real_escape_string($con, $search);
    $searchSql = "WHERE name LIKE '%$search%' OR phone LIKE '%$search%' OR service_interest LIKE '%$search%'";
}

// Total count
$countQuery = "SELECT COUNT(*) as total FROM chatbot_leads $searchSql";
$countResult = mysqli_query($con, $countQuery);
$countRow = mysqli_fetch_assoc($countResult);
$totalRecords = $countRow['total'] ?? 0;
$totalPages = ($totalRecords > 0) ? ceil($totalRecords / $limit) : 1;

// Fetch data
$query = "SELECT * FROM chatbot_leads $searchSql ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);

// Helper for initials
function getInitials($str) {
    return strtoupper(substr($str, 0, 1));
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
    .table-premium td { padding: 18px 20px; border: none !important; font-size: 0.95rem; vertical-align: middle; }
    .table-premium td:first-child { border-top-left-radius: 12px; border-bottom-left-radius: 12px; }
    .table-premium td:last-child { border-top-right-radius: 12px; border-bottom-right-radius: 12px; }

    /* 🎨 Avatar Style */
    .avatar-circle { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 15px; margin-right: 15px; }

    /* 📊 Analytics Cards */
    .stat-card { border-radius: 20px; border: none; overflow: hidden; position: relative; background: #fff; transition: all 0.4s ease; box-shadow: 0 10px 40px rgba(0,0,0,0.03); height: 100%; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 15px 50px rgba(192, 42, 124, 0.08); }
    .stat-card .card-body { padding: 30px; position: relative; z-index: 2; }
    .stat-icon { width: 50px; height: 50px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; margin-bottom: 20px; }

    .bg-light-primary { background-color: #fff0f6; }
    .bg-light-warning { background-color: #fffcf0; }
    
    .source-badge { font-size: 10px; font-weight: 700; text-transform: uppercase; padding: 5px 10px; border-radius: 6px; background: #f1f5f9; color: #475569; }
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
          <!-- 🚀 Dashboard Header -->
          <div class="page-header d-flex justify-content-between align-items-center mb-4">
            <div data-aos="fade-right">
              <h3 class="fw-bold mb-2">Chatbot Hub</h3>
              <ul class="breadcrumbs p-0 bg-transparent">
                <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
                <li class="separator"><i class="fas fa-chevron-right"></i></li>
                <li class="nav-item">Converse & Convert</li>
              </ul>
            </div>
          </div>

          <!-- 📊 Real-time Stats Cards -->
          <div class="row mb-5 g-4">
              <div class="col-md-6" data-aos="fade-down" data-aos-delay="0">
                  <div class="stat-card card">
                      <div class="card-body">
                          <div class="stat-icon bg-light-primary text-primary"><i class="fas fa-comments"></i></div>
                          <h6 class="text-muted fw-bold mb-1 small uppercase">TOTAL BOT INTERACTIONS</h6>
                          <h2 class="fw-extrabold mb-0"><?= $totalCount ?> AI Generated Leads</h2>
                          <div class="progress progress-sm mt-3" style="height: 4px;"><div class="progress-bar bg-primary" style="width: 100%"></div></div>
                      </div>
                  </div>
              </div>
              <div class="col-md-6" data-aos="fade-down" data-aos-delay="100">
                  <div class="stat-card card">
                      <div class="card-body">
                          <div class="stat-icon bg-light-warning text-warning"><i class="fas fa-bolt"></i></div>
                          <h6 class="text-muted fw-bold mb-1 small uppercase">TODAY'S HOT LEADS</h6>
                          <h2 class="fw-extrabold mb-0"><?= ($todayCount > 0) ? '+'.$todayCount : '0' ?> New Prospects</h2>
                          <div class="progress progress-sm mt-3" style="height: 4px;"><div class="progress-bar bg-warning" style="width: <?= min(($todayCount/10)*100, 100) ?>%"></div></div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- 💎 Chatbot Lead Management Table -->
          <div class="row">
            <div class="col-md-12">
              <div class="card border-0 shadow-sm card-round overflow-hidden" data-aos="fade-up">
                <div class="card-header bg-white p-4">
                  <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                      <h4 class="fw-bold mb-0">Conversation Leads</h4>
                      <form method="GET" action="" class="input-group" style="max-width: 320px;">
                          <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control border-end-0 bg-light" placeholder="Search by name, phone or interest...">
                          <button class="btn btn-light border-start-0" type="submit"><i class="fas fa-search text-muted"></i></button>
                      </form>
                  </div>
                </div>
                <div class="card-body bg-light-pink p-0">
                  <div class="table-responsive p-4">
                    <table class="table table-premium mb-0">
                      <thead>
                        <tr>
                          <th>Sr. No</th>
                          <th>Lead Interest</th>
                          <th>Contact Details</th>
                          <th>Inquiry Source</th>
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

                            echo "<tr>";
                            echo "<td><span class='text-muted small'>#" . str_pad($sr_no++, 3, "0", STR_PAD_LEFT) . "</span></td>";
                            echo "<td>
                                    <div class='fw-bold text-dark'>" . htmlspecialchars($row['service_interest']) . "</div>
                                    <span class='badge bg-light-primary text-primary' style='font-size:10px; text-transform:uppercase;'>Interest Captured</span>
                                  </td>";
                            echo "<td>
                                    <div class='d-flex align-items-center'>
                                        <div class='avatar-circle' style='background:$bgColor; color:$textColor'>$initials</div>
                                        <div>
                                            <div class='fw-bold text-dark'>" . htmlspecialchars($row['name']) . "</div>
                                            <div class='text-muted small'><i class='fas fa-phone-alt me-1 text-success'></i>" . htmlspecialchars($row['phone']) . "</div>
                                        </div>
                                    </div>
                                  </td>";
                            echo "<td><span class='source-badge'>" . basename(htmlspecialchars($row['page_source'])) . "</span></td>";
                            echo "<td>
                                    <div class='text-dark fw-bold'>" . date("d M Y", strtotime($row['created_at'])) . "</div>
                                    <div class='text-muted tiny'>" . date("h:i A", strtotime($row['created_at'])) . "</div>
                                  </td>"; 
                            echo "</tr>";
                          }
                        } else {
                          echo "<tr><td colspan='5' class='text-center py-5'>
                                    <div class='text-muted py-4'><i class='fas fa-robot fa-3x mb-3 opacity-25'></i><br>No AI conversation leads found yet.</div>
                                </td></tr>";
                        }
                        ?>
                      </tbody>
                    </table>

                    <!-- Pagination -->
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
