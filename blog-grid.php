<?php
// Include database connection file
include('config.php');

// Fetch blogs from database
$query = "SELECT * FROM blog WHERE status = 1 ORDER BY created_at DESC";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<body class="home-page">
    <!-- Navbar -->
    <?php include 'component/navbar.php'; ?>

    <!-- Premium Blog Hero -->
    <header class="about-hero" data-aos="fade-down">
        <div class="container">
            <div class="about-badge mb-3">Latest Insights</div>
            <h1 class="story-title">Unlock <span>Property</span> Knowledge <br>& Market Trends</h1>
            <p class="text-muted mx-auto" style="max-width: 800px !important;">Stay updated with the latest in real estate, investment strategies, and home solutions from the experts at I Kan Housing.</p>
        </div>
    </header>

    <!-- News Grid -->
    <section class="section-padding">
        <div class="container">
            <div class="blog-grid-modern">
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <div class="blog-card-premium" data-aos="fade-up">
                        <div class="blog-card-img">
                            <img src="uploads/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['name']); ?>">
                        </div>
                        <div class="blog-card-content">
                            <div class="blog-card-category">Real Estate</div>
                            <h2 class="blog-card-title"><?php echo htmlspecialchars($row['name']); ?></h2>
                            <p class="blog-card-excerpt">
                                <?php echo substr(strip_tags($row['massage']), 0, 120) . '...'; ?>
                            </p>
                            <div class="blog-card-footer">
                                <div class="blog-date">
                                    <i class="fa fa-calendar-alt"></i>
                                    <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                </div>
                                <a href="blog-details?slug=<?php echo $row['slug']; ?>" class="read-more-link">
                                    Read More <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php include 'component/footer.php'; ?>

</body>
</html>