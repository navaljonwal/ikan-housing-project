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

  <!-- 💎 New Premium Hero & Gallery -->
  <section class="premium-hero-header" data-aos="fade-down" data-aos-duration="800">
    <div class="container">
      <div class="row align-items-end mb-4">
        <div class="col-lg-8">
          <h1 class="project-title mb-3"><?= htmlspecialchars($property['project_name']) ?></h1>
          <p class="mb-2" style="font-size:16px; font-weight:500; display:flex; align-items:center; flex-wrap:wrap; gap:15px;">
            <span style="color:#64748b;"><i class="fa fa-building" style="color:#c02a7c; margin-right:5px;"></i> Builder: 
              <?php
                $showbuilder = "SELECT builder.builder_name FROM new_property LEFT JOIN builder ON new_property.builder_name = builder.id WHERE new_property.id = '" . $property['id'] . "'";
                $resbuilder = mysqli_query($con, $showbuilder);
                $builderRow = mysqli_fetch_assoc($resbuilder);
              ?>
              <a href="#" class="b-name" style="color:#0f172a; text-decoration:none; font-weight:700;"><?= htmlspecialchars($builderRow['builder_name'] ?? 'N/A') ?></a>
            </span>
            <span style="color:#64748b;"><i class="fa fa-map-marker-alt" style="color:#c02a7c; margin-right:5px;"></i> <?= htmlspecialchars($property['location']) ?></span>
          </p>
          <div style="margin-top:15px; display:flex; align-items:center; flex-wrap:wrap; gap:10px;">
            <span class="<?= ($rera_display !== 'N/A') ? 'badge bg-light text-success border' : 'badge bg-light text-secondary border' ?>" style="padding: 8px 14px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                <?= ($rera_display !== 'N/A') ? '✔ RERA: ' . htmlspecialchars($rera_display) : '✔ Verified Property' ?>
            </span>
            <span class="badge bg-light text-secondary border" style="padding: 8px 14px; font-size: 13px; font-weight: 700; border-radius: 8px;">
              <i class="fa fa-calendar-alt me-1" style="color:#c02a7c;"></i>
              <?php
                if (!empty($property['created_at'])) {
                  $created_at = new DateTime($property['created_at']);
                  echo "Added on " . $created_at->format('j M Y');
                } else {
                  echo "Added Recently";
                }
              ?>
            </span>
          </div>
        </div>
        <div class="col-lg-4 text-lg-end mt-4 mt-lg-0">
          <div class="price-label">Estimated Price</div>
          <div class="header-price" style="color: #c02a7c; white-space: nowrap;"><?= htmlspecialchars($price_range_display) ?></div>
        </div>
      </div>

      <!-- 🖼️ Responsive Premium Gallery -->
      <?php if (!empty($images)): 
        $img_count = count($images);
        $grid_class = ($img_count <= 5) ? 'gallery-grid-' . $img_count : 'gallery-grid-default';
      ?>
      <div class="gallery-wrapper mb-4" data-aos="zoom-in" data-aos-duration="1000">
        
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
    </div>
  </section>

  <section class="property-section py-4">
    <div class="container">
      <div class="row g-4">

        <!-- Left Side -->
        <div class="col-12 col-lg-8">
          <div class="col-md-12 rtyu">
            <div class="detl-rd" data-aos="fade-down" data-aos-duration="1000">
              <h3 class="vh mb-3">About Project</h3>
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
                  echo '<p class="text-muted">Detailed project description will be updated soon.</p>';
                }
                ?>
              </div>

              <!-- Premium Brochure Action Card -->
              <div class="brochure-card-premium mt-4 p-4 d-flex align-items-center gap-4 shadow-sm" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 20px; border: 1px solid #e2e8f0;">
                <div class="brochure-icon" style="width: 60px; height: 60px; background: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                  <i class="fa-solid fa-file-pdf" style="color: #ef4444; font-size: 30px;"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 4px;">Project Brochure</h5>
                  <p style="color: #64748b; font-size: 13px; margin: 0; font-weight: 500;">Download complete project details, floor plans & specifications.</p>
                </div>
                <?php if (!empty($property['brochure']) && file_exists('uploads/' . trim($property['brochure']))): ?>
                  <a href="uploads/<?= htmlspecialchars(trim($property['brochure'])); ?>" class="btn-premium-brochure" download style="background: #c02a7c; color: white; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(192, 42, 124, 0.3);">
                    <i class="fa-solid fa-download me-2"></i> Download
                  </a>
                <?php else: ?>
                  <a href="#sidebarContactForm" class="btn-premium-brochure" style="background: #c02a7c; color: white; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(192, 42, 124, 0.3);">
                    <i class="fa-solid fa-envelope me-2"></i> Request Brochure
                  </a>
                <?php endif; ?>
              </div>
            </div>
          </div>
          
          <div class="why-box mb-4 mt-4" data-aos="fade-down" data-aos-duration="1000">
            <h3 class="mb-3">Highlights</h3>
            <div class="property-highlights-box">
              <?php 
              $hl = trim($property['highlight'] ?? '');
              if (!empty($hl)) {
                if (stripos($hl, '<li') !== false || stripos($hl, '<p') !== false) {
                  echo $hl;
                } else {
                  echo '<ul><li>' . nl2br($hl) . '</li></ul>';
                }
              } else {
                echo '<p class="text-muted">Highlights not specified for this property.</p>';
              }
              ?>
            </div>
          </div>

          <section class="project-overview" data-aos="fade-down" data-aos-duration="1000">
            <div class="mb-4 border-bottom pb-3">
              <h3 class="vh">Property Overview</h3>
              <p style="color: #64748b; font-size: 14px; margin-top: 5px;">Key specifications and current status of the project.</p>
            </div>

            <div class="overview-grid-premium">
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-building"></i></div>
                <div>
                  <p class="ov-title">Status</p>
                  <p class="ov-val"><?= htmlspecialchars($constructText) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-couch"></i></div>
                <div>
                  <p class="ov-title">Furnishing</p>
                  <p class="ov-val"><?= htmlspecialchars($furnishText) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-home"></i></div>
                <div>
                  <p class="ov-title">Category</p>
                  <p class="ov-val"><?= htmlspecialchars($flats) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-vector-square"></i></div>
                <div>
                  <p class="ov-title">Carpet Area</p>
                  <p class="ov-val"><?= htmlspecialchars($carpet_display) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-ruler-combined"></i></div>
                <div>
                  <p class="ov-title">Build-up Area</p>
                  <p class="ov-val"><?= htmlspecialchars($buildup_display) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-coins"></i></div>
                <div>
                  <p class="ov-title">Price Range</p>
                  <p class="ov-val"><?= htmlspecialchars($price_range_display) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-clock"></i></div>
                <div>
                  <p class="ov-title">Possession</p>
                  <p class="ov-val"><?= htmlspecialchars($possession_display) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-bed"></i></div>
                <div>
                  <p class="ov-title">Configurations</p>
                  <p class="ov-val"><?= htmlspecialchars($property['bhk']) ?> Apts</p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-file-contract"></i></div>
                <div>
                  <p class="ov-title"><?= ($property['rera_no'] != "JDA Approved") ? "RERA ID" : "JDA" ?></p>
                  <p class="ov-val"><?= ($property['rera_no'] != "JDA Approved") ? htmlspecialchars($rera_display) : "Approved" ?></p>
                </div>
              </div>
            </div>
            
            <div class="d-flex flex-wrap gap-2 mb-4 align-items-center">
              <div class="dropdown">
                <button class="btn-share-premium dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa-solid fa-share-nodes" style="color:#c02a7c; margin-right:5px;"></i> Share
                </button>
                <div class="dropdown-menu share-dropdown-menu shadow-lg border-0" style="border-radius:15px; padding:10px;">
                  <a class="dropdown-item share-dropdown-item d-flex align-items-center py-2" href="https://api.whatsapp.com/send?text=<?= urlencode('Check out this property: ' . 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                    <i class="fa-brands fa-whatsapp" style="color: #25D366; font-size:20px; width:25px; margin-right:10px;"></i> WhatsApp
                  </a>
                  <a class="dropdown-item share-dropdown-item d-flex align-items-center py-2" href="https://www.facebook.com/sharer/sharer?u=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                    <i class="fa-brands fa-facebook" style="color: #1877F2; font-size:20px; width:25px; margin-right:10px;"></i> Facebook
                  </a>
                  <a class="dropdown-item share-dropdown-item d-flex align-items-center py-2" href="https://twitter.com/intent/tweet?url=<?= urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" target="_blank">
                    <i class="fa-brands fa-x-twitter" style="color: #000; font-size:20px; width:25px; margin-right:10px;"></i> Twitter (X)
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item share-dropdown-item d-flex align-items-center py-2" href="javascript:void(0);" onclick="copyToClipboard();">
                    <i class="fa-solid fa-link" style="color: #64748b; font-size:20px; width:25px; margin-right:10px;"></i> Copy Link
                  </a>
                </div>
              </div>

              <button class="btn-share-premium" id="savePropertyBtn" onclick="toggleSaveProperty();" style="color: #c02a7c; transition: all 0.2s;">
                <i class="fa-regular fa-heart"></i> Save
              </button>

              <button class="btn-share-premium" data-bs-toggle="modal" data-bs-target="#siteVisitModal" style="background:#fdf2f8; color:#c02a7c; border:1px solid #fbcfe8; font-weight:700;">
                <i class="fa-solid fa-calendar-check me-1"></i> Book Site Visit
              </button>

              <a href="https://wa.me/918955331454?text=<?= urlencode('Hello Ikan Housing, I am interested in ' . $property['project_name'] . ' (' . $property['location'] . '). Please share details.') ?>" target="_blank" class="btn-share-premium" style="background:#f0fdf4; color:#15803d; border:1px solid #86efac; font-weight:700; text-decoration:none;">
                <i class="fa-brands fa-whatsapp me-1" style="color: #22c55e;"></i> WhatsApp
              </a>
            </div>
          </section>

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
            // Intelligent fallback: check if amenity names are mentioned in description or highlights
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
          <div class="amenities-section" data-aos="fade-down" data-aos-duration="1000">
            <h3 class="vh mb-4">Project Amenities</h3>

            <div class="amenities-premium-grid" id="amenitiesGrid">
              <?php
              foreach ($amenities as $index => $am):
                $hidden_class = ($index >= 9) ? 'amenity-hidden d-none' : '';
                ?>
                <div class="amenity-premium-badge <?= $hidden_class ?>">
                  <img src="uploads/<?php echo htmlspecialchars($am['icon']); ?>" alt="icon">
                  <span><?php echo htmlspecialchars($am['name']); ?></span>
                </div>
                <?php
              endforeach;
              ?>
              
              <?php if (count($amenities) > 9): ?>
                <button id="toggleAmenitiesBtn" onclick="toggleAmenities();" class="load-more-btn-hs amenity-premium-badge" style="background:#fdf2f8; color:#c02a7c; font-weight:700; border:none; cursor:pointer;">+ View All</button>
              <?php endif; ?>
            </div>

            <script>
              function toggleAmenities() {
                const hiddenItems = document.querySelectorAll('.amenity-hidden');
                const btn = document.getElementById('toggleAmenitiesBtn');
                
                hiddenItems.forEach(item => {
                  if(item.classList.contains('d-none')) {
                    item.classList.remove('d-none');
                    btn.innerHTML = '- View Less';
                  } else {
                    item.classList.add('d-none');
                    btn.innerHTML = '+ View All';
                  }
                });
              }
            </script>
          </div>
          <?php endif; ?>

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
          <?php if (!empty($embed_url) || $has_video_file || count($images) > 1): ?>
          <section class="media-showcase" data-aos="fade-down" data-aos-duration="1000">
            <div class="media-container">
              <h5 class="media-title">Photos & Videos: <span>Tour this project virtually</span></h5>
              <p class="media-subtitle">Project Tour & Photos</p>

              <div class="media-grid">
                <!-- Featured Video File (Dynamic from Admin Upload) -->
                <?php if ($has_video_file): ?>
                <div class="media-item media-video video-wide">
                  <video controls playsinline class="w-100 h-100" style="object-fit: cover; border-radius: 12px; background: #000; min-height: 280px;">
                    <source src="uploads/<?= htmlspecialchars($video_file) ?>">
                    Your browser does not support the video tag.
                  </video>
                </div>
                <?php endif; ?>

                <!-- Featured YouTube Video (Dynamic from Admin) -->
                <?php if (!empty($embed_url)): ?>
                <div class="media-item media-video video-wide">
                  <iframe src="<?= htmlspecialchars($embed_url) ?>" title="YouTube video player"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                  </iframe>
                </div>
                <?php endif; ?>

                <!-- Images from PHP -->
                <?php
                $total_images = count($images);
                foreach ($images as $index => $img) {
                  $clean_img = trim($img);
                  if (empty($clean_img)) continue;
                  if ($index < 1) { // Show first image
                    ?>
                    <div class="media-item">
                      <a href="uploads/<?= htmlspecialchars($clean_img) ?>" target="_blank">
                        <img src="uploads/<?= htmlspecialchars($clean_img) ?>" alt="Project Photo">
                      </a>
                    </div>
                  <?php } elseif ($index == 3) { // Last image shows +count ?>
                    <div class="media-item more-photos view-more" onclick="document.getElementById('popup').style.display='block'" style="cursor:pointer;">
                      <div class="gallery-small view-more"
                        style="background-image: url('uploads/<?= htmlspecialchars($clean_img); ?>');">
                        <div class="overlay overlay-v">+ View More</div>
                      </div>
                    </div>
                    <?php break;
                  }
                } ?>
              </div>
            </div>
          </section>
          <?php endif; ?>
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
          ?>

          <?php
          // ✅ Fetch BHK Images with existence check
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

          // ✅ Show section only if at least one valid floor plan exists
          if (!empty($bhk_images)) :
          ?>
          <section class="rd-flore-pland" data-aos="fade-down" data-aos-duration="1000">
            <div class="rd-container">
              <div class="rd-bhk-buttons">
                <?php foreach ($bhks as $index => $b): ?>
                  <button class="<?= $index == 0 ? 'active' : '' ?>" onclick="rdShowSlider('bhk-<?= $index ?>', event)">
                    <?= $b['name'] ?>
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
                        <img src="uploads/<?= $img ?>" alt="">
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
          </section>
          <?php
          endif;
          ?>

          <?php
          // Intelligent default loan amount (80% of min_price_int or 50 Lakhs default)
          $init_loan_amount = 5000000;
          if (!empty($property['min_price_int']) && $property['min_price_int'] > 0) {
              $calc_loan = round(($property['min_price_int'] * 0.8) / 100000) * 100000;
              if ($calc_loan >= 500000 && $calc_loan <= 50000000) {
                  $init_loan_amount = $calc_loan;
              }
          }
          ?>
          <!-- 🧮 Interactive Home Loan EMI Calculator -->
          <section class="emi-calculator-section mt-4 mb-4" data-aos="fade-down" data-aos-duration="1000">
            <div class="emi-card-premium">
              <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3 pb-2 border-bottom">
                <div>
                  <h4 style="font-weight: 800; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-calculator" style="color: #c02a7c;"></i> Home Loan EMI Calculator
                  </h4>
                  <p class="text-muted small mb-0 mt-1">Estimate your monthly mortgage payments with our instant loan calculator.</p>
                </div>
                <span class="badge" style="background:#fdf2f8; color:#c02a7c; font-weight:700; border:1px solid #fbcfe8; padding:6px 12px; border-radius:20px;">
                  ⚡ Real-Time Estimate
                </span>
              </div>

              <div class="row g-4 align-items-stretch">
                <!-- Left: Sliders -->
                <div class="col-12 col-lg-7">
                  <!-- Loan Amount -->
                  <div class="emi-slider-wrap">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="fw-bold small text-muted text-uppercase" style="letter-spacing:0.5px;">Loan Amount</label>
                      <span id="emiLoanAmountDisplay" class="fw-bold fs-5 text-dark" style="font-family:'Outfit', sans-serif;">₹<?= number_format($init_loan_amount) ?></span>
                    </div>
                    <input type="range" class="emi-slider" id="emiLoanInput" min="500000" max="50000000" step="50000" value="<?= $init_loan_amount ?>">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mt-1">
                      <span class="text-muted" style="font-size:11px;">₹5 L</span>
                      <div class="d-flex gap-1">
                        <button type="button" class="emi-quick-btn" onclick="setEmiAmount(2500000)">₹25 L</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiAmount(5000000)">₹50 L</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiAmount(7500000)">₹75 L</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiAmount(10000000)">₹1 Cr</button>
                      </div>
                      <span class="text-muted" style="font-size:11px;">₹5 Cr</span>
                    </div>
                  </div>

                  <!-- Interest Rate -->
                  <div class="emi-slider-wrap">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="fw-bold small text-muted text-uppercase" style="letter-spacing:0.5px;">Interest Rate (% p.a.)</label>
                      <span id="emiRateDisplay" class="fw-bold fs-5 text-dark" style="font-family:'Outfit', sans-serif;">8.5% p.a.</span>
                    </div>
                    <input type="range" class="emi-slider" id="emiRateInput" min="6.0" max="15.0" step="0.1" value="8.5">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mt-1">
                      <span class="text-muted" style="font-size:11px;">6.0%</span>
                      <div class="d-flex gap-1">
                        <button type="button" class="emi-quick-btn" onclick="setEmiRate(8.0)">8.0%</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiRate(8.5)">8.5%</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiRate(9.0)">9.0%</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiRate(9.5)">9.5%</button>
                      </div>
                      <span class="text-muted" style="font-size:11px;">15.0%</span>
                    </div>
                  </div>

                  <!-- Tenure -->
                  <div class="emi-slider-wrap mb-0">
                    <div class="d-flex justify-content-between align-items-center">
                      <label class="fw-bold small text-muted text-uppercase" style="letter-spacing:0.5px;">Loan Tenure</label>
                      <span id="emiTenureDisplay" class="fw-bold fs-5 text-dark" style="font-family:'Outfit', sans-serif;">20 Years</span>
                    </div>
                    <input type="range" class="emi-slider" id="emiTenureInput" min="1" max="30" step="1" value="20">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-1 mt-1">
                      <span class="text-muted" style="font-size:11px;">1 Yr</span>
                      <div class="d-flex gap-1">
                        <button type="button" class="emi-quick-btn" onclick="setEmiTenure(10)">10 Yrs</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiTenure(15)">15 Yrs</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiTenure(20)">20 Yrs</button>
                        <button type="button" class="emi-quick-btn" onclick="setEmiTenure(25)">25 Yrs</button>
                      </div>
                      <span class="text-muted" style="font-size:11px;">30 Yrs</span>
                    </div>
                  </div>
                </div>

                <!-- Right: Calculation Results -->
                <div class="col-12 col-lg-5">
                  <div class="emi-result-panel">
                    <div>
                      <div class="text-muted small fw-bold text-uppercase mb-1" style="letter-spacing:0.5px;">Monthly EMI Payable</div>
                      <div class="emi-highlight-amount" id="emiMonthlyDisplay">₹43,391</div>
                      <div class="text-muted small mt-1" id="emiSubtext">per month for 20 years</div>
                    </div>

                    <div class="my-3">
                      <!-- Visual Breakdown Bar -->
                      <div class="emi-breakup-bar">
                        <div class="emi-bar-principal" id="emiPrincipalBar" style="width: 48%;"></div>
                        <div class="emi-bar-interest" id="emiInterestBar" style="width: 52%;"></div>
                      </div>
                      <div class="d-flex justify-content-between align-items-center small mt-1">
                        <span style="color:#334155; font-weight:700;"><i class="fa-solid fa-circle me-1" style="color:#334155; font-size:9px;"></i> <span id="emiPrincipalLabel">Principal (48%)</span></span>
                        <span style="color:#c02a7c; font-weight:700;"><i class="fa-solid fa-circle me-1" style="color:#c02a7c; font-size:9px;"></i> <span id="emiInterestLabel">Interest (52%)</span></span>
                      </div>
                    </div>

                    <div class="border-top pt-2">
                      <div class="d-flex justify-content-between py-1 small">
                        <span class="text-muted">Principal Amount:</span>
                        <span class="fw-bold text-dark" id="emiPrincipalDisplay">₹50,00,000</span>
                      </div>
                      <div class="d-flex justify-content-between py-1 small">
                        <span class="text-muted">Total Interest:</span>
                        <span class="fw-bold text-dark" id="emiInterestDisplay">₹54,13,879</span>
                      </div>
                      <div class="d-flex justify-content-between py-1 small border-top mt-1 pt-1">
                        <span class="fw-bold text-dark">Total Amount:</span>
                        <span class="fw-bold text-dark" id="emiTotalPayableDisplay">₹1,04,13,879</span>
                      </div>
                    </div>

                    <div class="mt-3">
                      <a href="#" id="emiLoanAssistanceBtn" target="_blank" class="btn-emi-cta w-100">
                        <i class="fa-solid fa-hand-holding-dollar me-2"></i> Apply for Home Loan
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>

          <?php if (!empty(trim($property['map'] ?? ''))): ?>
          <div class="property-map-section mt-4" data-aos="fade-down" data-aos-duration="1000">
            <div class="map-card-premium" style="background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; padding: 20px;">
              <h4 style="font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="fa fa-map-marked-alt" style="color: #c02a7c;"></i> Project Location & Map
              </h4>
              <div class="map-iframe-container">
                <?php echo $property['map']; ?>
              </div>
            </div>
          </div>
          <?php endif; ?>
        </div>

        <!-- Right Side -->
        <div class="col-12 col-lg-4 ghjp">
          <div class="sidebar-sticky">
            <div id="formMessage"></div>
            <div class="premium-contact-card">
              <div class="badge-premium">⚡ Most Liked Project in This Area</div>

              <div class="seller-info mb-4 d-flex align-items-center gap-3 p-3" style="background: #f8fafc; border-radius: 12px; border: 1px solid #e2e8f0;">
                <div class="seller-icon-box" style="width: 48px; height: 48px; background: #c02a7c; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white;">
                  <i class="fa-solid fa-building-circle-check" style="font-size: 24px;"></i>
                </div>
                <div class="flex-grow-1 text-start">
                  <h4 style="font-weight: 800; color: #0f172a; margin: 0; font-size: 18px; line-height: 1.2;">I Kan Housing <i class="fa fa-circle-check" style="color: #22c55e; font-size: 14px; margin-left: 4px;" title="Verified Provider"></i></h4>
                  <p style="color: #64748b; font-weight: 600; margin: 2px 0 0; font-size: 14px;"><i class="fa-solid fa-phone-volume me-1" style="color: #22c55e;"></i> +91 89553 31454</p>
                </div>
              </div>

              <form class="contact-form" method="POST" id="sidebarContactForm">
                <input type="hidden" name="property_slug" value="<?= htmlspecialchars($slug) ?>">
                <input type="text" name="c_name" class="form-control" placeholder="Your Name" required>
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                <input type="text" name="phone" class="form-control" placeholder="Phone Number" required pattern="\d{10}">

                <div class="form-check my-3">
                  <input type="checkbox" class="form-check-input" id="agree" checked>
                  <label for="agree" class="form-check-label" style="font-size:13px; color:#64748b;">
                    I agree to be contacted via WhatsApp, SMS, or phone.
                  </label>
                </div>

                <button type="submit" class="btn-premium-cta" id="sidebarSubmitBtn">Contact Expert</button>
              </form>

              <!-- Quick Action Conversion CTAs -->
              <div class="d-flex flex-column gap-2 mt-3 pt-3 border-top">
                <button type="button" class="btn w-100 fw-bold py-2" data-bs-toggle="modal" data-bs-target="#siteVisitModal" style="border-radius: 12px; border: 1.5px solid #c02a7c; color: #c02a7c; background: #fff5f9; font-size: 14px; transition: all 0.2s;">
                  <i class="fa-solid fa-calendar-check me-2"></i> Book a Free Site Visit
                </button>
                <a href="https://wa.me/918955331454?text=<?= urlencode('Hello Ikan Housing, I am interested in ' . $property['project_name'] . ' (' . $property['location'] . '). Please share details.') ?>" target="_blank" class="btn w-100 fw-bold py-2 text-white" style="border-radius: 12px; background: #22c55e; font-size: 14px; text-decoration: none; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(34, 197, 94, 0.25);">
                  <i class="fa-brands fa-whatsapp me-2" style="font-size: 18px;"></i> Instant WhatsApp Chat
                </a>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

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
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div>
            <h5 class="modal-title fw-bold text-dark mb-0" id="siteVisitModalLabel">
              <i class="fa-solid fa-calendar-check" style="color: #c02a7c; margin-right: 8px;"></i> Schedule a Site Visit
            </h5>
            <p class="text-muted small mb-0 mt-1">Tour <strong><?= htmlspecialchars($property['project_name']) ?></strong> with our property expert.</p>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div id="siteVisitMsg" class="d-none mb-3"></div>

          <form id="siteVisitForm" method="POST">
            <input type="hidden" name="property_id" value="<?= (int)$property['id'] ?>">
            <input type="hidden" name="property_name" value="<?= htmlspecialchars($property['project_name']) ?>">
            <input type="hidden" name="property_slug" value="<?= htmlspecialchars($slug) ?>">

            <div class="mb-3">
              <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing:0.5px;">Your Full Name *</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa fa-user"></i></span>
                <input type="text" name="name" class="form-control border-start-0" placeholder="e.g. Rahul Sharma" required>
              </div>
            </div>

            <div class="row g-2 mb-3">
              <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing:0.5px;">Mobile Number *</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted">+91</span>
                  <input type="tel" name="phone" maxlength="10" pattern="[0-9]{10}" class="form-control border-start-0" placeholder="10-digit number" required>
                </div>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing:0.5px;">Email Address</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa fa-envelope"></i></span>
                  <input type="email" name="email" class="form-control border-start-0" placeholder="Optional">
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing:0.5px;">Preferred Visit Date *</label>
              <input type="date" name="visit_date" id="visitDateInput" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= date('Y-m-d', strtotime('+1 day')) ?>" required>
            </div>

            <div class="mb-4">
              <label class="form-label small fw-bold text-muted text-uppercase" style="letter-spacing:0.5px;">Preferred Time Slot *</label>
              <div class="row g-2">
                <div class="col-4">
                  <input type="radio" name="time_slot" id="slotMorning" value="Morning (10 AM - 1 PM)" class="slot-pill-input" checked>
                  <label for="slotMorning" class="slot-pill-label">
                    <i class="fa-regular fa-sun d-block mb-1 text-warning"></i> Morning<br><span style="font-size:10px; font-weight:normal; opacity:0.8;">10 AM - 1 PM</span>
                  </label>
                </div>
                <div class="col-4">
                  <input type="radio" name="time_slot" id="slotAfternoon" value="Afternoon (1 PM - 4 PM)" class="slot-pill-input">
                  <label for="slotAfternoon" class="slot-pill-label">
                    <i class="fa-solid fa-sun d-block mb-1 text-primary"></i> Afternoon<br><span style="font-size:10px; font-weight:normal; opacity:0.8;">1 PM - 4 PM</span>
                  </label>
                </div>
                <div class="col-4">
                  <input type="radio" name="time_slot" id="slotEvening" value="Evening (4 PM - 7 PM)" class="slot-pill-input">
                  <label for="slotEvening" class="slot-pill-label">
                    <i class="fa-solid fa-moon d-block mb-1" style="color:#c02a7c;"></i> Evening<br><span style="font-size:10px; font-weight:normal; opacity:0.8;">4 PM - 7 PM</span>
                  </label>
                </div>
              </div>
            </div>

            <div class="p-2 mb-3 rounded-3 d-flex align-items-center gap-2" style="background:#f0fdf4; border:1px solid #bbf7d0;">
              <i class="fa-solid fa-car-side text-success fs-5"></i>
              <div style="font-size:12px; color:#166534; line-height:1.3;">
                <strong>Free Site Visit Assistance:</strong> Our property manager will assist with site directions and project walkthrough.
              </div>
            </div>

            <button type="submit" class="btn w-100 py-3 fw-bold text-white shadow-sm" id="submitSiteVisitBtn" style="background:linear-gradient(135deg, #c02a7c 0%, #991b5b 100%); border-radius:12px; font-size:15px;">
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
    document.addEventListener('DOMContentLoaded', function () {
      const modal = document.getElementById('myModal');
      const openBtn = document.getElementById('openModalBtn');
      const closeBtn = document.querySelector('#myModal .close');

      openBtn.addEventListener('click', function (e) {
        e.preventDefault();
        modal.style.display = 'block';
      });

      closeBtn.addEventListener('click', function () {
        modal.style.display = 'none';
      });

      window.addEventListener('click', function (event) {
        if (event.target === modal) {
          modal.style.display = 'none';
        }
      });
    });
  </script>
  <script>
    const slider = document.getElementById('locationSlider');
    document.querySelector('.loc-btn.next').addEventListener('click', () => {
      slider.scrollBy({ left: slider.clientWidth, behavior: 'smooth' });
    });
    document.querySelector('.loc-btn.prev').addEventListener('click', () => {
      slider.scrollBy({ left: -slider.clientWidth, behavior: 'smooth' });
    });
  </script>


  <script>
    const openBtn = document.getElementById("openContactBox");
    const closeBtn = document.getElementById("closeContactBox");
    const contactBox = document.getElementById("contactBox");

    openBtn.addEventListener("click", () => {
      contactBox.style.display = "flex";
    });

    closeBtn.addEventListener("click", () => {
      contactBox.style.display = "none";
    });

    // Agar background pe click kare to bhi close ho
    window.addEventListener("click", (e) => {
      if (e.target === contactBox) {
        contactBox.style.display = "none";
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

    // --- 3. AJAX SITE VISIT FORM SUBMISSION ---
    document.addEventListener('DOMContentLoaded', function() {
      calculateEMI();
      updateSaveButtonUI();

      const siteVisitForm = $('#siteVisitForm');
      if (siteVisitForm.length) {
        siteVisitForm.on('submit', function(e) {
          e.preventDefault();
          const form = $(this);
          const submitBtn = $('#submitSiteVisitBtn');
          const msgBox = $('#siteVisitMsg');

          msgBox.html('').removeClass('alert alert-success alert-danger d-none');
          const originalBtnHtml = submitBtn.html();
          submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Scheduling Visit...');

          $.ajax({
            url: 'api/schedule_visit.php',
            type: 'POST',
            data: form.serialize(),
            dataType: 'json',
            success: function(res) {
              if (res.status === 'success') {
                msgBox.addClass('alert alert-success').html('<strong>🎉 Success!</strong> ' + res.message);
                form[0].reset();
                submitBtn.html('<i class="fa-solid fa-check me-2"></i>Visit Scheduled!');

                if (typeof Swal !== 'undefined') {
                  Swal.fire({
                    icon: 'success',
                    title: 'Site Visit Confirmed!',
                    text: res.message,
                    confirmButtonColor: '#c02a7c',
                    confirmButtonText: 'Great, Thank You!'
                  });
                }

                setTimeout(function() {
                  const modalEl = document.getElementById('siteVisitModal');
                  if (modalEl && typeof bootstrap !== 'undefined') {
                    const modalInstance = bootstrap.Modal.getInstance(modalEl);
                    if (modalInstance) modalInstance.hide();
                  }
                  submitBtn.prop('disabled', false).html(originalBtnHtml);
                }, 4000);
              } else {
                msgBox.addClass('alert alert-danger').html('⚠️ ' + (res.message || 'Could not schedule visit. Please try again.'));
                submitBtn.prop('disabled', false).html(originalBtnHtml);
              }
            },
            error: function() {
              msgBox.addClass('alert alert-danger').html('❌ Communication failed. Please call us directly at +91 89553 31454.');
              submitBtn.prop('disabled', false).html(originalBtnHtml);
            }
          });
        });
      }
    });
  </script>
</body>

</html>