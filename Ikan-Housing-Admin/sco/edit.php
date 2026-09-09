<?php
include('../components/auth.php');
include('../../config.php');

// ================= GET ID =================
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID is missing");
}

// ================= FETCH SEO PAGE =================
$sql = "SELECT * FROM seo_pages WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$seo = mysqli_fetch_assoc($result);

if (!$seo) {
    die("SEO Page not found");
}

// ================= UPDATE =================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $page_name        = mysqli_real_escape_string($con, $_POST['page_name']);
    $meta_title       = mysqli_real_escape_string($con, $_POST['meta_title']);
    $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
    $meta_keywords    = mysqli_real_escape_string($con, $_POST['meta_keywords']);
    $status           = mysqli_real_escape_string($con, $_POST['status']);

    $update = "UPDATE seo_pages SET 
                page_name='$page_name',
                meta_title='$meta_title',
                meta_description='$meta_description',
                meta_keywords='$meta_keywords',
                status='$status'
               WHERE id=$id";

    if (mysqli_query($con, $update)) {
        header("Location: list");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<style>
    .char-counter { font-size: 12px; font-weight: 700; margin-top: 5px; display: block; text-align: right; }
    .status-good { color: #2ecc71; }
    .status-warning { color: #f1c40f; }
    .status-bad { color: #e74c3c; }
    .preview-box { position: sticky; top: 20px; }
</style>

<body>
<div class="wrapper">

  <!-- Sidebar -->
  <?php include('../components/viewSidebar.php'); ?>

  <div class="main-panel">

    <!-- Navbar -->
    <?php include('../components/viewNavbar.php'); ?>

    <div class="container">
      <div class="page-inner">

        <div class="page-header">
          <h3 class="fw-bold mb-3">SEO Optimizer</h3>
          <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
            <li class="separator"><i class="fas fa-chevron-right"></i></li>
            <li class="nav-item"><a href="list">SEO List</a></li>
            <li class="separator"><i class="fas fa-chevron-right"></i></li>
            <li class="nav-item">Modify Optimization</li>
          </ul>
        </div>

        <div class="row">
          <div class="col-md-7">
            <div class="card card-round shadow-sm">
              <div class="card-header bg-white py-3">
                <div class="card-title fw-bold text-primary"><i class="fas fa-edit me-2"></i>Update SEO Configuration</div>
              </div>

              <div class="card-body">
                <form method="POST" id="seoForm">
                  <div class="form-group mb-4">
                    <label class="fw-bold">Target Page Name</label>
                    <input type="text" name="page_name" id="pageNameInput" class="form-control" 
                           value="<?= htmlspecialchars($seo['page_name']) ?>" required>
                    <small class="text-muted">Currently optimizing: <strong><?= htmlspecialchars($seo['page_name']) ?></strong></small>
                  </div>

                  <div class="form-group mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="fw-bold">Meta Title</label>
                        <span id="titleCounter" class="char-counter">0 / 60</span>
                    </div>
                    <input type="text" name="meta_title" id="titleInput" class="form-control" maxlength="100" 
                           value="<?= htmlspecialchars($seo['meta_title']) ?>" required>
                    <p class="seo-tip">Optimized titles are between 50-60 characters.</p>
                  </div>

                  <div class="form-group mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="fw-bold">Meta Description</label>
                        <span id="descCounter" class="char-counter">0 / 160</span>
                    </div>
                    <textarea name="meta_description" id="descInput" class="form-control" rows="4" maxlength="300" required><?= htmlspecialchars($seo['meta_description']) ?></textarea>
                    <p class="seo-tip">Summarize the page in 150-160 characters for best CTR.</p>
                  </div>

                  <div class="form-group mb-4">
                    <label class="fw-bold">Focus Keywords</label>
                    <textarea name="meta_keywords" class="form-control" rows="2"><?= htmlspecialchars($seo['meta_keywords']) ?></textarea>
                    <small class="text-muted">Separate keywords with commas.</small>
                  </div>

                  <div class="form-group mb-4">
                    <label class="fw-bold">Visibility Status</label>
                    <select name="status" class="form-select" required>
                      <option value="1" <?= $seo['status'] == 1 ? 'selected' : '' ?>>Live / Optimized</option>
                      <option value="0" <?= $seo['status'] == 0 ? 'selected' : '' ?>>Draft / Inactive</option>
                    </select>
                  </div>

                  <div class="pt-3">
                    <button type="submit" class="btn btn-primary px-5 btn-round shadow">
                      <i class="fas fa-save me-2"></i>Apply Optimizations
                    </button>
                    <a href="list" class="btn btn-light px-4 btn-round ms-2 border">Cancel</a>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- Preview Column -->
          <div class="col-md-5">
            <div class="preview-box">
                <div class="card card-round shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <div class="card-title fw-bold text-success"><i class="fab fa-google me-2"></i>Google Search Preview</div>
                    </div>
                    <div class="card-body">
                        <div class="google-preview-card">
                            <div class="google-url">
                                https://ikanhousing.com › <span id="previewPage"><?= strtolower($seo['page_name']) ?></span>
                            </div>
                            <a href="#" class="google-title" id="previewTitle"><?= htmlspecialchars($seo['meta_title']) ?></a>
                            <div class="google-description" id="previewDesc">
                                <?= htmlspecialchars($seo['meta_description']) ?>
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-light rounded shadow-sm">
                            <p class="fw-bold mb-2" style="font-size: 0.85rem;"><i class="fas fa-lightbulb text-warning me-2"></i>SEO Insight</p>
                            <small class="text-muted d-block line-height-base">
                                Updating meta tags regularly based on trending keywords can significantly improve your search rankings.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <?php include('../components/viewFooter.php'); ?>
  </div>
</div>

<script>
    const titleInput = document.getElementById('titleInput');
    const descInput = document.getElementById('descInput');
    const pageNameInput = document.getElementById('pageNameInput');
    
    const previewTitle = document.getElementById('previewTitle');
    const previewDesc = document.getElementById('previewDesc');
    const previewPage = document.getElementById('previewPage');
    
    const titleCounter = document.getElementById('titleCounter');
    const descCounter = document.getElementById('descCounter');

    function updateCounters() {
        const titleLen = titleInput.value.length;
        const descLen = descInput.value.length;
        
        // Update Preview
        previewTitle.textContent = titleInput.value || 'Page Title Example';
        previewDesc.textContent = descInput.value || 'Provide a meta description...';
        previewPage.textContent = (pageNameInput.value || 'page').toLowerCase();

        // Title Health
        titleCounter.textContent = `${titleLen} / 60`;
        if(titleLen >= 50 && titleLen <= 60) {
            titleCounter.className = 'char-counter status-good';
            titleCounter.innerHTML += ' <i class="fas fa-check-circle"></i>';
        } else if(titleLen > 60) {
            titleCounter.className = 'char-counter status-bad';
            titleCounter.innerHTML += ' <i class="fas fa-exclamation-triangle"></i>';
        } else {
            titleCounter.className = 'char-counter status-warning';
        }

        // Description Health
        descCounter.textContent = `${descLen} / 160`;
        if(descLen >= 140 && descLen <= 160) {
            descCounter.className = 'char-counter status-good';
            descCounter.innerHTML += ' <i class="fas fa-check-circle"></i>';
        } else if(descLen > 160) {
            descCounter.className = 'char-counter status-bad';
            descCounter.innerHTML += ' <i class="fas fa-exclamation-triangle"></i>';
        } else {
            descCounter.className = 'char-counter status-warning';
        }
    }

    titleInput.addEventListener('input', updateCounters);
    descInput.addEventListener('input', updateCounters);
    pageNameInput.addEventListener('input', updateCounters);
    
    // Initial call to set values
    updateCounters();
</script>

</body>
</html>
