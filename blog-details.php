<?php
include('config.php'); // DB Connection

// Get blog slug from URL, e.g., blog-details.php?slug=example-slug
$slug = isset($_GET['slug']) ? mysqli_real_escape_string($con, $_GET['slug']) : '';

$query = "SELECT * FROM blog WHERE slug = '$slug' LIMIT 1";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Query Failed: " . mysqli_error($con));
}

$blog = mysqli_fetch_assoc($result);

if (!$blog) {
    echo "Blog not found!";
    exit;
}

// Fetch latest blogs (excluding the current one)
$latest_query = "SELECT * FROM blog WHERE slug != '$slug' ORDER BY created_at DESC LIMIT 3";
$latest_result = mysqli_query($con, $latest_query);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'component/head.php'; ?>

<body class="home-page">

<?php include 'component/navbar.php'; ?>

<!-- Premium Blog Details Hero -->
<header class="about-hero" data-aos="fade-down">
    <div class="container">
        <div class="about-badge mb-3">Real Estate Blog</div>
        <h1 class="story-title" style="font-size: 2.2rem; max-width: 900px; margin: 20px auto;">
            <?php echo htmlspecialchars($blog['name']); ?>
        </h1>
        <div class="d-flex justify-content-center gap-4 mt-3">
            <div class="meta-item">
                <i class="fa fa-calendar-alt"></i>
                <span><?php echo date('F d, Y', strtotime($blog['created_at'])); ?></span>
            </div>
            <div class="meta-item">
                <i class="fa fa-user"></i>
                <span>By I Kan Team</span>
            </div>
        </div>
    </div>
</header>

<!-- Main Content Section -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row g-5">
            <!-- Blog Content -->
            <div class="col-lg-8" data-aos="fade-right">
                <div class="blog-details-wrapper">
                    <div class="blog-featured-media">
                        <img src="uploads/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['name']); ?>">
                    </div>
                    
                    <div class="blog-content-body">
                        <?php echo $blog['massage']; ?>
                    </div>

                    <!-- Static Tag Section for Flare -->
                    <div class="d-flex gap-2 mt-5 pt-4 border-top">
                        <span class="badge bg-primary-light px-3 py-2 rounded-pill">Property</span>
                        <span class="badge bg-primary-light px-3 py-2 rounded-pill">Investment</span>
                        <span class="badge bg-primary-light px-3 py-2 rounded-pill">Jaipur</span>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="sticky-top" style="top: 100px; z-index: 10;">
                    <div class="bg-light p-4 rounded-4 border border-light">
                        <h4 class="blog-sidebar-title">Recommended Reading</h4>
                        <div class="latest-post-list">
                            <?php while ($latest = mysqli_fetch_assoc($latest_result)) { ?>
                                <a href="blog-details?slug=<?php echo $latest['slug']; ?>" class="sidebar-post-item">
                                    <div class="sidebar-post-img">
                                        <img src="uploads/<?php echo htmlspecialchars($latest['image']); ?>" alt="<?php echo htmlspecialchars($latest['name']); ?>">
                                    </div>
                                    <div class="sidebar-post-info">
                                        <h6><?php echo htmlspecialchars($latest['name']); ?></h6>
                                        <div class="sidebar-post-date">
                                            <i class="fa fa-calendar-alt me-1"></i>
                                            <?php echo date('M d, Y', strtotime($latest['created_at'])); ?>
                                        </div>
                                    </div>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'component/footer.php'; ?>

</body>
</html>
