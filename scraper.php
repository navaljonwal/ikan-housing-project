<?php
include 'config.php';

$slugs = [
    'gulmohar-heights',
    'anand-residency-1',
    'floresta-by-reliant-group',
    'sky-star-krishnam',
    'grand-golden-bells',
    'exclusive-444',
    'royal-eternia',
    'urban-height',
    'arihant-legacy',
    'the-century-garden'
];

foreach ($slugs as $slug) {
    // Check if property already exists
    $check_sql = "SELECT id FROM new_property WHERE slug = '$slug'";
    $check_res = mysqli_query($con, $check_sql);
    if(mysqli_num_rows($check_res) > 0) {
        echo "Skipping $slug (Already exists)<br>";
        continue;
    }

    $url = "https://ikanhousing.com/property-detail-for.php?slug=" . $slug;
    
    // Create stream context to handle HTTPS
    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  

    $html = @file_get_contents($url, false, stream_context_create($arrContextOptions));
    
    if (!$html) {
        echo "Failed to load $url <br>";
        continue;
    }

    // Default values for NOT NULL columns
    $project_name = $slug; // fallback
    $rera_no = 'N/A';
    $bhk = 'N/A';
    $video_link = '';
    $map = '';
    $highlight = '';
    $other_key_feature = '';
    $bigha = 0;
    $unit = 0;
    $floor = 0;
    $block = 0;
    $brochure = '';
    $main_image = 'default.jpg';
    $image_1 = '';
    $image_2 = '';
    $image_3 = '';
    $image_4 = '';
    $location = 'Jaipur';
    
    // Extract Title/Name
    if (preg_match('/<h3 class="fw-bold mb-1">\s*(.*?)\s*<span/is', $html, $matches)) {
        $project_name = trim($matches[1]);
    }
    
    // Extract RERA
    if (preg_match('/RERA ID :<\/p>\s*<p class="mb-0 fw-semibold">\s*(.*?)\s*<\/p>/is', $html, $matches)) {
        $rera_no = trim($matches[1]);
    }

    // Extract Price
    $price = '';
    if (preg_match('/Price<\/p>\s*<p class="mb-0 fw-semibold">\s*(.*?)\s*<\/p>/is', $html, $matches)) {
        $price = trim($matches[1]);
    }
    
    // Extract Image (main_image)
    if (preg_match('/<div class="main-image">.*?<img src="(.*?)"/is', $html, $matches)) {
        $main_image = basename(trim($matches[1]));
        // Note: Actual image download is skipped to avoid huge bandwidth/storage issues locally,
        // but we just map the string. You can manually download images later or copy from live.
    }

    // Insert into DB
    $sql = "INSERT INTO new_property (
                project_name, location, rera_no, bhk, video_link, map, highlight, other_key_feature, bigha, unit, floor, block, brochure, main_image, image_1, image_2, image_3, image_4, slug
            ) VALUES (
                '".mysqli_real_escape_string($con, $project_name)."',
                '$location',
                '".mysqli_real_escape_string($con, $rera_no)."',
                '$bhk',
                '$video_link',
                '$map',
                '$highlight',
                '$other_key_feature',
                $bigha,
                $unit,
                $floor,
                $block,
                '$brochure',
                '$main_image',
                '$image_1',
                '$image_2',
                '$image_3',
                '$image_4',
                '$slug'
            )";

    if (mysqli_query($con, $sql)) {
        echo "Successfully inserted $project_name ($slug)<br>";
    } else {
        echo "Error inserting $slug : " . mysqli_error($con) . "<br>";
    }
}
?>
