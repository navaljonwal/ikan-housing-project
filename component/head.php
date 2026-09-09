  <?php
  include_once 'config.php';

  /* ================= SEO ONLY VARIABLES ================= */
  $seo_page_key = basename($_SERVER['PHP_SELF'], '.php');

  /* ================= DEFAULT SEO ================= */
  $seo_title = "I Kan Housing – Real Estate in Jaipur";
  $seo_desc  = "Buy, Sell, Rent, and Invest in trusted properties with I Kan Housing Jaipur.";
  $seo_keys  = "Real Estate Jaipur, Property in Jaipur";

  /* ================= FETCH SEO ================= */
  $sql = "SELECT meta_title, meta_description, meta_keywords
          FROM seo_pages
          WHERE page_name = ? AND status = 1
          LIMIT 1";

  $stmt = mysqli_prepare($con, $sql);
  mysqli_stmt_bind_param($stmt, "s", $seo_page_key);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);

  if ($result && mysqli_num_rows($result) > 0) {
      $seo = mysqli_fetch_assoc($result);

      if (!empty($seo['meta_title'])) {
          $seo_title = $seo['meta_title'];
      }
      if (!empty($seo['meta_description'])) {
          $seo_desc = $seo['meta_description'];
      }
      if (!empty($seo['meta_keywords'])) {
          $seo_keys = $seo['meta_keywords'];
      }
  }
  ?>
  <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <title><?= htmlspecialchars($seo_title) ?></title>
      <meta name="description" content="<?= htmlspecialchars($seo_desc) ?>">
      <meta name="keywords" content="<?= htmlspecialchars($seo_keys) ?>">

      <!-- 🚀 Resource Hints -->
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      
      <link rel="dns-prefetch" href="https://www.googletagmanager.com">
      <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

      <!-- 🏁 Favicon -->
      <link rel="icon" href="img/Ikanhousing-logo.svg" type="image/svg+xml">

      <!-- 📸 LCP Preload (Example for Hero) -->
      <link rel="preload" as="image" href="img/homepage.jpeg" fetchpriority="high">

      <!-- 🎨 Critical Styles -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet" media="print" onload="this.media='all'">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
      <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
      <link href="css/style.css" rel="stylesheet">
      <link href="css/rk.css" rel="stylesheet">
      <link href="css/modern-design.css" rel="stylesheet">

      <!-- Google Analytics (Non-blocking) -->
      <script async src="https://www.googletagmanager.com/gtag/js?id=G-9CD8MJK7L9"></script>
      <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', 'G-9CD8MJK7L9', { 'send_page_view': true });
      </script>

  </head>
