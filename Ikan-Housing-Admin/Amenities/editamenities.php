<?php
include('../components/auth.php');
include '../../config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM amenity WHERE id = $id";
$edit = mysqli_fetch_assoc(mysqli_query($con, $query));

if (!$edit) {
    header("Location: listamenities");
    exit();
}

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, trim($_POST['amenity_name']));
    $status = mysqli_real_escape_string($con, trim($_POST['status']));
    $icon = $edit['icon'];

    if (isset($_FILES['icon']) && $_FILES['icon']['error'] == 0) {
        $icon_name = time() . "_" . $_FILES['icon']['name'];
        if (move_uploaded_file($_FILES['icon']['tmp_name'], '../../uploads/' . $icon_name)) {
            $icon = $icon_name;
        } else {
            $error = "❌ Processing Error: Icon upload failed.";
        }
    }

    if (empty($error)) {
        $updateQuery = "UPDATE amenity SET name='$name', status='$status', icon='$icon' WHERE id = $id";
        if (mysqli_query($con, $updateQuery)) {
            header("Location: listamenities");
            exit();
        } else {
            $error = "❌ Database Update Error: " . mysqli_error($con);
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
              <h2 class="mb-1 text-premium">Edit Facility Profile</h2>
              <p class="text-muted mb-0">Update classification and visual identity for <strong><?= htmlspecialchars($edit['name']) ?></strong>.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="listamenities" class="text-primary">Amenities</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Modify Asset</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-7 mx-auto">
            <div class="card card-premium shadow-sm border-0" data-aos="fade-up">
              <div class="card-header bg-white py-3 border-bottom-light">
                <h4 class="card-title fw-bold text-premium mb-0"><i class="fas fa-edit me-2"></i>Update Specifications</h4>
              </div>
              <div class="card-body p-4">
                <form method="POST" enctype="multipart/form-data" class="modern-form">
                  <div class="row g-4">
                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Amenity Title <span class="text-danger">*</span></label>
                        <div class="input-group">
                           <span class="input-group-text bg-light-pink border-0 text-primary"><i class="fas fa-star"></i></span>
                           <input type="text" name="amenity_name" class="form-control" value="<?= htmlspecialchars($edit['name']) ?>" required>
                        </div>
                        <?php if (!empty($error)): ?>
                          <div class="alert alert-danger-soft mt-3 py-2 small"><?= $error ?></div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="col-md-12 text-center py-2">
                       <div class="form-group mb-0">
                        <label class="form-label fw-bold d-block text-premium mb-3">Feature Identity (Icon)</label>
                        <div class="icon-preview-wrapper mb-3 mx-auto shadow-sm" style="height: 120px; width: 120px; border: 2px solid #f8f9fa; border-radius: 20px; display: flex; align-items: center; justify-content: center; background: white;">
                          <img id="iconPreview" src="../../uploads/<?= $edit['icon'] ?>" style="max-height: 80%; max-width: 80%; object-fit: contain;">
                        </div>
                        <input type="file" name="icon" class="form-control" accept="image/*" onchange="previewIcon(this)">
                        <small class="text-muted mt-2 d-block">Leave empty to retain existing icon.</small>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Market Status</label>
                        <select name="status" class="form-select" required>
                          <option value="1" <?= $edit['status'] == 1 ? 'selected' : '' ?>>Active Engagement</option>
                          <option value="0" <?= $edit['status'] == 0 ? 'selected' : '' ?>>Inactive Feature</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-12 border-top pt-4">
                      <div class="d-flex gap-2 justify-content-end">
                        <a href="listamenities" class="btn btn-light px-4">Stop Editing</a>
                        <button type="submit" class="btn btn-primary btn-round px-5 shadow-sm">Save Changes</button>
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
        document.getElementById('iconPreview').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>
</body>
</html>
