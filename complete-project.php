<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>
<?php
session_start();
include('config.php');

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

$showModal=true;
if(isset($_COOKIE['mobile_submitted']) && $_COOKIE['mobile_submitted'] =='1'){
  $showModal=false;
}

// Fetch all new_property
$query = "SELECT * FROM new_property WHERE project_type = 1 AND status = 1 ORDER BY id ASC";
$result = mysqli_query($con, $query);

if (!$result) {
  die("Database query failed: " . mysqli_error($con));
}
$search = "";
if (isset($_GET['search']) && !empty($_GET['search'])) {
  $search = mysqli_real_escape_string($con, $_GET['search']);
  $query = "SELECT * FROM new_property 
              WHERE status = 1 
              AND project_type = 1  
              AND project_name LIKE '%$search%' 
              ORDER BY id ASC";
} else {
  $query = "SELECT * FROM new_property 
              WHERE status = 1 
              AND project_type = 1 
              ORDER BY id ASC";
}

$result = mysqli_query($con, $query);
if (!$result) {
  die("Database query failed: " . mysqli_error($con));
}
?>
<body>

  <!--/ Nav Star /-->
  <?php include 'component/navbar.php'; ?>
  <!--/ Nav End /-->

<section class="project-hero-section text-center">
    <div class="container">
        <h1 class="project-hero-title mb-2">Discover <span>Completed</span> Excellence</h1>
        <p class="project-hero-subtitle mb-5">Premium residential and commercial landmarks by I Kan Housing</p>
        
        <div class="search-console-wrapper mx-auto">
            <form method="GET" action="" class="d-flex align-items-center">
                <div class="search-input-group flex-grow-1">
                    <i class="fa fa-search search-icon-left text-muted"></i>
                    <input type="search" name="search" class="form-control-modern" placeholder="Search by project name or location..."
                        value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                </div>
                <button class="search-btn-modern" type="submit">
                    Search Now
                </button>
            </form>
        </div>
    </div>
</section>

  <!--/ Property Single Star /-->
  <section class="section-property section-t8" data-aos="fade-up" data-aos-duration="1000"
    style="    margin-top: 40px;">
    <div class="container container-rdx">
      <div class="row">
        <?php if (mysqli_num_rows($result) > 0) { ?>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-lg-6 col-md-12 mb-4">
              <div class="property-card">
                <div class="property-img">
                  <a href="#" onclick="openPopup('<?= $row['slug'] ?>'); return false;">
                    <img src="uploads/<?= htmlspecialchars($row['main_image']) ?>" 
                         alt="<?= htmlspecialchars($row['project_name']) ?>" 
                         width="600" height="400" 
                         loading="lazy" 
                         decoding="async" 
                         style="aspect-ratio: 3/2; width: 100%; height: auto; object-fit: cover;">
                    <!-- <span class="time-stamp">4w ago</span> -->
                     <span class="time-stamp">
                      <?php
                        $created_at=$row['created_at'];
                        $now= new DateTime();
                        $created= new DateTime($created_at);
                        $diff=$now->diff($created);
                        echo $diff->days."w";
                      ?>
                     </span>
                  </a>
                </div>

                <!-- Property Details -->
                <div class="property-details">
                  <div class="property-header">
                    <h5 class="property-title">
                      <a href="#"
                        onclick="openPopup('<?= $row['slug'] ?>'); return false;"><?= htmlspecialchars($row['project_name']) ?></a>
                    </h5>
                    <span class="<?= ($row['rera_no'] != 'JDA Approved') ? 'rera-badge' : 'jda-badge' ?>">
                      <?= ($row['rera_no'] != 'JDA Approved') ? 'RERA' : 'JDA Approved' ?>
                    </span>
                  </div>

                  <p class="property-subtitle"><?= htmlspecialchars($row['bhk']) ?> Flats in
                    <?= htmlspecialchars($row['location']) ?></p>

                  <!-- Pricing Section -->
                  <div class="property-prices">
                    <div>
                      <small>Starting from</small>
                      <h6>₹ <?= htmlspecialchars($row['min_price']) ?></h6>
                    </div>
                     <div>
                    <small>Ending till</small>
                    <h6>₹ <?= htmlspecialchars($row['max_price']) ?></h6>
                  </div>
                    <div>
                      <small>Possession</small>
                      <h6><?php echo htmlspecialchars($row['possession_date'])?></h6>
                    </div>
                  </div>

                  <div class="divider"></div>

                  <!-- Bottom Section -->
                  <div class="property-footer">
                    <div class="seller-info">
                      <!-- <i class="fa fa-building"></i> -->
                        <span>By</span>
                          <span>  <?php
                              $showbuilder = "SELECT builder.builder_name 
                            FROM new_property
                            LEFT JOIN builder
                            ON new_property.builder_name = builder.id
                            WHERE new_property.id = '" . $row['id'] . "'";

                            $resbuilder = mysqli_query($con, $showbuilder);
                            $builderRow = mysqli_fetch_assoc($resbuilder);
                            ?>
                            <a href="#" class="text-primarys fw-semibold "> <?= $builderRow['builder_name'] ?></a></span>
                            </div>
                                <button class="btn btn-primary w-100 fd-rdx"
                                  onclick="window.open('https://wa.me/918955331454?text=<?= urlencode('Hello! I am interested in your property: ' . $row['project_name']); ?>', '_blank')">Contact Us
                                </button>  
                              </div>
                      </div>
              </div>
            </div>
          <?php } ?>
        <?php } else { ?>
          <div class="col-12">
            <div class="no-results-container text-center py-5" data-aos="zoom-in">
              <img src="img/no-results.png" alt="No Results Found" class="img-fluid mb-4" style="max-width: 180px; opacity: 0.9;">
              <h3 class="fw-bold text-secondary mb-2">No Results Found</h3>
              <p class="text-muted mx-auto" style="max-width: 400px;">We couldn't find any properties matching your search. Try adjusting your filters or search terms.</p>
              <a href="complete-project" class="btn btn-outline-primary rounded-pill px-4 mt-3">Reset Search</a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>


  <!--/ Property Single End /-->
<!-- Popup Modal -->
<div class="jhyt" id="mobilePopup" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);backdrop-filter:blur(5px);z-index:9999;">
  <div class="jhytt" style="background:white;padding:30px;width:90%;max-width:380px;border-radius:15px;text-align:center;box-shadow:0 15px 35px rgba(0,0,0,0.2);position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);">
    <span onclick="closePopup()" style="position:absolute;top:10px;right:18px;font-size:28px;cursor:pointer;color:#999;font-weight:bold;">&times;</span>
    <div style="margin-bottom:20px;">
        <i class="fa fa-phone" style="font-size:36px;color:#c02a7c;background:#fdeaf3;padding:15px 18px;border-radius:50%;"></i>
    </div>
    <h3 style="font-size:22px;font-weight:700;color:#333;margin-bottom:10px;">View Full Details</h3>
    <p style="font-size:14px;color:#666;margin-bottom:20px;">Please enter your mobile number to proceed.</p>
    <form id="mobileForm" action="api/modal_contact.php" method="POST">
        <input type="hidden" name="slug" id="popup-slug" value="<?php echo isset($_GET['slug']) ? htmlspecialchars($_GET['slug']) : ''; ?>">
        <input class="num form-control" type="text" id="mobileNumber" name="phone" placeholder="+91 00000 00000" required pattern="\d{10}" style="padding:12px;width:100%;border-radius:8px;border:1px solid #ddd;font-size:16px;text-align:center;letter-spacing:1px;box-shadow:none;">
        <button class="prk-btn" type="submit" style="width:100%;padding:13px;background:#c02a7c;color:white;border:none;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;margin-top:15px;transition:0.3s;box-shadow:0 4px 10px rgba(192,42,124,0.3);">Verify & Continue</button>
    </form>
  </div>
</div>

  <?php include 'component/footer.php'; ?>

  <!-- redirect script  start for popup box -->

  <script>
    function openPopup(slug) {
      const isSubmitted = (getCookie('mobile_submitted') === '1' || localStorage.getItem('mobile_submitted') === '1');
      if (isSubmitted) {
        // Sync back to localStorage if found in cookie 
        if (localStorage.getItem('mobile_submitted') !== '1') {
          localStorage.setItem('mobile_submitted', '1');
        }
        window.location.href = 'property-detail-for.php?slug=' + encodeURIComponent(slug);
        return;
      }
      const pSlug = document.getElementById('popup-slug');
      if (pSlug) pSlug.value = slug;
      const mPop = document.getElementById('mobilePopup');
      if (mPop) mPop.style.display = 'block';
    }

    function closePopup() {
      const mPop = document.getElementById('mobilePopup');
      if (mPop) mPop.style.display = 'none';
    }

    function getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    }

    // Prevent double submit
    document.getElementById('mobileForm')?.addEventListener('submit', function(e){
      const btn = this.querySelector('button[type="submit"]');
      if (btn) btn.disabled = true;
    });
  </script>

<script>
  const minRange = document.getElementById('minRange');
const maxRange = document.getElementById('maxRange');
const minLabel = document.getElementById('price-min-label');
const maxLabel = document.getElementById('price-max-label');
const rangeTrack = document.querySelector('.range-slider::after'); // For background update

function formatPrice(value) {
  if (value == 0) return '₹0';
  if (value >= 50) return '₹5.00Cr+';
  return ₹${value}Cr;
}

function updateLabels() {
  let minValue = parseInt(minRange.value);
  let maxValue = parseInt(maxRange.value);

  // Ensure min is always less than max
  if (minValue > maxValue - 1) {
    minRange.value = maxValue - 1;
    minValue = maxValue - 1;
  }

  minLabel.textContent = formatPrice(minValue);
  maxLabel.textContent = formatPrice(maxValue);
}

minRange.addEventListener('input', updateLabels);
maxRange.addEventListener('input', updateLabels);

// Initialize
updateLabels();

</script>

<script>
    const filterBtn = document.getElementById("filterToggleBtn");
    const filterBar = document.getElementById("filterBar");

    filterBtn.addEventListener("click", () => {
      if (filterBar.style.display === "flex") {
        filterBar.style.display = "none";
      } else {
        filterBar.style.display = "flex";
      }
    });
  </script>
<!-- redirect script end for popup box -->

</body>

</html>