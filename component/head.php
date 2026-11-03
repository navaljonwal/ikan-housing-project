<?php
include_once __DIR__ . '/../config.php';
require_once __DIR__ . '/SeoHelper.php';
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<?php
    global $con, $seo_override;
    SeoHelper::render($con ?? null, $seo_override ?? []);
?>

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
    <link href="css/animations.css" rel="stylesheet">

    <!-- Google Analytics (Non-blocking) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-9CD8MJK7L9"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-9CD8MJK7L9', { 'send_page_view': true });
    </script>

</head>
