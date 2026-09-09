<?php
include('../components/auth.php');
include('../../config.php');

$search = mysqli_real_escape_string($con, $_GET['search'] ?? '');
$page = (int)($_GET['page'] ?? 1);
$limit = 10;
$offset = ($page - 1) * $limit;

$where = "";
if (!empty($search)) {
    $where = "WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR mobile LIKE '%$search%' OR position LIKE '%$search%'";
}

// Count total rows
$countQuery = "SELECT COUNT(*) as total FROM resume_submissions $where";
$countResult = mysqli_query($con, $countQuery);
$total = mysqli_fetch_assoc($countResult)['total'];
$totalPages = ceil($total / $limit);

// Fetch paginated data
$query = "SELECT * FROM resume_submissions $where ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($con, $query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<body>
<style>
.pagination .page-item.active .page-link {
    background-color: white !important;
    color: black !important;
    border-color: #dee2e6;
}
.pagination .page-link {
    color: black;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
}
.pagination .page-link:hover {
    background-color: #e2e6ea;
    color: black;
}


</style>

<div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>
    <div class="main-panel">
        <div class="main-header">
            <?php include('../components/viewNavbar.php'); ?>
        </div>

        <div class="container">
            <div class="page-inner">
         <div class="download-detail-btn">     <button>Download</button></div>
                <form id="companyForm" class="form-section" onsubmit="return validateForm(this)">
    <h5>Company Registration Form</h5>
    <div class="row g-3">
      <!-- <div class="col-md-6">
        <label class="form-label">Type (*)</label>
        <input type="text" class="form-control" value="COMPANY" readonly>
      </div> -->
      <div class="col-md-6">
        <label class="form-label">Company Name As per Trade License (*)</label>
        <input type="text" class="form-control" placeholder="Enter Company Name" required readonly>
      </div>
      <div class="col-md-6">
        <label class="form-label">Agency Type (*)</label>
        <select class="form-select" required disabled >
          <option selected >Select</option>
          <option>Real Estate</option>
          <option>Referral Agent</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Country (*)</label>
        <select class="form-select" required disabled >
          <option selected >Select</option>
          <!-- <option>UAE</option> -->
          <option>India</option>
        </select>
      </div>
      <div class="col-md-3">
        <label class="form-label">Mobile Country Code (*)</label>
        <select class="form-select" required disabled >
          <option selected >Select</option>
          <!-- <option>+971</option> -->
          <option>+91</option>
        </select>
      </div>
      <div class="col-md-9">
        <label class="form-label">Mobile Number (*)</label>
        <input type="tel" class="form-control" placeholder="Example 971509999999" required readonly>
      </div>
      <div class="col-12">
        <label class="form-label">User Email ID (*)</label>
        <input type="email" class="form-control" placeholder="Example name@domain.com" required readonly>
      </div>
    
    </div>
  
  </form>

            </div>
        </div>
        <?php include('../components/viewFooter.php'); ?>
    </div>
</div>
</body>
</html>
