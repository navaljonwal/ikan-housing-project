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
<body>
  <div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>

    <div class="main-panel">
      <div class="main-header">
        <?php include('../components/viewNavbar.php'); ?>
      </div>

      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <h3 class="fw-bold mb-3">Company Registration form</h3>
            <ul class="breadcrumbs mb-3">
              <li class="nav-home">
                <a href="#"><i class="icon-home"></i></a>
              </li>
              <li class="separator"><i class="icon-arrow-right"></i></li>
              <li class="nav-item"><a href="add">Company Registration form</a></li>
            </ul>
          </div>

          <form method="GET" class="mb-3">
              <div class="row justify-content-end gx-1">
                <div class="col-auto">
                  <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
                </div>
                <div class="col-auto">
                  <button type="submit" class="btn btn-primary btn-sm">Search</button>
                </div>  
              </div>
            </form>

          <div class="card">
            <div class="card-header"><h4 class="card-title">Company Registration form List</h4></div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Sr.no</th>
                      <!-- <th>Image</th> -->
                      <th>Name</th>
                      <!-- <th>Message</th> -->
                      <!-- <th>Status</th> -->
                      <th>Action</th>
                    </tr>
                  </thead>
                 <tbody>
                                    <tr>
                                            <td>1</td>
                                            <td>Philip Foreman</td>
                                            <!-- <td>legaduw@mailinator.com</td> -->
                                            <!-- <td>6334567890</td> -->
                                            <!-- <td>96</td> -->
                                            <!-- <td>HR Manager</td> -->
                                          <td>
                                <div style="display: flex; gap: 6px;">
                                  <a href="Company-registration-form" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> view</a>
                                  <a href="delete-blog?id=15" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this blog?');"><i class="fa fa-trash"></i> Delete</a>
                                </div>
                              </td>
                                        </tr>
                                                                 </tbody>
                </table>
              </div>

              <!-- Pagination -->
         <nav>
                    <ul class="pagination">
                      
                                              <li class="page-item active">
                          <a class="page-link" href="?search=&amp;page=1">1</a>
                        </li>
                                              <li class="page-item ">
                          <a class="page-link" href="?search=&amp;page=2">2</a>
                        </li>
                                              <li class="page-item ">
                          <a class="page-link" href="?search=&amp;page=3">3</a>
                        </li>
                      
                                              <li class="page-item">
                          <a class="page-link" href="?search=&amp;page=2">Next</a>
                        </li>
                                          </ul>
                  </nav>

            </div>
          </div>
        </div>
      </div>
      <?php include('../components/viewFooter.php'); ?>
    </div>
  </div>

  <!-- Font Awesome (for icons) -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

</body>
</html>
