<?php
include('../components/auth.php');
include('../../config.php');

// ✅ Slug Generate
function generateSlug($name, $con)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name), '-'));
    $base = $slug;
    $i = 1;
    while (mysqli_num_rows(mysqli_query($con, "SELECT id FROM new_property WHERE slug='$slug'")) > 0) {
        $slug = $base . '-' . $i++;
    }
    return $slug;
}

// ✅ File Upload Helper (WebP Support + Watermark + Direct Fallback)
function uploadFile($file, $dest = "../../uploads/", $allowed = ["jpg", "jpeg", "png", "webp", "pdf", "jfif", "avif", "gif"], $maxMB = 10)
{
    if (!isset($file['error']) || $file['error'] !== UPLOAD_ERR_OK) return "";
    $ext = strtolower(pathinfo($file['name'] ?? '', PATHINFO_EXTENSION));
    if ($ext === 'jfif') $ext = 'jpg';
    if (!in_array($ext, $allowed)) return "";
    if (($file['size'] ?? 0) > $maxMB * 1024 * 1024 || ($file['size'] ?? 0) <= 0) return "";

    $dest = rtrim($dest, '/') . '/';
    if (!is_dir($dest)) {
        @mkdir($dest, 0777, true);
    }

    $baseName = time() . rand(1000, 9999);

    if ($ext === 'pdf') {
        $finalName = $baseName . ".pdf";
        return @move_uploaded_file($file['tmp_name'], $dest . $finalName) ? $finalName : "";
    }

    $imageProcessed = false;
    $finalName = "";

    // Attempt GD watermark/compression if GD is available
    if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
        $content = @file_get_contents($file['tmp_name']);
        if ($content !== false) {
            $src = @imagecreatefromstring($content);

            if (!$src) {
                if (($ext === 'jpg' || $ext === 'jpeg') && function_exists('imagecreatefromjpeg')) {
                    $src = @imagecreatefromjpeg($file['tmp_name']);
                } elseif ($ext === 'png' && function_exists('imagecreatefrompng')) {
                    $src = @imagecreatefrompng($file['tmp_name']);
                } elseif ($ext === 'webp' && function_exists('imagecreatefromwebp')) {
                    $src = @imagecreatefromwebp($file['tmp_name']);
                } elseif ($ext === 'gif' && function_exists('imagecreatefromgif')) {
                    $src = @imagecreatefromgif($file['tmp_name']);
                }
            }

            if ($src) {
                $watermark_path = "../assets/img/icon-2.png"; 
                if (file_exists($watermark_path) && function_exists('imagecreatefrompng')) {
                    $watermark = @imagecreatefrompng($watermark_path);
                    if ($watermark) {
                        $src_w = (int)imagesx($src);
                        $src_h = (int)imagesy($src);
                        $wm_w = (int)imagesx($watermark);
                        $wm_h = (int)imagesy($watermark);

                        if ($src_w > 80 && $src_h > 80 && $wm_w > 0 && $wm_h > 0) {
                            $target_wm_w = max(1, (int)($src_w * 0.18));
                            $target_wm_h = max(1, (int)($wm_h * ($target_wm_w / $wm_w)));

                            $final_wm = imagecreatetruecolor($target_wm_w, $target_wm_h);
                            imagealphablending($final_wm, false);
                            imagesavealpha($final_wm, true);
                            imagecopyresampled($final_wm, $watermark, 0, 0, 0, 0, $target_wm_w, $target_wm_h, $wm_w, $wm_h);

                            // ✅ Apply 30% "Ghost" Opacity to Watermark
                            for ($x = 0; $x < $target_wm_w; $x++) {
                                for ($y = 0; $y < $target_wm_h; $y++) {
                                    $color = imagecolorat($final_wm, $x, $y);
                                    $alpha = ($color >> 24) & 0xFF; 
                                    $newAlpha = 127 - ((127 - $alpha) * 0.3); 
                                    $newColor = ($color & 0xFFFFFF) | ((int)$newAlpha << 24);
                                    imagesetpixel($final_wm, $x, $y, $newColor);
                                }
                            }

                            $dest_x = max(5, (int)($src_w - $target_wm_w - 40));
                            $dest_y = max(5, (int)($src_h - $target_wm_h - 40));
                            imagealphablending($src, true);
                            imagecopy($src, $final_wm, $dest_x, $dest_y, 0, 0, $target_wm_w, $target_wm_h);
                            imagedestroy($final_wm);
                        }
                        imagedestroy($watermark);
                    }
                }

                if (function_exists('imagewebp')) {
                    $finalName = $baseName . ".webp";
                    if (@imagewebp($src, $dest . $finalName, 85)) {
                        $imageProcessed = true;
                    }
                } elseif (function_exists('imagejpeg')) {
                    $finalName = $baseName . ".jpg";
                    if (@imagejpeg($src, $dest . $finalName, 90)) {
                        $imageProcessed = true;
                    }
                }
                imagedestroy($src);
            }
        }
    }

    if ($imageProcessed && !empty($finalName) && file_exists($dest . $finalName)) {
        return $finalName;
    }

    // ✅ Graceful Direct Save Fallback: Never reject a valid image if GD cannot decode/re-encode it
    $safeExt = in_array($ext, ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"]) ? ($ext === 'jfif' ? 'jpg' : $ext) : "jpg";
    $fallbackName = $baseName . "." . $safeExt;
    if (@move_uploaded_file($file['tmp_name'], $dest . $fallbackName)) {
        return $fallbackName;
    }

    return "";
}

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inputs
    $propertyname = mysqli_real_escape_string($con, $_POST['project_name']);
    $buildername = mysqli_real_escape_string($con, $_POST['buildername']);
    $minprice = $_POST['min-price'] ?? '';
    $maxprice = $_POST['max-price'] ?? '';
    $location = $_POST['location'] ?? '';
    $bhk = $_POST['bhk'] ?? '';
    $video_link = $_POST['video_link'] ?? '';
    $bigha = $_POST['bigha'] ?? '';
    $unit = $_POST['units'] ?? '';
    $floor = $_POST['floor'] ?? '';
    $block = $_POST['blocks'] ?? '';
    $status = $_POST['status'] ?? '';
    $trend = $_POST['trending'] ?? '';
    $project_type = $_POST['project_type'] ?? '';
    $launch = $_POST['launch_date'] ?? '';
    $possession = $_POST['possession_date'] ?? '';
    $furnish = $_POST['furnish'] ?? '';
    $construct = $_POST['construct'] ?? '';
    $map = $_POST['map'] ?? '';
    $highlight = $_POST['highlights'] ?? '';
    $other_key = $_POST['other_key_feature'] ?? '';
    $slug = generateSlug($propertyname, $con);

    // ✅ Required Validation
    if (!$propertyname) $errors[] = "Project name is required.";
    if (!$location) $errors[] = "Location is required.";
    if (!$bhk) $errors[] = "BHK is required.";
    if (!$buildername) $errors[] = "Builder name is required.";

    // ✅ RERA / JDA
    if (empty($_POST['rera_type'])) {
        $errors[] = "Please select RERA or JDA option.";
    } else {
        $rera_no = ($_POST['rera_type'] == "rera")
            ? ($_POST['rera_no'] ?? $errors[] = "RERA Number required.")
            : "JDA Approved";
    }

    // ✅ Area validation
    $carpet = floatval($bigha);
    $builtup = floatval($unit);
    $super = floatval($floor);

    // ✅ Uploads
    $main_image = "";
    if (isset($_FILES['main_image']) && $_FILES['main_image']['error'] == UPLOAD_ERR_OK) {
        $main_image = uploadFile($_FILES['main_image'], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
        if (!$main_image) $errors[] = "Main image upload failed. Please ensure file is a valid image (JPG, PNG, WebP) under 10MB.";
    } elseif (empty($errors)) {
        // Only require main image if we're not already displaying errors
        $errors[] = "Main image is required.";
    }

    $image1 = uploadFile($_FILES['image1'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    $image2 = uploadFile($_FILES['image2'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    $image3 = uploadFile($_FILES['image3'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    $image4 = uploadFile($_FILES['image4'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    
    $pdf = "";
    if ($_FILES['brochure']['error'] == 0) {
        $pdf = uploadFile($_FILES['brochure'], "../../uploads/", ["pdf"], 200);
        if (!$pdf) $errors[] = "Brochure (PDF) upload failed. Check file size (Max 200MB).";
    } elseif ($_FILES['brochure']['error'] != 4) { // 4 = No file uploaded
        $errors[] = "Brochure upload error code: " . $_FILES['brochure']['error'];
    }

    // ✅ Stop if error (Removing exit to show errors in UI)
    if (empty($errors)) {
        function priceToInt($price) {
            $price = strtolower(trim($price));
            $price = str_replace([' ', ','], '', $price);
            if (strpos($price, 'cr') !== false) return (int)(floatval($price) * 10000000);
            if (strpos($price, 'lac') !== false || strpos($price, 'lakh') !== false) return (int)(floatval($price) * 100000);
            return (int)$price;
        }

        $min_price_int = priceToInt($minprice);
        $max_price_int = priceToInt($maxprice);

        // ✅ Insert Query
        $sql = "INSERT INTO new_property 
        (project_name,builder_name,max_price_int,min_price_int,min_price,max_price,location,rera_no,bhk,video_link,map,highlight,other_key_feature,
         bigha,unit,floor,block,status,trending,project_type,launch_date,possession_date,furnish_type,construct_Status,
         main_image,image_1,image_2,image_3,image_4,brochure,slug) 
        VALUES 
        ('$propertyname','$buildername','$max_price_int','$min_price_int', '$minprice','$maxprice','$location','$rera_no','$bhk','$video_link','$map',
        '$highlight','$other_key','$bigha','$unit','$floor','$block','$status','$trend','$project_type','$launch',
        '$possession','$furnish','$construct','$main_image','$image1','$image2','$image3','$image4','$pdf','$slug')";

        if (mysqli_query($con, $sql)) {
            $property_id = mysqli_insert_id($con);

            // ✅ Multiple images
            if (!empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $k => $tmp) {
                    if (empty($_FILES['images']['name'][$k])) continue;
                    $fileData = [
                        'name' => $_FILES['images']['name'][$k],
                        'tmp_name' => $tmp,
                        'error' => $_FILES['images']['error'][$k],
                        'size' => $_FILES['images']['size'][$k]
                    ];
                    $img = uploadFile($fileData, "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
                    if ($img) mysqli_query($con, "INSERT INTO property_img (property_id,image) VALUES ('$property_id','$img')");
                }
            }

            // ✅ Amenities
            if (!empty($_POST['amenities'])) {
                foreach ($_POST['amenities'] as $a) mysqli_query($con, "INSERT INTO property_amenities (property_id, amenity_id) VALUES ('$property_id','$a')");
            }

            // ✅ Sub Categories
            if (!empty($_POST['subcat'])) {
                $cat_id = mysqli_real_escape_string($con, $_POST['cat_name']);
                foreach ($_POST['subcat'] as $s) mysqli_query($con, "INSERT INTO property_subcat (property_id,category_id,subcat_id) VALUES ('$property_id','$cat_id','$s')");
            }

            // ✅ Category
            if (!empty($_POST['cat_name'])) {
                $cat = mysqli_real_escape_string($con, $_POST['cat_name']);
                mysqli_query($con, "INSERT INTO property_category (property_id,category_id) VALUES ('$property_id','$cat')");
            }

            // ✅ Floor Plan (Verbose Error Reporting & 20MB Limit)
            if (!empty($_POST['subcat'])) {
                foreach ($_POST['subcat'] as $subcat_item) {
                    $subcat_id = (int)$subcat_item;
                    if (!empty($_FILES['images_floor']['name'][$subcat_id])) {
                        $countFiles = count($_FILES['images_floor']['name'][$subcat_id]);
                        for ($i = 0; $i < $countFiles; $i++) {
                            $errCode = $_FILES['images_floor']['error'][$subcat_id][$i];
                            if ($errCode === 0) {
                                $fileSize = $_FILES['images_floor']['size'][$subcat_id][$i];
                                if ($fileSize > 20 * 1024 * 1024) {
                                    $errors[] = "Floor Plan Error: File too large (Max 20MB) for Subcat ID: $subcat_id";
                                    continue;
                                }

                                $fileData = [
                                    'name' => $_FILES['images_floor']['name'][$subcat_id][$i],
                                    'tmp_name' => $_FILES['images_floor']['tmp_name'][$subcat_id][$i],
                                    'error' => $errCode,
                                    'size' => $fileSize
                                ];
                                
                                $fileName = uploadFile($fileData, "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 20);
                                if ($fileName) {
                                    $imgNameEsc = mysqli_real_escape_string($con, $fileName);
                                    $floorSql = "INSERT INTO floor_plane (image, property_id, subcat_id) VALUES ('$imgNameEsc', $property_id, $subcat_id)";
                                    if (!mysqli_query($con, $floorSql)) {
                                        $errors[] = "Floor Plan DB Error: " . mysqli_error($con) . " (ID: $subcat_id)";
                                    }
                                } else {
                                    $errors[] = "Floor Plan Processing Error: Failed to process image for Subcat ID: $subcat_id. Check format (JPG/PNG/WebP).";
                                }
                            } elseif ($errCode !== 4) {
                                $errors[] = "Floor Plan Upload Error (Code $errCode) for Subcat ID: $subcat_id";
                            }
                        }
                    }
                }
            }
            header("Location: new_property");
            exit;
        } else {
            $errors[] = "Database Error: " . mysqli_error($con);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('../components/viewHead.php'); ?>
<style>
    /* ✅ Fix for CKEditor font visibility and spacing */
    .ck-editor__editable { 
        min-height: 250px !important; 
        color: #2d0a1c !important; 
        background: #fff !important; 
    }
    .ck-content { 
        color: #2d0a1c !important; 
        font-family: 'Outfit', sans-serif !important;
    }
    .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
        border-color: #eee !important;
    }

    /* 💎 Pricing Visualizer Styles */
    .price-display-box {
        margin-top: 1.5rem;
        padding: 20px;
        background: #fff5f9; /* var(--light-pink) */
        border: 2px dashed #c02a7c33;
        border-radius: 16px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .price-display-box:hover {
        background: #fff0f6;
        border-color: #c02a7c;
    }
    .price-label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #8e6f7e; /* var(--text-muted) */
        margin-bottom: 5px;
    }
    .price-indicator {
        display: block;
        font-size: 24px;
        font-weight: 800;
        color: #c02a7c; /* var(--primary-color) */
    }
</style>
<body>
    <div class="wrapper">
        <?php include('../components/viewSidebar.php'); ?>

        <div class="main-panel">
            <div class="main-header">
                <?php include('../components/viewNavbar.php'); ?>
            </div>

            <div class="container text-main">
                <div class="page-inner">

                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger shadow-sm border-0 mb-4" data-aos="fade-down">
                            <h5 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Form Submission Error</h5>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success shadow-sm border-0 mb-4" data-aos="fade-down">
                            <h5 class="fw-bold mb-0"><i class="fas fa-check-circle me-2"></i> <?= $success ?></h5>
                        </div>
                    <?php endif; ?>

                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2">Create New Property Listing</h3>
                            <ul class="breadcrumbs p-0 bg-transparent">
                                <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
                                <li class="separator"><i class="fas fa-chevron-right"></i></li>
                                <li class="nav-item">Add Property</li>
                            </ul>
                        </div>
                        <a href="new_property" class="btn btn-outline-primary btn-round">
                            <i class="fas fa-arrow-left me-2"></i>Back to Inventory
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form name="PropertyForm" id="PropertyForm" action="addproperty.php" enctype="multipart/form-data" method="POST" novalidate onsubmit="return validateForm()">
                                <div class="card card-round border-0 shadow-sm overflow-hidden">
                                    <div class="card-header bg-white p-0">
                                        <ul class="nav nav-pills nav-pills-premium mb-0" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="btn-tab-identity" data-bs-toggle="pill" data-bs-target="#tab-identity" type="button"><i class="fas fa-id-card me-2"></i>1. Project Identity</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="btn-tab-specs" data-bs-toggle="pill" data-bs-target="#tab-specs" type="button"><i class="fas fa-ruler-combined me-2"></i>2. Architecture</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="btn-tab-pricing" data-bs-toggle="pill" data-bs-target="#tab-pricing" type="button"><i class="fas fa-tag me-2"></i>3. Commercials</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="btn-tab-media" data-bs-toggle="pill" data-bs-target="#tab-media" type="button"><i class="fas fa-images me-2"></i>4. Media Gallery</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="btn-tab-ecosystem" data-bs-toggle="pill" data-bs-target="#tab-ecosystem" type="button"><i class="fas fa-leaf me-2"></i>5. Ecosystem</button>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="card-body p-4 bg-light">
                                        <div class="tab-content" id="pills-tabContent">
                                            <!-- Step 1: Identity -->
                                            <div class="tab-pane fade show active" id="tab-identity">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Project Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="project_name" class="form-control form-control-lg bg-white" placeholder="e.g. Skyline Heights" value="<?= htmlspecialchars($_POST['project_name'] ?? '') ?>" required>
                                                            <div class="invalid-feedback">Please enter the project name.</div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Builder Name <span class="text-danger">*</span></label>
                                                            <select name="buildername" class="form-select form-select-lg bg-white" required>
                                                                <option value="" disabled selected>Select Builder</option>
                                                                <?php
                                                                $builderRes = mysqli_query($con, "SELECT id, builder_name FROM builder WHERE status = 1 ORDER BY builder_name ASC");
                                                                while ($b = mysqli_fetch_assoc($builderRes)) {
                                                                    $selected = (isset($_POST['buildername']) && $_POST['buildername'] == $b['id']) ? 'selected' : '';
                                                                    echo "<option value='{$b['id']}' $selected>{$b['builder_name']}</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a builder.</div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Project Category <span class="text-danger">*</span></label>
                                                            <select name="cat_name" id="category" class="form-select form-select-lg bg-white" required>
                                                                <option value="" disabled selected>Select Category</option>
                                                                <?php
                                                                $catRes = mysqli_query($con, "SELECT id, category_name FROM category WHERE status = 1");
                                                                while ($c = mysqli_fetch_assoc($catRes)) {
                                                                    $selected = (isset($_POST['cat_name']) && $_POST['cat_name'] == $c['id']) ? 'selected' : '';
                                                                    echo "<option value='{$c['id']}' $selected>{$c['category_name']}</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <div class="invalid-feedback">Please select a category.</div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold text-muted small uppercase">Listing Status</label>
                                                                <select name="status" class="form-select bg-white" required>
                                                                    <option value="1" <?= (isset($_POST['status']) && $_POST['status'] == '1') ? 'selected' : '' ?>>Active</option>
                                                                    <option value="0" <?= (isset($_POST['status']) && $_POST['status'] == '0') ? 'selected' : '' ?>>Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold text-muted small uppercase">Trending Now</label>
                                                                <select name="trending" class="form-select bg-white">
                                                                    <option value="0" <?= (isset($_POST['trending']) && $_POST['trending'] == '0') ? 'selected' : '' ?>>No</option>
                                                                    <option value="1" <?= (isset($_POST['trending']) && $_POST['trending'] == '1') ? 'selected' : '' ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold small">Launch Date</label>
                                                                <input type="date" name="launch_date" class="form-control bg-white">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold small">Possession Date</label>
                                                                <input type="date" name="possession_date" class="form-control bg-white" value="<?= htmlspecialchars($_POST['possession_date'] ?? '') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label class="fw-bold">Project Status Type <span class="text-danger">*</span></label>
                                                            <select name="project_type" class="form-select bg-white" required>
                                                                <option value="0" <?= (isset($_POST['project_type']) && $_POST['project_type'] == '0') ? 'selected' : '' ?>>Ongoing / Under Construction</option>
                                                                <option value="1" <?= (isset($_POST['project_type']) && $_POST['project_type'] == '1') ? 'selected' : '' ?>>Completed / Ready to Move</option>
                                                            </select>
                                                            <div class="invalid-feedback">Please select the project status type.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 2: Architecture -->
                                            <div class="tab-pane fade" id="tab-specs">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Primary Location <span class="text-danger">*</span></label>
                                                            <input type="text" name="location" class="form-control bg-white" placeholder="e.g. Vaishali Nagar, Jaipur" value="<?= htmlspecialchars($_POST['location'] ?? '') ?>" required>
                                                            <div class="invalid-feedback">Please enter the location.</div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Google Map Iframe Link</label>
                                                            <input type="text" name="map" class="form-control bg-white" placeholder="Paste embed link here" value="<?= htmlspecialchars($_POST['map'] ?? '') ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Configuration (BHK) <span class="text-danger">*</span></label>
                                                            <input type="text" name="bhk" class="form-control bg-white" placeholder="e.g. 2, 3 & 4 BHK" value="<?= htmlspecialchars($_POST['bhk'] ?? '') ?>" required>
                                                            <div class="invalid-feedback">Please enter BHK details.</div>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Total Blocks / Towers</label>
                                                            <input type="text" name="blocks" class="form-control bg-white" placeholder="e.g. 5 Towers" value="<?= htmlspecialchars($_POST['blocks'] ?? '') ?>">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="fw-bold"><i class="fas fa-layer-group me-2 text-primary"></i>Sub-Categories & Floor Plans</label>
                                                            <div id="subcat-container" class="border rounded bg-white p-3" style="min-height: 100px;">
                                                                <p class="text-muted small mb-0">Please select a category first to load sub-categories.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 p-4 bg-white rounded border dash-border text-center">
                                                        <h5 class="fw-bold mb-4">Area Specifications</h5>
                                                        <div class="row g-3">
                                                            <div class="col-4">
                                                                <label class="small fw-bold">Carpet (sqft)</label>
                                                                <input type="text" name="bigha" class="form-control text-center" value="<?= htmlspecialchars($_POST['bigha'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="small fw-bold">Built-up (sqft)</label>
                                                                <input type="text" name="units" class="form-control text-center" value="<?= htmlspecialchars($_POST['units'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="small fw-bold">Super (sqft)</label>
                                                                <input type="text" name="floor" class="form-control text-center" value="<?= htmlspecialchars($_POST['floor'] ?? '') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label class="fw-bold small text-muted">Video Walkthrough (YouTube Link)</label>
                                                            <input type="text" name="video_link" class="form-control bg-light" placeholder="https://youtube.com/..." value="<?= htmlspecialchars($_POST['video_link'] ?? '') ?>">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 3: Pricing -->
                                            <div class="tab-pane fade" id="tab-pricing">
                                                <div class="row g-4 align-items-center">
                                                    <div class="col-md-7">
                                                        <div class="row g-3">
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="fw-bold">Minimum Price <span class="text-danger">*</span></label>
                                                                    <input type="text" name="min-price" id="minPriceInput" class="form-control form-control-lg bg-white" placeholder="e.g. 45 Lakh" value="<?= htmlspecialchars($_POST['min-price'] ?? '') ?>" required>
                                                                    <div class="invalid-feedback">Please enter the minimum price.</div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="fw-bold">Maximum Price</label>
                                                                    <input type="text" name="max-price" id="maxPriceInput" class="form-control form-control-lg bg-white" placeholder="e.g. 1.2 Cr" value="<?= htmlspecialchars($_POST['max-price'] ?? '') ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="price-display-box">
                                                            <span class="price-label">Project Valuation Range</span>
                                                            <span id="priceVisualizer" class="price-indicator">₹ 0 - ₹ 0</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="p-4 bg-white rounded shadow-sm border">
                                                            <div class="mb-4">
                                                                <label class="fw-bold mb-2">Legal Compliance <span class="text-danger">*</span></label>
                                                                <select name="rera_type" id="rera_type" class="form-select mb-2" required>
                                                                    <option value="">Select Compliance</option>
                                                                    <option value="rera" <?= (isset($_POST['rera_type']) && $_POST['rera_type'] == 'rera') ? 'selected' : '' ?>>RERA Number</option>
                                                                    <option value="jda" <?= (isset($_POST['rera_type']) && $_POST['rera_type'] == 'jda') ? 'selected' : '' ?>>JDA Approved</option>
                                                                </select>
                                                                <div class="invalid-feedback">Please select compliance type.</div>
                                                                <input type="text" name="rera_no" id="rera_no" class="form-control" placeholder="Enter Registration No." value="<?= htmlspecialchars($_POST['rera_no'] ?? '') ?>">
                                                                <div class="invalid-feedback mt-1" id="rera_no_error">RERA number is required.</div>
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Furnishing</label>
                                                                    <select name="furnish" class="form-select">
                                                                        <option value="2" <?= (isset($_POST['furnish']) && $_POST['furnish'] == '2') ? 'selected' : '' ?>>Unfurnished</option>
                                                                        <option value="1" <?= (isset($_POST['furnish']) && $_POST['furnish'] == '1') ? 'selected' : '' ?>>Semi furnished</option>
                                                                        <option value="0" <?= (isset($_POST['furnish']) && $_POST['furnish'] == '0') ? 'selected' : '' ?>>Fully furnished</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Construction Status</label>
                                                                    <select name="construct" class="form-select">
                                                                        <option value="1" <?= (isset($_POST['construct']) && $_POST['construct'] == '1') ? 'selected' : '' ?>>Under Construction</option>
                                                                        <option value="0" <?= (isset($_POST['construct']) && $_POST['construct'] == '0') ? 'selected' : '' ?>>Ready to move</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 4: Media Gallery -->
                                            <div class="tab-pane fade" id="tab-media">
                                                <div class="row g-4">
                                                    <div class="col-md-3">
                                                        <div class="image-upload-wrapper mb-3" style="height: 250px;">
                                                            <img id="prev-main" src="../assets/img/placeholder-house.webp" class="w-100 h-100 object-fit-cover">
                                                            <div class="preview-overlay">MAIN COVER IMAGE <span class="text-danger">*</span></div>
                                                        </div>
                                                        <input type="file" name="main_image" id="main_image" class="form-control" accept="image/*" onchange="previewImg(this, 'prev-main')" required>
                                                        <div class="invalid-feedback">Main image is mandatory.</div>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row g-2 mb-3">
                                                            <?php for($i=1; $i<=4; $i++): ?>
                                                            <div class="col-md-3">
                                                                <div class="image-upload-wrapper mb-2" style="height: 120px;">
                                                                    <img id="prev-<?=$i?>" src="../assets/img/placeholder-house.webp" class="w-100 h-100 object-fit-cover">
                                                                </div>
                                                                <input type="file" name="image<?=$i?>" class="form-control form-control-sm" accept="image/*" onchange="previewImg(this, 'prev-<?=$i?>')">
                                                            </div>
                                                            <?php endfor; ?>
                                                        </div>
                                                        <div class="p-4 bg-white rounded border">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <label class="fw-bold"><i class="fas fa-file-pdf me-2 text-danger"></i>Project Brochure (PDF) <span class="text-danger">*</span></label>
                                                                    <input type="file" name="brochure" id="brochure" class="form-control" accept=".pdf" required>
                                                                    <div class="invalid-feedback">PDF brochure is required.</div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="fw-bold">Bulk Gallery Upload</label>
                                                                    <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 5: Ecosystem -->
                                            <div class="tab-pane fade" id="tab-ecosystem">
                                                <div class="row g-4">
                                                    <div class="col-md-12">
                                                        <div class="card card-round border shadow-none bg-white p-3 mb-4">
                                                            <h6 class="fw-bold mb-3"><i class="fas fa-spa me-2 text-success"></i>Select Amenities & Features</h6>
                                                            <div class="row g-2" style="max-height: 200px; overflow-y: auto;">
                                                                <?php
                                                                $amenRes = mysqli_query($con, "SELECT * FROM amenity WHERE status = 1");
                                                                while ($a = mysqli_fetch_assoc($amenRes)): 
                                                                    $checked = (isset($_POST['amenities']) && in_array($a['id'], $_POST['amenities'])) ? 'checked' : '';
                                                                ?>
                                                                <div class="col-md-3">
                                                                    <div class="form-check p-0">
                                                                        <input class="btn-check" type="checkbox" name="amenities[]" value="<?=$a['id']?>" id="amen-<?=$a['id']?>" <?=$checked?>>
                                                                        <label class="btn btn-outline-secondary btn-sm w-100 text-start py-2" for="amen-<?=$a['id']?>">
                                                                            <i class="fas fa-check-circle me-1 opacity-50"></i> <?=$a['name']?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <?php endwhile; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                        <div class="form-group p-0">
                                            <label class="fw-bold mb-2">Location Advantage & Highlights</label>
                                            <textarea name="highlights" id="editor1"><?= htmlspecialchars($_POST['highlights'] ?? '') ?></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group p-0">
                                            <label class="fw-bold mb-2">About Property Details</label>
                                            <textarea name="other_key_feature" id="editor2"><?= htmlspecialchars($_POST['other_key_feature'] ?? '') ?></textarea>
                                        </div>
                                    </div>                                                     </div>
                                                    </div>
                                                </div>
                                                <div class="mt-4 text-center">
                                                    <button type="submit" id="btn-submit" class="btn btn-primary btn-round px-5 py-3 shadow">
                                                        <i class="fas fa-plus-circle me-2"></i>PUBLISH PROPERTY LISTING
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include('../components/viewFooter.php'); ?>
        </div>
    </div>

    <!-- Sub-category handling (kept for internal logic) -->
    <div id="subcat-fields-container" style="display:none;"></div>

    <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
    <script>
        // CKEditor initialization
        ClassicEditor.create(document.querySelector('#editor1')).catch(err => console.error(err));
        ClassicEditor.create(document.querySelector('#editor2')).catch(err => console.error(err));
        
        // Initialize AOS
        AOS.init({
            duration: 800,
            on: 'ease-in-out',
            once: true
        });

        // ✅ RERA Toggle logic with validation clearing
        document.getElementById('rera_type').addEventListener('change', function() {
            const reraNo = document.getElementById('rera_no');
            if(this.value === 'rera'){
                reraNo.style.display = 'block';
                reraNo.setAttribute('required', 'true');
            } else {
                reraNo.style.display = 'none';
                reraNo.removeAttribute('required');
                reraNo.classList.remove('is-invalid');
                document.getElementById('rera_no_error').style.display = 'none';
            }
        });

        // Price Intelligence
        function formatPrice(val) {
            if(!val) return '₹ 0';
            return '₹ ' + val;
        }
        function updateVisualizer() {
            const min = document.getElementById('minPriceInput').value;
            const max = document.getElementById('maxPriceInput').value;
            document.getElementById('priceVisualizer').textContent = `${formatPrice(min)} - ${formatPrice(max)}`;
        }
        document.getElementById('minPriceInput').addEventListener('input', updateVisualizer);
        document.getElementById('maxPriceInput').addEventListener('input', updateVisualizer);

        // ✅ Validation Logic
        function validateForm() {
            const form = document.getElementById('PropertyForm');
            let isValid = true;
            let firstInvalidTab = null;

            // Clear previous highlighting
            document.querySelectorAll('.nav-link').forEach(btn => btn.style.borderBottom = "");

            // 1. Native Bootstrap Validation Loop
            const inputs = form.querySelectorAll('input[required], select[required], textarea[required]');
            
            inputs.forEach(input => {
                if (!input.value.trim() && input.type !== 'file') {
                    showError(input);
                    isValid = false;
                    markTabError(input);
                } else if (input.type === 'file' && !input.files.length) {
                    showError(input);
                    isValid = false;
                    markTabError(input);
                } else {
                    hideError(input);
                }
            });

            // 2. Special Check for RERA
            const reraType = document.getElementById('rera_type').value;
            const reraNo = document.getElementById('rera_no');
            if (reraType === 'rera' && !reraNo.value.trim()) {
                reraNo.classList.add('is-invalid');
                document.getElementById('rera_no_error').style.display = 'block';
                isValid = false;
                markTabError(reraNo);
            }

            if (!isValid) {
                // Focus first error tab
                const tabsWithErrors = [];
                document.querySelectorAll('.nav-link').forEach(btn => {
                    if(btn.style.borderBottom.includes("red")) {
                        tabsWithErrors.push(btn);
                    }
                });

                if(tabsWithErrors.length > 0) {
                    const firstTab = new bootstrap.Tab(tabsWithErrors[0]);
                    firstTab.show();
                    
                    swal({
                        title: "Oops...",
                        text: "Please fill all mandatory fields marked with *",
                        icon: "error",
                        buttons: {
                            confirm: {
                                className: "btn btn-danger"
                            }
                        }
                    });
                }
                return false;
            }

            return true;
        }

        function showError(el) {
            el.classList.add('is-invalid');
        }

        function hideError(el) {
            el.classList.remove('is-invalid');
        }

        function markTabError(el) {
            const pane = el.closest('.tab-pane');
            if (pane) {
                const tabId = pane.id;
                const tabBtn = document.querySelector(`[data-bs-target="#${tabId}"]`);
                if (tabBtn) tabBtn.style.borderBottom = "3px solid red";
            }
        }

        // ✅ Floor Plan & Sub-Category Intelligence
        const categorySelect = document.getElementById('category');
        const subcatContainer = document.getElementById('subcat-container');

        categorySelect.addEventListener('change', function() {
            const catId = this.value;
            if(!catId) return;

            subcatContainer.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>';

            fetch(`get_subcategories.php?cat_id=${catId}`)
                .then(response => response.json())
                .then(data => {
                    if(data.success && data.data.length > 0) {
                        subcatContainer.innerHTML = '';
                        data.data.forEach(sub => {
                            const subRow = document.createElement('div');
                            subRow.className = 'subcat-item mb-3 p-2 border-bottom';
                            subRow.innerHTML = `
                                <div class="form-check mb-2">
                                    <input class="form-check-input subcat-checkbox" type="checkbox" name="subcat[]" value="${sub.id}" id="sub-${sub.id}">
                                    <label class="form-check-label fw-bold" for="sub-${sub.id}">${sub.name}</label>
                                </div>
                                <div class="floor-upload-box ms-4" id="floor-box-${sub.id}" style="display:none;">
                                    <label class="small text-muted mb-1 d-block"><i class="fas fa-upload me-1"></i> Upload Floor Plan for ${sub.name}</label>
                                    <input type="file" name="images_floor[${sub.id}][]" class="form-control form-control-sm" multiple accept="image/*">
                                </div>
                            `;
                            subcatContainer.appendChild(subRow);
                        });

                        // Add listeners to new checkboxes
                        document.querySelectorAll('.subcat-checkbox').forEach(chk => {
                            chk.addEventListener('change', function() {
                                const subId = this.value;
                                document.getElementById(`floor-box-${subId}`).style.display = this.checked ? 'block' : 'none';
                            });
                        });
                    } else {
                        subcatContainer.innerHTML = '<p class="text-danger small mb-0">No sub-categories found for this category.</p>';
                    }
                })
                .catch(err => {
                    console.error(err);
                    subcatContainer.innerHTML = '<p class="text-danger small mb-0">Error loading sub-categories.</p>';
                });
        });

        // Image Preview
        function previewImg(input, target) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => document.getElementById(target).src = e.target.result;
                reader.readAsDataURL(input.files[0]);
                hideError(input); // Clear error on change
            }
        }
    </script>
</body>
</html>