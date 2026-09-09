<?php
include('../components/auth.php');
include('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  $page_name        = mysqli_real_escape_string($con, $_POST['page_name']);
  $meta_title       = mysqli_real_escape_string($con, $_POST['meta_title']);
  $meta_description = mysqli_real_escape_string($con, $_POST['meta_description']);
  $meta_keywords    = mysqli_real_escape_string($con, $_POST['meta_keywords']);
  $status           = mysqli_real_escape_string($con, $_POST['status']);

  $sql = "INSERT INTO seo_pages 
          (page_name, meta_title, meta_description, meta_keywords, status)
          VALUES 
          ('$page_name', '$meta_title', '$meta_description', '$meta_keywords', '$status')";

  if (mysqli_query($con, $sql)) {
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
          <h3 class="fw-bold mb-3">SEO Intelligence</h3>
          <ul class="breadcrumbs mb-3">
            <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
            <li class="separator"><i class="fas fa-chevron-right"></i></li>
            <li class="nav-item"><a href="list">SEO List</a></li>
            <li class="separator"><i class="fas fa-chevron-right"></i></li>
            <li class="nav-item">New Optimization</li>
          </ul>
        </div>

        <div class="row">
          <div class="col-md-7">
            <div class="card card-round shadow-sm">
              <div class="card-header bg-white py-3">
                <div class="card-title fw-bold text-primary"><i class="fas fa-magic me-2"></i>Configure SEO Page</div>
              </div>

              <div class="card-body">
                <form method="POST" id="seoForm">
                  <div class="form-group mb-4">
                    <label class="fw-bold">Target Page Name</label>
                    <input type="text" name="page_name" id="pageNameInput" class="form-control" placeholder="e.g. index, contact, about-us" required>
                    <small class="text-muted">Must match the PHP filename or route name.</small>
                  </div>

                  <div class="form-group mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="fw-bold">Meta Title</label>
                        <span id="titleCounter" class="char-counter">0 / 60</span>
                    </div>
                    <input type="text" name="meta_title" id="titleInput" class="form-control" maxlength="100" placeholder="Enter page title..." required>
                    <p class="seo-tip">Optimized titles are between 50-60 characters.</p>
                  </div>

                  <div class="form-group mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="fw-bold">Meta Description</label>
                        <span id="descCounter" class="char-counter">0 / 160</span>
                    </div>
                    <textarea name="meta_description" id="descInput" class="form-control" rows="4" maxlength="300" placeholder="Enter search snippet..." required></textarea>
                    <p class="seo-tip">Summarize the page in 150-160 characters for best CTR.</p>
                  </div>

                  <div class="form-group mb-4">
                    <label class="fw-bold">Focus Keywords</label>
                    <textarea name="meta_keywords" class="form-control" rows="2" placeholder="real estate, luxury homes, ikan housing..."></textarea>
                    <small class="text-muted">Separate keywords with commas.</small>
                  </div>

                  <div class="form-group mb-4">
                    <label class="fw-bold">Visibility Status</label>
                    <select name="status" class="form-select" required>
                      <option value="1">Live / Optimized</option>
                      <option value="0">Draft / Inactive</option>
                    </select>
                  </div>

                  <div class="pt-3">
                    <button type="submit" class="btn btn-primary px-5 btn-round shadow">
                      <i class="fas fa-save me-2"></i>Deploy SEO Settings
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
                                https://ikanhousing.com › <span id="previewPage">page</span>
                            </div>
                            <a href="#" class="google-title" id="previewTitle">Page Title Example | I Kan Housing</a>
                            <div class="google-description" id="previewDesc">
                                Provide a meta description by editing the field on the left. This is how your page will look when people find you on Google.
                            </div>
                        </div>
                        
                        <div class="mt-4 p-3 bg-light rounded shadow-sm">
                            <p class="fw-bold mb-2" style="font-size: 0.85rem;"><i class="fas fa-lightbulb text-warning me-2"></i>SEO Pro Tip</p>
                            <small class="text-muted d-block line-height-base">
                                Ensure your focus keywords appear in both the title and the first 100 characters of the description for maximum crawlability.
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
        previewTitle.textContent = titleInput.value || 'Page Title Example | I Kan Housing';
        previewDesc.textContent = descInput.value || 'Provide a meta description by editing the field on the left. This is how your page will look when people find you on Google.';
        previewPage.textContent = (pageNameInput.value || 'page').toLowerCase();

        // Title Health
        titleCounter.textContent = `${titleLen} / 60`;
        if(titleLen >= 50 && titleLen <= 60) titleCounter.className = 'char-counter status-good';
        else if(titleLen > 60) titleCounter.className = 'char-counter status-bad';
        else titleCounter.className = 'char-counter status-warning';

        // Description Health
        descCounter.textContent = `${descLen} / 160`;
        if(descLen >= 140 && descLen <= 160) descCounter.className = 'char-counter status-good';
        else if(descLen > 160) descCounter.className = 'char-counter status-bad';
        else descCounter.className = 'char-counter status-warning';
    }

    titleInput.addEventListener('input', updateCounters);
    descInput.addEventListener('input', updateCounters);
    pageNameInput.addEventListener('input', updateCounters);
</script>

</body>
</html>
