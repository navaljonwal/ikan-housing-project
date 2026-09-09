<?php
$xml = simplexml_load_file("sitemap.xml");

function getPageNameFromUrl($url) {
    if (!$url) return 'Home';
    $parsedUrl = parse_url($url);
    $path = $parsedUrl['path'] ?? '/';
    $path = trim($path, '/');

    if ($path == '') return 'Home';

    $segments = explode('/', $path);
    $lastSegment = end($segments);

    // Remove file extensions like .php
    $lastSegment = preg_replace('/\.php$/', '', $lastSegment);

    $name = str_replace(['-', '_'], ' ', $lastSegment);
    return ucwords($name);
}

// Categorization Logic for grouped experience
$categories = [
    'Strategic Services' => [
        'investment.php', 'land-services.php', 'indus-logi.php', 
        'commer-retail.php', 'commer-leasing.php', 'joint-venture.php'
    ],
    'Residential Excellence' => [
        'residential.php', 'sales-marketing.php', 'strat-ad-va.php'
    ],
    'Experience I Kan' => [
        'about-us.php', 'reward-and-team.php', 'blog.php', 'contact.php'
    ]
];

// Flat list for "All Other Pages"
$assigned_urls = [];
foreach ($categories as $list) {
    foreach ($list as $file) { $assigned_urls[] = $file; }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'component/head.php'; ?>

<style>
    /* 🧭 Premium Sitemap Overhaul */
    :root {
        --plum-base: #1a0511;
        --plum-vibrant: #2d0a1c;
        --pink-prime: #c02a7c;
        --pink-soft: #ff85c0;
        --slate-cool: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #faf9fb; color: var(--plum-vibrant); overflow-x: hidden; }

    /* --- Site Explorer Hero --- */
    .sitemap-hero {
        background: linear-gradient(135deg, var(--plum-base) 0%, #3d1428 100%);
        padding: 160px 0 100px;
        color: #fff;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Geometric Decoration */
    .sitemap-hero::after {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 2px 2px, rgba(255,133,192,0.1) 1px, transparent 0);
        background-size: 40px 40px;
        opacity: 0.3;
    }

    .hero-title { font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; letter-spacing: -2px; margin-bottom: 20px; }
    .hero-title span { color: var(--pink-soft); }
    .hero-subtitle { font-size: 1.25rem; opacity: 0.8; max-width: 600px; margin: 0 auto; line-height: 1.6; }

    /* --- Categorized Hub --- */
    .sitemap-section { padding: 100px 0; }
    
    .category-group-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 50px;
    }

    .category-group-header h2 { font-weight: 850; font-size: 2.2rem; color: var(--plum-vibrant); margin: 0; }
    .category-group-header .line { flex: 1; height: 1px; background: linear-gradient(to right, var(--pink-prime), transparent); }

    .sitemap-grid-high-end {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 25px;
        margin-bottom: 80px;
    }

    .sitemap-card-premium {
        background: white;
        padding: 35px 30px;
        border-radius: 25px;
        box-shadow: 0 10px 30px rgba(45, 10, 28, 0.04);
        border: 1px solid rgba(192, 42, 124, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        text-decoration: none !important;
    }

    .sitemap-card-premium:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(192, 42, 124, 0.12);
        border-color: var(--pink-prime);
    }

    .card-icon-wrap {
        width: 60px; height: 60px;
        background: #fff5f9;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        color: var(--pink-prime);
        font-size: 22px;
        transition: all 0.4s ease;
    }

    .sitemap-card-premium:hover .card-icon-wrap {
        background: var(--pink-prime);
        color: white;
        transform: rotate(10deg);
    }

    .card-label { font-size: 1.15rem; font-weight: 800; color: var(--plum-vibrant); margin-bottom: 10px; }
    .card-desc { font-size: 0.95rem; color: var(--slate-cool); opacity: 0.8; }

    /* Dynamic Footer List */
    .other-links-wrap {
        background: white;
        padding: 60px;
        border-radius: 40px;
        box-shadow: 0 40px 80px rgba(0,0,0,0.03);
    }

    .other-links-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .other-link {
        color: var(--slate-cool);
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .other-link:hover { color: var(--pink-prime); }
    .other-link::before { content: '•'; color: var(--pink-prime); font-weight: bold; }

    @media (max-width: 768px) {
        .sitemap-hero { padding: 120px 0 60px; }
        .other-links-wrap { padding: 40px 25px; }
    }
</style>

<body>
    <?php include 'component/navbar.php'; ?>

    <!-- 🌐 Premium Site Explorer Hero -->
    <header class="sitemap-hero">
        <div class="container" data-aos="fade-down" data-aos-duration="1000">
            <h1 class="hero-title">Site <span>Explorer</span></h1>
            <p class="hero-subtitle">Comprehensive architecture and navigation of the I Kan Housing real estate ecosystem — crafted for maximum accessibility.</p>
        </div>
    </header>

    <div class="container sitemap-section">
        
        <?php foreach ($categories as $categoryName => $urls): ?>
            <div class="category-group-header" data-aos="fade-right">
                <h2><?= $categoryName ?></h2>
                <div class="line"></div>
            </div>

            <div class="sitemap-grid-high-end">
                <?php foreach ($urls as $file): ?>
                    <a href="<?= $file ?>" class="sitemap-card-premium" data-aos="fade-up">
                        <div class="card-icon-wrap"><i class="fa fa-chevron-right"></i></div>
                        <div class="card-label"><?= getPageNameFromUrl($file) ?></div>
                        <div class="card-desc">Advanced real estate expertise.</div>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <!-- 🖇️ Dynamic Other Links (from XML) -->
        <div class="category-group-header mt-5" data-aos="fade-right">
            <h2>Detailed Index</h2>
            <div class="line"></div>
        </div>

        <div class="other-links-wrap" data-aos="zoom-in" data-aos-duration="1000">
            <div class="other-links-grid">
                <?php foreach ($xml->url as $url): 
                    $loc = (string)$url->loc;
                    $filename = basename($loc);
                    if (in_array($filename, $assigned_urls) || $filename == "" || $filename == "") continue;
                ?>
                    <a href="<?= $loc ?>" class="other-link"><?= getPageNameFromUrl($loc) ?></a>
                <?php endforeach; ?>
                <!-- Added these for completeness as they might not be in the XML correctly or as base pages -->
                <a href="index" class="other-link">Home</a>
                <a href="privacy-policy" class="other-link">Privacy Policy</a>
                <a href="terms-conditions" class="other-link">Terms & Conditions</a>
            </div>
        </div>

    </div>

    <?php include 'component/footer.php'; ?>
</body>
</html>
