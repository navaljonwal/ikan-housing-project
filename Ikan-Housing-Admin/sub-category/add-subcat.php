<?php
include('../components/auth.php');
include('../../config.php');

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_id = mysqli_real_escape_string($con, trim($_POST['name']));
    $name = mysqli_real_escape_string($con, trim($_POST['subname']));
    $status = mysqli_real_escape_string($con, trim($_POST['status']));

    if (empty($category_id) || empty($name)) {
        $error = "❌ Please fill in all required fields.";
    }

    if (empty($error)) {
        $query = "INSERT INTO `sub_category` (`cat_id`, `name`, `status`) VALUES ('$category_id', '$name', '$status')";
        if (mysqli_query($con, $query)) {
            header("Location: sub-category");
            exit();
        } else {
            $error = "❌ System Error: " . mysqli_error($con);
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
              <h2 class="mb-1 text-premium">Detailed Classification</h2>
              <p class="text-muted mb-0">Define a specific sub-category within your primary property groups.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="sub-category" class="text-primary">Sub-Categories</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Initialize Sub-Category</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-8 mx-auto">
            <div class="card card-premium shadow-sm border-0" data-aos="fade-up">
              <div class="card-header bg-white py-3 border-bottom-light">
                <h4 class="card-title fw-bold text-premium mb-0"><i class="fas fa-layer-group me-2"></i>Hierarchy Definition</h4>
              </div>
              <div class="card-body p-4">
                <form method="POST" class="modern-form">
                  <div class="row g-4">
                    <div class="col-md-6">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Parent Category <span class="text-danger">*</span></label>
                        <select name="name" class="form-select" required>
                          <option value="" selected disabled>-- Select Primary --</option>
                          <?php
                          $catQuery = "SELECT id, category_name FROM `category` WHERE status = 1 ORDER BY category_name ASC";
                          $catresult = mysqli_query($con, $catQuery);
                          while ($row = mysqli_fetch_assoc($catresult)) {
                              echo "<option value='{$row['id']}'>{$row['category_name']}</option>";
                          }
                          ?>
                        </select>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                          <option value="1">Active / Live</option>
                          <option value="0">Inactive / Hidden</option>
                        </select>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Sub-Category Title <span class="text-danger">*</span></label>
                        <div class="input-group">
                           <span class="input-group-text bg-light-pink border-0 text-primary"><i class="fas fa-indent"></i></span>
                           <input type="text" name="subname" class="form-control" placeholder="e.g., 2 BHK Apartment, Office Space, etc." required>
                        </div>
                        <?php if (!empty($error)): ?>
                          <div class="alert alert-danger-soft mt-3 py-2 small"><?= $error ?></div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="col-12 border-top pt-4">
                      <div class="d-flex gap-2 justify-content-end">
                        <a href="sub-category" class="btn btn-light px-4">Exit</a>
                        <button type="submit" class="btn btn-primary btn-round px-5 shadow-sm">Save Sub-Category</button>
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
</script>
</body>
</html>