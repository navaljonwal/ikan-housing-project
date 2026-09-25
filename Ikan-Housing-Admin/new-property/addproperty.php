<?php
include('../components/auth.php');
include('../../config.php');

// ✅ Increase memory and execution time for uploads
@ini_set('memory_limit', '512M');
@ini_set('max_execution_time', '300');

// ✅ Auto-Migrate / Self-Heal Database Schema dynamically
function ensurePropertySchema($con)
{
    static $done = false;
    if ($done || !$con) return;
    $done = true;

    try {
        // 1. Check & Add video_file column
        $colCheck = mysqli_query($con, "SHOW COLUMNS FROM new_property LIKE 'video_file'");
        if ($colCheck && mysqli_num_rows($colCheck) == 0) {
            @mysqli_query($con, "ALTER TABLE new_property ADD COLUMN video_file varchar(255) DEFAULT NULL AFTER video_link");
        }

        // 2. Relax brochure to optional DEFAULT '' NULL
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN brochure varchar(255) DEFAULT '' NULL");

        // 3. Relax strict integer & date columns so empty values never crash strict MySQL
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN bigha int(11) DEFAULT 0 NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN unit int(11) DEFAULT 0 NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN floor int(11) DEFAULT 0 NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN block int(11) DEFAULT 0 NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN launch_date date DEFAULT NULL NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN possession_date date DEFAULT NULL NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN max_price_int bigint(20) DEFAULT NULL NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN min_price_int bigint(20) DEFAULT NULL NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN trending tinyint(4) DEFAULT 0 NULL");
        @mysqli_query($con, "ALTER TABLE new_property MODIFY COLUMN project_type tinyint(4) DEFAULT 1 NULL");
    } catch (Throwable $e) {
        error_log("Schema auto-migrate notice: " . $e->getMessage());
    }
}
ensurePropertySchema($con);

// ✅ Slug Generate (Resilient)
function generateSlug($name, $con)
{
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', (string)$name), '-'));
    if (empty($slug)) {
        $slug = 'property-' . time();
    }
    $base = $slug;
    $i = 1;
    try {
        while (true) {
            $checkRes = mysqli_query($con, "SELECT id FROM new_property WHERE slug='" . mysqli_real_escape_string($con, $slug) . "'");
            if ($checkRes && mysqli_num_rows($checkRes) > 0) {
                $slug = $base . '-' . $i++;
            } else {
                break;
            }
        }
    } catch (Throwable $t) {
        $slug = $base . '-' . time() . '-' . rand(10, 99);
    }
    return $slug;
}

// ✅ File Upload Helper (High performance + Bulletproof GD + Instant fallback)
function uploadFile($file, $dest = "../../uploads/", $allowed = ["jpg", "jpeg", "png", "webp", "pdf", "jfif", "avif", "gif"], $maxMB = 10)
{
    @ini_set('memory_limit', '512M');
    @ini_set('max_execution_time', '300');

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

    if ($ext === 'pdf' || in_array($ext, ['mp4', 'webm', 'ogg', 'mov', 'mkv'])) {
        $finalName = $baseName . "." . $ext;
        return @move_uploaded_file($file['tmp_name'], $dest . $finalName) ? $finalName : "";
    }

    $imageProcessed = false;
    $finalName = "";

    // ✅ Safe & Fast GD Watermark / WebP Conversion
    try {
        if (extension_loaded('gd') && function_exists('imagecreatefromstring')) {
            $content = @file_get_contents($file['tmp_name']);
            if ($content !== false && strlen($content) > 0) {
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
                    $watermark_candidates = [
                        __DIR__ . '/../assets/img/watermark-ikan.png',
                        __DIR__ . '/../../img/watermark-ikan.png',
                        __DIR__ . '/../assets/img/watermark-ikan-white.png',
                        __DIR__ . '/../../img/watermark-ikan-white.png',
                        __DIR__ . '/../assets/img/icon-2.png'
                    ];
                    $watermark_path = "";
                    foreach ($watermark_candidates as $cand) {
                        if (file_exists($cand)) {
                            $watermark_path = $cand;
                            break;
                        }
                    }

                    if (!empty($watermark_path) && function_exists('imagecreatefrompng')) {
                        $watermark = @imagecreatefrompng($watermark_path);
                        if ($watermark) {
                            $src_w = (int)imagesx($src);
                            $src_h = (int)imagesy($src);
                            $wm_w = (int)imagesx($watermark);
                            $wm_h = (int)imagesy($watermark);

                            if ($src_w > 120 && $src_h > 120 && $wm_w > 0 && $wm_h > 0) {
                                // Scale watermark to ~45% photo width (between 180px and 900px)
                                $target_wm_w = max(180, min((int)($src_w * 0.45), 900));
                                $target_wm_h = max(1, (int)($wm_h * ($target_wm_w / $wm_w)));

                                $scaled = imagecreatetruecolor($target_wm_w, $target_wm_h);
                                if ($scaled) {
                                    imagealphablending($scaled, false);
                                    imagesavealpha($scaled, true);
                                    $trans = imagecolorallocatealpha($scaled, 0, 0, 0, 127);
                                    imagefill($scaled, 0, 0, $trans);
                                    imagecopyresampled($scaled, $watermark, 0, 0, 0, 0, $target_wm_w, $target_wm_h, $wm_w, $wm_h);

                                    // Robust check if watermark already has alpha transparency
                                    $is_already_translucent = false;
                                    for ($sx = 0; $sx < $target_wm_w; $sx += 10) {
                                        for ($sy = 0; $sy < $target_wm_h; $sy += 10) {
                                            $sc = imagecolorat($scaled, $sx, $sy);
                                            $sa = ($sc >> 24) & 0x7F;
                                            if ($sa > 50 && $sa < 125) {
                                                $is_already_translucent = true;
                                                break 2;
                                            }
                                        }
                                    }

                                    // If watermark is solid, apply ~35% opacity
                                    if (!$is_already_translucent) {
                                        for ($px = 0; $px < $target_wm_w; $px++) {
                                            for ($py = 0; $py < $target_wm_h; $py++) {
                                                $col = imagecolorat($scaled, $px, $py);
                                                $alp = ($col >> 24) & 0x7F;
                                                if ($alp < 127) {
                                                    $newAlp = 127 - (int)((127 - $alp) * 0.35);
                                                    $newColor = ($col & 0x00FFFFFF) | ($newAlp << 24);
                                                    imagesetpixel($scaled, $px, $py, $newColor);
                                                }
                                            }
                                        }
                                    }

                                    // Rotate diagonally by 30 degrees
                                    $rotated = function_exists('imagerotate') ? @imagerotate($scaled, 30, $trans) : false;
                                    if ($rotated) {
                                        imagesavealpha($rotated, true);
                                        $rot_w = (int)imagesx($rotated);
                                        $rot_h = (int)imagesy($rotated);
                                        $dest_x = (int)(($src_w - $rot_w) / 2);
                                        $dest_y = (int)(($src_h - $rot_h) / 2);

                                        imagealphablending($src, true);
                                        imagecopy($src, $rotated, $dest_x, $dest_y, 0, 0, $rot_w, $rot_h);
                                        @imagedestroy($rotated);
                                    } else {
                                        $dest_x = (int)(($src_w - $target_wm_w) / 2);
                                        $dest_y = (int)(($src_h - $target_wm_h) / 2);
                                        imagealphablending($src, true);
                                        imagecopy($src, $scaled, $dest_x, $dest_y, 0, 0, $target_wm_w, $target_wm_h);
                                    }
                                    @imagedestroy($scaled);
                                }
                            }
                            @imagedestroy($watermark);
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
                    @imagedestroy($src);
                }
            }
        }
    } catch (Throwable $t) {
        error_log("GD Processing notice: " . $t->getMessage());
        $imageProcessed = false;
    }

    if ($imageProcessed && !empty($finalName) && file_exists($dest . $finalName)) {
        return $finalName;
    }

    // ✅ Graceful Direct Save Fallback: Never fail upload or crash if GD is unavailable or out of RAM
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

$errors = [];
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Inputs
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
    $status = isset($_POST['status']) ? (int)$_POST['status'] : 1;
    $trend = isset($_POST['trending']) ? (int)$_POST['trending'] : 0;
    $project_type = isset($_POST['project_type']) ? (int)$_POST['project_type'] : 0;
    $launchSql = sqlDateOrNull($con, $_POST['launch_date'] ?? '');
    $possessionSql = sqlDateOrNull($con, $_POST['possession_date'] ?? '');
    $furnish = postEsc($con, 'furnish');
    $construct = postEsc($con, 'construct');
    $map = postEsc($con, 'map');
    $highlight = postEsc($con, 'highlights');
    $other_key = postEsc($con, 'other_key_feature');
    $slug = generateSlug($propertyname, $con);

    // ✅ Required Validation
    if (!$propertyname) $errors[] = "Project name is required.";
    if (!$location) $errors[] = "Location is required.";
    if (!$bhk) $errors[] = "BHK is required.";
    if (!$buildername) $errors[] = "Builder name is required.";

    // ✅ RERA / JDA
    if (empty($_POST['rera_type'])) {
        $errors[] = "Please select RERA or JDA option.";
        $rera_no = "";
    } elseif ($_POST['rera_type'] == "rera") {
        $rera_no = postEsc($con, 'rera_no');
        if ($rera_no === '') {
            $errors[] = "RERA Number is required.";
        }
    } else {
        $rera_no = "JDA Approved";
    }

    // ✅ Uploads - Main Image
    $main_image = "";
    $mainErr = uploadedFileError('main_image');
    if ($mainErr === UPLOAD_ERR_OK) {
        $main_image = uploadFile($_FILES['main_image'], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
        if (!$main_image) $errors[] = "Main cover image upload failed. Please ensure file is under 10MB.";
    } else {
        $errors[] = "Main cover image is required.";
    }

    $image1 = uploadFile($_FILES['image1'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    $image2 = uploadFile($_FILES['image2'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    $image3 = uploadFile($_FILES['image3'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    $image4 = uploadFile($_FILES['image4'] ?? [], "../../uploads/", ["jpg", "jpeg", "png", "webp", "jfif", "avif", "gif"], 10);
    
    // ✅ Brochure is strictly OPTIONAL (Never block property submission)
    $pdf = "";
    if (isset($_FILES['brochure']) && uploadedFileError('brochure') === UPLOAD_ERR_OK) {
        $uploadedPdf = uploadFile($_FILES['brochure'], "../../uploads/", ["pdf"], 200);
        if ($uploadedPdf) {
            $pdf = $uploadedPdf;
        }
    }

    // ✅ Video File is strictly OPTIONAL
    $video_file = "";
    if (isset($_FILES['video_file']) && uploadedFileError('video_file') === UPLOAD_ERR_OK) {
        $uploadedVideo = uploadFile($_FILES['video_file'], "../../uploads/", ["mp4", "webm", "ogg", "mov", "mkv"], 100);
        if ($uploadedVideo) {
            $video_file = $uploadedVideo;
        }
    }

    // ✅ Stop if validation error
    if (empty($errors)) {
        $min_price_int = priceToInt($minprice);
        $max_price_int = priceToInt($maxprice);

        // Dynamically verify if video_file column is present in new_property table
        $hasVideoCol = false;
        try {
            $colRes = mysqli_query($con, "SHOW COLUMNS FROM new_property LIKE 'video_file'");
            if ($colRes && mysqli_num_rows($colRes) > 0) {
                $hasVideoCol = true;
            }
        } catch (Throwable $t) {
            $hasVideoCol = false;
        }

        // ✅ Resilient Insert Query
        if ($hasVideoCol) {
            $sql = "INSERT INTO new_property 
            (project_name,builder_name,max_price_int,min_price_int,min_price,max_price,location,rera_no,bhk,video_link,video_file,map,highlight,other_key_feature,
             bigha,unit,floor,block,status,trending,project_type,launch_date,possession_date,furnish_type,construct_Status,
             main_image,image_1,image_2,image_3,image_4,brochure,slug) 
            VALUES 
            ('$propertyname','$buildername','$max_price_int','$min_price_int', '$minprice','$maxprice','$location','$rera_no','$bhk','$video_link','$video_file','$map',
            '$highlight','$other_key',$bigha,$unit,$floor,$block,$status,$trend,$project_type,$launchSql,
            $possessionSql,'$furnish','$construct','$main_image','$image1','$image2','$image3','$image4','$pdf','$slug')";
        } else {
            $sql = "INSERT INTO new_property 
            (project_name,builder_name,max_price_int,min_price_int,min_price,max_price,location,rera_no,bhk,video_link,map,highlight,other_key_feature,
             bigha,unit,floor,block,status,trending,project_type,launch_date,possession_date,furnish_type,construct_Status,
             main_image,image_1,image_2,image_3,image_4,brochure,slug) 
            VALUES 
            ('$propertyname','$buildername','$max_price_int','$min_price_int', '$minprice','$maxprice','$location','$rera_no','$bhk','$video_link','$map',
            '$highlight','$other_key',$bigha,$unit,$floor,$block,$status,$trend,$project_type,$launchSql,
            $possessionSql,'$furnish','$construct','$main_image','$image1','$image2','$image3','$image4','$pdf','$slug')";
        }

        $inserted = false;
        try {
            $inserted = mysqli_query($con, $sql);
        } catch (Throwable $e) {
            $inserted = false;
            $errors[] = "Database Error: " . $e->getMessage();
        }

        if ($inserted) {
            $property_id = mysqli_insert_id($con);

            try {
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
                        if ($img) {
                            $imgEsc = mysqli_real_escape_string($con, $img);
                            mysqli_query($con, "INSERT INTO property_img (property_id,image) VALUES ('$property_id','$imgEsc')");
                        }
                    }
                }

                // ✅ Amenities
                if (!empty($_POST['amenities'])) {
                    foreach ($_POST['amenities'] as $a) {
                        $a_id = (int)$a;
                        mysqli_query($con, "INSERT INTO property_amenities (property_id, amenity_id) VALUES ('$property_id','$a_id')");
                    }
                }

                // ✅ Sub Categories
                if (!empty($_POST['subcat'])) {
                    $cat_id = (int)($_POST['cat_name'] ?? 0);
                    foreach ($_POST['subcat'] as $s) {
                        $s_id = (int)$s;
                        mysqli_query($con, "INSERT INTO property_subcat (property_id,category_id,subcat_id) VALUES ('$property_id','$cat_id','$s_id')");
                    }
                }

                // ✅ Category
                if (!empty($_POST['cat_name'])) {
                    $cat = (int)$_POST['cat_name'];
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
                                        mysqli_query($con, $floorSql);
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (Throwable $e) {
                error_log("Sub-table insert notice: " . $e->getMessage());
            }

            header("Location: new_property");
            exit;
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

    /* 🌿 Premium Amenities & Features Selector */
    .amenities-scroll-wrapper {
        max-height: 360px;
        overflow-y: auto;
        overflow-x: hidden;
        position: relative;
        overflow-anchor: none;
        padding: 12px;
        border-radius: 14px;
        background: #fdfafd;
        border: 1.5px solid #f2e3ec;
        scrollbar-width: thin;
        scrollbar-color: #c02a7c #f0e6ed;
    }
    .amenities-scroll-wrapper::-webkit-scrollbar {
        width: 6px;
    }
    .amenities-scroll-wrapper::-webkit-scrollbar-track {
        background: #f8f1f5;
        border-radius: 6px;
    }
    .amenities-scroll-wrapper::-webkit-scrollbar-thumb {
        background: #c02a7c66;
        border-radius: 6px;
    }
    .amenities-scroll-wrapper::-webkit-scrollbar-thumb:hover {
        background: #c02a7c;
    }

    .amenity-card-item {
        position: relative;
        width: 100%;
        display: block;
    }
    .amenity-checkbox {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
        margin: 0;
    }
    .amenity-btn-label {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 14px;
        border-radius: 10px;
        border: 1.5px solid #e5dfe4;
        background: #ffffff;
        color: #372b33;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        width: 100%;
        user-select: none;
        margin-bottom: 0;
        min-height: 44px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    }
    .amenity-card-item:hover .amenity-btn-label {
        border-color: #c02a7c;
        background: #fff9fc;
        transform: translateY(-1px);
        box-shadow: 0 3px 8px rgba(192, 42, 124, 0.1);
    }
    .amenity-checkbox:checked + .amenity-btn-label {
        background: #fff0f6 !important;
        border-color: #c02a7c !important;
        color: #c02a7c !important;
        font-weight: 600 !important;
        box-shadow: 0 2px 8px rgba(192, 42, 124, 0.18) !important;
    }
    .amenity-icon-indicator {
        font-size: 15px;
        flex-shrink: 0;
        color: #b5a3ad;
        transition: all 0.2s ease;
    }
    .amenity-checkbox:checked + .amenity-btn-label .amenity-icon-indicator {
        color: #c02a7c !important;
    }
    .amenity-name {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
    }
    .amenity-quick-btn {
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 8px;
        transition: all 0.2s ease;
    }
    .amenity-badge-selected {
        background: #fff0f6;
        color: #c02a7c;
        border: 1px solid #f3c2dc;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        border-radius: 20px;
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
                                                            <div class="row g-3">
                                                                <div class="col-md-6">
                                                                    <label class="fw-bold small text-muted">Video Walkthrough (YouTube Link)</label>
                                                                    <input type="text" name="video_link" class="form-control bg-light" placeholder="https://youtube.com/..." value="<?= htmlspecialchars($_POST['video_link'] ?? '') ?>">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label class="fw-bold small text-muted">Or Upload Video File (MP4, WebM)</label>
                                                                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg,video/quicktime" class="form-control bg-light">
                                                                    <small class="text-muted d-block mt-1">Supported: MP4, WebM, MOV (Max 100MB)</small>
                                                                </div>
                                                            </div>
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
                                                                    <label class="fw-bold"><i class="fas fa-file-pdf me-2 text-danger"></i>Project Brochure (PDF) <span class="badge bg-secondary ms-1 fw-normal" style="font-size: 11px;">Optional</span></label>
                                                                    <input type="file" name="brochure" id="brochure" class="form-control" accept=".pdf">
                                                                    <small class="text-muted d-block mt-1">Optional - Upload PDF brochure only if available (Max 200MB)</small>
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
                                                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                    <h6 class="fw-bold mb-0 text-dark">
                                                                        <i class="fas fa-spa me-2 text-primary"></i>Select Amenities & Features
                                                                    </h6>
                                                                    <span class="amenity-badge-selected" id="amenityCountBadge">
                                                                        <i class="fas fa-check-circle me-1"></i><span id="selectedAmenityCount">0</span> of <span id="totalAmenityCount">0</span> Selected
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                                                    <div class="btn-group btn-group-sm shadow-sm" style="border-radius: 8px; overflow: hidden;">
                                                                        <button type="button" class="btn btn-outline-primary amenity-quick-btn" id="selectAllAmenities">
                                                                            <i class="fas fa-check-double me-1"></i>Select All
                                                                        </button>
                                                                        <button type="button" class="btn btn-outline-secondary amenity-quick-btn" id="deselectAllAmenities">
                                                                            <i class="fas fa-times me-1"></i>Clear All
                                                                        </button>
                                                                    </div>
                                                                    <div class="input-group input-group-sm shadow-sm" style="max-width: 250px; border-radius: 8px; overflow: hidden;">
                                                                        <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                                                        <input type="text" id="searchAmenitiesAdd" class="form-control border-start-0" placeholder="Search amenities...">
                                                                        <button class="btn btn-outline-secondary border-start-0 d-none" type="button" id="clearSearchAmenity"><i class="fas fa-times"></i></button>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="amenities-scroll-wrapper" id="amenitiesWrapperAdd">
                                                                <div class="row g-2" id="amenitiesContainerAdd">
                                                                    <?php
                                                                    $amenRes = mysqli_query($con, "SELECT * FROM amenity WHERE status = 1 ORDER BY name ASC");
                                                                    while ($a = mysqli_fetch_assoc($amenRes)): 
                                                                        $checked = (isset($_POST['amenities']) && in_array($a['id'], $_POST['amenities'])) ? 'checked' : '';
                                                                    ?>
                                                                    <div class="col-xl-3 col-lg-4 col-sm-6 col-12 amenity-item-col">
                                                                        <div class="amenity-card-item">
                                                                            <input class="amenity-checkbox" type="checkbox" name="amenities[]" value="<?=$a['id']?>" id="amen-<?=$a['id']?>" <?=$checked?>>
                                                                            <label class="amenity-btn-label" for="amen-<?=$a['id']?>">
                                                                                <i class="fas <?= $checked ? 'fa-check-circle' : 'fa-circle' ?> amenity-icon-indicator"></i> 
                                                                                <span class="amenity-name text-truncate" title="<?= htmlspecialchars($a['name']) ?>"><?= htmlspecialchars($a['name']) ?></span>
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                    <?php endwhile; ?>
                                                                </div>
                                                                <div id="noAmenitiesNotice" class="text-center py-4 text-muted d-none">
                                                                    <i class="fas fa-filter me-2 opacity-50"></i>No matching amenities found.
                                                                </div>
                                                            </div>

                                                            <script>
                                                                (function() {
                                                                    const searchInput = document.getElementById('searchAmenitiesAdd');
                                                                    const clearSearchBtn = document.getElementById('clearSearchAmenity');
                                                                    const items = document.querySelectorAll('#amenitiesContainerAdd .amenity-item-col');
                                                                    const noNotice = document.getElementById('noAmenitiesNotice');
                                                                    const countBadge = document.getElementById('selectedAmenityCount');
                                                                    const totalBadge = document.getElementById('totalAmenityCount');
                                                                    const selectAllBtn = document.getElementById('selectAllAmenities');
                                                                    const deselectAllBtn = document.getElementById('deselectAllAmenities');

                                                                    if (totalBadge) totalBadge.textContent = items.length;

                                                                    function updateCount() {
                                                                        const checked = document.querySelectorAll('#amenitiesContainerAdd .amenity-checkbox:checked').length;
                                                                        if (countBadge) countBadge.textContent = checked;
                                                                    }

                                                                    function syncIcons() {
                                                                        document.querySelectorAll('#amenitiesContainerAdd .amenity-checkbox').forEach(chk => {
                                                                            const icon = chk.closest('.amenity-card-item')?.querySelector('.amenity-icon-indicator');
                                                                            if (icon) {
                                                                                if (chk.checked) {
                                                                                    icon.classList.remove('fa-circle');
                                                                                    icon.classList.add('fa-check-circle');
                                                                                } else {
                                                                                    icon.classList.remove('fa-check-circle');
                                                                                    icon.classList.add('fa-circle');
                                                                                }
                                                                            }
                                                                        });
                                                                        updateCount();
                                                                    }

                                                                    syncIcons();

                                                                    document.querySelectorAll('#amenitiesContainerAdd .amenity-checkbox').forEach(chk => {
                                                                        chk.addEventListener('change', function() {
                                                                            syncIcons();
                                                                        });
                                                                        chk.addEventListener('focus', function(e) {
                                                                            try { e.target.focus({ preventScroll: true }); } catch(_) {}
                                                                        });
                                                                    });

                                                                    function doSearch() {
                                                                        const val = (searchInput?.value || '').toLowerCase().trim();
                                                                        if (clearSearchBtn) {
                                                                            clearSearchBtn.classList.toggle('d-none', !val);
                                                                        }
                                                                        let visibleCount = 0;
                                                                        items.forEach(col => {
                                                                            const name = col.querySelector('.amenity-name')?.innerText.toLowerCase() || '';
                                                                            const matches = name.includes(val);
                                                                            col.style.display = matches ? '' : 'none';
                                                                            if (matches) visibleCount++;
                                                                        });
                                                                        if (noNotice) {
                                                                            noNotice.classList.toggle('d-none', visibleCount > 0);
                                                                        }
                                                                    }

                                                                    searchInput?.addEventListener('input', doSearch);
                                                                    clearSearchBtn?.addEventListener('click', function() {
                                                                        if (searchInput) searchInput.value = '';
                                                                        doSearch();
                                                                        searchInput?.focus();
                                                                    });

                                                                    selectAllBtn?.addEventListener('click', function() {
                                                                        items.forEach(col => {
                                                                            if (col.style.display !== 'none') {
                                                                                const chk = col.querySelector('.amenity-checkbox');
                                                                                if (chk) chk.checked = true;
                                                                            }
                                                                        });
                                                                        syncIcons();
                                                                    });

                                                                    deselectAllBtn?.addEventListener('click', function() {
                                                                        items.forEach(col => {
                                                                            if (col.style.display !== 'none') {
                                                                                const chk = col.querySelector('.amenity-checkbox');
                                                                                if (chk) chk.checked = false;
                                                                            }
                                                                        });
                                                                        syncIcons();
                                                                    });
                                                                })();
                                                            </script>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer bg-white text-center py-4">
                                        <button type="submit" id="btn-submit" class="btn btn-primary btn-round px-5 py-3 shadow">
                                            <i class="fas fa-plus-circle me-2"></i>PUBLISH PROPERTY LISTING
                                        </button>
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
        function syncRera() {
            const reraTypeEl = document.getElementById('rera_type');
            const reraNo = document.getElementById('rera_no');
            if (!reraTypeEl || !reraNo) return;
            if (reraTypeEl.value === 'rera') {
                reraNo.style.display = 'block';
                reraNo.setAttribute('required', 'true');
            } else {
                reraNo.style.display = 'none';
                reraNo.removeAttribute('required');
                reraNo.classList.remove('is-invalid');
                const err = document.getElementById('rera_no_error');
                if (err) err.style.display = 'none';
            }
        }
        document.getElementById('rera_type')?.addEventListener('change', syncRera);
        syncRera();

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
                    if(btn.style.borderBottom && btn.style.borderBottom.includes("red")) {
                        tabsWithErrors.push(btn);
                    }
                });

                if(tabsWithErrors.length > 0) {
                    const firstTab = new bootstrap.Tab(tabsWithErrors[0]);
                    firstTab.show();
                }

                if (typeof swal === 'function') {
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
                } else {
                    alert("Please fill all mandatory fields marked with *");
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