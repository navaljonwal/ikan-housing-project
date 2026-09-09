<?php
include '../../config.php'; 

function generateSlug($name, $con) {
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    $originalSlug = $slug;
    $counter = 1;
    while (true) {
        $check = mysqli_query($con, "SELECT id FROM `testimonial` WHERE slug = '$slug'");
        if (mysqli_num_rows($check) == 0) {
            break;
        }
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }
    return $slug;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $about_testimonial = mysqli_real_escape_string($con, $_POST['about_our_testimonial']);
    $status = mysqli_real_escape_string($con, $_POST['status']);

    $slug = generateSlug($name, $con);

    if ($_FILES['image']['error'] == 0) {
        $image = time() . '_' . $_FILES['image']['name'];
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

    $sql = "INSERT INTO `testimonial`(`name`, `desc`, `image`, `status`, `slug`)
            VALUES('$name', '$about_testimonial', '$image', '$status', '$slug')";

    $result = mysqli_query($con, $sql);

    if ($result) {
        header("Location:list.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html> 
<html lang="en">
<?php include('../components/viewHead.php'); ?>

<head>
  <meta charset="utf-8">
  <title>Add Testimonial</title>
  <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>

    <div class="main-panel">
      <div class="main-header main-header-dd">
        <div class="main-header-logo">
          <div class="logo-header" data-background-color="dark">
            <a href="../index" class="logo">
              <img src="../assets/img/kaiadmin/Ikanhousing-logowhite.svg" alt="navbar brand" class="navbar-brand" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
              <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
          </div>
        </div>
        <?php include('../components/viewNavbar.php'); ?>
      </div>

      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <h3 class="fw-bold mb-3">Add Testimonial</h3>
            <ul class="breadcrumbs mb-3">
              <li class="nav-home">
                <a href="../index">
                  <i class="icon-home"></i>
                </a>
              </li>
              <li class="separator"><i class="icon-arrow-right"></i></li>
              <li class="nav-item"><a href="testimonial-list">Testimonial List</a></li>
            </ul>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">ADD TESTIMONIAL</div>
                </div>
                <div class="card-body">
                  <form method="POST" enctype="multipart/form-data" class="form-a contactForm new-from-prrr">
                    <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" name="name" class="form-control form-control-lg" placeholder="Name" required>
                    </div>

                    <div class="form-group">
                      <label for="paragraph">About Testimonial</label>
                      <textarea name="about_our_testimonial" id="editor"></textarea>
                    </div>

                    <div class="form-group">
                      <label for="paragraph">Image (jpg, jpeg, png)</label>
                      <input type="file" name="image" accept=".jpg,.jpeg,.png" class="form-control form-control-lg" required>
                    </div>

                    <div class="form-group">
                      <label for="status">Status</label>
                      <select name="status" class="form-control form-control-lg" required>
                        <option value="">Select Status</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                      </select>
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                    <button class="btn btn-danger" type="reset">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php include('../components/viewFooter.php'); ?>

        <script>
          ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
              console.error(error);
            });
        </script>
</body>
</html>
