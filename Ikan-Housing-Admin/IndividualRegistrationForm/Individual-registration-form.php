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
    <h2 class="text-center text-primary mb-2 h2-imdividual">Individual / Personal Registration Form</h2>
   <form>
  <h4>Personal Information</h4>
  <div class="row g-3">
    <div class="col-md-6"><label>First Name *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Last Name *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Apt. / House / Villa No. *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Building Name *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Street Name</label><input type="text" class="form-control" readonly></div>
    <div class="col-md-6"><label>Area Name *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>City *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6">
      <label>Country *</label>
      <select class="form-select" required disabled>
        <option selected>INDIA</option>
        <option>UAE</option>
        <option>Other</option>
      </select>
    </div>
    <div class="col-md-6"><label>Postal Code</label><input type="text" class="form-control" readonly></div>
    <div class="col-md-6"><label>Mobile Number *</label><input type="tel" class="form-control" required readonly></div>
    <div class="col-12"><label>Email Address *</label><input type="email" class="form-control" required readonly></div>
    <div class="col-12">
      <label>Application Form (Completely Filled) *</label>
      <input type="file" class="form-control form-control-f" required readonly>
      <div class="note">Please upload all documents in English.</div>
    </div>
    <div class="col-12">
      <label>Attach Indemnity Letter *</label>
      <input type="file" class="form-control form-control-f" required readonly>
      <div class="note">All document copies must be in colour.</div>
    </div>
  </div>

  <hr class="my-4">

  <h4>Passport Details</h4>
  <div class="row g-3">
    <div class="col-md-6"><label>Full Name as per Passport *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Passport No. *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Passport Issue Date *</label><input type="date" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Passport Expiry Date *</label><input type="date" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Passport Front Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
    <div class="col-md-6"><label>Passport Signature Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
  </div>

  <hr class="my-4">

  <h4>National ID / Driver's License</h4>
  <div class="row g-3">
    <div class="col-md-6"><label>ID Number</label><input type="text" class="form-control" readonly></div>
    <div class="col-md-3"><label>ID Issue Date</label><input type="date" class="form-control" readonly></div>
    <div class="col-md-3"><label>ID Expiry Date</label><input type="date" class="form-control" readonly></div>
    <div class="col-12"><label>Upload National ID / Driver's License</label><input type="file" class="form-control form-control-f" disabled ></div>
  </div>

  <hr class="my-4">

  <h4>Bank Information</h4>
  <div class="note mb-2">*Commission will not be released to third party or personal bank accounts.</div>
  <div class="row g-3">
    <div class="col-md-6"><label>Beneficiary Name *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Account Number *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>IFSC / Bank Code *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Confirm IFSC / Bank Code *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Bank Name *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Bank Address *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Bank City *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6"><label>Bank Pincode</label><input type="text" class="form-control" readonly></div>
    <div class="col-md-6"><label>Bank Branch *</label><input type="text" class="form-control" required readonly></div>
    <div class="col-md-6">
      <label>Currency of Account *</label>
      <select class="form-select" required disabled>
        <option>Select Currency</option>
        <option>INR</option>
      </select>
    </div>
  </div>

</form>

  </div>
    </div>
        </div>
        <?php include('../components/viewFooter.php'); ?>
    </div>
</div>
</body>
</html>
