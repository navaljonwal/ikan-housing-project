<?php
include('../components/auth.php');
include('../../config.php');

$error = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $status = trim($_POST['status']);

    if (empty($name)) {
        $error = "❌ Category name is required.";
    }

    if (empty($error)) {
        $name = mysqli_real_escape_string($con, $name);
        $status = mysqli_real_escape_string($con, $status);

        $query = "INSERT INTO `category`(`category_name`,`status`) VALUES ('$name','$status')";
        $result = mysqli_query($con, $query);

        if ($result) {
            header("Location: category");
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
              <h2 class="mb-1 text-premium">New Classification</h2>
              <p class="text-muted mb-0">Create a high-level category for property grouping.</p>
              <nav aria-label="breadcrumb" class="mt-2">
                <ol class="breadcrumb mb-0" style="background: transparent; padding: 0;">
                  <li class="breadcrumb-item"><a href="../index" class="text-primary"><i class="fas fa-home me-1"></i>Dashboard</a></li>
                  <li class="breadcrumb-item"><a href="category" class="text-primary">Categories</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Ad Category</li>
                </ol>
              </nav>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-7 mx-auto">
            <div class="card card-premium shadow-sm border-0" data-aos="fade-up">
              <div class="card-header bg-white py-3 border-bottom-light">
                <h4 class="card-title fw-bold text-premium mb-0"><i class="fas fa-folder-plus me-2"></i>Category Definition</h4>
              </div>
              <div class="card-body p-4">
                <form method="POST" class="modern-form">
                  <div class="row g-4">
                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Category Title <span class="text-danger">*</span></label>
                        <div class="input-group">
                           <span class="input-group-text bg-light-pink border-0 text-primary"><i class="fas fa-tag"></i></span>
                           <input type="text" name="name" class="form-control" placeholder="e.g., Residential, Commercial, Luxury" required>
                        </div>
                        <?php if (!empty($error)): ?>
                          <div class="alert alert-danger-soft mt-3 py-2 small">
                            <i class="fas fa-exclamation-circle me-1"></i> <?= $error ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-group mb-0">
                        <label class="form-label fw-bold text-premium">Market Availability</label>
                        <select name="status" class="form-select" required>
                          <option value="1">Visible on Website (Active)</option>
                          <option value="0">Hidden / Draft (Inactive)</option>
                        </select>
                        <small class="text-muted mt-2 d-block px-1">Inactive categories will not appear in filters or search results.</small>
                      </div>
                    </div>

                    <div class="col-12 border-top pt-4">
                      <div class="d-flex gap-2 justify-content-end">
                        <a href="category" class="btn btn-light px-4">Discard</a>
                        <button type="submit" class="btn btn-primary btn-round px-5 shadow-sm">Save Category</button>
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