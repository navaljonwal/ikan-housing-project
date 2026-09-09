<?php
include('../components/auth.php');
include '../../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID is missing.");
}

// Fetch existing blog data
$query = "SELECT * FROM blog WHERE id = $id";
$result = mysqli_query($con, $query);
$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    die("Blog not found.");
}

// Function to create slug from name
function createSlug($name) {
    $slug = strtolower(trim($name));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug);
    return $slug;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $massage = mysqli_real_escape_string($con, $_POST['massage']);
    
    // Check if status is set, if not, default to 1 (active)
    $status = isset($_POST['status']) ? mysqli_real_escape_string($con, $_POST['status']) : 1;

    // Create the slug from the name
    $slug = createSlug($name);

    // Check if image is uploaded
    if ($_FILES['image']['error'] === 0) {
        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = '../../uploads/' . $image;

        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading image.";
            exit();
        }

        // Update with image and new slug
        $sql = "UPDATE blog SET name='$name', image='$image', massage='$massage', status='$status', slug='$slug' WHERE id=$id";
    } else {
        // Update without image but with new slug
        $sql = "UPDATE blog SET name='$name', massage='$massage', status='$status', slug='$slug' WHERE id=$id";
    }

    if (mysqli_query($con, $sql)) {
        header("Location: list");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<body class="premium-admin-theme">
  <div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>

    <div class="main-panel">
      <div class="main-header">
        <?php include('../components/viewNavbar.php'); ?>
      </div>

      <div class="container">
        <div class="page-inner">
          
          <div class="row align-items-center mb-4" data-aos="fade-down">
            <div class="col-lg-8">
              <h2 class="fw-bold mb-1">Edit Blog Post</h2>
              <p class="text-muted mb-0">Updating: <span class="text-primary fw-bold"><?= htmlspecialchars($blog['name']) ?></span></p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
              <a href="list" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to List
              </a>
            </div>
          </div>

          <form action="" method="POST" enctype="multipart/form-data">
            <div class="row g-4">
              <!-- Left Column: Primary Content -->
              <div class="col-lg-8" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                  <div class="form-group mb-4">
                    <label class="fw-bold mb-2 text-dark small text-uppercase" style="letter-spacing: 1px;">Blog Title <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control rounded-3 py-2 px-3 shadow-none border-light-subtle" 
                           value="<?= htmlspecialchars($blog['name']) ?>" placeholder="Enter blog title..." style="background: #fafafa;" required>
                    <small class="text-muted mt-2 d-block">The URL slug will be updated based on this title.</small>
                  </div>

                  <div class="form-group mb-0">
                    <label class="fw-bold mb-2 text-dark small text-uppercase" style="letter-spacing: 1px;">Blog Content <span class="text-danger">*</span></label>
                    <div class="modern-editor-wrapper">
                      <textarea name="massage" id="blog-editor"><?= htmlspecialchars($blog['massage']) ?></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Column: Settings & Media -->
              <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                  <h6 class="fw-bold mb-3 text-dark small text-uppercase" style="letter-spacing: 1px;">Archive Status</h6>
                  <div class="form-group mb-0">
                    <label class="text-muted small mb-2">Current Visibility</label>
                    <select name="status" class="form-select rounded-3 shadow-none border-light-subtle" style="background: #fafafa;">
                      <option value="1" <?= $blog['status'] == 1 ? 'selected' : '' ?>>Active (Visible)</option>
                      <option value="0" <?= $blog['status'] == 0 ? 'selected' : '' ?>>Inactive (Hidden)</option>
                    </select>
                  </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                  <h6 class="fw-bold mb-3 text-dark small text-uppercase" style="letter-spacing: 1px;">Featured Image</h6>
                  <div class="image-upload-wrapper mb-3 text-center d-flex align-items-center justify-content-center" style="height: 200px; background: #fdfdfd; border-radius: 16px; border: 2px dashed #eee; position: relative; overflow: hidden;">
                    <img id="image-preview" src="../../uploads/<?= $blog['image'] ?>" class="w-100 h-100 object-fit-cover">
                    <div class="preview-overlay position-absolute bottom-0 w-100 py-2" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(5px); color: var(--primary-color); font-weight: 600; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">
                       Current Image Preview
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="small text-muted mb-2">Replace Image (Optional)</label>
                    <div class="custom-file-input">
                      <input type="file" name="image" id="blog-image" accept=".jpg,.jpeg,.png,.webp" 
                             class="form-control rounded-3 shadow-none border-light-subtle" style="background: #fafafa;" 
                             onchange="previewImage(this)">
                    </div>
                  </div>
                </div>

                <div class="d-grid gap-3" data-aos="zoom-in" data-aos-delay="200">
                  <button type="submit" class="btn btn-primary py-3 rounded-pill shadow-sm fw-bold">
                    <i class="fas fa-save me-2"></i>Save Changes
                  </button>
                  <a href="list" class="btn btn-link text-muted text-decoration-none small text-center">
                    Cancel & Return
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div> <!-- End page-inner -->
      </div> <!-- End container -->
      <?php include('../components/viewFooter.php'); ?>
    </div>
  </div>

  <style>
    .object-fit-cover { object-fit: cover; }
    .ck-editor__editable { min-height: 400px !important; border-radius: 0 0 12px 12px !important; border-color: #eee !important; box-shadow: none !important; }
    .ck-toolbar { border-radius: 12px 12px 0 0 !important; border-color: #eee !important; background: #f8f9fa !important; }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    .btn-primary:hover { background-color: var(--secondary-color); border-color: var(--secondary-color); transform: translateY(-2px); transition: all 0.3s; }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Initialize AOS
      AOS.init({ duration: 800, once: true });

      // Initialize CKEditor
      if (typeof ClassicEditor !== 'undefined') {
        ClassicEditor
          .create(document.querySelector('#blog-editor'), {
            toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo'],
            placeholder: 'Write your content here...'
          })
          .catch(error => console.error(error));
      }
    });

    // Image Preview Logic
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          var preview = document.getElementById('image-preview');
          preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>

</body>
</html>
