<?php
include('../components/auth.php');
include '../../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid ID.";
    exit();
}

$query = mysqli_query($con, "SELECT * FROM properties WHERE id = $id");
$property = mysqli_fetch_assoc($query);
if (!$property) {
    echo "Property not found.";
    exit();
}

// Update logic
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $project_name = mysqli_real_escape_string($con, $_POST['project_name']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);
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

    // Optional fields
    $bigha = is_numeric($_POST['bigha']) ? $_POST['bigha'] : 'NULL';
    $no_of_units = is_numeric($_POST['no_of_units']) ? $_POST['no_of_units'] : 'NULL';
    $no_of_floor = is_numeric($_POST['no_of_floor']) ? $_POST['no_of_floor'] : 'NULL';
    $no_of_blocks = is_numeric($_POST['no_of_blocks']) ? $_POST['no_of_blocks'] : 'NULL';

    // File uploads
    function handleUpload($fieldName, $existingFile) {
        if (!empty($_FILES[$fieldName]['name'])) {
            $file = $_FILES[$fieldName]['name'];
            move_uploaded_file($_FILES[$fieldName]['tmp_name'], '../../uploads/' . $file);
            return $file;
        }
        return $existingFile;
    }

    $image = handleUpload('image', $property['image']);
    $image_1 = handleUpload('image1', $property['image_1']);
    $image_2 = handleUpload('image2', $property['image_2']);
    $image_3 = handleUpload('image3', $property['image_3']);
    $image_4 = handleUpload('image4', $property['image_4']);
    $brochure = handleUpload('brochure', $property['brochure']);
    $logo = handleUpload('logo', $property['logo']); 


    $update = "UPDATE properties SET 
        project_name = '$project_name',
        slug = '$slug',
        price = '$price',
        location = '$location',
        rera_no = '$rera_no',
        size = '$size',
        status = '$status',
        trending= '$trend',
        about_project = '$about_project',
        highlights = '$highlights',
        other_key_feature = '$other_key_feature',
        image = '$image',
        image_1 = '$image_1',
        image_2 = '$image_2',
        image_3 = '$image_3',
        image_4 = '$image_4',
        brochure = '$brochure',
        logo='$logo',
        video_link = '$video_link',
        map='$map',
        bigha = $bigha,
        no_of_units = $no_of_units,
        no_of_floors   = $no_of_floor,
        no_of_blocks = $no_of_blocks
        WHERE id = $id";

    if (mysqli_query($con, $update)) {
        header("Location: list");
        exit();
    } else {
        echo "Update failed: " . mysqli_error($con);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<head>
  <meta charset="utf-8">
  <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
</head>
<body>
<?php include('../components/viewSidebar.php'); ?>
<div class="main-panel">
  <?php include('../components/viewNavbar.php'); ?>
  <div class="container">
    <div class="page-inner">
      <div class="page-header">
        <h3>Edit Property</h3>
      </div>
      <form action="" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label>Project Name</label>
    <input type="text" name="project_name" class="form-control" value="<?= htmlspecialchars($property['project_name']) ?>" required>
  </div>

  <div class="form-group">
    <label>Slug</label>
    <input type="text" name="slug" id="slug" class="form-control" value="<?= htmlspecialchars($property['slug']) ?>" required>
  </div>

  <div class="form-group">
    <label>Price</label>
    <input type="text" name="price" class="form-control" value="<?= htmlspecialchars($property['price']) ?>" required>
  </div>

  <div class="form-group">
    <label>Location</label>
    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($property['location']) ?>" required>
  </div>

  <div class="form-group">
    <label>RERA No</label>
    <input type="text" name="rera_no" class="form-control" value="<?= htmlspecialchars($property['rera_no']) ?>" required>
  </div>

  <div class="form-group">
    <label>Size</label>
    <input type="text" name="size" class="form-control" value="<?= htmlspecialchars($property['size']) ?>" required>
  </div>

  <div class="form-group">
    <label>Status</label>
    <select name="status" class="form-control" required>
      <option value="1" <?= $property['status'] == '1' ? 'selected' : '' ?>>Active</option>
      <option value="0" <?= $property['status'] == '0' ? 'selected' : '' ?>>Inactive</option>
    </select>
  </div>

    <div class="form-group">
    <label>Trending Project</label>
    <select name="trend" class="form-control" required>
      <option value="1" <?= $property['trending'] == '1' ? 'selected' : '' ?>>Active</option>
      <option value="0" <?= $property['trending'] == '0' ? 'selected' : '' ?>>Inactive</option>
    </select>
  </div>

  <div class="form-group">
    <label>Video Link</label>
    <input type="text" name="video_link" class="form-control" value="<?= htmlspecialchars($property['video_link']) ?>">
  </div>

   <div class="form-group">
    <label>Map</label>
    <input type="text" name="map" class="form-control" value="<?= htmlspecialchars($property['map']) ?>">
  </div>

  <!-- Optional Fields -->
  <div class="form-group">
    <label>Bigha</label>
    <input type="text" name="bigha" class="form-control" value="<?= htmlspecialchars($property['bigha']?? '') ?>">
  </div>

  <div class="form-group">
    <label>No. of Units</label>
    <input type="text" name="no_of_units" class="form-control" value="<?= htmlspecialchars($property['no_of_units']?? '') ?>">
  </div>

  <div class="form-group">
    <label>No. of Floor</label>
    <input type="text" name="no_of_floor" class="form-control" value="<?= htmlspecialchars($property['no_of_floors']?? '') ?>">
  </div>

  <div class="form-group">
    <label>No. of Blocks</label>
    <input type="text" name="no_of_blocks" class="form-control" value="<?= htmlspecialchars($property['no_of_blocks']?? '') ?>">
  </div>

  <!-- CKEditor fields -->
  <div class="form-group">
    <label>About Our Project</label>
    <textarea name="about_our_project" id="editor"><?= htmlspecialchars($property['about_project']) ?></textarea>
  </div>

  <div class="form-group">
    <label>Highlights</label>
    <textarea name="highlights" id="editorr"><?= htmlspecialchars($property['highlights']) ?></textarea>
  </div>

  <div class="form-group">
    <label>Other Key Feature</label>
    <textarea name="other_key_feature" id="editorrr"><?= htmlspecialchars($property['other_key_feature']) ?></textarea>
  </div>

  <!-- File Inputs -->
  <div class="form-group">
    <label>Project Main Image</label>
    <input type="file" name="image" class="form-control">
    <?php if ($property['image']): ?>
      <img src="../../uploads/<?= $property['image'] ?>" width="100">
    <?php endif; ?>
  </div>

  <?php
    for ($i = 1; $i <= 4; $i++) {
        $imgField = "image_$i";
  ?>
  

  <div class="form-group">
    <label>Project Image <?= $i ?></label>
    <input type="file" name="image<?= $i ?>" class="form-control">
    <?php if ($property[$imgField]): ?>
      <img src="../../uploads/<?= $property[$imgField] ?>" width="100">
    <?php endif; ?>
  </div>
  <?php } ?>

  <div class="form-group">
    <label>Brochure</label>
    <input type="file" name="brochure" class="form-control">
    <?php if ($property['brochure']): ?>
      <a href="../../uploads/<?= $property['brochure'] ?>" target="_blank">Download Existing</a>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label>Project logo</label>
    <input type="file" name="logo" class="form-control">
    <?php if ($property['logo']): ?>
      <a href="../../uploads/<?= $property['logo'] ?>" target="_blank">Download Existing</a>
    <?php endif; ?>
  </div>

  <div class="form-group">
    <label>Builder logo</label>
    <input type="file" name="logo" class="form-control">
    <?php if ($property['logo']): ?>  
      <a href="../../uploads/<?= $property['builder_logo'] ?>" target="_blank">Download Existing</a>
    <?php endif; ?>
  </div>

  <button type="submit" class="btn btn-primary">Update</button>
  <a href="list" class="btn btn-secondary">Cancel</a>
</form>

    </div>
  </div>
</div>

<script>
  // CKEditor
  ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
  ClassicEditor.create(document.querySelector('#editorr')).catch(error => console.error(error));
  ClassicEditor.create(document.querySelector('#editorrr')).catch(error => console.error(error));

  // Auto slug generator
  document.getElementById('project_name').addEventListener('input', function () {
    let name = this.value;
    let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    document.getElementById('slug').value = slug;
  });
</script>
</body>
</html>

