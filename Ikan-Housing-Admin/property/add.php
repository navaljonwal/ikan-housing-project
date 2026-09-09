<?php
include('../components/auth.php');
include '../../config.php';

function generateSlug($project_name, $con)
{
  $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $project_name), '-'));
  $originalSlug = $slug;
  $counter = 1;
  while (true) {
    $check = mysqli_query($con, "SELECT id FROM properties WHERE slug = '$slug'");
    if (mysqli_num_rows($check) == 0) {
      break;
    }
    $slug = $originalSlug . '-' . $counter;
    $counter++;
  }
  return $slug;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $project_name = mysqli_real_escape_string($con, $_POST['project_name']);
  $price = mysqli_real_escape_string($con, $_POST['price']);
  $location = mysqli_real_escape_string($con, $_POST['location']);
  $rera_no = mysqli_real_escape_string($con, $_POST['rera_no']);
  $size = mysqli_real_escape_string($con, $_POST['size']);
  $status = mysqli_real_escape_string($con, $_POST['status']);
  $trend = mysqli_real_escape_string($con, $_POST['trending']);
  $about_project = mysqli_real_escape_string($con, $_POST['about_our_project']);
  $highlights = mysqli_real_escape_string($con, $_POST['highlights']);
  $other_key_feature = mysqli_real_escape_string($con, $_POST['other_key_feature']);
  $video_link = mysqli_real_escape_string($con, $_POST['video_link']);
  $map = mysqli_real_escape_string($con, $_POST['map']);
  $bigha = mysqli_real_escape_string($con, $_POST['bigha']);
  $units = mysqli_real_escape_string($con, $_POST['no_of_units']);
  $floors = mysqli_real_escape_string($con, $_POST['no_of_floor']);
  $blocks = mysqli_real_escape_string($con, $_POST['no_of_blocks']);

  $slug = generateSlug($project_name, $con);

  if ($_FILES['image']['error'] == 0) {
    $image = $_FILES['image']['name'];
    $image_tmp_name = $_FILES['image']['tmp_name'];
    $image_path = '../../uploads/' . $image;
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
      echo "Error uploading the image file.";
    }
  }

  if ($_FILES['image1']['error'] == 0) {
    $image1 = $_FILES['image1']['name'];
    $image_tmp_name = $_FILES['image1']['tmp_name'];
    $image_path = '../../uploads/' . $image1;
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
      echo "Error uploading the image file.";
    }
  }

  if ($_FILES['image2']['error'] == 0) {
    $image2 = $_FILES['image2']['name'];
    $image_tmp_name = $_FILES['image2']['tmp_name'];
    $image_path = '../../uploads/' . $image2;
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
      echo "Error uploading the image file.";
    }
  }

  if ($_FILES['image3']['error'] == 0) {
    $image3 = $_FILES['image3']['name'];
    $image_tmp_name = $_FILES['image3']['tmp_name'];
    $image_path = '../../uploads/' . $image3;
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
      echo "Error uploading the image file.";
    }
  }

  if ($_FILES['image4']['error'] == 0) {
    $image4 = $_FILES['image4']['name'];
    $image_tmp_name = $_FILES['image4']['tmp_name'];
    $image_path = '../../uploads/' . $image4;
    if (!move_uploaded_file($image_tmp_name, $image_path)) {
      echo "Error uploading the image file.";
    }
  } else {
    echo "Error with the image upload.";
  }

  if ($_FILES['brochure']['error'] == 0) {
    $brochure = $_FILES['brochure']['name'];
    $brochure_tmp_name = $_FILES['brochure']['tmp_name'];
    $brochure_path = '../../uploads/' . $brochure;
    if (!move_uploaded_file($brochure_tmp_name, $brochure_path)) {
      echo "Error uploading the brochure file.";
      exit();
    }
  } else {
    echo "Error with the brochure upload.";
    exit();
  }

  if ($_FILES['logo']['error'] == 0) {
    $logo = time() . '_' . $_FILES['logo']['name'];
    $logo_tmp_name = $_FILES['logo']['tmp_name'];
    $logo_path = '../../uploads/' . $logo;
    if (!move_uploaded_file($logo_tmp_name, $logo_path)) {
      echo "Error uploading the logo file.";
      exit();
    }
  } else {
    $logo = '';
  }


  //////conversion of price into numeric/////////////////
  function priceToInt($price) {
  $price = strtolower(trim($price));
  $price = str_replace([' ', ','], '', $price);

  if (strpos($price, 'cr') !== false) {
    return (int)(floatval($price) * 10000000);
  }

  if (strpos($price, 'lac') !== false || strpos($price, 'lakh') !== false) {
    return (int)(floatval($price) * 100000);
  }

  return (int)$price; // fallback
}

$min_price = $_POST['min_price'];   // "44 Lakh"
$max_price = $_POST['max_price'];   // "1.2 Cr"

$min_price_int = priceToInt($min_price);
$max_price_int = priceToInt($max_price);

///////////////conversion end//////////////////////////////

  $sql = "INSERT INTO `properties`(`project_name`, `price`, `location`, `rera_no`, `size`, `status`,`trending`, `about_project`, `highlights`, `other_key_feature`, `image`, `image_1`, `image_2`, `image_3`, `image_4`, `brochure`, `video_link`, `map`  ,`bigha`,`no_of_units`,`no_of_floors`,`no_of_blocks`, `logo`, `slug`)
    VALUES('$project_name', '$price', '$location', '$rera_no', '$size', '$status','$trend', '$about_project', '$highlights', '$other_key_feature', '$image','$image1','$image2','$image3','$image4', '$brochure', '$video_link','$map','$bigha','$units','$floors','$blocks', '$logo' , '$slug')";

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

<head>
  <meta charset="utf-8">
  <title>CKEditor 5 – Classic editor</title>
  <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <?php include('../components/viewSidebar.php'); ?>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header main-header-dd">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="../index" class="logo">
              <img src="../assets/img/kaiadmin/Ikanhousing-logowhite.svg" alt="navbar brand" class="navbar-brand" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <?php include('../components/viewNavbar.php'); ?>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <h3 class="fw-bold mb-3">Add Property</h3>
            <ul class="breadcrumbs mb-3">
              <li class="nav-home">
                <a href="../index ">
                  <i class="icon-home"></i>
                </a>
              </li>
              <!-- <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="#">Forms</a>
              </li> -->
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="list">Property List</a>
              </li>
            </ul>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <div class="card-title">ADD PROPERTY</div>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-6 ">
                      <div class="row new-f-r">
                        <div class="col-md-12">
                          <form name="PropertyForm" action="" enctype="multipart/form-data" method="POST"
                            class="form-a contactForm new-from-prrr">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Project Name</label>
                                  <input type="text" name="project_name" class="form-control form-control-lg"
                                    placeholder="NAME OF PROJECT" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="Price">Price</label>
                                  <input type="text" name="price" class="form-control form-control-lg"
                                    placeholder="Price OF PROJECT" required>
                                </div>
                              </div>
                              <!-- <div class="col-md-12">
                        <div class="form-group">
                          <label for="Price">Max Price</label>
                          <input type="text" name="max_price" class="form-control form-control-lg" placeholder="Price OF PROJECT" required>
                        </div>
                      </div> -->

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Location</label>
                                  <input type="text" name="location" class="form-control form-control-lg"
                                    placeholder="LOCATION OF PROJECT" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Rera No. / JDA Approved</label>
                                  <input type="text" name="rera_no" class="form-control form-control-lg"
                                    placeholder="RERA No." required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Size</label>
                                  <input type="text" name="size" class="form-control form-control-lg" placeholder="Size"
                                    required>
                                </div>
                              </div>



                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Video Link</label>
                                  <input type="text" name="video_link" class="form-control form-control-lg"
                                    placeholder="Video Link">
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Map</label>
                                  <input type="text" name="map" class="form-control form-control-lg"
                                    placeholder="Location">
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">Bigha</label>
                                  <input type="text" name="bigha" class="form-control form-control-lg"
                                    placeholder="Bigha">
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">No. of Units</label>
                                  <input type="text" name="no_of_units" class="form-control form-control-lg"
                                    placeholder="Total Units">
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">No. of floor</label>
                                  <input type="text" name="no_of_floor" class="form-control form-control-lg"
                                    placeholder="Total Floors">
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="">No. of Blocks</label>
                                  <input type="text" name="no_of_blocks" class="form-control form-control-lg"
                                    placeholder="Total Blocks">
                                </div>
                              </div>


                              <!-- <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Status</label>
                          <input type="text" name="status" class="form-control form-control-lg" placeholder="Status" required>
                        </div>
                      </div> -->

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="status">Status</label>
                                  <select name="status" id="status" class="form-control form-control-lg" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                  </select>
                                </div>
                              </div>

                                <div class="col-md-12">
                                <div class="form-group">
                                  <label for="status">Trending Status</label>
                                  <select name="trending" id="status" class="form-control form-control-lg" required>
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                  </select>
                                </div>
                              </div>

                              <!-- <div class="col-md-12">
                        <div class="form-group">
                          <label for="">Complete Project</label>
                          <input type="text" name="com_property" class="form-control form-control-lg" placeholder="Status" required>
                        </div>
                      </div> -->

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">About Our Project</label>
                                  <textarea name="about_our_project" id="editor"></textarea>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Highlights</label>
                                  <textarea name="highlights" id="editorr"></textarea>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Other Key Features</label>
                                  <textarea name="other_key_feature" id="editorrr"></textarea>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project logo (jpg,jpeg,png)</label>
                                  <input type="file" name="logo" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Builder logo (jpg,jpeg,png)</label>
                                  <input type="file" name="logo" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project Main Image (jpg,jpeg,png)</label>
                                  <input type="file" name="image" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project Image (jpg,jpeg,png)</label>
                                  <input type="file" name="image1" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project Image (jpg,jpeg,png)</label>
                                  <input type="file" name="image2" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project Image (jpg,jpeg,png)</label>
                                  <input type="file" name="image3" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project Image (jpg,jpeg,png)</label>
                                  <input type="file" name="image4" accept=".jpg,.jpeg,.png"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="paragraph">Project Brochure (pdf,doc,docx,xls,xlsx)</label>
                                  <input type="file" name="brochure" accept=".pdf,.doc,.docx,.xls,.xlsx"
                                    class="form-control form-control-lg" required>
                                </div>
                              </div>

                              <div class="col-md-12">
                                <button type="submit" class="btn btn-success">Submit</button>
                                <button class="btn btn-danger">Cancel</button>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
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
      <script>
        ClassicEditor
          .create(document.querySelector('#editorr'))
          .catch(error => {
            console.error(error);
          });
      </script>
      <script>
        ClassicEditor
          .create(document.querySelector('#editorrr'))
          .catch(error => {
            console.error(error);
          });
      </script>
</body>

</html>