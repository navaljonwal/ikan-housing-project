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
                <form>

    <!-- Company Information -->
    <h4 class="section-title">Company Information</h4>
    <div class="row g-3">
      <!-- Fields as you provided -->
      <div class="col-md-6"><label>Company Name as per the Licence *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Office Number/Unit Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Building Name *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Street Name</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-6"><label>Area Name *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Company City *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Country *</label><input type="text" class="form-control" value="INDIA" readonly></div>
      <div class="col-md-6"><label>Postal Code</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-6"><label>Company Mobile Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Company Email Address *</label><input type="email" class="form-control" required readonly></div>
      <div class="col-12"><label>Application Form (COMPLETELY FILLED) *</label><input type="file" class="form-control form-control-f" required disabled >
        <!-- <div class="note">Please ensure all mandatory fields are completed before downloading the 'Filled Application Form'. All uploaded documents must be in English.</div> -->
      </div>
    </div>

    <hr>

    <!-- Certificate of Incorporation -->
    <h4 class="section-title">Certificate of Rera</h4>
    <div class="row g-3">
      <div class="col-md-6"><label>Issuing Authority *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Licensing/Certification Legal Type *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Certificate of Rera Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Licensing/Certification Issuance Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Licensing/Certification Expiry Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Certificate Upload *</label><input type="file" class="form-control form-control-f" required readonly></div>
      <div class="col-12"><label>Memorandum of Association / Articles of Incorporation</label><input type="file" class="form-control form-control-f" disabled ></div>
    </div>

    <hr>

    <!-- Owner Information -->
    <h4 class="section-title">Owner Information - 1</h4>
    <div class="row g-3">
      <div class="col-md-6"><label>Owner’s Full Name as per Passport *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Owner’s Passport Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Owner’s Nationality *</label><select class="form-select" required disabled ><option>Select</option><option>Indian</option><option>Other</option></select></div>
      <div class="col-md-6"><label>Passport Issue Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Passport Expiry Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Passport First Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
      <div class="col-md-6"><label>Passport Signature Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
      <div class="col-md-6"><label>Owner's National ID Number</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-3"><label>National ID Issue Date</label><input type="date" class="form-control" readonly></div>
      <div class="col-md-3"><label>National ID Expiry Date</label><input type="date" class="form-control" readonly></div>
      <div class="col-12"><label>Owner's National ID Copy (Front and Back)</label><input type="file" class="form-control form-control-f" disabled ></div>
    </div>

    <hr>

    <!-- ////////////////////////// -->
    <button class="bhyu"   type="button" id="show-owner2">Owner Information - 2</button>
    <div class="owner-form" id="owner2-form">
    <h4 class="section-title">Owner Information - 2</h4>
    <div  class="row g-3 " >
      <div class="col-md-6"><label>Owner’s Full Name as per Passport *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Owner’s Passport Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Owner’s Nationality *</label><select class="form-select" required disabled ><option>Select</option><option>Indian</option><option>Other</option></select></div>
      <div class="col-md-6"><label>Passport Issue Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Passport Expiry Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Passport First Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
      <div class="col-md-6"><label>Passport Signature Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
      <div class="col-md-6"><label>Owner's National ID Number</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-3"><label>National ID Issue Date</label><input type="date" class="form-control" readonly></div>
      <div class="col-md-3"><label>National ID Expiry Date</label><input type="date" class="form-control" readonly></div>
      <div class="col-12"><label>Owner's National ID Copy (Front and Back)</label><input type="file" class="form-control form-control-f" disabled ></div>
    </div>
</div>
    <hr>

    <!-- /////////////////////////////// -->
    <button class="bhyu"  type="button" id="show-owner3">Owner Information - 3</button>
    <div class="owner-form" id="owner3-form">
    <h4 class="section-title">Owner Information - 3</h4>
    <div class="row g-3 " >
      <div class="col-md-6"><label>Owner’s Full Name as per Passport *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Owner’s Passport Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Owner’s Nationality *</label><select class="form-select" required disabled ><option>Select</option><option>Indian</option><option>Other</option></select></div>
      <div class="col-md-6"><label>Passport Issue Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Passport Expiry Date *</label><input type="date" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Passport First Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
      <div class="col-md-6"><label>Passport Signature Page *</label><input type="file" class="form-control form-control-f" required disabled ></div>
      <div class="col-md-6"><label>Owner's National ID Number</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-3"><label>National ID Issue Date</label><input type="date" class="form-control" readonly></div>
      <div class="col-md-3"><label>National ID Expiry Date</label><input type="date" class="form-control" readonly></div>
      <div class="col-12"><label>Owner's National ID Copy (Front and Back)</label><input type="file" class="form-control form-control-f" disabled ></div>
    </div>
</div>
    <hr>

    <!-- Staff Member Information -->
    <h4 class="section-title">Staff Member Information</h4>
    <div class="row g-3">
      <div class="col-md-6"><label>Office Admin Full Name</label><input type="text" class="form-control" readonly ></div>
      <div class="col-md-6"><label>Office Admin Nationality</label><select class="form-select" disabled ><option>Select</option></select></div>
      <div class="col-md-6"><label>Office Admin Email Address</label><input type="email" class="form-control" readonly></div>
      <div class="col-md-6"><label>Office Admin Phone Number</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-6"><label>Is Owner and Manager Same?</label><select class="form-select" disabled ><option>Select</option></select></div>
      <div class="col-md-6"><label>Office Manager Full Name</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-6"><label>Office Manager Nationality</label><select class="form-select" disabled ><option>Select</option></select></div>
      <div class="col-md-6"><label>Office Manager Email Address</label><input type="email" class="form-control" readonly></div>
      <div class="col-md-6"><label>Office Manager Phone Number</label><input type="text" class="form-control" readonly></div>
    </div>

    <hr>

    <!-- POA Information -->
    <h4 class="section-title mt-4">POA Information</h4>
    <div class="mb-3"><label>Does the Owner has Power of Attorney? *</label><select class="form-select" required disabled >
        <option>Select</option>
        <option>Yes</option>
        <option>No</option>
</select></div>

    <hr>

    <!-- Company Bank Information -->
    <h4 class="section-title">Company Bank Information</h4>
    <div class="note mb-2">*Important Note*: No commission will be released to a third party or personal bank account. Commission release requires a company to provide a company bank account as per the  License.</div>
    <div class="row g-3">
      <div class="col-md-6"><label>Bank Account Status *</label><select class="form-select" required disabled ><option>Select</option></select></div>
      <div class="col-md-6"><label>Beneficiary Name *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Account Number *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>IFSC/ Country Bank Code *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Confirm IFSC/ Bank Code *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Bank Name *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Bank Address *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Bank Address - City *</label><input type="text" class="form-control" required readonly></div>
      <div class="col-md-6"><label>Bank Address - Pincode</label><input type="text" class="form-control" readonly></div>
      <div class="col-md-6"><label>Bank Branch *</label><input type="text" class="form-control" required readonly></div>
      <!-- <div class="col-md-6"><label>Swift/Sort Code *</label><input type="text" class="form-control" required readonly></div> -->
      <div class="col-md-6"><label>Currency of Account *</label><select class="form-select" required disabled ><option>Select Currency</option><option>INR-Indian Rupee</option></select></div>
    </div>

    <hr>

    <!-- Upload Documents -->
    <h4 class="section-title mt-4">Upload Required readonly Documents</h4>
    <div class="mb-3"><label>Other Related Documents</label><input type="file" class="form-control form-control-f" disabled ></div>
    <div class="mb-3"><label>Add Indemnity Letter (Company Letterhead with Stamp) *</label><input type="file" class="form-control form-control-f" required disabled ></div>


  </form>

            </div>
        </div>
        <?php include('../components/viewFooter.php'); ?>
    </div>
</div>
</body>
</html>
