<?php
include('../components/auth.php');
include '../../config.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Invalid property");
}

// ✅ Fetch Property Data
$querry = "SELECT * FROM new_property WHERE id=$id";
$result = mysqli_query($con, $querry);
$edit = mysqli_fetch_assoc($result);

if (!$edit) {
    die("Property not found");
}

// ✅ Fetch Related Data
$extra_images = mysqli_query($con, "SELECT * FROM property_img WHERE property_id='$id'");
$current_builder_id = $edit['builder_name'];

// ✅ Category, Subcat & Floor Plan Data
$cat_data = mysqli_fetch_assoc(mysqli_query($con, "SELECT category_id FROM property_category WHERE property_id='$id'"));
$current_category_id = $cat_data['category_id'] ?? null;

$subcat_res = mysqli_query($con, "SELECT subcat_id FROM property_subcat WHERE property_id='$id'");
$current_subcats = [];
while($s = mysqli_fetch_assoc($subcat_res)) $current_subcats[] = $s['subcat_id'];

$floor_plans_res = mysqli_query($con, "SELECT * FROM floor_plane WHERE property_id='$id'");
$existing_floor_plans = [];
while($f = mysqli_fetch_assoc($floor_plans_res)) {
    $existing_floor_plans[$f['subcat_id']][] = $f;
}

// ✅ Improved File Upload Helper (WebP Support + Watermark + Direct Fallback)
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

function postEsc($con, $key, $default = '') {
    return mysqli_real_escape_string($con, (string)($_POST[$key] ?? $default));
}

function priceToInt($price) {
    $price = strtolower(trim((string)$price));
    $price = str_replace([' ', ','], '', $price);
    if (strpos($price, 'cr') !== false) return (int)(floatval($price) * 10000000);
    if (strpos($price, 'lac') !== false || strpos($price, 'lakh') !== false) return (int)(floatval($price) * 100000);
    return (int)$price;
}

function sqlDateOrNull($con, $value) {
    $value = trim((string)$value);
    if ($value === '' || $value === '0000-00-00') {
        return 'NULL';
    }
    return "'" . mysqli_real_escape_string($con, $value) . "'";
}

function uploadedFileError($field) {
    return $_FILES[$field]['error'] ?? UPLOAD_ERR_NO_FILE;
}

// ✅ Handle Update
$errors = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $propertyname = postEsc($con, 'project_name');
    $buildername = postEsc($con, 'buildername');
    $minprice = postEsc($con, 'min-price');
    $maxprice = postEsc($con, 'max-price');
    $location = postEsc($con, 'location');
    $bhk = postEsc($con, 'bhk');
    $video_link = postEsc($con, 'video_link');
    $bigha = (int)($_POST['bigha'] ?? 0);
    $unit = (int)($_POST['units'] ?? 0);
    $floor = (int)($_POST['floor'] ?? 0);
    $block = (int)($_POST['blocks'] ?? 0);
    $status = (int)($_POST['status'] ?? 0);
    $trend = (int)($_POST['trending'] ?? 0);
    $project_type = (int)($_POST['project_type'] ?? 0);
    $launchSql = sqlDateOrNull($con, $_POST['launch_date'] ?? '');
    $possessionSql = sqlDateOrNull($con, $_POST['possession_date'] ?? '');
    $furnish = postEsc($con, 'furnish');
    $construct = postEsc($con, 'construct');
    $map = postEsc($con, 'map');
    $highlight = postEsc($con, 'highlights');
    $other_key_feature = postEsc($con, 'other_key_feature');

    if (($_POST['rera_type'] ?? '') === 'jda') {
        $rera_no = 'JDA Approved';
    } else {
        $rera_no = postEsc($con, 'rera_no');
    }

    // ✅ Required Validation
    if (!$propertyname) $errors[] = "Project name is required.";
    if (!$location) $errors[] = "Location is required.";
    if (!$buildername) $errors[] = "Builder name is required.";
    if (($_POST['rera_type'] ?? '') === 'rera' && $rera_no === '') {
        $errors[] = "RERA Number is required.";
    }

    $min_price_int = priceToInt($minprice);
    $max_price_int = priceToInt($maxprice);

    // Image Upload Handling (Processed)
    $main_image = $edit['main_image'];
    if (uploadedFileError('main_image') == UPLOAD_ERR_OK) {
        $new_main = uploadFile($_FILES['main_image'], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
        if ($new_main) {
            $main_image = $new_main;
        } else {
            $errors[] = "Main Image upload failed. Please ensure file is a valid image (JPG, PNG, WebP) under 10MB.";
        }
    } elseif (uploadedFileError('main_image') != UPLOAD_ERR_NO_FILE) {
        $errors[] = "Main Image upload error code: " . uploadedFileError('main_image');
    }

    for($i=1; $i<=4; $i++) {
        $var = "image".$i;
        $db_var = "image_".$i;
        $$var = $edit[$db_var];
        if (uploadedFileError($var) == UPLOAD_ERR_OK) {
            $new_img = uploadFile($_FILES[$var], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
            if ($new_img) {
                $$var = $new_img;
            } else {
                $errors[] = "Gallery Image $i upload failed. Please ensure file is a valid image under 10MB.";
            }
        } elseif (uploadedFileError($var) != UPLOAD_ERR_NO_FILE) {
            $errors[] = "Gallery Image $i upload error code: " . uploadedFileError($var);
        }
    }

    $pdf = $edit['brochure'];
    $brochureErr = uploadedFileError('brochure');
    if ($brochureErr == 0) {
        $new_pdf = uploadFile($_FILES['brochure'], "../../uploads/", ["pdf"], 200);
        if ($new_pdf) $pdf = $new_pdf;
        else $errors[] = "Brochure (PDF) upload failed. Max 200MB.";
    } elseif ($brochureErr != UPLOAD_ERR_NO_FILE) {
        $errors[] = "Brochure upload error code: " . $brochureErr;
    }

    if (empty($errors)) {
        $id = (int)$id;
        $updateSql = "UPDATE new_property SET 
            project_name='$propertyname', builder_name='$buildername', max_price_int='$max_price_int', min_price_int='$min_price_int', 
            min_price='$minprice', max_price='$maxprice', location='$location', rera_no='$rera_no', bhk='$bhk', video_link='$video_link', 
            map='$map', highlight='$highlight', other_key_feature='$other_key_feature', bigha='$bigha', unit='$unit', floor='$floor', 
            block='$block', status='$status', trending='$trend', project_type='$project_type', launch_date=$launchSql, 
            possession_date=$possessionSql, furnish_type='$furnish', construct_Status='$construct', main_image='$main_image', 
            image_1='$image1', image_2='$image2', image_3='$image3', image_4='$image4', brochure='$pdf' 
            WHERE id=$id";

        try {
            $updated = mysqli_query($con, $updateSql);
        } catch (mysqli_sql_exception $e) {
            $updated = false;
            $errors[] = "Database Error: " . $e->getMessage();
        }

        if ($updated) {
            // Update Amenities
            mysqli_query($con, "DELETE FROM property_amenities WHERE property_id='$id'");
            if (!empty($_POST['amenities'])) {
                foreach ($_POST['amenities'] as $a_id) {
                    mysqli_query($con, "INSERT INTO property_amenities (property_id, amenity_id) VALUES ('$id', '$a_id')");
                }
            }

            // ✅ Update Category
            if (!empty($_POST['cat_name'])) {
                $new_cat = mysqli_real_escape_string($con, $_POST['cat_name']);
                mysqli_query($con, "DELETE FROM property_category WHERE property_id='$id'");
                mysqli_query($con, "INSERT INTO property_category (property_id, category_id) VALUES ('$id', '$new_cat')");
            }

            // ✅ Update Sub-Categories
            mysqli_query($con, "DELETE FROM property_subcat WHERE property_id='$id'");
            if (!empty($_POST['subcat'])) {
                $cat_id = mysqli_real_escape_string($con, $_POST['cat_name']);
                foreach ($_POST['subcat'] as $s) {
                    mysqli_query($con, "INSERT INTO property_subcat (property_id, category_id, subcat_id) VALUES ('$id', '$cat_id', '$s')");
                }
            }

            // ✅ Process New Floor Plans (Robust Saving & 20MB Limit)
            if (!empty($_POST['subcat'])) {
                $pid_int = (int)$id;
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
                                    $floorSql = "INSERT INTO floor_plane (image, property_id, subcat_id) VALUES ('$imgNameEsc', $pid_int, $subcat_id)";
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

            // Add More Images (Gallery - Processed)
            if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
                foreach ($_FILES['images']['tmp_name'] as $key => $tmp) {
                    if (empty($_FILES['images']['name'][$key])) continue;
                    $fileData = [
                        'name' => $_FILES['images']['name'][$key],
                        'tmp_name' => $tmp,
                        'error' => $_FILES['images']['error'][$key],
                        'size' => $_FILES['images']['size'][$key]
                    ];
                    $newName = uploadFile($fileData, "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
                    if ($newName) {
                        mysqli_query($con, "INSERT INTO property_img (property_id, image) VALUES ('$id', '$newName')");
                    }
                }
            }

            header('Location: new_property');
            exit;
        } elseif (empty($errors)) {
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
                            <h5 class="fw-bold mb-2"><i class="fas fa-exclamation-triangle me-2"></i> Please correct the following errors:</h5>
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="page-header d-flex justify-content-between align-items-center">
                        <div>
                            <h3 class="fw-bold mb-2">Modify Property Details</h3>
                            <ul class="breadcrumbs p-0 bg-transparent">
                                <li class="nav-home"><a href="../index"><i class="fas fa-home"></i></a></li>
                                <li class="separator"><i class="fas fa-chevron-right"></i></li>
                                <li class="nav-item">Edit: <?= htmlspecialchars($edit['project_name']) ?></li>
                            </ul>
                        </div>
                        <a href="new_property" class="btn btn-outline-primary btn-round">
                            <i class="fas fa-arrow-left me-2"></i>Back to Inventory
                        </a>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <form name="PropertyForm" id="PropertyForm" action="" enctype="multipart/form-data" method="POST" novalidate onsubmit="return validateForm()">
                                <div class="card card-round border-0 shadow-sm overflow-hidden">
                                    <div class="card-header bg-white p-0">
                                        <ul class="nav nav-pills nav-pills-premium mb-0" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#tab-identity" type="button"><i class="fas fa-id-card me-2"></i>1. Project Identity</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-specs" type="button"><i class="fas fa-ruler-combined me-2"></i>2. Architecture</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-pricing" type="button"><i class="fas fa-tag me-2"></i>3. Commercials</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-media" type="button"><i class="fas fa-images me-2"></i>4. Media Gallery</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-bs-toggle="pill" data-bs-target="#tab-ecosystem" type="button"><i class="fas fa-leaf me-2"></i>5. Ecosystem</button>
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
                                                            <label class="fw-bold">Project Name</label>
                                                            <input type="text" name="project_name" class="form-control form-control-lg bg-white" value="<?= htmlspecialchars($_POST['project_name'] ?? $edit['project_name'] ?? '') ?>" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Builder Name</label>
                                                            <select name="buildername" class="form-select form-select-lg bg-white" required>
                                                                <?php
                                                                $builderRes = mysqli_query($con, "SELECT id, builder_name FROM builder WHERE status = 1 ORDER BY builder_name ASC");
                                                                while ($b = mysqli_fetch_assoc($builderRes)) {
                                                                    $selected = (($_POST['buildername'] ?? $current_builder_id) == $b['id']) ? "selected" : "";
                                                                    echo "<option value='{$b['id']}' $selected>{$b['builder_name']}</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Project Category</label>
                                                            <select name="cat_name" id="category" class="form-select form-select-lg bg-white" required>
                                                                <option value="" disabled>Select Category</option>
                                                                <?php
                                                                $catRes = mysqli_query($con, "SELECT id, category_name FROM category WHERE status = 1");
                                                                while ($c = mysqli_fetch_assoc($catRes)) {
                                                                    $selected = ($c['id'] == $current_category_id) ? "selected" : "";
                                                                    echo "<option value='{$c['id']}' $selected>{$c['category_name']}</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold text-muted small uppercase">Listing Status</label>
                                                            <select name="status" class="form-select bg-white" required>
                                                                <option value="1" <?= $edit['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                                                <option value="0" <?= $edit['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold text-muted small uppercase">Trending Now</label>
                                                                <select name="trending" class="form-select bg-white">
                                                                    <option value="0" <?= $edit['trending'] == 0 ? 'selected' : '' ?>>No</option>
                                                                    <option value="1" <?= $edit['trending'] == 1 ? 'selected' : '' ?>>Yes</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold small">Project Status Type</label>
                                                                <select name="project_type" class="form-select bg-white" required>
                                                                    <option value="0" <?= ($_POST['project_type'] ?? $edit['project_type']) == 0 ? 'selected' : '' ?>>Ongoing</option>
                                                                    <option value="1" <?= ($_POST['project_type'] ?? $edit['project_type']) == 1 ? 'selected' : '' ?>>Completed</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold small">Launch Date</label>
                                                                <input type="date" name="launch_date" class="form-control bg-white" value="<?= $_POST['launch_date'] ?? $edit['launch_date'] ?? '' ?>">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="fw-bold small">Possession Date</label>
                                                                <input type="date" name="possession_date" class="form-control bg-white" value="<?= $_POST['possession_date'] ?? $edit['possession_date'] ?? '' ?>">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Step 2: Architecture -->
                                            <div class="tab-pane fade" id="tab-specs">
                                                <div class="row g-4">
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Primary Location</label>
                                                            <input type="text" name="location" class="form-control bg-white" value="<?= htmlspecialchars($_POST['location'] ?? $edit['location'] ?? '') ?>" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Google Map Iframe Link</label>
                                                            <input type="text" name="map" class="form-control bg-white" value="<?= htmlspecialchars($_POST['map'] ?? $edit['map'] ?? '') ?>">
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Configuration (BHK)</label>
                                                            <input type="text" name="bhk" class="form-control bg-white" value="<?= htmlspecialchars($_POST['bhk'] ?? $edit['bhk'] ?? '') ?>" required>
                                                        </div>
                                                        <div class="form-group mb-3">
                                                            <label class="fw-bold">Total Blocks / Towers</label>
                                                            <input type="text" name="blocks" class="form-control bg-white" value="<?= htmlspecialchars($_POST['blocks'] ?? $edit['block'] ?? '') ?>">
                                                        </div>
                                                        <div class="form-group mb-4">
                                                            <label class="fw-bold"><i class="fas fa-layer-group me-2 text-primary"></i>Sub-Categories & Floor Plans</label>
                                                            <div id="subcat-container" class="border rounded bg-white p-3" style="min-height: 100px;">
                                                                <p class="text-muted small mb-0">Select category to load configurations.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 p-4 bg-white rounded border dash-border text-center">
                                                        <h5 class="fw-bold mb-4">Area Specifications</h5>
                                                        <div class="row g-3">
                                                            <div class="col-4">
                                                                <label class="small fw-bold">Carpet (sqft)</label>
                                                                <input type="text" name="bigha" class="form-control text-center" value="<?= htmlspecialchars($_POST['bigha'] ?? $edit['bigha'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="small fw-bold">Built-up (sqft)</label>
                                                                <input type="text" name="units" class="form-control text-center" value="<?= htmlspecialchars($_POST['units'] ?? $edit['unit'] ?? '') ?>">
                                                            </div>
                                                            <div class="col-4">
                                                                <label class="small fw-bold">Super (sqft)</label>
                                                                <input type="text" name="floor" class="form-control text-center" value="<?= htmlspecialchars($_POST['floor'] ?? $edit['floor'] ?? '') ?>">
                                                            </div>
                                                        </div>
                                                        <div class="mt-4">
                                                                <label class="fw-bold small text-muted">Video Walkthrough (YouTube Link)</label>
                                                                <input type="text" name="video_link" class="form-control bg-light" value="<?= htmlspecialchars($_POST['video_link'] ?? $edit['video_link'] ?? '') ?>">
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
                                                                    <input type="text" name="min-price" id="minPriceInput" class="form-control form-control-lg bg-white" placeholder="e.g. 45 Lakh" value="<?= htmlspecialchars($_POST['min-price'] ?? $edit['min_price'] ?? '') ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group mb-3">
                                                                    <label class="fw-bold">Maximum Price</label>
                                                                    <input type="text" name="max-price" id="maxPriceInput" class="form-control form-control-lg bg-white" placeholder="e.g. 1.2 Cr" value="<?= htmlspecialchars($_POST['max-price'] ?? $edit['max_price'] ?? '') ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="price-display-box">
                                                            <span class="price-label">Project Valuation Range</span>
                                                            <span id="priceVisualizer" class="price-indicator">₹ <?= $edit['min_price'] ?> - ₹ <?= $edit['max_price'] ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="p-4 bg-white rounded shadow-sm border">
                                                            <div class="mb-4">
                                                                <label class="fw-bold mb-2">Legal Compliance <span class="text-danger">*</span></label>
                                                                <?php 
                                                                    $is_jda = ($edit['rera_no'] == 'JDA Approved');
                                                                    $curr_rera_type = $_POST['rera_type'] ?? ($is_jda ? 'jda' : 'rera');
                                                                ?>
                                                                <select name="rera_type" id="rera_type" class="form-select mb-2" required>
                                                                    <option value="rera" <?= $curr_rera_type == 'rera' ? 'selected' : '' ?>>RERA Number</option>
                                                                    <option value="jda" <?= $curr_rera_type == 'jda' ? 'selected' : '' ?>>JDA Approved</option>
                                                                </select>
                                                                <input type="text" name="rera_no" id="rera_no" class="form-control" placeholder="Enter Registration No." value="<?= htmlspecialchars($_POST['rera_no'] ?? ($is_jda ? '' : $edit['rera_no'])) ?>" style="<?= $curr_rera_type != 'jda' ? 'display:block;' : 'display:none;' ?>">
                                                            </div>
                                                            <div class="row g-2">
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Furnishing</label>
                                                                    <select name="furnish" class="form-select">
                                                                        <option value="2" <?= ($_POST['furnish'] ?? $edit['furnish_type']) == '2' ? 'selected' : '' ?>>Unfurnished</option>
                                                                        <option value="1" <?= ($_POST['furnish'] ?? $edit['furnish_type']) == '1' ? 'selected' : '' ?>>Semi furnished</option>
                                                                        <option value="0" <?= ($_POST['furnish'] ?? $edit['furnish_type']) == '0' ? 'selected' : '' ?>>Fully furnished</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label class="fw-bold small">Construction Status</label>
                                                                    <select name="construct" class="form-select">
                                                                        <option value="1" <?= ($_POST['construct'] ?? $edit['construct_Status']) == '1' ? 'selected' : '' ?>>Under Construction</option>
                                                                        <option value="0" <?= ($_POST['construct'] ?? $edit['construct_Status']) == '0' ? 'selected' : '' ?>>Ready to move</option>
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
                                                            <img id="prev-main" src="../../uploads/<?= $edit['main_image'] ?>" class="w-100 h-100 object-fit-cover">
                                                            <div class="preview-overlay">CURRENT MAIN COVER</div>
                                                        </div>
                                                        <input type="file" name="main_image" class="form-control" accept="image/*" onchange="previewImg(this, 'prev-main')">
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="row g-2 mb-3">
                                                            <?php for($i=1; $i<=4; $i++): 
                                                                $db_img = "image_".$i;
                                                                $src = !empty($edit[$db_img]) ? "../../uploads/".$edit[$db_img] : "../assets/img/placeholder-house.webp";
                                                            ?>
                                                            <div class="col-md-3">
                                                                <div class="image-upload-wrapper mb-2" style="height: 120px;">
                                                                    <img id="prev-<?=$i?>" src="<?=$src?>" class="w-100 h-100 object-fit-cover">
                                                                </div>
                                                                <input type="file" name="image<?=$i?>" class="form-control form-control-sm" accept="image/*" onchange="previewImg(this, 'prev-<?=$i?>')">
                                                            </div>
                                                            <?php endfor; ?>
                                                        </div>
                                                        
                                                        <h6 class="fw-bold mt-4 mb-2">Extended Gallery (Current)</h6>
                                                        <div class="row g-2 mb-4">
                                                            <?php while($g = mysqli_fetch_assoc($extra_images)): ?>
                                                            <div class="col-md-2">
                                                                <div class="image-upload-wrapper" style="height: 80px;">
                                                                    <img src="../../uploads/<?=$g['image']?>" class="w-100 h-100 object-fit-cover">
                                                                    <a href="delete-moreimg?id=<?=$g['I_id']?>&property_id=<?=$id?>" class="preview-overlay text-danger fw-bold text-decoration-none">DELETE</a>
                                                                </div>
                                                            </div>
                                                            <?php endwhile; ?>
                                                        </div>

                                                        <div class="p-4 bg-white rounded border">
                                                            <div class="row align-items-center">
                                                                <div class="col-md-6">
                                                                    <label class="fw-bold">Replace Brochure (PDF)</label>
                                                                    <input type="file" name="brochure" class="form-control" accept=".pdf">
                                                                    <small class="text-success"><?= $edit['brochure'] ?></small>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="fw-bold">Upload New Gallery Images</label>
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
                                                            <h6 class="fw-bold mb-3"><i class="fas fa-spa me-2 text-success"></i>Toggle Amenities</h6>
                                                            <div class="row g-2" style="max-height: 200px; overflow-y: auto;">
                                                                <?php
                                                                $current_amenities = [];
                                                                $ca_res = mysqli_query($con, "SELECT amenity_id FROM property_amenities WHERE property_id=$id");
                                                                while($caa = mysqli_fetch_assoc($ca_res)) $current_amenities[] = $caa['amenity_id'];

                                                                $amenRes = mysqli_query($con, "SELECT * FROM amenity WHERE status = 1");
                                                                while ($a = mysqli_fetch_assoc($amenRes)): 
                                                                    $checked = in_array($a['id'], $current_amenities) ? 'checked' : '';
                                                                ?>
                                                                <div class="col-md-3">
                                                                    <div class="form-check p-0">
                                                                        <input class="btn-check" type="checkbox" name="amenities[]" value="<?=$a['id']?>" id="amen-<?=$a['id']?>" <?= $checked ?>>
                                                                        <label class="btn btn-outline-secondary btn-sm w-100 text-start py-2" for="amen-<?=$a['id']?>">
                                                                            <i class="fas <?= $checked ? 'fa-check-circle' : 'fa-circle' ?> me-1 opacity-50"></i> <?=$a['name']?>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <?php endwhile; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 mb-3">
                                                        <div class="form-group p-0">
                                                            <label class="fw-bold mb-2">Location Advantage</label>
                                                            <textarea name="highlights" id="editor1"><?= htmlspecialchars($_POST['highlights'] ?? $edit['highlight'] ?? '') ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group p-0">
                                                            <label class="fw-bold mb-2">About Property Details</label>
                                                            <textarea name="other_key_feature" id="editor2"><?= htmlspecialchars($_POST['other_key_feature'] ?? $edit['other_key_feature'] ?? '') ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white text-center py-4">
                                        <button type="submit" class="btn btn-primary btn-round px-5 py-3 shadow">
                                            <i class="fas fa-save me-2"></i>SAVE UPDATED LISTING
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://cdn.ckeditor.com/ckeditor5/35.0.1/classic/ckeditor.js"></script>
            <script>
                let ckEditor1, ckEditor2;

                ClassicEditor.create(document.querySelector('#editor1'))
                    .then(editor => { ckEditor1 = editor; })
                    .catch(err => console.error('CKEditor1 Error:', err));

                ClassicEditor.create(document.querySelector('#editor2'))
                    .then(editor => { ckEditor2 = editor; })
                    .catch(err => console.error('CKEditor2 Error:', err));

                function markTabError(el) {
                    const pane = el.closest('.tab-pane');
                    if (!pane) return;
                    const tabBtn = document.querySelector(`[data-bs-target="#${pane.id}"]`);
                    if (tabBtn) tabBtn.style.borderBottom = "3px solid red";
                }

                function validateForm() {
                    const form = document.getElementById('PropertyForm');
                    let isValid = true;

                    document.querySelectorAll('.nav-link').forEach(btn => btn.style.borderBottom = "");

                    form.querySelectorAll('input[required], select[required]').forEach(input => {
                        if (input.type === 'file' || input.style.display === 'none') return;
                        if (!String(input.value || '').trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                            markTabError(input);
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    const reraType = document.getElementById('rera_type').value;
                    const reraNo = document.getElementById('rera_no');
                    if (reraType === 'rera' && !reraNo.value.trim()) {
                        reraNo.classList.add('is-invalid');
                        isValid = false;
                        markTabError(reraNo);
                    } else {
                        reraNo.classList.remove('is-invalid');
                    }

                    if (!isValid) {
                        const firstBadTab = document.querySelector('.nav-link[style*="red"]');
                        if (firstBadTab && window.bootstrap) {
                            new bootstrap.Tab(firstBadTab).show();
                        }
                        alert('Please fill all mandatory fields. Check the highlighted tabs.');
                        return false;
                    }

                    if (ckEditor1) document.querySelector('#editor1').value = ckEditor1.getData();
                    if (ckEditor2) document.querySelector('#editor2').value = ckEditor2.getData();
                    return true;
                }

                // Initialize AOS
                AOS.init({
                    duration: 800,
                    on: 'ease-in-out',
                    once: true
                });

                document.getElementById('rera_type').addEventListener('change', function() {
                    document.getElementById('rera_no').style.display = this.value === 'rera' ? 'block' : 'none';
                });

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

                // ✅ Floor Plan & Sub-Category Intelligence (Edited version)
                const categorySelect = document.getElementById('category');
                const subcatContainer = document.getElementById('subcat-container');
                const currentSubcats = <?= json_encode($current_subcats) ?>;
                const currentFloorPlans = <?= json_encode($existing_floor_plans) ?>;

                function loadSubcategories(catId) {
                    if(!catId) return;
                    subcatContainer.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-primary"></div></div>';

                    fetch(`get_subcategories.php?cat_id=${catId}`)
                        .then(response => response.json())
                        .then(data => {
                            if(data.success && data.data.length > 0) {
                                subcatContainer.innerHTML = '';
                                data.data.forEach(sub => {
                                    const isChecked = currentSubcats.includes(sub.id.toString()) || currentSubcats.includes(parseInt(sub.id));
                                    const existingPlans = currentFloorPlans[sub.id] || [];
                                    
                                    const subRow = document.createElement('div');
                                    subRow.className = 'subcat-item mb-3 p-3 border rounded bg-white shadow-sm';
                                    
                                    let existingHtml = '';
                                    if(existingPlans.length > 0) {
                                        existingHtml = `<div class="existing-plans row g-2 mb-2">`;
                                        existingPlans.forEach(plan => {
                                            existingHtml += `
                                                <div class="col-md-3">
                                                    <div class="position-relative border rounded overflow-hidden" style="height: 80px;">
                                                        <img src="../../uploads/${plan.image}" class="w-100 h-100 object-fit-cover">
                                                        <a href="delete_floorplane_img?img=${plan.image}&pid=<?= $id ?>" 
                                                           onclick="return confirm('Delete this floor plan?')"
                                                           class="position-absolute top-0 end-0 bg-danger text-white p-1" style="font-size:10px;">
                                                           <i class="fas fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            `;
                                        });
                                        existingHtml += `</div>`;
                                    }

                                    subRow.innerHTML = `
                                        <div class="form-check mb-2">
                                            <input class="form-check-input subcat-checkbox" type="checkbox" name="subcat[]" value="${sub.id}" id="sub-${sub.id}" ${isChecked ? 'checked' : ''}>
                                            <label class="form-check-label fw-bold" for="sub-${sub.id}">${sub.name}</label>
                                        </div>
                                        ${existingHtml}
                                        <div class="floor-upload-box ms-4" id="floor-box-${sub.id}" style="${isChecked ? 'display:block;' : 'display:none;'}">
                                            <label class="small text-muted mb-1 d-block"><i class="fas fa-upload me-1"></i> Upload New Floor Plan for ${sub.name}</label>
                                            <input type="file" name="images_floor[${sub.id}][]" class="form-control form-control-sm" multiple accept="image/*">
                                        </div>
                                    `;
                                    subcatContainer.appendChild(subRow);
                                });

                                // Add listeners
                                document.querySelectorAll('.subcat-checkbox').forEach(chk => {
                                    chk.addEventListener('change', function() {
                                        const subId = this.value;
                                        document.getElementById(`floor-box-${subId}`).style.display = this.checked ? 'block' : 'none';
                                    });
                                });
                            } else {
                                subcatContainer.innerHTML = '<p class="text-danger small mb-0">No sub-categories found.</p>';
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            subcatContainer.innerHTML = '<p class="text-danger small mb-0">Error loading sub-categories.</p>';
                        });
                }

                // Initialize on load
                if(categorySelect.value) loadSubcategories(categorySelect.value);
                
                // Change listener
                categorySelect.addEventListener('change', function() {
                    loadSubcategories(this.value);
                });

                function previewImg(input, target) {
                    if (input.files && input.files[0]) {
                        const reader = new FileReader();
                        reader.onload = e => document.getElementById(target).src = e.target.result;
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            </script>

            <?php include('../components/viewFooter.php'); ?>
        </div>
    </div>