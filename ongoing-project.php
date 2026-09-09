<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>
<?php
session_start();
include('config.php');

// Enable error reporting to find any hidden errors
error_reporting(E_ALL);
ini_set('display_errors', 0);

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// searchbar conditions
$conditions = [];
if (!empty($_GET['category_id'])) {
  $cat_id = mysqli_real_escape_string($con, $_GET['category_id']);
  $conditions[] = "id IN (SELECT property_id FROM property_category WHERE category_id = '$cat_id')";
}

if (!empty($_GET['builder_id'])) {
  $builder_id = mysqli_real_escape_string($con, $_GET['builder_id']);
  $conditions[] = "builder_name = '$builder_id'";
}

if (!empty($_GET['min_price_int']) && !empty($_GET['max_price_int'])) {
  $min_p = (int) $_GET['min_price_int'];
  $max_p = (int) $_GET['max_price_int'];
  // Show properties that overlap with the selected range
  $conditions[] = "min_price_int <= $max_p AND max_price_int >= $min_p";
}

if (!empty($_GET['search'])) {
  $search = mysqli_real_escape_string($con, $_GET['search']);
  $conditions[] = "(project_name LIKE '%$search%' OR location LIKE '%$search%')";
}

// Restore status=1 filter
$where = "status = 1 AND project_type = 0"; 
if (!empty($conditions)) {
  $where .= " AND " . implode(" AND ", $conditions);
}

// Simplified Query (No Joins unless category is filtered)
$query = "SELECT * FROM new_property WHERE $where ORDER BY id DESC";
$result = mysqli_query($con, $query);

if (!$result) {
  die("Database error: " . mysqli_error($con));
}

// Get selected names for premium labels
$selected_cat_name = "Category";
if (!empty($_GET['category_id'])) {
  $cq = mysqli_query($con, "SELECT category_name FROM category WHERE id = '".mysqli_real_escape_string($con, $_GET['category_id'])."'");
  $cr = mysqli_fetch_assoc($cq);
  if ($cr) $selected_cat_name = $cr['category_name'];
}

$selected_builder_name = "Builder";
if (!empty($_GET['builder_id'])) {
  $bq = mysqli_query($con, "SELECT builder_name FROM builder WHERE id = '".mysqli_real_escape_string($con, $_GET['builder_id'])."'");
  $br = mysqli_fetch_assoc($bq);
  if ($br) $selected_builder_name = mb_strimwidth($br['builder_name'], 0, 12, "...");
}

$found_count = mysqli_num_rows($result);
?>
<body>

  <?php include 'component/navbar.php'; ?>

  <!-- Hero Section (Optimized for LCP) -->
  <section class="projects-hero" style="position: relative; overflow: hidden; padding: 150px 0 100px; text-align: center; color: white;">
    <img src="img/homepage.jpeg" alt="Hero Background" fetchpriority="high" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; z-index: 1; filter: brightness(0.4);">
    <div class="container" data-aos="zoom-in" style="position: relative; z-index: 2;">
      <h1 style="font-family: 'Outfit', sans-serif; font-weight: 700; font-size: clamp(2.5rem, 8vw, 4rem); margin-bottom: 20px; text-shadow: 0 4px 10px rgba(0,0,0,0.3);">Discover Your Dream Home</h1>
      <p style="font-size: 1.25rem; opacity: 0.95; max-width: 700px; margin: 0 auto; font-family: 'Outfit', sans-serif; font-weight: 300; letter-spacing: 0.5px;">Premium Ongoing Residential & Commercial Projects in Jaipur</p>
    </div>
  </section>

  <section class="joi" style="margin-top: -40px; position: relative; z-index: 10;">
    <!-- Mobile Filter Button -->
    <div class="text-center mb-4 filter-btn">
      <button id="filterToggleBtn" class="btn btn-primary" style="background: #bf006a; border: none; border-radius: 50px; padding: 12px 30px; font-weight: 600; box-shadow: 0 10px 20px rgba(191,0,106,0.3);">
        <i class="bi bi-funnel"></i> Toggle Filters
      </button>
    </div>

    <?php
    $priceQ = mysqli_query($con, "SELECT MIN(min_price_int) AS minp, MAX(max_price_int) AS maxp FROM new_property WHERE status = 1");
    $priceRow = mysqli_fetch_assoc($priceQ);
    $minPrice = (int)$priceRow['minp'];
    $maxPrice = (int)$priceRow['maxp'];
    ?>

    <!-- ======= PREMIUM FILTER BAR STYLES ======= -->
    <style>
      .pf-bar {
        display: flex; align-items: center; gap: 10px;
        flex-wrap: wrap; justify-content: center;
        background: #fff; border-radius: 20px;
        padding: 12px 20px; margin: 0 auto 30px;
        width: 95%; max-width: 1100px;
        box-shadow: 0 8px 40px rgba(191,0,106,.10), 0 2px 12px rgba(0,0,0,.06);
        border: 1px solid rgba(191,0,106,.10);
        animation: pfSlideDown .4s cubic-bezier(.4,0,.2,1);
      }
      @keyframes pfSlideDown { from{opacity:0;transform:translateY(-16px)} to{opacity:1;transform:translateY(0)} }

      .pf-label {
        font-family:'Outfit',sans-serif; font-size:11px; font-weight:700;
        text-transform:uppercase; letter-spacing:1.2px; color:#bf006a;
        padding: 0 6px 0 2px; white-space:nowrap;
      }
      .pf-sep { width:1px; height:34px; background:#f0e0eb; flex-shrink:0; }

      .pf-chip {
        display:inline-flex; align-items:center; gap:7px;
        background:#fdf5fa; border:1.5px solid #f0dded; color:#3a1a2e;
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:600;
        padding:8px 17px; border-radius:50px; cursor:pointer;
        transition:all .22s ease; white-space:nowrap; position:relative;
      }
      .pf-chip i { font-size:13px; color:#bf006a; }
      .pf-chip .pf-caret { font-size:9px; color:#bf006a; transition:transform .22s; }
      .pf-chip:hover {
        background:#fff0f7; border-color:#bf006a; color:#bf006a;
        box-shadow:0 4px 14px rgba(191,0,106,.18); transform:translateY(-1px);
      }
      .pf-chip:hover i, .pf-chip:hover .pf-caret { color:#bf006a; }
      .pf-chip.pf-active {
        background:#bf006a; border-color:#bf006a; color:#fff;
        box-shadow:0 4px 14px rgba(191,0,106,.3);
      }
      .pf-chip.pf-active i, .pf-chip.pf-active .pf-caret { color:#fff; }
      .pf-chip.pf-active:hover { background:#9e005a; color:#fff; }

      .pf-wrap { position:relative; }

      .pf-panel {
        position:absolute; top:calc(100% + 10px); left:50%;
        transform:translateX(-50%);
        background:#fff; border-radius:18px;
        box-shadow:0 20px 50px rgba(0,0,0,.14);
        padding:8px; z-index:9999; min-width:220px;
        display:none; border:1px solid #f5e6f0;
        animation:pfFadeUp .22s ease;
      }
      .pf-panel.pf-wide { min-width:330px; }
      @keyframes pfFadeUp {
        from{opacity:0;transform:translateX(-50%) translateY(8px)}
        to{opacity:1;transform:translateX(-50%) translateY(0)}
      }
      .pf-panel.pf-open { display:block; }

      /* builder search */
      .pf-srch {
        display:flex; align-items:center; gap:7px;
        background:#fdf5fa; border:1.5px solid #f0dded;
        border-radius:50px; padding:6px 13px; margin-bottom:7px;
      }
      .pf-srch i { color:#bf006a; font-size:11px; }
      .pf-srch input {
        border:none; outline:none; background:transparent;
        font-family:'Outfit',sans-serif; font-size:13px; width:100%; color:#3a1a2e;
      }

      .pf-list {
        list-style:none; padding:0; margin:0;
        max-height:210px; overflow-y:auto;
        scrollbar-width:thin; scrollbar-color:#f0dded transparent;
      }
      .pf-list::-webkit-scrollbar{width:3px}
      .pf-list::-webkit-scrollbar-thumb{background:#f0dded;border-radius:10px}
      .pf-list li label {
        display:flex; align-items:center; gap:9px;
        padding:8px 12px; border-radius:11px; cursor:pointer;
        font-family:'Outfit',sans-serif; font-size:13px; color:#3a1a2e;
        transition:background .15s; font-weight:500;
      }
      .pf-list li label:hover { background:#fdf0f7; }
      .pf-list li input[type="radio"] { accent-color:#bf006a; width:14px; height:14px; flex-shrink:0; }
      .pf-list .pf-sel { background:#fff0f7; color:#bf006a; font-weight:700; }

      /* price panel */
      .pf-price-inner { padding:6px 6px 4px; }
      .pf-price-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
      .pf-price-val {
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:700;
        color:#bf006a; background:#fff0f7; padding:4px 11px; border-radius:50px;
      }
      .price-slider-container {
        position:relative; height:38px; margin:0 0 12px;
      }
      .price-slider-container input[type="range"] {
        position:absolute; width:100%; pointer-events:none;
        appearance:none; height:5px; background:transparent; z-index:10; top:8px;
      }
      .price-slider-container input[type="range"]::-webkit-slider-thumb {
        pointer-events:all; appearance:none;
        width:19px; height:19px; background:#bf006a; border-radius:50%;
        cursor:pointer; border:3px solid #fff; box-shadow:0 2px 8px rgba(191,0,106,.3);
      }
      .price-slider-container input[type="range"]::-moz-range-thumb {
        pointer-events:all; width:17px; height:17px; background:#bf006a;
        border-radius:50%; border:3px solid #fff; cursor:pointer;
      }
      .price-slider-container .slider-track {
        position:absolute; width:100%; height:5px;
        background:#f0e0eb; border-radius:10px; top:8px; z-index:5;
      }
      .pf-apply {
        width:100%; background:linear-gradient(135deg,#bf006a,#8a004d);
        color:#fff; border:none; border-radius:50px; padding:10px;
        font-family:'Outfit',sans-serif; font-weight:700; font-size:13px;
        cursor:pointer; transition:all .22s; box-shadow:0 4px 13px rgba(191,0,106,.25);
      }
      .pf-apply:hover { transform:translateY(-1px); box-shadow:0 6px 18px rgba(191,0,106,.35); }

      /* inline search */
      .pf-isearch {
        display:flex; align-items:center;
        background:#fdf5fa; border:1.5px solid #f0dded; border-radius:50px;
        padding: 4px 4px 4px 15px;
        transition:border-color .22s, box-shadow .22s;
      }
      .pf-isearch:focus-within { border-color:#bf006a; box-shadow:0 4px 13px rgba(191,0,106,.18); }
      .pf-isearch input {
        border:none; outline:none; background:transparent;
        font-family:'Outfit',sans-serif; font-size:13px; font-weight:500;
        padding: 5px 10px 5px 0; color:#3a1a2e; min-width:165px;
      }
      .pf-isearch button {
        display:inline-flex; align-items:center; justify-content:center;
        width:36px; height:36px; flex-shrink:0;
        background:#bf006a; border:none; color:#fff;
        border-radius:50%; cursor:pointer; font-size:14px;
        transition:background .2s, transform .2s;
        box-shadow: 0 3px 10px rgba(191,0,106,.3);
      }
      .pf-isearch button:hover { background:#9e005a; transform:scale(1.08); }

      /* reset */
      .pf-reset {
        display:inline-flex; align-items:center; gap:5px;
        font-family:'Outfit',sans-serif; font-size:12px; font-weight:600;
        color:#bbb; padding:8px 13px; border-radius:50px; cursor:pointer;
        text-decoration:none; transition:color .2s, background .2s; white-space:nowrap;
      }
      .pf-reset:hover { color:#bf006a; background:#fff0f7; }

      @media (max-width:767px) {
        .pf-bar { display:none; border-radius:16px; padding:12px; }
        .pf-bar.pf-show { display:flex !important; }
        .pf-isearch input { min-width:110px; }
        .pf-panel { left:0; transform:none; }
        @keyframes pfFadeUp{ from{opacity:0;transform:translateY(8px)} to{opacity:1;transform:translateY(0)} }
      }
      @media (min-width:768px) { .filter-btn { display:none; } }
    </style>

    <div class="container">
      <form method="GET" action="ongoing-project.php" id="unifiedFilterForm">
        <div class="pf-bar" id="filterBar" data-aos="fade-down">

          <span class="pf-label"><i class="bi bi-sliders2 me-1"></i>Filter by</span>
          <div class="pf-sep"></div>

          <!-- ── Category ── -->
          <div class="pf-wrap">
            <button type="button" onclick="pfToggle('pfCat',this)"
              class="pf-chip <?= !empty($_GET['category_id']) ? 'pf-active' : '' ?>" id="pfCatBtn">
              <i class="bi bi-grid-3x3-gap-fill"></i>
              <?= $selected_cat_name ?>
              <i class="bi bi-chevron-down pf-caret"></i>
            </button>
            <div class="pf-panel" id="pfCat">
              <ul class="pf-list">
                <li>
                  <label class="<?= (!isset($_GET['category_id']) || $_GET['category_id'] == '') ? 'pf-sel' : '' ?>">
                    <input type="radio" name="category_id" value="" onclick="this.form.submit()"
                      <?= (!isset($_GET['category_id']) || $_GET['category_id'] == '') ? 'checked' : '' ?>>
                    All Categories
                  </label>
                </li>
                <?php
                $catQuery  = "SELECT id,category_name FROM category WHERE status=1";
                $catresult = mysqli_query($con, $catQuery);
                while ($crow = mysqli_fetch_assoc($catresult)) {
                  $isCatSel = (isset($_GET['category_id']) && $_GET['category_id'] == $crow['id']);
                ?>
                <li>
                  <label class="<?= $isCatSel ? 'pf-sel' : '' ?>">
                    <input type="radio" name="category_id" value="<?= $crow['id'] ?>"
                      onclick="this.form.submit()" <?= $isCatSel ? 'checked' : '' ?>>
                    <?= htmlspecialchars($crow['category_name']) ?>
                  </label>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>

          <!-- ── Builder ── -->
          <div class="pf-wrap">
            <button type="button" onclick="pfToggle('pfBuilder',this)"
              class="pf-chip <?= !empty($_GET['builder_id']) ? 'pf-active' : '' ?>" id="pfBuilderBtn">
              <i class="bi bi-person-badge-fill"></i>
              <?= $selected_builder_name ?>
              <i class="bi bi-chevron-down pf-caret"></i>
            </button>
            <div class="pf-panel" id="pfBuilder">
              <div class="pf-srch">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search builder..." id="bSrchInput" oninput="pfBuilderSearch(this.value)">
              </div>
              <ul class="pf-list" id="bList">
                <li>
                  <label class="<?= (!isset($_GET['builder_id']) || $_GET['builder_id'] == '') ? 'pf-sel' : '' ?>">
                    <input type="radio" name="builder_id" value="" onclick="this.form.submit()"
                      <?= (!isset($_GET['builder_id']) || $_GET['builder_id'] == '') ? 'checked' : '' ?>>
                    All Builders
                  </label>
                </li>
                <?php
                $builderQuery = "SELECT id, builder_name FROM builder WHERE status=1 ORDER BY builder_name ASC";
                $bresult = mysqli_query($con, $builderQuery);
                while ($brow = mysqli_fetch_assoc($bresult)) {
                  $isBSel = (isset($_GET['builder_id']) && $_GET['builder_id'] == $brow['id']);
                ?>
                <li data-bname="<?= strtolower(htmlspecialchars($brow['builder_name'])) ?>">
                  <label class="<?= $isBSel ? 'pf-sel' : '' ?>">
                    <input type="radio" name="builder_id" value="<?= $brow['id'] ?>"
                      onclick="this.form.submit()" <?= $isBSel ? 'checked' : '' ?>>
                    <?= htmlspecialchars($brow['builder_name']) ?>
                  </label>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>

          <!-- ── Price Range ── -->
          <div class="pf-wrap">
            <button type="button" onclick="pfToggle('pfPrice',this)"
              class="pf-chip <?= !empty($_GET['min_price_int']) ? 'pf-active' : '' ?>" id="pfPriceBtn">
              <i class="bi bi-tag-fill"></i>
              Price Range
              <i class="bi bi-chevron-down pf-caret"></i>
            </button>
            <div class="pf-panel pf-wide" id="pfPrice">
              <div class="pf-price-inner">
                <div class="pf-price-row">
                  <span class="pf-price-val" id="price-min-label">₹<?= number_format($minPrice) ?></span>
                  <span style="font-size:10px;color:#bbb;font-weight:700;letter-spacing:.5px">TO</span>
                  <span class="pf-price-val" id="price-max-label">₹<?= number_format($maxPrice) ?></span>
                </div>
                <div class="price-slider-container">
                  <div class="slider-track"></div>
                  <input type="range" id="minRange" min="<?= $minPrice ?>" max="<?= $maxPrice ?>"
                    value="<?= isset($_GET['min_price_int']) ? $_GET['min_price_int'] : $minPrice ?>">
                  <input type="range" id="maxRange" min="<?= $minPrice ?>" max="<?= $maxPrice ?>"
                    value="<?= isset($_GET['max_price_int']) ? $_GET['max_price_int'] : $maxPrice ?>">
                </div>
                <input type="hidden" name="min_price_int" id="minPriceInput"
                  value="<?= isset($_GET['min_price_int']) ? $_GET['min_price_int'] : $minPrice ?>">
                <input type="hidden" name="max_price_int" id="maxPriceInput"
                  value="<?= isset($_GET['max_price_int']) ? $_GET['max_price_int'] : $maxPrice ?>">
                <button type="submit" class="pf-apply">
                  <i class="bi bi-check2-circle me-1"></i> Apply Price Filter
                </button>
              </div>
            </div>
          </div>

          <div class="pf-sep"></div>

          <!-- ── Inline Search ── -->
          <div class="pf-isearch">
            <input type="search" name="search" placeholder="Search project or location..."
              value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <button type="submit"><i class="bi bi-search"></i></button>
          </div>

          <!-- ── Reset (only when filters active) ── -->
          <?php if (!empty($_GET['category_id']) || !empty($_GET['builder_id']) || !empty($_GET['search']) || !empty($_GET['min_price_int'])): ?>
          <a href="ongoing-project" class="pf-reset">
            <i class="bi bi-x-circle-fill"></i> Reset
          </a>
          <?php endif; ?>

        </div>
      </form>
    </div>
  </section>

  <section class="section-property py-5">
    <div class="container">
      <div class="row">
        <?php if (mysqli_num_rows($result) > 0) { ?>
          <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <div class="col-lg-4 col-md-6 mb-4" data-aos="fade-up">
              <div class="property-card h-100 shadow-sm border-0">
                <div class="property-img">
                  <a href="#" onclick="openPopup('<?= $row['slug'] ?>'); return false;">
                    <img src="uploads/<?= htmlspecialchars($row['main_image']) ?>" 
                         alt="<?= htmlspecialchars($row['project_name']) ?>" 
                         width="600" height="400" 
                         loading="lazy" 
                         decoding="async" 
                         style="aspect-ratio: 3/2; width: 100%; height: auto; object-fit: cover;">
                    <span class="time-stamp">
                      <?php 
                      $created = new DateTime($row['created_at']);
                      $diff = (new DateTime())->diff($created);
                      echo ($diff->days > 0 ? $diff->days . "d ago" : "Today");
                      ?>
                    </span>
                  </a>
                  <?php if ($row['rera_no'] != 'JDA Approved'): ?>
                    <span class="rera-badge">RERA</span>
                  <?php else: ?>
                    <span class="jda-badge">JDA</span>
                  <?php endif; ?>
                </div>

                <!-- Property Details -->
                <div class="property-details">
                  <div class="property-header">
                    <h2 class="property-title">
                      <a href="#" onclick="openPopup('<?= $row['slug'] ?>'); return false;"><?= htmlspecialchars($row['project_name']) ?></a>
                    </h2>
                    <p class="property-subtitle">
                      <i class="bi bi-geo-alt-fill text-primary"></i> <?= htmlspecialchars($row['bhk']) ?> Flats in <?= htmlspecialchars($row['location']) ?>
                    </p>
                  </div>

                  <!-- Pricing Section -->
                  <div class="property-prices">
                    <div>
                      <small>Starts from</small>
                      <h6>₹ <?= htmlspecialchars($row['min_price']) ?></h6>
                    </div>
                    <div>
                      <small>Up to</small>
                      <h6>₹ <?= htmlspecialchars($row['max_price']) ?></h6>
                    </div>
                    <div>
                      <small>Possession</small>
                      <h6><?= htmlspecialchars($row['possession_date']) ?></h6>
                    </div>
                  </div>


                  <div class="divider"></div>

                  <!-- Bottom Section -->
                  <div class="property-footer">
                    <div class="seller-info">
                      By <span><?php
                        $showbuilder = "SELECT b.builder_name FROM new_property p LEFT JOIN builder b ON p.builder_name = b.id WHERE p.id = '".$row['id']."'";
                        $resbuilder = mysqli_query($con, $showbuilder);
                        $builderRow = mysqli_fetch_assoc($resbuilder);
                        echo htmlspecialchars(!empty($builderRow['builder_name']) ? mb_strimwidth($builderRow['builder_name'], 0, 25, '...') : 'N/A');
                      ?></span>
                    </div>
                    <button class="btn btn-primary fd-rdx px-4" onclick="window.open('https://wa.me/918955331454?text=<?= urlencode('Hello! I am interested in your property: ' . $row['project_name']); ?>', '_blank')">
                      Contact Us
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
              <p class="text-muted mx-auto" style="max-width: 400px;">We couldn't find any ongoing properties matching your search. Try adjusting your category or builder filters.</p>
              <a href="ongoing-project" class="btn btn-outline-primary rounded-pill px-4 mt-3">Reset Filters</a>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </section>

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

  <!-- ======= MASTER SCRIPTS ======= -->
  <script>
    (function() {
        // --- 1. Global Utilities & State ---
        window.getCookie = function(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        };

        window.openPopup = function(slug) {
            const isSubmitted = (window.getCookie('mobile_submitted') === '1' || localStorage.getItem('mobile_submitted') === '1');
            if (isSubmitted) {
                if (localStorage.getItem('mobile_submitted') !== '1') {
                    localStorage.setItem('mobile_submitted', '1');
                }
                window.location.href = 'property-detail-for.php?slug=' + encodeURIComponent(slug);
                return;
            }
            const slugInput = document.getElementById('popup-slug');
            if (slugInput) slugInput.value = slug;
            const popup = document.getElementById('mobilePopup');
            if (popup) popup.style.display = 'block';
        };

        window.closePopup = function() {
            const popup = document.getElementById('mobilePopup');
            if (popup) popup.style.display = 'none';
        };

        // --- 2. Filter Bar Helpers ---
        window.pfToggle = function(panelId, btn) {
            const panel = document.getElementById(panelId);
            if (!panel) return;
            const isOpen = panel.classList.contains('pf-open');
            document.querySelectorAll('.pf-panel.pf-open').forEach(p => p.classList.remove('pf-open'));
            document.querySelectorAll('.pf-chip[data-open]').forEach(c => c.removeAttribute('data-open'));
            if (!isOpen) {
                panel.classList.add('pf-open');
                btn.setAttribute('data-open', '1');
                const caret = btn.querySelector('.pf-caret');
                if (caret) caret.style.transform = 'rotate(180deg)';
            } else {
                const caret = btn.querySelector('.pf-caret');
                if (caret) caret.style.transform = '';
            }
        };

        window.pfBuilderSearch = function(q) {
            const items = document.querySelectorAll('#bList li[data-bname]');
            items.forEach(li => {
                li.style.display = li.dataset.bname.includes(q.toLowerCase()) ? '' : 'none';
            });
        };

        // --- 3. Price Filter Logic ---
        function formatPrice(value) {
            value = parseInt(value);
            if (value >= 10000000) return '₹' + (value/10000000).toFixed(value%10000000===0?0:2) + ' Cr';
            if (value >= 100000)   return '₹' + Math.round(value/100000) + ' Lakh';
            return '₹' + value;
        }

        function updatePriceFilter(e) {
            const minRange = document.getElementById('minRange');
            const maxRange = document.getElementById('maxRange');
            const minInput = document.getElementById('minPriceInput');
            const maxInput = document.getElementById('maxPriceInput');
            const minLabel = document.getElementById('price-min-label');
            const maxLabel = document.getElementById('price-max-label');
            if (!minRange || !maxRange) return;
            let min = parseInt(minRange.value);
            let max = parseInt(maxRange.value);
            if (min >= max - 100000) {
                if (e && e.target && e.target.id === 'minRange') { minRange.value = max - 100000; min = max - 100000; }
                else { maxRange.value = min + 100000; max = min + 100000; }
            }
            if (minLabel) minLabel.innerText = formatPrice(min);
            if (maxLabel) maxLabel.innerText = formatPrice(max);
            if (minInput) minInput.value = min;
            if (maxInput) maxInput.value = max;
        }

        // --- 4. Initialization ---
        document.addEventListener('DOMContentLoaded', () => {
            // Price listeners
            const minR = document.getElementById('minRange');
            const maxR = document.getElementById('maxRange');
            if (minR) minR.addEventListener('input', updatePriceFilter);
            if (maxR) maxR.addEventListener('input', updatePriceFilter);
            updatePriceFilter();

            // Mobile toggle
            document.getElementById('filterToggleBtn')?.addEventListener('click', () => {
                const fb = document.getElementById('filterBar');
                if (fb) {
                    fb.classList.toggle('pf-show');
                    fb.style.display = fb.classList.contains('pf-show') ? 'flex' : '';
                }
            });
        });
    })();
  </script>
  <!-- /////filter scripts end/////// -->
</body>

</html>