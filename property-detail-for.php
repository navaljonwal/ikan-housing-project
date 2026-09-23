<?php
include 'config.php'; // database connection file

// Get property slug from URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($con, trim($_GET['slug'])) : '';

$property = null;
if (!empty($slug)) {
  // Fetch property data using slug
  $sql = "SELECT * FROM new_property WHERE slug = '$slug' LIMIT 1";
  $result = mysqli_query($con, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $property = mysqli_fetch_assoc($result);
  }
}

// If no property found by slug, fallback to latest active property
if (!$property) {
  $sql = "SELECT * FROM new_property WHERE status = 1 ORDER BY id DESC LIMIT 1";
  $result = mysqli_query($con, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $property = mysqli_fetch_assoc($result);
  }
}

// If still none, fallback to latest any property
if (!$property) {
  $sql = "SELECT * FROM new_property ORDER BY id DESC LIMIT 1";
  $result = mysqli_query($con, $sql);
  if ($result && mysqli_num_rows($result) > 0) {
    $property = mysqli_fetch_assoc($result);
  }
}

// If no data found at all
if (!$property) {
  echo "<div style='text-align:center; padding:60px 20px; font-family:sans-serif;'><h2>No Property Available</h2><p>Please add properties from the admin panel.</p></div>";
  exit;
}
$slug = $property['slug'] ?? '';

// Trending Properties (alag query)
$similar_query = "SELECT * FROM new_property WHERE status = 1 AND trending = 1 ORDER BY RAND()";
$similar_result = mysqli_query($con, $similar_query);

//fixed 5 img of property
$images = [];
if (!empty($property['main_image']))
  $images[] = $property['main_image'];
if (!empty($property['image_1']))
  $images[] = $property['image_1'];
if (!empty($property['image_2']))
  $images[] = $property['image_2'];
if (!empty($property['image_3']))
  $images[] = $property['image_3'];
if (!empty($property['image_4']))
  $images[] = $property['image_4'];

// Extra images of property
$extra_img = "SELECT image FROM property_img WHERE property_id=" . (int) $property['id'];
$extra_result = mysqli_query($con, $extra_img);
while ($row_ex = mysqli_fetch_assoc($extra_result)) {
  $images[] = $row_ex['image'];
}

// ✅ Robust File Check: Filter out images that don't exist on disk
$valid_images = [];
$upload_path = "uploads/";
foreach (array_unique(array_filter($images)) as $img) {
  $clean_img = trim($img);
  if (!empty($clean_img) && file_exists($upload_path . $clean_img)) {
    $valid_images[] = $clean_img;
  }
}
$images = $valid_images;


// $property['furnish_type'] => 0,1,2
if ($property['furnish_type'] == 0) {
  $furnishText = 'Fully furnished';
} elseif ($property['furnish_type'] == 1) {
  $furnishText = 'Semi furnished';
} elseif ($property['furnish_type'] == 2) {
  $furnishText = 'Unfurnished';
} else {
  $furnishText = 'Not specified';
}

$constructText = '';
if ($property['construct_Status'] == 0) {
  $constructText = 'Ready to move';
} elseif ($property['construct_Status'] == 1) {
  $constructText = 'Under Construction';
} else {
  $constructText = 'Not specified';
}

$flats = 'Flat';

// 💎 Clean Display Helpers
$raw_min_price = trim($property['min_price'] ?? '');
$raw_max_price = trim($property['max_price'] ?? '');
$min_price_display = $raw_min_price;
if (!empty($min_price_display) && !preg_match('/^[₹\s]|Rs/u', $min_price_display)) {
  $min_price_display = '₹' . $min_price_display;
}
$max_price_display = $raw_max_price;
if (!empty($max_price_display) && !preg_match('/^[₹\s]|Rs/u', $max_price_display)) {
  $max_price_display = '₹' . $max_price_display;
}

if (!empty($min_price_display) && !empty($max_price_display)) {
  $price_range_display = $min_price_display . ' – ' . $max_price_display;
} elseif (!empty($min_price_display)) {
  $price_range_display = $min_price_display;
} elseif (!empty($max_price_display)) {
  $price_range_display = $max_price_display;
} else {
  $price_range_display = 'Price on Request';
}

// Clean RERA ID
$raw_desc_content = $property['other_key_feature'] ?? '';
$rera_display = trim($property['rera_no'] ?? '');
if (empty($rera_display) || strtoupper($rera_display) === 'N/A' || $rera_display === '0') {
  if (preg_match('/RAJ\/P\/\d+\/\d+/i', $raw_desc_content, $rera_matches)) {
    $rera_display = $rera_matches[0];
  } else {
    $rera_display = 'N/A';
  }
}

// Clean Possession Date
$possession_display = trim($property['possession_date'] ?? '');
if (!empty($possession_display) && $possession_display !== '0000-00-00' && strtotime($possession_display) !== false) {
  $possession_display = date('F Y', strtotime($possession_display));
} else {
  $possession_display = 'Contact for Details';
}

// Clean Carpet & Build-up Area
$carpet_val = (int)($property['bigha'] ?? 0);
$carpet_display = ($carpet_val > 0) ? $carpet_val . ' sq.ft' : 'On Request';

$buildup_val = (int)($property['unit'] ?? 0);
$buildup_display = ($buildup_val > 0) ? $buildup_val . ' sq.ft' : 'On Request';
?>


<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>
<?php include 'component/premium-styles.php'; ?>

<body style="background:#f8fafc;">
  <script>
    // Persist mobile submission status to localStorage for dual-layer checking
    <?php if (isset($_SESSION['mobile_submitted']) || isset($_COOKIE['mobile_submitted'])): ?>
      localStorage.setItem('mobile_submitted', '1');
    <?php endif; ?>
  </script>
  <?php include 'component/navbar.php'; ?>

  <!-- 💎 Ultra-Luxury Real Estate Hero & Gallery Section -->
  <section class="premium-hero-header" data-aos="fade-down" data-aos-duration="800">
    <div class="container">
      
      <!-- Breadcrumb Navigation -->
      <nav class="property-breadcrumb" aria-label="breadcrumb">
        <a href="index"><i class="fa fa-home me-1"></i> Home</a>
        <span class="separator">/</span>
        <a href="ongoing-project">Jaipur</a>
        <span class="separator">/</span>
        <a href="ongoing-project">Projects</a>
        <span class="separator">/</span>
        <span class="current"><?= htmlspecialchars($property['project_name']) ?></span>
      </nav>

      <!-- Property Title, Meta & Price Header -->
      <div class="row align-items-start justify-content-between mb-3">
        <div class="col-lg-8">
          <h1 class="project-title"><?= htmlspecialchars($property['project_name']) ?></h1>
          
          <div class="project-meta-row">
            <span class="project-meta-item">
              <i class="fa fa-building"></i> Builder:
              <?php
                $showbuilder = "SELECT builder.builder_name FROM new_property LEFT JOIN builder ON new_property.builder_name = builder.id WHERE new_property.id = '" . $property['id'] . "'";
                $resbuilder = mysqli_query($con, $showbuilder);
                $builderRow = mysqli_fetch_assoc($resbuilder);
              ?>
              <a href="ongoing-project"><?= htmlspecialchars($builderRow['builder_name'] ?? 'Ikan Housing Partner') ?></a>
            </span>
            <span class="project-meta-item">
              <i class="fa fa-map-marker-alt"></i> <?= htmlspecialchars($property['location']) ?>
            </span>
          </div>

          <!-- Feature & Verification Pills -->
          <div class="d-flex align-items-center flex-wrap gap-2 mb-2">
            <span class="badge-pill-luxury badge-pill-rera">
              <i class="fa-solid fa-circle-check"></i>
              <?= ($rera_display !== 'N/A') ? 'RERA: ' . htmlspecialchars($rera_display) : 'Verified Property' ?>
            </span>
            <span class="badge-pill-luxury badge-pill-status">
              <i class="fa-solid fa-clock"></i> <?= htmlspecialchars($constructText) ?>
            </span>
            <span class="badge-pill-luxury badge-pill-neutral">
              <i class="fa-regular fa-calendar-check text-muted"></i>
              <?php
                if (!empty($property['created_at'])) {
                  $created_at = new DateTime($property['created_at']);
                  echo "Added " . $created_at->format('j M Y');
                } else {
                  echo "Verified Listing";
                }
              ?>
            </span>
          </div>
        </div>

        <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
          <div class="hero-price-card">
            <div class="hero-price-label">Estimated Price</div>
            <div class="hero-price-value"><?= htmlspecialchars($price_range_display) ?></div>
            <div class="hero-price-emi">
              EMI starts from ₹43,391/mo • <a href="#sectionEmi">Calculate EMI</a>
            </div>
          </div>
        </div>
      </div>

      <!-- 🖼️ Responsive Luxury Gallery -->
      <?php if (!empty($images)): 
        $img_count = count($images);
        $grid_class = ($img_count <= 5) ? 'gallery-grid-' . $img_count : 'gallery-grid-default';
      ?>
      <div class="gallery-wrapper" data-aos="zoom-in" data-aos-duration="1000">
        
        <!-- 🖥️ Desktop Staggered Grid -->
        <div class="gallery-grid-premium <?= $grid_class ?>">
          <!-- Main Featured Image -->
          <div class="gallery-img-bx g-main" onclick="document.getElementById('popup').style.display='block'">
              <div class="badge-verified-float">
                <i class="fa-solid fa-circle-check"></i> Verified Property
              </div>
              <div class="featured-price-tag">
                <i class="fa-solid fa-star me-1"></i> Featured Asset
              </div>
              <img src="uploads/<?= htmlspecialchars(trim($images[0])) ?>" 
                   alt="<?= htmlspecialchars($property['project_name']) ?>" 
                   fetchpriority="high">
          </div>
          
          <?php if (isset($images[1])): ?>
            <div class="gallery-img-bx" onclick="document.getElementById('popup').style.display='block'">
              <img src="uploads/<?= htmlspecialchars(trim($images[1])) ?>" alt="Gallery 1" loading="lazy">
            </div>
          <?php endif; ?>

          <?php if (isset($images[2])): ?>
            <div class="gallery-img-bx" onclick="document.getElementById('popup').style.display='block'">
              <img src="uploads/<?= htmlspecialchars(trim($images[2])) ?>" alt="Gallery 2" loading="lazy">
            </div>
          <?php endif; ?>

          <?php if (isset($images[3])): ?>
            <div class="gallery-img-bx" onclick="document.getElementById('popup').style.display='block'">
              <img src="uploads/<?= htmlspecialchars(trim($images[3])) ?>" alt="Gallery 3" loading="lazy">
            </div>
          <?php endif; ?>

          <?php if (isset($images[4])): ?>
            <div class="gallery-img-bx" onclick="document.getElementById('popup').style.display='block'">
                <?php if ($img_count > 5): ?>
                  <div class="g-view-more">
                      <i class="fa-solid fa-images"></i>
                      <span>+<?= $img_count - 5 ?> More Photos</span>
                  </div>
                <?php endif; ?>
                <img src="uploads/<?= htmlspecialchars(trim($images[4])) ?>" alt="Gallery 4" loading="lazy">
            </div>
          <?php endif; ?>
        </div>

        <!-- 📱 Mobile Premium Slider (Visible on < 992px) -->
        <div class="swiper mobile-gallery-swiper">
            <div class="badge-verified-float">
                <i class="fa-solid fa-circle-check"></i> Verified
            </div>
            <div class="gallery-count-chip">
                <i class="fa-solid fa-camera me-1"></i> <span class="current-idx">1</span> / <?= $img_count ?>
            </div>
            <div class="swiper-wrapper">
                <?php foreach ($images as $img): ?>
                <div class="swiper-slide" onclick="document.getElementById('popup').style.display='block'">
                    <img src="uploads/<?= htmlspecialchars(trim($img)) ?>" alt="Property View" loading="lazy">
                </div>
                <?php endforeach; ?>
            </div>
            <div class="swiper-pagination swiper-pagination-premium"></div>
        </div>

      </div>
      <?php endif; ?>

      <!-- 🎯 High-Converting Action Toolbar (Directly Below Gallery) -->
      <div class="property-actions-container">
        <div class="property-actions-toolbar">
          <div class="actions-group-primary">
            <button type="button" class="btn-action-primary" data-bs-toggle="modal" data-bs-target="#siteVisitModal">
              <i class="fa-solid fa-calendar-check"></i> Schedule Free Site Visit
            </button>

            <a href="https://wa.me/918955331454?text=<?= urlencode('Hello Ikan Housing, I am interested in ' . $property['project_name'] . ' (' . $property['location'] . '). Please share details.') ?>" target="_blank" class="btn-action-whatsapp">
              <i class="fa-brands fa-whatsapp" style="font-size: 17px; color: #22c55e;"></i> WhatsApp Advisor
            </a>

            <?php if (!empty($property['brochure']) && file_exists('uploads/' . trim($property['brochure']))): ?>
              <a href="uploads/<?= htmlspecialchars(trim($property['brochure'])); ?>" download class="btn-action-brochure">
                <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Brochure
              </a>
            <?php else: ?>
              <a href="#sidebarContactForm" class="btn-action-brochure">
                <i class="fa-solid fa-file-pdf" style="color: #ef4444;"></i> Brochure
              </a>
            <?php endif; ?>
          </div>

          <div class="actions-group-secondary">
            <button type="button" class="btn-action-pill" id="savePropertyBtn" onclick="toggleSaveProperty();">
              <i class="fa-regular fa-heart" style="color: #c02a7c;"></i> Save
            </button>

            <div class="dropdown">
              <button class="btn-action-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa-solid fa-share-nodes" style="color: #64748b;"></i> Share
              </button>
              <div class="dropdown-menu dropdown-menu-end shadow-lg border-0" style="border-radius:15px; padding:10px; min-width: 180px;">
                <a class="dropdown-item d-flex align-items-center py-2" href="https://api.whatsapp.com/send?text=<?= urlencode('Check out this property: ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                  <i class="fa-brands fa-whatsapp" style="color: #25D366; font-size:18px; width:25px;"></i> WhatsApp
                </a>
                <a class="dropdown-item d-flex align-items-center py-2" href="https://www.facebook.com/sharer/sharer?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                  <i class="fa-brands fa-facebook" style="color: #1877F2; font-size:18px; width:25px;"></i> Facebook
                </a>
                <a class="dropdown-item d-flex align-items-center py-2" href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                  <i class="fa-brands fa-x-twitter" style="color: #000; font-size:18px; width:25px;"></i> Twitter (X)
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item d-flex align-items-center py-2" href="javascript:void(0);" onclick="copyToClipboard();">
                  <i class="fa-solid fa-link" style="color: #64748b; font-size:16px; width:25px;"></i> Copy Link
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <?php
  // Check if property has floor plans
  $has_floor_plans = false;
  $fp_check_res = mysqli_query($con, "SELECT id FROM floor_plane WHERE property_id = " . (int)$property['id'] . " LIMIT 1");
  if ($fp_check_res && mysqli_num_rows($fp_check_res) > 0) {
    $has_floor_plans = true;
  }
  ?>
  <!-- 🧭 Sticky Quick Anchor Navigation Sub-Bar -->
  <div class="property-subnav-sticky" id="propertySubnavSticky">
    <div class="container">
      <div class="subnav-scroll-wrap">
        <a href="#sectionOverview" class="subnav-link active" data-target="#sectionOverview"><i class="fa fa-list-check"></i> Key Specs</a>
        <a href="#sectionAbout" class="subnav-link" data-target="#sectionAbout"><i class="fa fa-file-lines"></i> About Project</a>
        <?php if (!empty(trim($property['highlight'] ?? ''))): ?>
          <a href="#sectionHighlights" class="subnav-link" data-target="#sectionHighlights"><i class="fa fa-sparkles"></i> Highlights</a>
        <?php endif; ?>
        <a href="#sectionAmenities" class="subnav-link" data-target="#sectionAmenities"><i class="fa fa-swimming-pool"></i> Amenities</a>
        <?php if ($has_floor_plans): ?>
          <a href="#sectionFloorPlans" class="subnav-link" data-target="#sectionFloorPlans"><i class="fa fa-ruler-combined"></i> Floor Plans</a>
        <?php endif; ?>
        <a href="#sectionEmi" class="subnav-link" data-target="#sectionEmi"><i class="fa fa-calculator"></i> EMI Calculator</a>
        <?php if (!empty(trim($property['map'] ?? ''))): ?>
          <a href="#sectionMap" class="subnav-link" data-target="#sectionMap"><i class="fa fa-map-location-dot"></i> Location & Map</a>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <section class="property-section pb-5" id="propertyDetailPage">
    <div class="container">
      <div class="row g-4">

        <!-- Left Side: Main Property Content (8 Cols) -->
        <div class="col-12 col-lg-8">
          
          <!-- 🍱 1. Key Specifications: Modern Bento Overview Grid -->
          <div id="sectionOverview" class="mb-4" data-aos="fade-up" data-aos-duration="800">
            <div class="section-title-luxury">
              <span class="heading-accent-bar"></span> Key Specifications & Overview
            </div>
            <p class="section-subtitle-luxury">Essential details and verified configurations for this project.</p>

            <div class="bento-overview-grid">
              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-status"><i class="fa fa-building"></i></div>
                <div>
                  <div class="bento-label">Status</div>
                  <div class="bento-value"><?= htmlspecialchars($constructText) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-bhk"><i class="fa fa-bed"></i></div>
                <div>
                  <div class="bento-label">Configurations</div>
                  <div class="bento-value"><?= htmlspecialchars($property['bhk']) ?> Apts</div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-carpet"><i class="fa fa-vector-square"></i></div>
                <div>
                  <div class="bento-label">Carpet Area</div>
                  <div class="bento-value"><?= htmlspecialchars($carpet_display) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-buildup"><i class="fa fa-ruler-combined"></i></div>
                <div>
                  <div class="bento-label">Build-Up Area</div>
                  <div class="bento-value"><?= htmlspecialchars($buildup_display) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-price"><i class="fa fa-tags"></i></div>
                <div>
                  <div class="bento-label">Price Range</div>
                  <div class="bento-value"><?= htmlspecialchars($price_range_display) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-possession"><i class="fa fa-calendar-check"></i></div>
                <div>
                  <div class="bento-label">Possession Date</div>
                  <div class="bento-value"><?= htmlspecialchars($possession_display) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-furnish"><i class="fa fa-couch"></i></div>
                <div>
                  <div class="bento-label">Furnishing</div>
                  <div class="bento-value"><?= htmlspecialchars($furnishText) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-category"><i class="fa fa-home"></i></div>
                <div>
                  <div class="bento-label">Property Type</div>
                  <div class="bento-value"><?= htmlspecialchars($flats) ?></div>
                </div>
              </div>

              <div class="bento-card">
                <div class="bento-icon-circle bento-icon-rera"><i class="fa fa-shield-halved"></i></div>
                <div>
                  <div class="bento-label"><?= ($property['rera_no'] != "JDA Approved") ? "RERA ID" : "Approval" ?></div>
                  <div class="bento-value"><?= ($property['rera_no'] != "JDA Approved") ? htmlspecialchars($rera_display) : "JDA Approved" ?></div>
                </div>
              </div>
            </div>
          </div>

          <!-- 📝 2. About Project & Rich Narrative Card -->
          <div id="sectionAbout" class="content-card-luxury" data-aos="fade-up" data-aos-duration="800">
            <div class="section-title-luxury mb-3">
              <span class="heading-accent-bar"></span> About <?= htmlspecialchars($property['project_name']) ?>
            </div>

            <div class="property-rich-desc">
              <?php 
              $desc = trim($property['other_key_feature'] ?? '');
              if (!empty($desc)) {
                // Clean SEO & prompt meta blocks that leaked into description
                $desc = preg_replace('/<h[1-6][^>]*>.*?SEO.*?<\/h[1-6]>/si', '', $desc);
                $desc = preg_replace('/<p[^>]*>.*?\(Targeting.*?<\/p>/si', '', $desc);
                $desc = preg_replace('/<p[^>]*>.*?Title:.*?<\/p>/si', '', $desc);
                $desc = preg_replace('/<p[^>]*>.*?Meta(?:&nbsp;|\s)*Description:.*?<\/p>/si', '', $desc);
                // Remove empty 3rd table column cells
                $desc = str_replace('<td>&nbsp;</td>', '', $desc);
                $desc = str_replace('<td></td>', '', $desc);
                // Clean empty paragraphs
                $desc = preg_replace('/<p[^>]*>(&nbsp;|\s)*<\/p>/si', '', $desc);
                echo $desc;
              } else {
                echo '<p class="text-muted">Detailed project description and specifications will be updated soon.</p>';
              }
              ?>
            </div>

            <!-- Luxury Brochure Action Card -->
            <div class="brochure-card-premium">
              <div class="brochure-icon-badge">
                <i class="fa-solid fa-file-pdf"></i>
              </div>
              <div class="flex-grow-1">
                <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 2px;">Official Project Brochure</h5>
                <p style="color: #64748b; font-size: 13.5px; margin: 0; font-weight: 500;">
                  Download comprehensive floor plans, payment schedules & technical specifications.
                </p>
              </div>
              <?php if (!empty($property['brochure']) && file_exists('uploads/' . trim($property['brochure']))): ?>
                <a href="uploads/<?= htmlspecialchars(trim($property['brochure'])); ?>" class="btn-premium-brochure" download>
                  <i class="fa-solid fa-download me-1"></i> Download PDF
                </a>
              <?php else: ?>
                <a href="#sidebarContactForm" class="btn-premium-brochure">
                  <i class="fa-solid fa-envelope me-1"></i> Request PDF
                </a>
              <?php endif; ?>
            </div>
          </div>
          
          <!-- ✨ 3. Project Highlights & Connectivity (Only shown when content exists!) -->
          <?php 
          $hl = trim($property['highlight'] ?? '');
          if (!empty($hl)): 
          ?>
          <div id="sectionHighlights" class="content-card-luxury" data-aos="fade-up" data-aos-duration="800">
            <div class="section-title-luxury">
              <span class="heading-accent-bar"></span> Project Highlights & Connectivity
            </div>
            <p class="section-subtitle-luxury">Key neighborhood landmarks and strategic access routes.</p>

            <div class="highlights-grid-container">
              <?php 
              if (preg_match_all('/<li>(.*?)<\/li>/i', $hl, $hl_matches)) {
                foreach ($hl_matches[1] as $item) {
                  $clean_item = trim(strip_tags($item));
                  if (!empty($clean_item)) {
                    echo '<div class="highlight-item-card">';
                    echo '  <div class="highlight-icon-check"><i class="fa-solid fa-check"></i></div>';
                    echo '  <span>' . htmlspecialchars($clean_item) . '</span>';
                    echo '</div>';
                  }
                }
              } else {
                $lines = array_filter(array_map('trim', explode("\n", strip_tags($hl))));
                foreach ($lines as $line) {
                  if (!empty($line)) {
                    echo '<div class="highlight-item-card">';
                    echo '  <div class="highlight-icon-check"><i class="fa-solid fa-check"></i></div>';
                    echo '  <span>' . htmlspecialchars($line) . '</span>';
                    echo '</div>';
                  }
                }
              }
              ?>
            </div>
          </div>
          <?php endif; ?>

          <!-- 🏊 4. Project Amenities -->
          <?php
          $property_id = (int) $property['id'];
          $amenity_querry = "SELECT amenity.name, amenity.icon
           FROM amenity 
           INNER JOIN property_amenities 
           on amenity.id=property_amenities.amenity_id 
           WHERE property_amenities.property_id= $property_id";
          $amenity_result = mysqli_query($con, $amenity_querry);
          $amenities = [];
          while ($row_amenity = mysqli_fetch_assoc($amenity_result)) {
            $amenities[] = $row_amenity;
          }
          if (empty($amenities)) {
            $all_amenities_q = mysqli_query($con, "SELECT name, icon FROM amenity WHERE status = 1");
            if ($all_amenities_q) {
              $search_blob = ($property['other_key_feature'] ?? '') . ' ' . ($property['highlight'] ?? '');
              while ($am_row = mysqli_fetch_assoc($all_amenities_q)) {
                if (stripos($search_blob, $am_row['name']) !== false) {
                  $amenities[] = $am_row;
                }
              }
            }
          }
          ?>
          <?php if (!empty($amenities)): ?>
          <div id="sectionAmenities" class="content-card-luxury" data-aos="fade-up" data-aos-duration="800">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
              <div>
                <div class="section-title-luxury">
                  <span class="heading-accent-bar"></span> World-Class Amenities
                </div>
                <p class="section-subtitle-luxury mb-0">Designed for modern lifestyle and leisure.</p>
              </div>
              <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill font-monospace" style="font-size:12px; font-weight:700;">
                <?= count($amenities) ?> Amenities
              </span>
            </div>

            <div class="amenities-premium-grid mt-3" id="amenitiesGrid">
              <?php
              foreach ($amenities as $index => $am):
                $hidden_class = ($index >= 8) ? 'amenity-hidden d-none' : '';
                ?>
                <div class="amenity-premium-badge <?= $hidden_class ?>">
                  <img src="uploads/<?php echo htmlspecialchars($am['icon']); ?>" alt="amenity icon">
                  <span><?php echo htmlspecialchars($am['name']); ?></span>
                </div>
                <?php
              endforeach;
              ?>
            </div>

            <?php if (count($amenities) > 8): ?>
              <div class="text-center mt-3 pt-2">
                <button id="toggleAmenitiesBtn" onclick="toggleAmenities();" class="btn btn-sm btn-light border px-4 py-2 rounded-pill" style="font-weight:700; color:#c02a7c;">
                  <i class="fa-solid fa-plus me-1"></i> View All (<?= count($amenities) ?>) Amenities
                </button>
              </div>
            <?php endif; ?>

            <script>
              function toggleAmenities() {
                const hiddenItems = document.querySelectorAll('.amenity-hidden');
                const btn = document.getElementById('toggleAmenitiesBtn');
                
                hiddenItems.forEach(item => {
                  if(item.classList.contains('d-none')) {
                    item.classList.remove('d-none');
                    btn.innerHTML = '<i class="fa-solid fa-minus me-1"></i> View Less';
                  } else {
                    item.classList.add('d-none');
                    btn.innerHTML = '<i class="fa-solid fa-plus me-1"></i> View All (<?= count($amenities) ?>) Amenities';
                  }
                });
              }
            </script>
          </div>
          <?php endif; ?>

          <!-- 🎬 5. Media & Videos Section -->
          <?php
          $video_url = trim($property['video_link'] ?? '');
          $embed_url = '';
          if (!empty($video_url)) {
            if (strpos($video_url, 'embed') !== false) {
              $embed_url = $video_url;
            } elseif (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $match)) {
              $embed_url = 'https://www.youtube.com/embed/' . $match[1];
            }
          }
          $video_file = trim($property['video_file'] ?? '');
          $has_video_file = !empty($video_file) && file_exists(__DIR__ . '/uploads/' . $video_file);
          ?>
          <?php if (!empty($embed_url) || $has_video_file): ?>
          <div id="sectionMedia" class="content-card-luxury" data-aos="fade-up" data-aos-duration="800">
            <div class="section-title-luxury">
              <span class="heading-accent-bar"></span> Virtual Tour & Video Walkthrough
            </div>
            <p class="section-subtitle-luxury">Take an immersive virtual walkthrough of the property.</p>

            <div class="map-iframe-container" style="height: 420px !important;">
              <?php if ($has_video_file): ?>
                <video controls playsinline class="w-100 h-100" style="object-fit: cover;">
                  <source src="uploads/<?= htmlspecialchars($video_file) ?>">
                  Your browser does not support the video tag.
                </video>
              <?php elseif (!empty($embed_url)): ?>
                <iframe src="<?= htmlspecialchars($embed_url) ?>" title="Virtual Tour"
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                  referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                </iframe>
              <?php endif; ?>
            </div>
          </div>
          <?php endif; ?>

          <!-- 📐 6. Interactive Floor Plans -->
          <?php
          $bhk_query = "
                  SELECT sub_category.id AS subcat_id, sub_category.name AS bhk_name
                  FROM sub_category
                  INNER JOIN property_subcat
                  ON sub_category.id = property_subcat.subcat_id
                  WHERE property_subcat.property_id = $property_id
                  ";
          $bhk_res = mysqli_query($con, $bhk_query);

          $bhks = [];
          while ($row = mysqli_fetch_assoc($bhk_res)) {
            $bhks[] = [
              'id' => $row['subcat_id'],
              'name' => $row['bhk_name']
            ];
          }

          $img_query = "SELECT subcat_id, image FROM floor_plane WHERE property_id = $property_id";
          $img_res = mysqli_query($con, $img_query);

          $bhk_images = [];
          $upload_path = "uploads/";
          while ($row3 = mysqli_fetch_assoc($img_res)) {
            $f_img = trim($row3['image']);
            if (!empty($f_img) && file_exists($upload_path . $f_img)) {
              $bhk_images[$row3['subcat_id']][] = $f_img;
            }
          }

          if (!empty($bhk_images)) :
          ?>
          <div id="sectionFloorPlans" class="floorplan-card-luxury" data-aos="fade-up" data-aos-duration="800">
            <div class="section-title-luxury">
              <span class="heading-accent-bar"></span> Floor Plans & Layouts
            </div>
            <p class="section-subtitle-luxury">Explore spacious layouts and architectural designs.</p>

            <div class="rd-flore-pland">
              <div class="rd-bhk-buttons">
                <?php foreach ($bhks as $index => $b): ?>
                  <button class="<?= $index == 0 ? 'active' : '' ?>" onclick="rdShowSlider('bhk-<?= $index ?>', event)">
                    <?= htmlspecialchars($b['name']) ?>
                  </button>
                <?php endforeach; ?>
              </div>
              <?php
              foreach ($bhks as $index => $b):
                $subcat_id = $b['id'];
                $images = $bhk_images[$subcat_id] ?? [];
                ?>
                <div id="bhk-<?= $index ?>" class="rd-slider <?= $index == 0 ? 'active' : '' ?>">
                  <button class="rd-arrow rd-left" onclick="rdPrevSlide('bhk-<?= $index ?>')">
                    &#10094;
                  </button>
                  <div class="rd-slides">
                    <?php if (!empty($images)): 
                       foreach ($images as $img): ?>  
                        <img src="uploads/<?= $img ?>" alt="Floor Plan">
                      <?php endforeach;
                     else: ?>
                      <img src="img/no-image.jpg" alt="No Image">
                    <?php endif; ?>
                  </div>
                  <button class="rd-arrow rd-right" onclick="rdNextSlide('bhk-<?= $index ?>')">
                    &#10095;
                  </button>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <?php endif; ?>

          <!-- 🧮 7. Interactive Home Loan EMI Calculator -->
          <?php
          $init_loan_amount = 5000000;
          if (!empty($property['min_price_int']) && $property['min_price_int'] > 0) {
              $calc_loan = round(($property['min_price_int'] * 0.8) / 100000) * 100000;
              if ($calc_loan >= 500000 && $calc_loan <= 50000000) {
                  $init_loan_amount = $calc_loan;
              }
          }
          ?>
          <div id="sectionEmi" class="emi-card-premium" data-aos="fade-up" data-aos-duration="800">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4 pb-3 border-bottom">
              <div>
                <span class="emi-section-badge">MORTGAGE CALCULATOR</span>
                <h4 class="emi-section-title">
                  <i class="fa-solid fa-calculator" style="color: #c02a7c;"></i> Home Loan EMI Calculator
                </h4>
                <p class="emi-section-subtitle">Plan your monthly budget with live bank interest rate estimates.</p>
              </div>
              <div class="emi-rate-pill">
                <i class="fa-solid fa-sparkles me-1"></i> Rates from 8.5% p.a.*
              </div>
            </div>

            <div class="row g-4 align-items-stretch">
              <!-- Left: Sliders -->
              <div class="col-12 col-lg-7">
                <!-- Loan Amount -->
                <div class="emi-slider-wrap">
                  <div class="emi-label-row">
                    <span class="emi-label-title">Loan Amount</span>
                    <span id="emiLoanAmountDisplay" class="emi-val-pill">₹<?= number_format($init_loan_amount) ?></span>
                  </div>
                  <input type="range" class="emi-slider" id="emiLoanInput" min="500000" max="50000000" step="50000" value="<?= $init_loan_amount ?>">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mt-1">
                    <span class="text-muted" style="font-size:11px; font-weight:600;">₹5 L</span>
                    <div class="d-flex gap-1">
                      <button type="button" class="emi-quick-btn" onclick="setEmiAmount(2500000)">₹25 L</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiAmount(5000000)">₹50 L</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiAmount(7500000)">₹75 L</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiAmount(10000000)">₹1 Cr</button>
                    </div>
                    <span class="text-muted" style="font-size:11px; font-weight:600;">₹5 Cr</span>
                  </div>
                </div>

                <!-- Interest Rate -->
                <div class="emi-slider-wrap">
                  <div class="emi-label-row">
                    <span class="emi-label-title">Interest Rate (% p.a.)</span>
                    <span id="emiRateDisplay" class="emi-val-pill">8.5% p.a.</span>
                  </div>
                  <input type="range" class="emi-slider" id="emiRateInput" min="6.0" max="15.0" step="0.1" value="8.5">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mt-1">
                    <span class="text-muted" style="font-size:11px; font-weight:600;">6.0%</span>
                    <div class="d-flex gap-1">
                      <button type="button" class="emi-quick-btn" onclick="setEmiRate(8.0)">8.0%</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiRate(8.5)">8.5%</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiRate(9.0)">9.0%</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiRate(9.5)">9.5%</button>
                    </div>
                    <span class="text-muted" style="font-size:11px; font-weight:600;">15.0%</span>
                  </div>
                </div>

                <!-- Tenure -->
                <div class="emi-slider-wrap mb-0">
                  <div class="emi-label-row">
                    <span class="emi-label-title">Loan Tenure</span>
                    <span id="emiTenureDisplay" class="emi-val-pill">20 Years (240 M)</span>
                  </div>
                  <input type="range" class="emi-slider" id="emiTenureInput" min="1" max="30" step="1" value="20">
                  <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mt-1">
                    <span class="text-muted" style="font-size:11px; font-weight:600;">1 Yr</span>
                    <div class="d-flex gap-1">
                      <button type="button" class="emi-quick-btn" onclick="setEmiTenure(10)">10 Yrs</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiTenure(15)">15 Yrs</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiTenure(20)">20 Yrs</button>
                      <button type="button" class="emi-quick-btn" onclick="setEmiTenure(25)">25 Yrs</button>
                    </div>
                    <span class="text-muted" style="font-size:11px; font-weight:600;">30 Yrs</span>
                  </div>
                </div>
              </div>

              <!-- Right: Luxury Dark Slate Result Card -->
              <div class="col-12 col-lg-5">
                <div class="emi-result-panel">
                  <div>
                    <div class="emi-card-lbl">Estimated Monthly EMI</div>
                    <div class="emi-highlight-amount" id="emiMonthlyDisplay">₹43,391</div>
                    <div class="emi-sub-duration" id="emiSubtext">per month for 20 years</div>
                  </div>

                  <div class="my-3">
                    <div class="emi-breakup-bar">
                      <div class="emi-bar-principal" id="emiPrincipalBar" style="width: 48%;"></div>
                      <div class="emi-bar-interest" id="emiInterestBar" style="width: 52%;"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center small mt-1">
                      <span style="color:#38bdf8; font-weight:700;"><i class="fa-solid fa-circle me-1" style="font-size:8px;"></i> <span id="emiPrincipalLabel">Principal (48%)</span></span>
                      <span style="color:#ec4899; font-weight:700;"><i class="fa-solid fa-circle me-1" style="font-size:8px;"></i> <span id="emiInterestLabel">Interest (52%)</span></span>
                    </div>
                  </div>

                  <div class="border-top border-secondary pt-2" style="border-color: #334155 !important;">
                    <div class="emi-breakdown-row">
                      <span class="lbl">Principal Amount:</span>
                      <span class="val" id="emiPrincipalDisplay">₹50,00,000</span>
                    </div>
                    <div class="emi-breakdown-row">
                      <span class="lbl">Total Interest:</span>
                      <span class="val" id="emiInterestDisplay">₹54,13,879</span>
                    </div>
                    <div class="emi-breakdown-row total-row">
                      <span class="lbl" style="color:#ffffff; font-weight:700;">Total Payable:</span>
                      <span class="val" id="emiTotalPayableDisplay">₹1,04,13,879</span>
                    </div>
                  </div>

                  <div>
                    <a href="#" id="emiLoanAssistanceBtn" target="_blank" class="btn-emi-cta">
                      <i class="fa-solid fa-hand-holding-dollar me-2"></i> Apply for Home Loan
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- 📍 8. Project Location & Interactive Map -->
          <?php if (!empty(trim($property['map'] ?? ''))): ?>
          <div id="sectionMap" class="map-card-luxury" data-aos="fade-up" data-aos-duration="800">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
              <div>
                <div class="section-title-luxury">
                  <span class="heading-accent-bar"></span> Project Location & Neighborhood
                </div>
                <p class="section-subtitle-luxury mb-0">
                  <i class="fa-solid fa-location-dot me-1 text-danger"></i> <?= htmlspecialchars($property['location']) ?>
                </p>
              </div>
              <a href="https://maps.google.com/?q=<?= urlencode($property['project_name'] . ' ' . $property['location']) ?>" target="_blank" class="btn btn-sm btn-light border px-3 py-2 rounded-pill font-weight-bold" style="color:#c02a7c; font-weight:700;">
                <i class="fa-solid fa-diamond-turn-right me-1"></i> Get Directions
              </a>
            </div>

            <div class="map-iframe-container">
              <?php echo $property['map']; ?>
            </div>
          </div>
          <?php endif; ?>

        </div>

        <!-- Right Side: High-Conversion Sticky Contact Sidebar (4 Cols) -->
        <div class="col-12 col-lg-4">
          <div class="sidebar-sticky">
            <div id="formMessage"></div>
            
            <div class="luxury-sidebar-card">
              <div class="badge-sidebar-demand">
                <i class="fa-solid fa-bolt"></i> High Demand Property in This Area
              </div>

              <!-- Agency Profile Header -->
              <div class="sidebar-agency-profile">
                <div class="sidebar-agency-avatar">
                  <i class="fa-solid fa-building-circle-check"></i>
                </div>
                <div>
                  <h5 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 17px; line-height: 1.2;">
                    I Kan Housing <i class="fa-solid fa-circle-check text-success" style="font-size: 13px;" title="Verified Platinum Partner"></i>
                  </h5>
                  <p style="color: #64748b; font-weight: 600; margin: 3px 0 0; font-size: 13.5px;">
                    <i class="fa-solid fa-phone-volume me-1 text-success"></i> +91 89553 31454
                  </p>
                </div>
              </div>

              <!-- Instant Lead Capture Form -->
              <form class="contact-form" method="POST" id="sidebarContactForm">
                <input type="hidden" name="property_slug" value="<?= htmlspecialchars($slug) ?>">
                <input type="hidden" name="property_name" value="<?= htmlspecialchars($property['project_name']) ?>">
                
                <div class="sidebar-form-group">
                  <div class="sidebar-input-wrap">
                    <i class="fa-solid fa-user sidebar-input-icon"></i>
                    <input type="text" name="c_name" class="sidebar-input" placeholder="Your Full Name *" required>
                  </div>
                </div>

                <div class="sidebar-form-group">
                  <div class="sidebar-input-wrap">
                    <i class="fa-solid fa-envelope sidebar-input-icon"></i>
                    <input type="email" name="email" class="sidebar-input" placeholder="Email Address *" required>
                  </div>
                </div>

                <div class="sidebar-form-group">
                  <div class="sidebar-input-wrap">
                    <i class="fa-solid fa-phone sidebar-input-icon"></i>
                    <input type="tel" name="phone" maxlength="10" pattern="[0-9]{10}" class="sidebar-input" placeholder="Mobile Number (10 Digits) *" required>
                  </div>
                </div>

                <div class="form-check mb-3 mt-2">
                  <input type="checkbox" class="form-check-input" id="agree" checked>
                  <label for="agree" class="form-check-label" style="font-size:12px; color:#64748b; cursor:pointer;">
                    I agree to receive project updates via WhatsApp and phone.
                  </label>
                </div>

                <button type="submit" class="btn-sidebar-submit" id="sidebarSubmitBtn">
                  <span>Request Instant Callback</span>
                  <i class="fa-solid fa-arrow-right"></i>
                </button>
              </form>

              <!-- Quick Action Conversion CTAs -->
              <div class="sidebar-dual-actions">
                <button type="button" class="sidebar-btn-visit" data-bs-toggle="modal" data-bs-target="#siteVisitModal">
                  <i class="fa-solid fa-calendar-check"></i> Book Visit
                </button>
                <a href="https://wa.me/918955331454?text=<?= urlencode('Hello Ikan Housing, I am interested in ' . $property['project_name'] . ' (' . $property['location'] . '). Please share details.') ?>" target="_blank" class="sidebar-btn-whatsapp">
                  <i class="fa-brands fa-whatsapp" style="font-size: 16px; color: #22c55e;"></i> WhatsApp
                </a>
              </div>

              <!-- Buyer Trust Indicators -->
              <div class="sidebar-trust-box">
                <span><i class="fa-solid fa-shield-halved text-success me-1"></i> Zero Brokerage</span>
                <span>•</span>
                <span><i class="fa-solid fa-user-shield text-primary me-1"></i> Free Site Visit</span>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- 📱 Mobile Floating Sticky Conversion Bar (< 992px) -->
  <div class="mobile-sticky-actionbar d-lg-none">
    <div class="mobile-sticky-price">
      <div class="lbl">Price Range</div>
      <div class="val"><?= htmlspecialchars($min_price_display ?: 'On Request') ?></div>
    </div>
    <div class="mobile-sticky-btns">
      <a href="https://wa.me/918955331454?text=<?= urlencode('Hello Ikan Housing, I am interested in ' . $property['project_name'] . ' (' . $property['location'] . '). Please share details.') ?>" target="_blank" class="btn-mobile-wa" title="WhatsApp Advisor">
        <i class="fa-brands fa-whatsapp"></i>
      </a>
      <button type="button" class="btn-mobile-visit" data-bs-toggle="modal" data-bs-target="#siteVisitModal">
        <i class="fa-solid fa-calendar-check"></i> Book Visit
      </button>
    </div>
  </div>

  <!-- Hidden Popup Slider (Safely outside content flow) -->
  <div id="popup" class="popup popup-v" style="display:none;">
    <div class="popup-content">
      <span class="close" onclick="document.getElementById('popup').style.display='none'">&times;</span>
      <div class="popup-slider">
        <?php foreach ($images as $img): ?>
          <div class="popup-slide">
            <img src="uploads/<?php echo trim($img); ?>" alt="Property Image" loading="lazy">
          </div>
        <?php endforeach; ?>
      </div>
      <a class="prevv">❮</a>
      <a class="nextt">❯</a>
    </div>
  </div>

  <!-- 📅 Modal: Schedule a Site Visit -->
  <div class="modal fade modal-site-visit" id="siteVisitModal" tabindex="-1" aria-labelledby="siteVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <div>
            <h5 class="modal-title mb-0" id="siteVisitModalLabel">
              <i class="fa-solid fa-calendar-check" style="color: #c02a7c; margin-right: 8px;"></i> Schedule a Free Site Visit
            </h5>
            <p class="modal-subtitle">Tour <strong><?= htmlspecialchars($property['project_name']) ?></strong> with our verified property advisor.</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="siteVisitMsg" class="d-none mb-3"></div>

          <form id="siteVisitForm" method="POST">
            <input type="hidden" name="property_id" value="<?= (int)$property['id'] ?>">
            <input type="hidden" name="property_name" value="<?= htmlspecialchars($property['project_name']) ?>">
            <input type="hidden" name="property_slug" value="<?= htmlspecialchars($slug) ?>">

            <div class="mb-3">
              <label class="form-label">Full Name *</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                <input type="text" name="name" class="form-control" placeholder="e.g. Rahul Sharma" required autocomplete="name">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Mobile Number (10 Digits) *</label>
              <div class="input-group">
                <span class="input-group-text fw-bold" style="font-size:13px; color:#475569;">+91</span>
                <input type="tel" name="phone" maxlength="10" pattern="[0-9]{10}" class="form-control" placeholder="e.g. 9829012345" required autocomplete="tel">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Email Address (Optional)</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                <input type="email" name="email" class="form-control" placeholder="name@example.com" autocomplete="email">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Preferred Visit Date *</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-calendar-day"></i></span>
                <input type="date" name="visit_date" id="visitDateInput" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Preferred Time Slot *</label>
              <div class="row g-2 slot-pills-row">
                <div class="col-4">
                  <input type="radio" name="time_slot" id="slotMorning" value="Morning (10 AM - 1 PM)" class="slot-pill-input" checked>
                  <label for="slotMorning" class="slot-pill-label">
                    <i class="fa-regular fa-sun slot-icon text-warning"></i>
                    <span class="slot-title">Morning</span>
                    <span class="slot-time">10 AM - 1 PM</span>
                  </label>
                </div>
                <div class="col-4">
                  <input type="radio" name="time_slot" id="slotAfternoon" value="Afternoon (1 PM - 4 PM)" class="slot-pill-input">
                  <label for="slotAfternoon" class="slot-pill-label">
                    <i class="fa-solid fa-sun slot-icon text-primary"></i>
                    <span class="slot-title">Afternoon</span>
                    <span class="slot-time">1 PM - 4 PM</span>
                  </label>
                </div>
                <div class="col-4">
                  <input type="radio" name="time_slot" id="slotEvening" value="Evening (4 PM - 7 PM)" class="slot-pill-input">
                  <label for="slotEvening" class="slot-pill-label">
                    <i class="fa-solid fa-moon slot-icon" style="color:#c02a7c;"></i>
                    <span class="slot-title">Evening</span>
                    <span class="slot-time">4 PM - 7 PM</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="trust-guarantee-box">
              <i class="fa-solid fa-shield-check"></i>
              <div>
                <strong>100% Free Site Visit:</strong> Zero brokerage, verified sales advisor & sanitized site car available.
              </div>
            </div>

            <button type="submit" class="btn btn-submit-visit" id="submitSiteVisitBtn">
              <i class="fa-solid fa-calendar-check me-2"></i> Confirm & Schedule Visit
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <?php include 'component/footer.php'; ?>

  <!-- ajax code for right side contact -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const contactForm = $('#sidebarContactForm');
      if (contactForm.length) {
        contactForm.on('submit', function (e) {
          e.preventDefault();

          let name = $.trim($('input[name="c_name"]').val());
          let email = $.trim($('input[name="email"]').val());
          let phone = $.trim($('input[name="phone"]').val());
          let msgBox = $('#formMessage');
          let submitBtn = $('#sidebarSubmitBtn');

          msgBox.html('').removeClass('alert alert-success alert-danger');

          if (name === "" || email === "" || phone === "") {
            msgBox.addClass('alert alert-danger').html("⚠️ Please fill all required fields.");
            return false;
          }

          const originalText = submitBtn.text();
          submitBtn.prop('disabled', true).text('Sending...');

          $.ajax({
            url: 'api/right_contact.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
              msgBox.addClass('alert alert-success').html("✅ Thank you! Our expert will call you shortly.");
              contactForm[0].reset();
            },
            error: function () {
              msgBox.addClass('alert alert-danger').html("❌ Something went wrong. Please try again.");
            },
            complete: function() {
              submitBtn.prop('disabled', false).text(originalText);
            }
          });
        });
      }
    });
  </script>

  <script>
    // Safe Location Slider Scroll fallback
    document.addEventListener('DOMContentLoaded', function () {
      const slider = document.getElementById('locationSlider');
      const nextBtn = document.querySelector('.loc-btn.next');
      const prevBtn = document.querySelector('.loc-btn.prev');
      if (slider && nextBtn) {
        nextBtn.addEventListener('click', () => slider.scrollBy({ left: slider.clientWidth, behavior: 'smooth' }));
      }
      if (slider && prevBtn) {
        prevBtn.addEventListener('click', () => slider.scrollBy({ left: -slider.clientWidth, behavior: 'smooth' }));
      }
    });
  </script>



  <!-- ///////////////////////// -->

  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script>
    // 🖼️ Main Property Gallery (Mobile)
    if (document.querySelector('.mobile-gallery-swiper')) {
      new Swiper('.mobile-gallery-swiper', {
        loop: true,
        pagination: {
          el: '.swiper-pagination-premium',
          clickable: true,
        },
        on: {
          slideChange: function () {
            const currentIdx = this.realIndex + 1;
            const counter = document.querySelector('.mobile-gallery-swiper .current-idx');
            if (counter) counter.innerText = currentIdx;
          }
        }
      });
    }

    // BHK Button functionality
    const bhkButtons = document.querySelectorAll('.bhk-btn');
    const bhkSliders = document.querySelectorAll('.bhk-slider');

    if (bhkButtons.length) {
      bhkButtons.forEach(button => {
        button.addEventListener('click', function () {
          bhkButtons.forEach(btn => btn.classList.remove('active'));
          this.classList.add('active');

          const targetId = this.getAttribute('data-target');
          bhkSliders.forEach(slider => {
            slider.classList.remove('active');
            if (slider.id === targetId) {
              slider.classList.add('active');
            }
          });
        });
      });
    }
  </script>

  <!-- 
  <script>
    document.addEventListener("DOMContentLoaded", function () {

     

      let currentBHK = "2bhk";
      let currentAreaIndex = 0;
      let currentZoom = 1;

      const areaTabs = document.getElementById("areaTabs");
      const priceDisplay = document.getElementById("priceDisplay");
      const floorPlanImage = document.getElementById("floorPlanImage");
      const roomDetails = document.getElementById("roomDetails");

      function loadAreaTabs() {
        areaTabs.innerHTML = "";
        floorPlans[currentBHK].areas.forEach((area, index) => {
          const btn = document.createElement("button");
         
          btn.innerText = area.size;
          btn.addEventListener("click", () => {
            currentAreaIndex = index;
            updateFloorPlan();
            document.querySelectorAll(".area-tab").forEach(tab => tab.classList.remove("active"));
            btn.classList.add("active");
          });
          areaTabs.appendChild(btn);
        });
      }

      function updateFloorPlan() {
        const currentData = floorPlans[currentBHK].areas[currentAreaIndex];
        priceDisplay.innerText = currentData.price;
        floorPlanImage.src = currentData.image;

        roomDetails.innerHTML = "";
        currentData.rooms.forEach(room => {
          const box = document.createElement("div");
          box.className = "detail-box";
          box.innerHTML = `<h6>${room.name}</h6><p>${room.size}</p>`;
          roomDetails.appendChild(box);
        });
      }

      document.querySelectorAll(".bhk-btn").forEach(btn => {
        btn.addEventListener("click", () => {
          document.querySelectorAll(".bhk-btn").forEach(b => b.classList.remove("active"));
          btn.classList.add("active");
          currentBHK = btn.getAttribute("data-bhk");
          currentAreaIndex = 0;
          loadAreaTabs();
          updateFloorPlan();
        });
      });

      document.getElementById("zoomIn").addEventListener("click", () => {
        currentZoom += 0.1;
        floorPlanImage.style.transform = `scale(${currentZoom})`;
      });

      document.getElementById("zoomOut").addEventListener("click", () => {
        if (currentZoom > 0.5) {
          currentZoom -= 0.1;
          floorPlanImage.style.transform = `scale(${currentZoom})`;
        }
      });

      document.getElementById("nextPlan").addEventListener("click", () => {
        if (currentAreaIndex < floorPlans[currentBHK].areas.length - 1) {
          currentAreaIndex++;
          updateFloorPlan();
          document.querySelectorAll(".area-tab").forEach(tab => tab.classList.remove("active"));
          areaTabs.children[currentAreaIndex].classList.add("active");
        }
      });

      document.getElementById("prevPlan").addEventListener("click", () => {
        if (currentAreaIndex > 0) {
          currentAreaIndex--;
          updateFloorPlan();
          document.querySelectorAll(".area-tab").forEach(tab => tab.classList.remove("active"));
          areaTabs.children[currentAreaIndex].classList.add("active");
        }
      });

      loadAreaTabs();
      updateFloorPlan();
    });
  </script> -->


  <script>
    // Popup Image Slider Logic
    document.addEventListener("DOMContentLoaded", function() {
      const popup = document.getElementById("popup");
      if(popup) {
        const slides = popup.querySelectorAll(".popup-slide");
        let currentSlide = 0;
        
        function showSlide(index) {
          slides.forEach(s => s.style.display = "none");
          if(index >= slides.length) currentSlide = 0;
          if(index < 0) currentSlide = slides.length - 1;
          if(slides[currentSlide]) slides[currentSlide].style.display = "block";
        }
        
        const nextBtn = popup.querySelector(".nextt");
        const prevBtn = popup.querySelector(".prevv");
        
        if(nextBtn && prevBtn && slides.length > 0) {
          nextBtn.addEventListener("click", () => showSlide(++currentSlide));
          prevBtn.addEventListener("click", () => showSlide(--currentSlide));
          showSlide(0); // init correctly
        }
      }
    });

    const rdSliders = document.querySelectorAll(".rd-slider");
    const rdButtons = document.querySelectorAll(".rd-bhk-buttons button");
    const rdPositions = {};

    rdSliders.forEach(slider => {
      rdPositions[slider.id] = 0;
    });

    function rdShowSlider(id, event) {
      rdSliders.forEach(slider => slider.classList.remove("active"));
      document.getElementById(id).classList.add("active");

      rdButtons.forEach(btn => btn.classList.remove("active"));
      event.target.classList.add("active");
    }

    function rdNextSlide(id) {
      const slider = document.getElementById(id);
      const slides = slider.querySelector(".rd-slides");
      const total = slides.children.length;
      rdPositions[id] = (rdPositions[id] + 1) % total;
      slides.style.transform = `translateX(-${rdPositions[id] * 100}%)`;
    }

    function rdPrevSlide(id) {
      const slider = document.getElementById(id);
      const slides = slider.querySelector(".rd-slides");
      const total = slides.children.length;
      rdPositions[id] = (rdPositions[id] - 1 + total) % total;
      slides.style.transform = `translateX(-${rdPositions[id] * 100}%)`;
    }
  </script>

  <!-- 🧮 Interactive Features Script: EMI Calculator, Wishlist & Site Visit Booking -->
  <script>
    const CURRENT_PROPERTY_NAME = <?= json_encode($property['project_name']) ?>;
    const CURRENT_PROPERTY_SLUG = <?= json_encode($slug) ?>;

    // --- 1. EMI CALCULATOR LOGIC ---
    function formatINR(val) {
      return '₹' + Number(Math.round(val)).toLocaleString('en-IN');
    }

    function calculateEMI() {
      const loanInput = document.getElementById('emiLoanInput');
      const rateInput = document.getElementById('emiRateInput');
      const tenureInput = document.getElementById('emiTenureInput');
      if (!loanInput || !rateInput || !tenureInput) return;

      const P = parseFloat(loanInput.value) || 5000000;
      const annualRate = parseFloat(rateInput.value) || 8.5;
      const years = parseInt(tenureInput.value) || 20;

      const N = years * 12;
      const R = (annualRate / 12) / 100;

      let emi = 0;
      if (R > 0) {
        emi = Math.round((P * R * Math.pow(1 + R, N)) / (Math.pow(1 + R, N) - 1));
      } else {
        emi = Math.round(P / N);
      }

      const totalPayment = emi * N;
      const totalInterest = Math.max(0, totalPayment - P);

      const principalPercent = Math.max(5, Math.min(95, Math.round((P / totalPayment) * 100)));
      const interestPercent = 100 - principalPercent;

      // Update Displays
      document.getElementById('emiLoanAmountDisplay').textContent = formatINR(P);
      document.getElementById('emiRateDisplay').textContent = annualRate.toFixed(1) + '% p.a.';
      document.getElementById('emiTenureDisplay').textContent = years + ' Years (' + N + ' M)';

      document.getElementById('emiMonthlyDisplay').textContent = formatINR(emi);
      document.getElementById('emiSubtext').textContent = 'per month for ' + years + ' years';

      document.getElementById('emiPrincipalDisplay').textContent = formatINR(P);
      document.getElementById('emiInterestDisplay').textContent = formatINR(totalInterest);
      document.getElementById('emiTotalPayableDisplay').textContent = formatINR(totalPayment);

      const pBar = document.getElementById('emiPrincipalBar');
      const iBar = document.getElementById('emiInterestBar');
      if (pBar && iBar) {
        pBar.style.width = principalPercent + '%';
        iBar.style.width = interestPercent + '%';
        document.getElementById('emiPrincipalLabel').textContent = 'Principal (' + principalPercent + '%)';
        document.getElementById('emiInterestLabel').textContent = 'Interest (' + interestPercent + '%)';
      }

      // WhatsApp Loan CTA message
      const loanBtn = document.getElementById('emiLoanAssistanceBtn');
      if (loanBtn) {
        const msg = "Hello Ikan Housing, I am interested in Home Loan assistance for " + CURRENT_PROPERTY_NAME + " (Loan Amount: " + formatINR(P) + ", EMI approx: " + formatINR(emi) + "/month). Please connect me with your banking advisor.";
        loanBtn.href = "https://wa.me/918955331454?text=" + encodeURIComponent(msg);
      }
    }

    function setEmiAmount(amount) {
      const el = document.getElementById('emiLoanInput');
      if (el) { el.value = amount; calculateEMI(); }
    }
    function setEmiRate(rate) {
      const el = document.getElementById('emiRateInput');
      if (el) { el.value = rate; calculateEMI(); }
    }
    function setEmiTenure(tenure) {
      const el = document.getElementById('emiTenureInput');
      if (el) { el.value = tenure; calculateEMI(); }
    }

    // Attach EMI events
    ['emiLoanInput', 'emiRateInput', 'emiTenureInput'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.addEventListener('input', calculateEMI);
    });

    // --- 2. LOCALSTORAGE WISHLIST / SAVE LOGIC ---
    function getSavedProperties() {
      try {
        return JSON.parse(localStorage.getItem('ikan_saved_properties')) || [];
      } catch (e) {
        return [];
      }
    }

    function updateSaveButtonUI() {
      const saved = getSavedProperties();
      const isSaved = saved.some(item => (typeof item === 'string' ? item : item.slug) === CURRENT_PROPERTY_SLUG);
      const btn = document.getElementById('savePropertyBtn');
      if (!btn) return;

      if (isSaved) {
        btn.innerHTML = '<i class="fa-solid fa-heart me-1" style="color:#ffffff;"></i> Saved';
        btn.style.backgroundColor = '#c02a7c';
        btn.style.borderColor = '#c02a7c';
        btn.style.color = '#ffffff';
      } else {
        btn.innerHTML = '<i class="fa-regular fa-heart me-1" style="color:#c02a7c;"></i> Save';
        btn.style.backgroundColor = 'transparent';
        btn.style.borderColor = '#e2e8f0';
        btn.style.color = '#c02a7c';
      }
    }

    function toggleSaveProperty() {
      let saved = getSavedProperties();
      const index = saved.findIndex(item => (typeof item === 'string' ? item : item.slug) === CURRENT_PROPERTY_SLUG);

      if (index >= 0) {
        saved.splice(index, 1);
        localStorage.setItem('ikan_saved_properties', JSON.stringify(saved));
        updateSaveButtonUI();
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'info',
            title: 'Removed from your favorites',
            showConfirmButton: false, timer: 2000, timerProgressBar: true
          });
        }
      } else {
        saved.push({
          slug: CURRENT_PROPERTY_SLUG,
          name: CURRENT_PROPERTY_NAME,
          saved_at: new Date().toISOString()
        });
        localStorage.setItem('ikan_saved_properties', JSON.stringify(saved));
        updateSaveButtonUI();
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Property saved to your favorites! ❤️',
            showConfirmButton: false, timer: 2500, timerProgressBar: true
          });
        }
      }
    }

    function copyToClipboard() {
      navigator.clipboard.writeText(window.location.href).then(() => {
        if (typeof Swal !== 'undefined') {
          Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Property link copied to clipboard!',
            showConfirmButton: false, timer: 2000
          });
        } else {
          alert("Link copied to clipboard!");
        }
      });
    }

    // --- 3. BULLETPROOF STICKY SUBNAV SMOOTH SCROLL & SCROLLSPY ---
    $(document).ready(function() {
      // Subnav click jump
      $('.subnav-link').on('click', function(e) {
        e.preventDefault();
        const targetSelector = $(this).attr('data-target') || $(this).attr('href');
        if (!targetSelector || targetSelector === '#') return;

        const targetEl = $(targetSelector);
        if (targetEl.length) {
          $('.subnav-link').removeClass('active');
          $(this).addClass('active');

          const stickyNav = $('.property-subnav-sticky');
          const navHeight = stickyNav.length ? stickyNav.outerHeight() : 54;
          const targetPos = targetEl.offset().top - navHeight - 16;

          $('html, body').stop().animate({
            scrollTop: targetPos
          }, 450);
        }
      });

      // Subnav scrollspy
      let scrollTimer = null;
      $(window).on('scroll', function() {
        if (scrollTimer) clearTimeout(scrollTimer);
        scrollTimer = setTimeout(function() {
          const scrollPos = $(window).scrollTop() + 160;
          let activeFound = false;
          const links = $('.subnav-link');

          $($(links).get().reverse()).each(function() {
            const targetSelector = $(this).attr('data-target') || $(this).attr('href');
            if (!targetSelector || targetSelector === '#') return;
            const targetEl = $(targetSelector);
            if (targetEl.length) {
              const top = targetEl.offset().top;
              if (scrollPos >= top && !activeFound) {
                $('.subnav-link').removeClass('active');
                $(this).addClass('active');
                activeFound = true;

                // Auto-scroll horizontal subnav wrap
                const wrap = $('.subnav-scroll-wrap');
                if (wrap.length) {
                  const linkPos = $(this).position().left;
                  wrap.stop().animate({ scrollLeft: linkPos - 40 }, 150);
                }
              }
            }
          });

          if (!activeFound && links.length) {
            links.removeClass('active');
            links.first().addClass('active');
          }
        }, 40);
      });

      // --- 4. BULLETPROOF SITE VISIT MODAL TRIGGER ---
      $(document).on('click', '[data-bs-target="#siteVisitModal"], .sidebar-btn-visit, .btn-mobile-visit, .btn-action-primary', function(e) {
        const modalEl = document.getElementById('siteVisitModal');
        if (modalEl) {
          if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstance.show();
          } else {
            // Direct DOM Fallback
            $(modalEl).addClass('show').css({ display: 'block', background: 'rgba(15,23,42,0.65)' });
            $('body').addClass('modal-open');
          }
        }
      });

      $(document).on('click', '#siteVisitModal [data-bs-dismiss="modal"], #siteVisitModal .btn-close', function(e) {
        e.preventDefault();
        const modalEl = document.getElementById('siteVisitModal');
        if (modalEl) {
          if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
          }
          $(modalEl).removeClass('show').css({ display: 'none' });
          $('body').removeClass('modal-open');
          $('.modal-backdrop').remove();
        }
      });

      $(document).on('click', '#siteVisitModal', function(e) {
        if (e.target === this) {
          const modalEl = document.getElementById('siteVisitModal');
          if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modalInstance = bootstrap.Modal.getInstance(modalEl);
            if (modalInstance) modalInstance.hide();
          }
          $(modalEl).removeClass('show').css({ display: 'none' });
          $('body').removeClass('modal-open');
          $('.modal-backdrop').remove();
        }
      });

      // --- 5. AJAX SITE VISIT FORM SUBMISSION ---
      const siteVisitForm = $('#siteVisitForm');
      if (siteVisitForm.length) {
        siteVisitForm.on('submit', function(e) {
          e.preventDefault();
          const form = $(this);
          const submitBtn = $('#submitSiteVisitBtn');
          const msgBox = $('#siteVisitMsg');

          const name = $.trim(form.find('input[name="name"]').val());
          const phone = $.trim(form.find('input[name="phone"]').val());
          const date = $.trim(form.find('input[name="visit_date"]').val());

          if (!name || !phone || !date) {
            msgBox.removeClass('d-none alert-success').addClass('alert alert-danger').html('⚠️ Please fill in all required fields (Name, Phone & Date).');
            return false;
          }

          if (phone.replace(/[^0-9]/g, '').length < 10) {
            msgBox.removeClass('d-none alert-success').addClass('alert alert-danger').html('⚠️ Please enter a valid 10-digit mobile number.');
            return false;
          }

          msgBox.html('').removeClass('alert alert-success alert-danger').addClass('d-none');
          const originalBtnHtml = submitBtn.html();
          submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Scheduling Visit...');

          $.ajax({
            url: 'api/schedule_visit.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(res) {
              if (res.status === 'success') {
                msgBox.removeClass('d-none alert-danger').addClass('alert alert-success').html('<strong>🎉 Success!</strong> ' + res.message);
                form[0].reset();
                submitBtn.html('<i class="fa-solid fa-circle-check me-2"></i>Visit Scheduled!');

                if (typeof Swal !== 'undefined') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Site Visit Confirmed! 🎉',
                    text: res.message,
                    confirmButtonColor: '#c02a7c',
                    confirmButtonText: 'Great, Thank You!'
                  });
                }

                setTimeout(function() {
                  const modalEl = document.getElementById('siteVisitModal');
                  if (modalEl && typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();
                  }
                  $('#siteVisitModal').removeClass('show').css({ display: 'none' });
                  $('body').removeClass('modal-open');
                  $('.modal-backdrop').remove();
                  submitBtn.prop('disabled', false).html(originalBtnHtml);
                  msgBox.addClass('d-none');
                }, 3500);
              } else {
                msgBox.removeClass('d-none alert-success').addClass('alert alert-danger').html('⚠️ ' + (res.message || 'Could not schedule visit. Please try again.'));
                submitBtn.prop('disabled', false).html(originalBtnHtml);
              }
            },
            error: function() {
              msgBox.removeClass('d-none alert-success').addClass('alert alert-danger').html('❌ Communication failed. Please call us directly at +91 89553 31454.');
              submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
          });
        });
      }

      calculateEMI();
      updateSaveButtonUI();
    });
  </script>
</body>

</html>