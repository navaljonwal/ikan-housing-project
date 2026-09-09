<?php
include 'config.php'; // database connection file

// Get property slug from URL
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($con, $_GET['slug']) : '';

// Fetch property data using slug
$sql = "SELECT * FROM new_property WHERE slug = '$slug' LIMIT 1";
$result = mysqli_query($con, $sql);
$property = mysqli_fetch_assoc($result);

// If no data found, redirect or show error
if (!$property) {
  echo "Property not found!";
  exit;
}

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

$flats = '';
$flats = 'Flat';
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
            <span class="<?= ($property['rera_no'] != 'JDA Approved') ? 'badge bg-light text-success border' : 'jda-badge' ?>" style="padding: 8px 14px; font-size: 13px; font-weight: 700; border-radius: 8px;">
                <?= ($property['rera_no'] != 'JDA Approved') ? '✔ RERA Approved' : '✔ JDA Approved' ?>
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
          <div class="header-price" style="color: #c02a7c;">₹<?= htmlspecialchars($property['min_price']) ?> – <?= htmlspecialchars($property['max_price']) ?></div>
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

  <!-- Hidden Popup Slider (Kept Intact) -->
  <div id="popup" class="popup popup-v">
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
  <section class="property-section py-4">
    <div class="container">
      <div class="row g-4">

        <!-- Left Side -->
        <div class="col-12  col-lg-8">
          <div class="col-md-12 rtyu">
            <div class="detl-rd" data-aos="fade-down" data-aos-duration="1000">
              <!-- <img style="width: 90px;" src="uploads/<?php echo htmlspecialchars($property['logo']); ?>" alt="error in loading image"> -->
              <!-- <img style="width: 90px;" src="uploads/<?php echo htmlspecialchars($property['logo']); ?>" alt="error in loading image"> -->
              <h3 class="vh">About Project</h3>
              <p style="color: #475569; line-height: 1.8; font-size: 15px;"><?php echo $property['other_key_feature']; ?></p>

              <!-- Premium Brochure Action Card -->
              <div class="brochure-card-premium mt-4 p-4 d-flex align-items-center gap-4 shadow-sm" style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 20px; border: 1px solid #e2e8f0;">
                <div class="brochure-icon" style="width: 60px; height: 60px; background: white; border-radius: 15px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
                  <i class="fa-solid fa-file-pdf" style="color: #ef4444; font-size: 30px;"></i>
                </div>
                <div class="flex-grow-1">
                  <h5 style="font-weight: 800; color: #0f172a; margin-bottom: 4px;">Project Brochure</h5>
                  <p style="color: #64748b; font-size: 13px; margin: 0; font-weight: 500;">Download complete project details, floor plans & specifications.</p>
                </div>
                <a href="uploads/<?= htmlspecialchars($property['brochure']); ?>" class="btn-premium-brochure" download style="background: #c02a7c; color: white; padding: 12px 25px; border-radius: 12px; text-decoration: none; font-weight: 700; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 4px 6px -1px rgba(192, 42, 124, 0.3);">
                  <i class="fa-solid fa-download me-2"></i> Download
                </a>
              </div>
            </div>
          </div>
          <div class="why-box mb-4 mt-4" data-aos="fade-down" data-aos-duration="1000">
            <h3>Highlights</h3>
            <ul class="rfvg">
              <li><?php echo $property['highlight'] ?></li>
            </ul>
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
                  <p class="ov-val"><?= htmlspecialchars($property['bigha']) ?> sq.ft</p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-ruler-combined"></i></div>
                <div>
                  <p class="ov-title">Build-up Area</p>
                  <p class="ov-val"><?= htmlspecialchars($property['unit']) ?> sq.ft</p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-coins"></i></div>
                <div>
                  <p class="ov-title">Price Range</p>
                  <p class="ov-val"><?= htmlspecialchars($property['min_price']) ?> - <?= htmlspecialchars($property['max_price']) ?></p>
                </div>
              </div>
              <div class="overview-card-premium">
                <div class="overview-icon-container"><i class="fa fa-clock"></i></div>
                <div>
                  <p class="ov-title">Possession</p>
                  <p class="ov-val"><?= htmlspecialchars($property['possession_date']) ?></p>
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
                  <p class="ov-val"><?= ($property['rera_no'] != "JDA Approved") ? htmlspecialchars($property['rera_no']) : "Approved" ?></p>
                </div>
              </div>
            </div>
            
            <div class="d-flex gap-3 mb-5 align-items-center">
              <div class="dropdown">
                <button class="btn-share-premium dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa-solid fa-share-nodes" style="color:#c02a7c; margin-right:5px;"></i> Share Property
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

              <button class="btn-share-premium" onclick="saveProperty();" style="color: #c02a7c;">
                <i class="fa-solid fa-heart"></i> Save
              </button>
            </div>

            <script>
              function copyToClipboard() {
                const url = window.location.href;
                navigator.clipboard.writeText(url).then(() => {
                  alert("Link copied to clipboard!");
                });
              }
              function saveProperty() {
                alert("Property saved to your favorites!");
              }
            </script>
          </section>

          <div class="amenities-section" data-aos="fade-down" data-aos-duration="1000">
            <h3 class="vh mb-4">Project Amenities</h3>

            <div class="amenities-premium-grid" id="amenitiesGrid">
              <?php
              $property_id = (int) $property['id'];
              $amenity_querry = "SELECT amenity.name , amenity.icon
               FROM amenity 
               INNER JOIN property_amenities 
               on amenity.id=property_amenities.amenity_id 
               WHERE property_amenities.property_id= $property_id";
              $amenity_result = mysqli_query($con, $amenity_querry);
              $amenities = [];
              while ($row_amenity = mysqli_fetch_assoc($amenity_result)) {
                $amenities[] = $row_amenity;
              }
              foreach ($amenities as $index => $am):
                $hidden_class = ($index >= 9) ? 'amenity-hidden d-none' : '';
                ?>
                <div class="amenity-premium-badge <?= $hidden_class ?>">
                  <img src="uploads/<?php echo $am['icon']; ?>" alt="icon">
                  <span><?php echo $am['name'] ?></span>
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

          <!-- <div class="floor-plan-container">

            <div class="bhk-buttons">
              <button class="bhk-btn active" data-target="slider-2bhk">2 BHK</button>
              <button class="bhk-btn" data-target="slider-3bhk">3 BHK</button>
              <button class="bhk-btn" data-target="slider-4bhk">4 BHK</button>
            </div>

            <div class="swiper bhk-slider active" id="slider-2bhk">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="images/2bhk1.jpg" alt="2 BHK 1"></div>
                <div class="swiper-slide"><img src="images/2bhk2.jpg" alt="2 BHK 2"></div>
                <div class="swiper-slide"><img src="images/2bhk3.jpg" alt="2 BHK 3"></div>
              </div>

              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination"></div>
            </div>


            <div class="swiper bhk-slider" id="slider-3bhk">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="images/3bhk1.jpg" alt="3 BHK 1"></div>
                <div class="swiper-slide"><img src="images/3bhk2.jpg" alt="3 BHK 2"></div>
                <div class="swiper-slide"><img src="images/3bhk3.jpg" alt="3 BHK 3"></div>
              </div>

              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination"></div>
            </div>


            <div class="swiper bhk-slider" id="slider-4bhk">
              <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="images/4bhk1.jpg" alt="4 BHK 1"></div>
                <div class="swiper-slide"><img src="images/4bhk2.jpg" alt="4 BHK 2"></div>
                <div class="swiper-slide"><img src="images/4bhk3.jpg" alt="4 BHK 3"></div>
              </div>

              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination"></div>
            </div>
          </div> -->

          <!-- <section class="floor-plan-section">
            <div class="container">
              <h5 class="section-title">Floor Plan</h5>

         
              <div class="bhk-options">
                <?php
                $bhk_querry = "SELECT sub_category.name 
                FROM sub_category
                INNER JOIN property_subcat
                ON sub_category.id=property_subcat.subcat_id
                WHERE property_subcat.property_id=$property_id";

                $bhk_result = mysqli_query($con, $bhk_querry);
                $bhks = [];
                while ($row_bhk = mysqli_fetch_assoc($bhk_result)) {
                  $bhks[] = $row_bhk;
                }
                foreach ($bhks as $bh):
                  ?>
                  <button class="bhk-btn"
                    data-bhk="<?php echo htmlspecialchars($bh['name']) ?>"><?php echo htmlspecialchars($bh['name']) ?></button>
                  <?php
                endforeach;
                ?>
              </div>

           
              <div class="area-tabs" id="areaTabs">
             
              </div>
              <div class="floor-plan-image">
                <img id="floorPlanImage" src="uploads/e-1.jpeg" alt="2D Floor Plan">

          
                <div class="floating-controls">
                  <button class="control-btn" id="zoomIn"><i class="fa fa-search-plus"></i></button>
                  <button class="control-btn" id="zoomOut"><i class="fa fa-search-minus"></i></button>
                  <button class="control-btn" id="shareBtn"><i class="fa fa-share"></i></button>
                </div>

           
                <div class="nav-arrows">
                  <button class="arrow-btn" id="prevPlan"><i class="fa fa-chevron-left"></i></button>
                  <button class="arrow-btn" id="nextPlan"><i class="fa fa-chevron-right"></i></button>
                </div>
              </div>

             
              <div class="room-details" id="roomDetails">
            
              </div>

        
              <p class="note">Is the pricing & floor plan helpful? 👍 👎</p>
            </div>
          </section>   -->


          <section class="media-showcase" data-aos="fade-down" data-aos-duration="1000">
            <div class="media-container">
              <h5 class="media-title">Photos & Videos: <span>Tour this project virtually</span></h5>
              <p class="media-subtitle">Project Tour & Photos</p>

              <div class="media-grid">
                <!-- Featured Video -->
                <div class="media-item media-video video-wide">
                  <a href="uploads/project-tour.mp4" target="_blank">
                    <iframe width="100%" height="auto"
                      src="https://www.youtube.com/embed/rDw0GYl9msY?si=nKamJCU0iplgXALq" title="YouTube video player"
                      frameborder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
                    </iframe>
                    <div class="video-play-icon">
                      <i class="fa fa-play-circle"></i>
                    </div>
                  </a>
                </div>

                <!-- Images from PHP -->
                <?php
                $total_images = count($images);
                foreach ($images as $index => $img) {
                  if ($index < 1) {  // Show first image
                    ?>
                    <div class="media-item">
                      <a href="uploads/<?= htmlspecialchars(trim($img)) ?>" target="_blank">
                        <img src="uploads/<?= htmlspecialchars(trim($img)) ?>" alt="Project Photo">
                      </a>
                    </div>
                  <?php } elseif ($index == 3) { // Last image shows +count ?>
                    <div class="media-item more-photos view-more" onclick="document.getElementById('popup').style.display='block'" style="cursor:pointer;">
                      <div class="gallery-small view-more"
                        style="background-image: url('uploads/<?php echo trim($images[2]); ?>');">
                        <div class="overlay overlay-v">+ View More</div>
                      </div>
                    </div>
                    <?php break;
                  }
                } ?>
              </div>
            </div>
          </section>
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

          <div class="fg-rdx">
            <div class="flxx" data-aos="fade-down" data-aos-duration="1000">
              <?php echo ($property['map']); ?>
            </div>
          </div>
        </div>

        <!-- Right Side -->
        <div class="col-12 col-md-4 ghjp">
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
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

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
</body>

</html>