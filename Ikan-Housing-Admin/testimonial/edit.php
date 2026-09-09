<?php
include '../../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "Invalid ID."; exit();
}

// Fetch existing data
$query = mysqli_query($con, "SELECT * FROM testimonial WHERE id = $id");
$testimonial = mysqli_fetch_assoc($query);
if (!$testimonial) {
    echo "Testimonial not found."; exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $about = mysqli_real_escape_string($con, $_POST['about_our_testimonial']);
    $status = mysqli_real_escape_string($con, $_POST['status']);
    $slug = mysqli_real_escape_string($con, $_POST['slug']);

    // Image update logic
    $image = $testimonial['image'];
    if (!empty($_FILES['image']['name'])) {
        $image = time() . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], '../../uploads/' . $image);
    }

    $sql = "UPDATE testimonial SET 
                `name` = '$name',
                `desc` = '$about',
                `image` = '$image',
                `status` = '$status',
                `slug` = '$slug'
            WHERE id = $id";

    if (mysqli_query($con, $sql)) {
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
    <meta charset="UTF-8">
    <title>Edit Testimonial</title>
    <script src="https://cdn.ckeditor.com/ckeditor5/12.0.0/classic/ckeditor.js"></script>
</head>
<body>
<div class="wrapper">
    <?php include('../components/viewSidebar.php'); ?>
    <div class="main-panel">
        <?php include('../components/viewNavbar.php'); ?>
        <div class="container">
            <div class="page-inner">
                <div class="page-header">
                    <h3>Edit Testimonial</h3>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="name" value="<?= htmlspecialchars($testimonial['name']) ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Slug</label>
                        <input type="text" name="slug" id="slug" value="<?= htmlspecialchars($testimonial['slug']) ?>" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>About Testimonial</label>
                        <textarea name="about_our_testimonial" id="editor"><?= htmlspecialchars($testimonial['desc']) ?></textarea>
                    </div>

                    <div class="form-group">
                        <label>Image (jpg, jpeg, png)</label>
                        <input type="file" name="image" class="form-control">
                        <?php if ($testimonial['image']): ?>
                            <img src="../../uploads/<?= $testimonial['image'] ?>" width="100" class="mt-2">
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="">Select Status</option>
                            <option value="Active" <?= $testimonial['status'] == 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?= $testimonial['status'] == 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="list" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));

    document.getElementById('name').addEventListener('input', function () {
        let text = this.value;
        let slug = text.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
</body>
</html>
