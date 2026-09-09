<?php
include('../components/auth.php');
include '../../config.php';

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, trim($_POST['amenity_name']));
    $status = mysqli_real_escape_string($con, trim($_POST['status']));
    $icon = "";

    if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
        $icon = time() . "_" . $_FILES['icon']['name'];
        if (!move_uploaded_file($_FILES['icon']['tmp_name'], '../../uploads/' . $icon)) {
            $error = "❌ Core Error: Icon upload failed.";
        }
    } else {
        $error = "❌ Icon is required for new amenities.";
    }

    if (empty($error)) {
        $query = "INSERT INTO `amenity` (`name`, `status`, `icon`) VALUES ('$name', '$status', '$icon')";
        if (mysqli_query($con, $query)) {
            header("Location: listamenities");
            exit();
        } else {
            $error = "❌ Database Error: " . mysqli_error($con);
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
              <h2 class="mb-1 text-premium">Initialize Feature</h2>
              <p class="text-muted mb-0">Add a new standardized amenity icon for the property catalog.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="listamenities" class="text-primary">Amenities</a></li>
                  <li class="breadcrumb-item active" aria-current="page">New Feature</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-7 mx-auto">
            <div class="card card-premium shadow-sm border-0" data-aos="fade-up">
              <div class="card-header bg-white py-3 border-bottom-light">
                <h4 class="card-title fw-bold text-premium mb-0"><i class="fas fa-plus-circle me-2"></i>Amenity Definition</h4>
              </div>
              <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data" class="modern-form">
                  <div class="row g-4">
                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Feature Name <span class="text-danger">*</span></label>
                        <div class="input-group">
                           <span class="input-group-text bg-light-pink border-0 text-primary"><i class="fas fa-star"></i></span>
                           <input type="text" name="amenity_name" class="form-control" placeholder="e.g., Swimming Pool, Gym, WiFi" required>
                        </div>
                        <?php if (!empty($error)): ?>
                          <div class="alert alert-danger-soft mt-3 py-2 small"><?= $error ?></div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="col-md-12 text-center py-2">
                       <div class="form-group mb-0">
                        <label class="form-label fw-bold d-block text-premium mb-3">Feature Icon Visibility</label>
                        <div class="icon-preview-wrapper mb-3 mx-auto" style="height: 100px; width: 100px; border: 2px dashed #eee; border-radius: 15px; display: flex; align-items: center; justify-content: center; background: #fafafa;">
                          <img id="iconPreview" src="../assets/img/kaiadmin/placeholder-icon.svg" style="max-height: 80%; max-width: 80%; object-fit: contain; opacity: 0.5;">
                        </div>
                        <input type="file" name="icon" class="form-control" accept="image/*" required onchange="previewIcon(this)">
                        <small class="text-muted mt-2 d-block">Recommended: SVG or Transparent PNG (Square ratio)</small>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Initial Availability</label>
                        <select name="status" class="form-select" required>
                          <option value="1">Active (Visible immediately)</option>
                          <option value="0">Draft (Hidden for now)</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-12 border-top pt-4">
                      <div class="d-flex gap-2 justify-content-end">
                        <a href="listamenities" class="btn btn-light px-4">Exit</a>
                        <button type="submit" class="btn btn-primary btn-round px-5 shadow-sm">Save Amenity</button>
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
  function previewIcon(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) { 
        const preview = document.getElementById('iconPreview');
        preview.src = e.target.result;
        preview.style.opacity = "1";
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
</body>
</html>