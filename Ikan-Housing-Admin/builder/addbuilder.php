<?php
include('../components/auth.php');
include('../../config.php');

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $status = trim($_POST['status']);
    $logo = "";

    if ($_FILES['logo']['error'] == 0) {
        $logo_name = time() . "_" . $_FILES['logo']['name'];
        $logo_tmp_name = $_FILES['logo']['tmp_name'];
        if (move_uploaded_file($logo_tmp_name, '../../uploads/' . $logo_name)) {
            $logo = $logo_name;
        } else {
            $error = "Error in uploading the logo.";
        }
    }

    if (empty($error)) {
        $name = mysqli_real_escape_string($con, $name);
        $status = mysqli_real_escape_string($con, $status);

        $query = "INSERT INTO `builder`(`builder_name`,`logo`,`status`) VALUES ('$name','$logo','$status')";
        if (mysqli_query($con, $query)) {
            header("Location: builder");
            exit();
        } else {
            $error = "❌ Data not inserted. Error: " . mysqli_error($con);
        }
    }
}
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
              <h2 class="mb-1 text-premium">Partner Onboarding</h2>
              <p class="text-muted mb-0">Add a new development partner to your network.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="builder" class="text-primary">Builders</a></li>
                  <li class="breadcrumb-item active" aria-current="page">New Partner</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8 mx-auto">
            <div class="card card-premium shadow-sm border-0" data-aos="fade-up">
              <div class="card-header bg-white py-3 border-bottom-light">
                <h4 class="card-title fw-bold text-premium mb-0"><i class="fas fa-briefcase me-2"></i>Builder Profile</h4>
              </div>
              <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data" class="modern-form">
                  <div class="row g-4">
                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Builder Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                           <span class="input-group-text bg-light-pink border-0 text-primary"><i class="fas fa-building"></i></span>
                           <input type="text" name="name" class="form-control" placeholder="Enter full name of the company" required>
                        </div>
                        <?php if (!empty($error)): ?>
                          <div class="alert alert-danger-soft mt-2 py-2 small">
                            <i class="fas fa-exclamation-circle me-1"></i> <?= $error ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Operational Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                          <option value="" disabled selected>Select status</option>
                          <option value="1">Active Partner</option>
                          <option value="0">On Hold / Inactive</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                       <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Brand Logo</label>
                        <div class="image-upload-wrapper mb-3" style="height: 160px;">
                          <img id="logoPreview" src="../assets/img/default img placeholder.png" 
                               style="width: 100%; height: 100%; object-fit: contain;">
                          <div class="preview-overlay">Ratio 1:1 Recommended</div>
                        </div>
                        <input type="file" name="logo" class="form-control" accept="image/*" onchange="previewLogo(this)">
                      </div>
                    </div>

                    <div class="col-12 border-top pt-4">
                      <div class="d-flex gap-2 justify-content-end">
                        <a href="builder" class="btn btn-light px-4">Discard</a>
                        <button type="submit" class="btn btn-primary btn-round px-5 shadow-sm">
                          Save Partner Profile
                        </button>
                      </div>
                    </div>
                  </div>
                </form>
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
  AOS.init({ duration: 800, once: true });
  
  function previewLogo(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('logoPreview').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
</body>
</html>