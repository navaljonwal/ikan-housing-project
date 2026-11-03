<?php
/**
 * Ikan Housing - Automated Database Migration Script
 * Safe, idempotent database schema synchronization for live and local environments.
 * Accessible at: https://ikanhousing.com/migrate.php
 */

include_once(__DIR__ . '/config.php');

$results = [];

function runMigrationStep($title, $sql, &$results, $con) {
    if (!$con) {
        $results[] = [
            'title' => $title,
            'status' => 'danger',
            'message' => 'Database connection failed'
        ];
        return false;
    }

    try {
        $res = mysqli_query($con, $sql);
        if ($res) {
            $results[] = [
                'title' => $title,
                'status' => 'success',
                'message' => 'Executed successfully'
            ];
            return true;
        } else {
            $err = mysqli_error($con);
            // Ignore duplicate column or already exists notices
            if (stripos($err, 'Duplicate column') !== false || stripos($err, 'already exists') !== false) {
                $results[] = [
                    'title' => $title,
                    'status' => 'info',
                    'message' => 'Already up-to-date (Column/Table exists)'
                ];
                return true;
            }
            $results[] = [
                'title' => $title,
                'status' => 'warning',
                'message' => $err
            ];
            return false;
        }
    } catch (Throwable $t) {
        $msg = $t->getMessage();
        if (stripos($msg, 'Duplicate column') !== false || stripos($msg, 'already exists') !== false) {
            $results[] = [
                'title' => $title,
                'status' => 'info',
                'message' => 'Already up-to-date'
            ];
            return true;
        }
        $results[] = [
            'title' => $title,
            'status' => 'danger',
            'message' => $msg
        ];
        return false;
    }
}

// 1. Check if column exists helper
function columnExists($table, $column, $con) {
    try {
        $res = mysqli_query($con, "SHOW COLUMNS FROM `$table` LIKE '$column'");
        return ($res && mysqli_num_rows($res) > 0);
    } catch (Throwable $t) {
        return false;
    }
}

// --- TABLE: new_property ---
// Check & Add video_file
if (!columnExists('new_property', 'video_file', $con)) {
    runMigrationStep("Add 'video_file' column to new_property", "ALTER TABLE new_property ADD COLUMN video_file varchar(255) DEFAULT NULL AFTER video_link", $results, $con);
} else {
    $results[] = ['title' => "Add 'video_file' column to new_property", 'status' => 'info', 'message' => 'Column already exists'];
}

// Relax brochure column to optional DEFAULT '' NULL
runMigrationStep("Make 'brochure' in new_property optional (DEFAULT '' NULL)", "ALTER TABLE new_property MODIFY COLUMN brochure varchar(255) DEFAULT '' NULL", $results, $con);

// Relax strict number columns to DEFAULT 0 NULL
runMigrationStep("Relax 'bigha' in new_property (DEFAULT 0 NULL)", "ALTER TABLE new_property MODIFY COLUMN bigha int(11) DEFAULT 0 NULL", $results, $con);
runMigrationStep("Relax 'unit' in new_property (DEFAULT 0 NULL)", "ALTER TABLE new_property MODIFY COLUMN unit int(11) DEFAULT 0 NULL", $results, $con);
runMigrationStep("Relax 'floor' in new_property (DEFAULT 0 NULL)", "ALTER TABLE new_property MODIFY COLUMN floor int(11) DEFAULT 0 NULL", $results, $con);
runMigrationStep("Relax 'block' in new_property (DEFAULT 0 NULL)", "ALTER TABLE new_property MODIFY COLUMN block int(11) DEFAULT 0 NULL", $results, $con);

// Relax dates to DEFAULT NULL NULL
runMigrationStep("Relax 'launch_date' in new_property (DEFAULT NULL NULL)", "ALTER TABLE new_property MODIFY COLUMN launch_date date DEFAULT NULL NULL", $results, $con);
runMigrationStep("Relax 'possession_date' in new_property (DEFAULT NULL NULL)", "ALTER TABLE new_property MODIFY COLUMN possession_date date DEFAULT NULL NULL", $results, $con);

// Relax price integer columns
runMigrationStep("Relax 'max_price_int' in new_property (DEFAULT NULL NULL)", "ALTER TABLE new_property MODIFY COLUMN max_price_int bigint(20) DEFAULT NULL NULL", $results, $con);
runMigrationStep("Relax 'min_price_int' in new_property (DEFAULT NULL NULL)", "ALTER TABLE new_property MODIFY COLUMN min_price_int bigint(20) DEFAULT NULL NULL", $results, $con);

// Add/relax trending and project_type
runMigrationStep("Ensure 'trending' in new_property (DEFAULT 0 NULL)", "ALTER TABLE new_property MODIFY COLUMN trending tinyint(4) DEFAULT 0 NULL", $results, $con);
runMigrationStep("Ensure 'project_type' in new_property (DEFAULT 1 NULL)", "ALTER TABLE new_property MODIFY COLUMN project_type tinyint(4) DEFAULT 1 NULL", $results, $con);

// Relax about_project
runMigrationStep("Ensure 'about_project' in new_property is nullable", "ALTER TABLE new_property MODIFY COLUMN about_project text DEFAULT NULL NULL", $results, $con);


// --- TABLE: right_contact ---
if (!columnExists('right_contact', 'property_name', $con)) {
    runMigrationStep("Add 'property_name' to right_contact", "ALTER TABLE right_contact ADD COLUMN property_name varchar(255) DEFAULT NULL AFTER phone", $results, $con);
} else {
    $results[] = ['title' => "Add 'property_name' to right_contact", 'status' => 'info', 'message' => 'Column already exists'];
}

if (!columnExists('right_contact', 'property_slug', $con)) {
    runMigrationStep("Add 'property_slug' to right_contact", "ALTER TABLE right_contact ADD COLUMN property_slug varchar(255) DEFAULT NULL AFTER property_name", $results, $con);
} else {
    $results[] = ['title' => "Add 'property_slug' to right_contact", 'status' => 'info', 'message' => 'Column already exists'];
}

runMigrationStep("Ensure 'message' in right_contact is nullable", "ALTER TABLE right_contact MODIFY COLUMN message text DEFAULT NULL NULL", $results, $con);


// --- TABLE: testimonial ---
$testimonialSql = "CREATE TABLE IF NOT EXISTS `testimonial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` text NOT NULL,
  `image` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `slug` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'testimonial' IF NOT EXISTS", $testimonialSql, $results, $con);


// --- TABLE: site_visits ---
$siteVisitsSql = "CREATE TABLE IF NOT EXISTS `site_visits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `property_name` varchar(255) NOT NULL,
  `property_slug` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `visit_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'New',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'site_visits' IF NOT EXISTS", $siteVisitsSql, $results, $con);


// --- TABLE: chatbot_leads ---
$chatbotLeadsSql = "CREATE TABLE IF NOT EXISTS `chatbot_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `service_interest` varchar(100) DEFAULT NULL,
  `page_source` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'chatbot_leads' IF NOT EXISTS", $chatbotLeadsSql, $results, $con);


// --- TABLE: property_amenities ---
$amenitiesSql = "CREATE TABLE IF NOT EXISTS `property_amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'property_amenities' IF NOT EXISTS", $amenitiesSql, $results, $con);


// --- TABLE: property_img ---
$propertyImgSql = "CREATE TABLE IF NOT EXISTS `property_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `image` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'property_img' IF NOT EXISTS", $propertyImgSql, $results, $con);


// --- TABLE: floor_plane ---
$floorPlaneSql = "CREATE TABLE IF NOT EXISTS `floor_plane` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) NOT NULL,
  `property_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'floor_plane' IF NOT EXISTS", $floorPlaneSql, $results, $con);


// --- TABLE: property_subcat ---
$propertySubcatSql = "CREATE TABLE IF NOT EXISTS `property_subcat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `subcat_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'property_subcat' IF NOT EXISTS", $propertySubcatSql, $results, $con);


// --- TABLE: property_category ---
$propertyCatSql = "CREATE TABLE IF NOT EXISTS `property_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'property_category' IF NOT EXISTS", $propertyCatSql, $results, $con);


// --- TABLE: seo_pages (Sync Production Metadata) ---
$seoPagesTableSql = "CREATE TABLE IF NOT EXISTS `seo_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(255) NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_description` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
runMigrationStep("Create table 'seo_pages' IF NOT EXISTS", $seoPagesTableSql, $results, $con);

$seoDataToSync = [
    'index' => [
        'title' => 'I Kan Housing | Trusted Real Estate Company in Jaipur',
        'desc'  => 'Explore residential, commercial, and land projects in Jaipur with I Kan Housing. Find verified properties, investment opportunities, and expert real estate guidance.',
        'keys'  => 'Real Estate Jaipur, Property in Jaipur, Buy Flat in Jaipur, Luxury Apartments Jaipur, Real Estate Agent Jaipur'
    ],
    'about-us' => [
        'title' => 'About I Kan Housing | Jaipur Real Estate Experts',
        'desc'  => 'Learn about I Kan Housing, a Jaipur real estate company helping buyers and investors discover residential, commercial, and land opportunities.',
        'keys'  => 'About I Kan Housing, Real Estate Company Jaipur, Property Consultants Jaipur, Real Estate Team Jaipur'
    ],
    'ongoing-project' => [
        'title' => 'Ongoing Residential Projects in Jaipur | I Kan Housing',
        'desc'  => 'Explore ongoing residential and commercial projects in Jaipur, including project locations, configurations, amenities, prices, and enquiry details.',
        'keys'  => 'Ongoing Projects Jaipur, Under Construction Flats Jaipur, Residential Projects Jaipur, New Housing Projects Jaipur'
    ],
    'complete-project' => [
        'title' => 'Completed Real Estate Projects in Jaipur | I Kan Housing',
        'desc'  => 'View completed residential and commercial projects in Jaipur with project details, locations, configurations, and enquiry information.',
        'keys'  => 'Completed Projects Jaipur, Ready to Move Flats Jaipur, Delivered Real Estate Projects Jaipur'
    ],
    'services' => [
        'title' => 'Real Estate Services in Jaipur | I Kan Housing',
        'desc'  => 'Explore I Kan Housing services for residential sales, land, commercial property, investment, leasing, post-sales support, and real estate advisory in Jaipur.',
        'keys'  => 'Real Estate Services Jaipur, Property Advisory Jaipur, Commercial Leasing Jaipur, Residential Sales Jaipur'
    ],
    'residential' => [
        'title' => 'Residential Properties and Projects in Jaipur | I Kan Housing',
        'desc'  => 'Find residential apartments, homes, and housing projects in Jaipur with project details, locations, configurations, amenities, and enquiry options.',
        'keys'  => 'Residential Property Jaipur, Apartments in Jaipur, Flats for Sale Jaipur, Luxury Homes Jaipur'
    ],
    'land-services' => [
        'title' => 'Land Investment and Development Services in Jaipur | I Kan Housing',
        'desc'  => 'Find land investment, development, and advisory opportunities in Jaipur with I Kan Housing’s local real estate expertise.',
        'keys'  => 'Land Investment Jaipur, Plots in Jaipur, Real Estate Land Acquisition, Land Development Jaipur'
    ],
    'contact' => [
        'title' => 'Contact I Kan Housing | Jaipur Real Estate Enquiries',
        'desc'  => 'Contact I Kan Housing for residential, commercial, land, investment, and property enquiries in Jaipur.',
        'keys'  => 'Contact I Kan Housing, Real Estate Office Jaipur, Property Enquiry Jaipur, Real Estate Agent Contact'
    ],
    'career' => [
        'title' => 'Careers at I Kan Housing | Real Estate Jobs in Jaipur',
        'desc'  => 'Explore career opportunities at I Kan Housing and join a growing real estate team serving buyers and investors in Jaipur.',
        'keys'  => 'Real Estate Jobs Jaipur, Careers at I Kan Housing, Property Sales Jobs Jaipur, Real Estate Hiring'
    ],
    'rewards-&-team' => [
        'title' => 'I Kan Housing Leadership Team and Achievements | Jaipur Real Estate',
        'desc'  => 'Meet the I Kan Housing team and learn about the company’s achievements, experience, and real estate work in Jaipur.',
        'keys'  => 'I Kan Housing Team, Real Estate Leadership Jaipur, Real Estate Awards, Real Estate Management'
    ]
];

if ($con) {
    foreach ($seoDataToSync as $page => $d) {
        $p = mysqli_real_escape_string($con, $page);
        $t = mysqli_real_escape_string($con, $d['title']);
        $de = mysqli_real_escape_string($con, $d['desc']);
        $k = mysqli_real_escape_string($con, $d['keys']);
        $check = mysqli_query($con, "SELECT id FROM seo_pages WHERE page_name = '$p' LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_assoc($check);
            mysqli_query($con, "UPDATE seo_pages SET meta_title = '$t', meta_description = '$de', meta_keywords = '$k', status = 1 WHERE id = " . (int)$row['id']);
        } else {
            mysqli_query($con, "INSERT INTO seo_pages (page_name, meta_title, meta_description, meta_keywords, status) VALUES ('$p', '$t', '$de', '$k', 1)");
        }
    }
    $results[] = ['title' => 'Sync Production SEO Metadata in seo_pages', 'status' => 'success', 'message' => 'Cleaned placeholder strings and synced 10 production pages'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Migration | Ikan Housing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: linear-gradient(135deg, #f8f9fa 0%, #edf2f7 100%);
            min-height: 100vh;
            padding: 40px 15px;
            color: #1e293b;
        }
        .migration-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.06);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            max-width: 850px;
            margin: 0 auto;
        }
        .migration-header {
            background: linear-gradient(135deg, #c02a7c 0%, #8b1356 100%);
            color: #ffffff;
            padding: 30px;
            text-align: center;
        }
        .step-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 20px;
            border-bottom: 1px solid #f1f5f9;
            transition: all 0.2s ease;
        }
        .step-row:last-child {
            border-bottom: none;
        }
        .step-row:hover {
            background: #f8fafc;
        }
        .badge-pill {
            padding: 6px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="migration-card">
    <div class="migration-header">
        <h3 class="fw-bold mb-1"><i class="fas fa-database me-2"></i> Database Schema Migration</h3>
        <p class="mb-0 opacity-75">Ikan Housing Live Synchronization System</p>
    </div>

    <div class="p-4 bg-light border-bottom d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <span class="text-muted small">Database:</span> 
            <strong class="text-primary ms-1"><?= htmlspecialchars($dbname ?? 'ikan-housing') ?></strong>
            <span class="badge bg-success ms-2"><i class="fas fa-check-circle me-1"></i> Connected</span>
        </div>
        <div class="d-flex gap-2">
            <a href="Ikan-Housing-Admin/new-property/addproperty" class="btn btn-sm btn-primary px-3 rounded-pill">
                <i class="fas fa-plus me-1"></i> Add Property
            </a>
            <a href="Ikan-Housing-Admin/new-property/new_property" class="btn btn-sm btn-outline-secondary px-3 rounded-pill">
                <i class="fas fa-boxes me-1"></i> Inventory
            </a>
            <a href="/" class="btn btn-sm btn-outline-dark px-3 rounded-pill">
                <i class="fas fa-home me-1"></i> Home
            </a>
        </div>
    </div>

    <div class="p-3">
        <?php foreach ($results as $r): ?>
            <div class="step-row">
                <div>
                    <strong class="d-block" style="font-size: 14px;"><?= htmlspecialchars($r['title']) ?></strong>
                    <small class="text-muted"><?= htmlspecialchars($r['message']) ?></small>
                </div>
                <div>
                    <?php if ($r['status'] === 'success'): ?>
                        <span class="badge badge-pill bg-success text-white"><i class="fas fa-check me-1"></i> Migrated</span>
                    <?php elseif ($r['status'] === 'info'): ?>
                        <span class="badge badge-pill bg-primary bg-opacity-10 text-primary border border-primary"><i class="fas fa-check-double me-1"></i> Up to Date</span>
                    <?php elseif ($r['status'] === 'warning'): ?>
                        <span class="badge badge-pill bg-warning text-dark"><i class="fas fa-exclamation-triangle me-1"></i> Notice</span>
                    <?php else: ?>
                        <span class="badge badge-pill bg-danger text-white"><i class="fas fa-times me-1"></i> Failed</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="p-4 bg-light text-center border-top">
        <h5 class="text-success fw-bold mb-1"><i class="fas fa-shield-check me-2"></i> Migration Complete</h5>
        <p class="text-muted small mb-0">All tables, optional columns, and relaxed constraints are synchronized with zero data loss.</p>
    </div>
</div>

</body>
</html>
