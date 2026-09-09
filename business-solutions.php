<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== BUSINESS SOLUTIONS — PREMIUM PINK & PLUM DESIGN ===== */

/* ---- HERO SECTION ---- */
.bs-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514;
}

.bs-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.35;
    z-index: 0;
}

.bs-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,5,20,0.95) 0%, rgba(45,10,28,0.7) 50%, rgba(192,42,124,0.1) 100%);
    z-index: 1;
}

.bs-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
    padding-bottom: 80px;
}

.bs-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192,42,124,0.15);
    border: 1px solid rgba(192,42,124,0.3);
    color: #ff85c0;
    padding: 8px 22px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 25px;
    backdrop-filter: blur(10px);
}

.bs-hero-title {
    font-size: clamp(3rem, 7vw, 6.5rem);
    font-weight: 950;
    color: #fff;
    line-height: 1;
    letter-spacing: -3px;
    margin-bottom: 25px;
}

.bs-hero-title span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.bs-hero-desc {
    color: rgba(255,255,255,0.7);
    font-size: 1.25rem;
    line-height: 1.8;
    max-width: 650px;
    margin-bottom: 45px;
}

/* ---- COMPETITIVE EDGE ---- */
.bs-edge {
    padding: 100px 0;
    background: #fff;
}

.bs-edge-card {
    background: #fff;
    border-radius: 35px;
    padding: 50px;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 20px 50px rgba(45,10,28,0.03);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.bs-edge-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 40px 80px rgba(192,42,124,0.12);
    border-color: rgba(192,42,124,0.15);
}

.bs-stat-num {
    font-size: 4rem;
    font-weight: 900;
    color: #2d0a1c;
    line-height: 1;
    margin-bottom: 10px;
}

.bs-stat-num span { color: #c02a7c; }

.bs-stat-label {
    color: #8e6f7e;
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 35px;
}

.bs-feature-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
}

.bs-feature-item {
    display: flex;
    gap: 15px;
    align-items: flex-start;
}

.bs-feature-icon {
    width: 50px; height: 50px;
    background: #fff5f9;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.bs-feature-icon img { width: 28px; }

.bs-feature-text {
    font-size: 0.95rem;
    color: #3a1d2e;
    line-height: 1.6;
    font-weight: 600;
}

/* ---- SHOWCASE PANEL ---- */
.bs-showcase {
    padding: 100px 0;
    background: #fdf6fa;
}

.bs-badge {
    display: inline-block;
    background: rgba(192,42,124,0.08);
    color: #c02a7c;
    padding: 8px 18px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.bs-section-title {
    font-size: clamp(2.5rem, 5vw, 3.5rem);
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 60px;
    text-align: center;
}

.bs-section-title span { color: #c02a7c; }

.bs-item {
    background: #fff;
    border-radius: 45px;
    overflow: hidden;
    margin-bottom: 60px;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 25px 60px rgba(45,10,28,0.04);
}

.bs-item-img-wrap {
    height: 100%;
    min-height: 450px;
    overflow: hidden;
}

.bs-item-img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.8s ease;
}

.bs-item:hover .bs-item-img { transform: scale(1.08); }

.bs-item-body {
    padding: 60px;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.bs-item-body h2 {
    font-size: 2.2rem;
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 20px;
}

.bs-item-body p {
    color: #8e6f7e;
    font-size: 1.15rem;
    line-height: 1.8;
    margin-bottom: 35px;
}

.bs-btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 18px 45px;
    border-radius: 50px;
    border: 2px solid #c02a7c;
    color: #c02a7c;
    font-weight: 800;
    text-decoration: none !important;
    transition: all 0.4s ease;
}

.bs-btn-outline:hover {
    background: #c02a7c;
    color: #fff;
    box-shadow: 0 15px 30px rgba(192,42,124,0.3);
}

/* ---- CTA ---- */
.bs-cta {
    padding: 100px 0;
    background: #fff;
}

.bs-cta-box {
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 60%, #0a0514 100%);
    border-radius: 50px;
    padding: 100px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.bs-cta-box h2 {
    font-size: clamp(2rem, 6vw, 4rem);
    font-weight: 950;
    color: #fff;
    margin-bottom: 25px;
    letter-spacing: -1px;
}

.bs-cta-box h2 span { color: #ff85c0; }

.bs-btn-primary {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 20px 55px;
    border-radius: 60px;
    font-weight: 800;
    font-size: 1.2rem;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.4s ease;
    box-shadow: 0 20px 40px rgba(192,42,124,0.3);
}

.bs-btn-primary:hover {
    transform: translateY(-10px);
    box-shadow: 0 35px 70px rgba(192,42,124,0.5);
    color: #fff;
}

@media (max-width: 991px) {
    .bs-item-img-wrap { min-height: 300px; }
    .bs-item-body { padding: 40px 30px; }
    .bs-feature-grid { grid-template-columns: 1fr; }
}
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="bs-hero">
        <video autoplay muted loop playsinline class="bs-hero-video">
            <source src="rkimg/Business_Solutions.webm" type="video/webm">
        </video>
        <div class="bs-hero-overlay"></div>
        <div class="container bs-hero-content">
            <div class="row">
                <div class="col-lg-9" data-aos="fade-up">
                    <div class="bs-hero-badge">Integrated Business Hub</div>
                    <h1 class="bs-hero-title">Beyond Traditional <span>Real Estate</span></h1>
                    <p class="bs-hero-desc">We offer integrated Business Solutions designed to support developers, investors, and property owners at every stage of their lifecycle — from inception to sell-out.</p>
                    <div class="d-flex gap-3">
                        <a href="#showw" class="bs-btn-primary">Request a Strategy <i class="fa fa-chevron-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== COMPETITIVE EDGE ===== -->
    <section class="bs-edge">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="rkimg/Tagimg.svg" alt="Business Solutions" class="img-fluid mb-4" style="max-height: 60px;">
                    <h2 class="bs-section-title" style="text-align: left; margin-bottom: 30px;">The <span>Competitive Edge</span> You Need</h2>
                    <p class="res-section-desc" style="font-size: 1.1rem; line-height: 1.8; color: #8e6f7e; margin-bottom: 40px;">
                        The real estate industry is constantly evolving, making it essential to stay ahead of the curve. Our team of experts delivers innovative, customized solutions to help you stand out.
                    </p>
                    <div class="bs-feature-grid">
                        <div class="bs-feature-item">
                            <div class="bs-feature-icon"><i class="fa fa-google"></i></div>
                            <div class="bs-feature-text">Ranked #1 by Google for innovative branding.</div>
                        </div>
                        <div class="bs-feature-item">
                            <div class="bs-feature-icon"><i class="fa fa-users"></i></div>
                            <div class="bs-feature-text">250+ Engagements through campaigns & events.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="bs-edge-card">
                        <div class="bs-stat-num"><span>6000</span>+</div>
                        <div class="bs-stat-label">Strong Relationships</div>
                        <div class="d-flex flex-column gap-4">
                            <div class="d-flex gap-3 align-items-center">
                                <img src="img/trophy.gif" style="width: 60px;" alt="Trophy">
                                <p style="margin:0; font-weight:700; color:#2d0a1c;">Industry-leading performance metrics in brand campaigns.</p>
                            </div>
                            <div class="d-flex gap-3 align-items-center">
                                <img src="img/engagement.gif" style="width: 60px;" alt="Engagement">
                                <p style="margin:0; font-weight:700; color:#2d0a1c;">High-impact engagement strategies for offline channels.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SHOWCASE PANELS ===== -->
    <section class="bs-showcase">
        <div class="container">
            <div class="bs-badge d-block text-center mx-auto" style="width: fit-content;">Our Core Units</div>
            <h2 class="bs-section-title">What We Can Do <span>For You</span></h2>

            <div class="bs-item row g-0" data-aos="fade-up">
                <div class="col-lg-7">
                    <div class="bs-item-img-wrap">
                        <img src="rkimg/Post_Sales1.jpg" class="bs-item-img" alt="Post Sales">
                    </div>
                </div>
                <div class="col-lg-5 bs-item-body">
                    <div class="bs-badge">Efficiency</div>
                    <h2>Post-Sales</h2>
                    <p>Creating a seamless experience by providing developers with a structured collections framework and lead management solutions.</p>
                    <a href="post-sales" class="bs-btn-outline">Explore Post-Sales <i class="fa fa-long-arrow-right"></i></a>
                </div>
            </div>

            <div class="bs-item row g-0" data-aos="fade-up">
                <div class="col-lg-5 bs-item-body order-2 order-lg-1">
                    <div class="bs-badge">Customer Success</div>
                    <h2>Home Solutions</h2>
                    <p>Delivering tech-driven and personalized home loan and interior design solutions to ensure a satisfying home-buying journey.</p>
                    <a href="home-solution" class="bs-btn-outline">Explore Home Solutions <i class="fa fa-long-arrow-right"></i></a>
                </div>
                <div class="col-lg-7 order-1 order-lg-2">
                    <div class="bs-item-img-wrap">
                        <img src="rkimg/home_solutios1.jpg" class="bs-item-img" alt="Home Solutions">
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="bs-cta">
        <div class="container">
            <div class="bs-cta-box" data-aos="zoom-in">
                <h2>Accelerate Your <span>Business Growth</span></h2>
                <p>Equip your team with cutting-edge tools and strategy designed to win in today's fast-paced market.</p>
                <a href="#showw" class="bs-btn-primary">Partner With Us Now <i class="fa fa-rocket"></i></a>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

</body>
</html>