<?php
include('../components/auth.php');
include('../../config.php');

// 🔧 Slug generate function
function generateSlug($string)
{
    $slug = strtolower(trim($string));
    $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
    $slug = preg_replace('/-+/', '-', $slug);
    return rtrim($slug, '-');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $massage = mysqli_real_escape_string($con, $_POST['massage']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    // ✅ Slug generate
    $slug = generateSlug($name);

    // Image Upload
    if ($_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = '../../uploads/' . $image;

        if (!move_uploaded_file($image_tmp_name, $image_path)) {
            echo "Error uploading the image file.";
            exit();
        }
    } else {
        echo "Error with the image upload.";
        exit();
    }

    // ✅ Insert Query with slug
    $sql = "INSERT INTO `blog`(`name`, `slug`, `image`, `massage`, `status`) 
            VALUES('$name', '$slug', '$image', '$massage', '$status')";

    $result = mysqli_query($con, $sql);

    if ($result) {
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
              <h2 class="fw-bold mb-1">Add New Blog</h2>
              <p class="text-muted mb-0">Create a new post to share with your audience.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
              <a href="list" class="btn btn-outline-primary rounded-pill px-4">
                <i class="fas fa-arrow-left me-2"></i>Back to List
              </a>
            </div>
          </div>

          <form name="blogForm" action="" enctype="multipart/form-data" method="POST">
            <div class="row g-4">
              <!-- Left Column: Primary Content -->
              <div class="col-lg-8" data-aos="fade-right">
                <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                  <div class="form-group mb-4">
                    <label class="fw-bold mb-2 text-dark small text-uppercase" style="letter-spacing: 1px;">Blog Title <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control rounded-3 py-2 px-3 shadow-none border-light-subtle" 
                           placeholder="Enter post title..." style="background: #fafafa;" required>
                    <small class="text-muted mt-2 d-block">This title will also be used to generate the URL slug.</small>
                  </div>

                  <div class="form-group mb-0">
                    <label class="fw-bold mb-2 text-dark small text-uppercase" style="letter-spacing: 1px;">Blog Content <span class="text-danger">*</span></label>
                    <div class="modern-editor-wrapper">
                      <textarea name="massage" id="blog-editor"></textarea>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Column: Settings & Media -->
              <div class="col-lg-4" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                  <h6 class="fw-bold mb-3 text-dark small text-uppercase" style="letter-spacing: 1px;">Publishing Details</h6>
                  <div class="form-group mb-0">
                    <label class="text-muted small mb-2">Visibility Status</label>
                    <select name="status" class="form-select rounded-3 shadow-none border-light-subtle" style="background: #fafafa;" required>
                      <option value="1">Active (Published)</option>
                      <option value="0">Inactive (Draft)</option>
                    </select>
                  </div>
                </div>

                <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                  <h6 class="fw-bold mb-3 text-dark small text-uppercase" style="letter-spacing: 1px;">Featured Image</h6>
                  <div class="image-upload-wrapper mb-3 text-center d-flex align-items-center justify-content-center" style="height: 200px; background: #fdfdfd; border-radius: 16px; border: 2px dashed #eee; position: relative; overflow: hidden;">
                    <img id="image-preview" src="../assets/img/placeholder-house.webp" class="w-100 h-100 object-fit-cover opacity-50">
                    <div class="preview-overlay position-absolute bottom-0 w-100 py-2" style="background: rgba(255,255,255,0.8); backdrop-filter: blur(5px); color: var(--primary-color); font-weight: 600; font-size: 10px; text-transform: uppercase; letter-spacing: 1px;">
                       Image Preview
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="custom-file-input">
                      <input type="file" name="image" id="blog-image" accept=".jpg,.jpeg,.png,.webp" 
                             class="form-control rounded-3 shadow-none border-light-subtle" style="background: #fafafa;" 
                             onchange="previewImage(this)" required>
                    </div>
                    <small class="text-muted d-block mt-2">Recommended: 1200x800px (WebP/PNG).</small>
                  </div>
                </div>

                <div class="d-grid gap-3" data-aos="zoom-in" data-aos-delay="200">
                  <button type="submit" class="btn btn-primary py-3 rounded-pill shadow-sm fw-bold">
                    <i class="fas fa-paper-plane me-2"></i>Publish Blog
                  </button>
                  <button type="reset" class="btn btn-link text-muted text-decoration-none small text-center">
                    Clear Changes
                  </button>
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
    .ck-editor__editable { min-height: 350px !important; border-radius: 0 0 12px 12px !important; border-color: #eee !important; box-shadow: none !important; }
    .ck-toolbar { border-radius: 12px 12px 0 0 !important; border-color: #eee !important; background: #f8f9fa !important; }
    .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); }
    .btn-primary:hover { background-color: var(--secondary-color); border-color: var(--secondary-color); transform: translateY(-2px); transition: all 0.3s; }
    .btn-outline-primary { color: var(--primary-color); border-color: var(--primary-color); }
    .btn-outline-primary:hover { background-color: var(--primary-color); color: #fff; }
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
          preview.classList.remove('opacity-50');
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>

</body>
</html>