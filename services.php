<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* 
================================================================
    SERVICES — UNIFIED DESIGN SYSTEM (PREMIUM REDESIGN)
    Pink & Plum Visual Identity for I Kan Housing
================================================================
*/

:root {
    --srv-plum: #2d0a1c;
    --srv-plum-deep: #1a0511;
    --srv-pink: #c02a7c;
    --srv-pink-light: #ff85c0;
    --srv-bg-light: #fdfafd;
    --srv-text-muted: #8e6f7e;
    --srv-glass: rgba(255, 255, 255, 0.85);
    --srv-shadow: 0 25px 60px rgba(45, 10, 28, 0.1);
    --srv-transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
}

body {
    background: #fff;
    font-family: 'Outfit', sans-serif;
    color: #2d0a1c;
    overflow-x: hidden;
}

/* ---- PREMIUM HERO ---- */
.srv-hero {
    position: relative;
    height: 80vh;
    display: flex;
    align-items: center;
    background: #000;
    overflow: hidden;
    padding-top: 120px;
}

.srv-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.5;
}

.srv-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(26,5,17,0.95) 20%, rgba(26,5,17,0.2) 100%);
    z-index: 1;
}

.srv-hero-content {
    position: relative;
    z-index: 5;
}

.srv-badge {
    display: inline-block;
    background: rgba(192, 42, 124, 0.1);
    border: 1px solid rgba(192, 42, 124, 0.3);
    color: var(--srv-pink-light);
    padding: 10px 30px;
    border-radius: 100px;
    font-size: 0.75rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 25px;
    backdrop-filter: blur(10px);
}

.srv-title {
    font-size: clamp(3.5rem, 8vw, 6rem);
    font-weight: 900;
    color: #fff;
    line-height: 1;
    letter-spacing: -3px;
    margin-bottom: 25px;
}

.srv-title span {
    background: linear-gradient(135deg, var(--srv-pink-light), #fff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.srv-hero-desc {
    font-size: 1.25rem;
    color: rgba(255,255,255,0.7);
    max-width: 650px;
    line-height: 1.8;
    margin-bottom: 40px;
    font-weight: 300;
}

/* ---- SERVICE GRID & CARDS ---- */
.srv-grid-section {
    padding: 100px 0;
    background: var(--srv-bg-light);
    position: relative;
}

.srv-card {
    background: var(--srv-glass);
    padding: 50px 40px;
    border-radius: 40px;
    border: 1px solid rgba(192, 42, 124, 0.05);
    transition: var(--srv-transition);
    height: 100%;
    position: relative;
    backdrop-filter: blur(20px);
    display: flex;
    flex-direction: column;
}

.srv-card:hover {
    transform: translateY(-15px);
    background: #fff;
    border-color: var(--srv-pink);
    box-shadow: var(--srv-shadow);
}

.srv-icon-box {
    width: 70px; height: 70px;
    background: #fff5f9;
    border-radius: 20px;
    display: flex; align-items: center; justify-content: center;
    color: var(--srv-pink);
    font-size: 2rem;
    margin-bottom: 30px;
    transition: 0.4s;
}

.srv-card:hover .srv-icon-box {
    background: var(--srv-pink);
    color: #fff;
    transform: rotate(10deg);
}

.srv-card-title {
    font-size: 1.6rem;
    font-weight: 800;
    margin-bottom: 15px;
    color: var(--srv-plum);
}

.srv-card-desc {
    color: var(--srv-text-muted);
    font-size: 0.95rem;
    line-height: 1.7;
    margin-bottom: 30px;
    flex-grow: 1;
}

/* ---- STAT TILES & BUTTONS ---- */
.srv-stat-wrapper {
    display: flex;
    gap: 20px;
    margin-top: auto;
    padding-top: 25px;
    border-top: 1px solid rgba(45, 10, 28, 0.05);
}

.srv-stat-item h5 {
    font-size: 1.25rem;
    font-weight: 900;
    margin-bottom: 2px;
    color: var(--srv-pink);
}

.srv-stat-item p {
    font-size: 0.72rem;
    color: var(--srv-text-muted);
    text-transform: uppercase;
    font-weight: 700;
    letter-spacing: 1px;
}

.srv-btn-more {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 12px 28px;
    background: #fff;
    border: 1.5px solid var(--srv-plum);
    color: var(--srv-plum);
    border-radius: 100px;
    font-size: 0.85rem;
    font-weight: 800;
    text-decoration: none !important;
    transition: 0.4s;
    margin-top: 25px;
}

.srv-card:hover .srv-btn-more {
    background: var(--srv-plum);
    color: #fff;
}

/* ---- SECTION DIVIDERS ---- */
.srv-section-title {
    font-size: 3rem;
    font-weight: 950;
    margin-bottom: 60px;
    letter-spacing: -2px;
}

.srv-section-title span {
    color: var(--srv-pink);
}

@media (max-width: 991px) {
    .srv-hero { height: auto; padding: 180px 0 100px; }
    .srv-title { font-size: 4rem; letter-spacing: -2px; }
}
</style>

<body class="srv-body">

    <?php include 'component/navbar.php'; ?>

    <!-- ===== PREMIUM HERO ===== -->
    <section class="srv-hero">
        <video autoplay muted loop playsinline class="srv-hero-video">
            <source src="rkimg/Services-neww.webm" type="video/webm">
        </video>
        <div class="srv-hero-overlay"></div>
        <div class="container srv-hero-content">
            <div class="row">
                <div class="col-lg-10" data-aos="fade-up">
                    <div class="srv-badge">Comprehensive Solutions</div>
                    <h1 class="srv-title">Excellence in <span>Real Estate</span> Architecture</h1>
                    <p class="srv-hero-desc">Bringing your real estate vision to life through institutional-grade strategies and deep market intelligence. We redefine the lifecycle of ownership and investment.</p>
                </div>
            </div>
        </div>
    </section>

    </div>


    <!--/ Start Card Section //////////////////////////////////////////////////-->    <!-- ===== SERVICE GRID SECTION ===== -->
    <section class="srv-grid-section">
        <div class="container">
            
            <!-- Category 1: Asset Advisory -->
            <div data-aos="fade-up">
                <h2 class="srv-section-title">Asset <span>Advisory</span></h2>
            </div>
            
            <div class="row g-5 mb-5">
                <!-- 1. Residential -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-house-heart"></i></div>
                        <h3 class="srv-card-title">Residential</h3>
                        <p class="srv-card-desc">Creating a seamless sales ecosystem to ensure end-to-end client and customer satisfaction in residential real estate.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>350+</h5><p>Projects</p></div>
                            <div class="srv-stat-item"><h5>10k+</h5><p>Sold</p></div>
                        </div>
                        <a href="residential" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 2. Land Services -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-geo-alt"></i></div>
                        <h3 class="srv-card-title">Land Services</h3>
                        <p class="srv-card-desc">Expertise in high-value land acquisition and disposition with a perfect blend of experience & deep-market knowledge.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>100+</h5><p>Transactions</p></div>
                            <div class="srv-stat-item"><h5>Elite</h5><p>Network</p></div>
                        </div>
                        <a href="land-services" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 3. Retail -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-shop"></i></div>
                        <h3 class="srv-card-title">Retail</h3>
                        <p class="srv-card-desc">Transforming retail challenges into competitive advantages through strategic placement and tenant-mix optimization.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>3300+</h5><p>Deals</p></div>
                            <div class="srv-stat-item"><h5>55</h5><p>Cities</p></div>
                        </div>
                        <a href="retail" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 4. Investment Banking -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-bank"></i></div>
                        <h3 class="srv-card-title">Investment Banking</h3>
                        <p class="srv-card-desc">Delivering a customised approach to complex capital markets and large-scale asset advisory transactions.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>450+</h5><p>Transacted</p></div>
                            <div class="srv-stat-item"><h5>10.5B+</h5><p>Capital</p></div>
                        </div>
                        <a href="investment" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 5. Commercial Strata -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-building"></i></div>
                        <h3 class="srv-card-title">Commercial Strata</h3>
                        <p class="srv-card-desc">Empowering success with comprehensive solutions for office space strata and retail commercial sales.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>850+</h5><p>Sales</p></div>
                            <div class="srv-stat-item"><h5>950k+</h5><p>Sq.ft.</p></div>
                        </div>
                        <a href="commer-retail" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 6. Industrial -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-truck"></i></div>
                        <h3 class="srv-card-title">Industrial & Logistics</h3>
                        <p class="srv-card-desc">India’s emerging alternative real estate sectors through cutting-edge leasing and supply chain land solutions.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>200+</h5><p>Team Exp</p></div>
                            <div class="srv-stat-item"><h5>Global</h5><p>Reach</p></div>
                        </div>
                        <a href="indus-logi" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

            <!-- Category 2: Business Solutions -->
            <div data-aos="fade-up" style="margin-top: 150px;">
                <h2 class="srv-section-title">Enterprise <span>Solutions</span></h2>
            </div>
            
            <div class="row g-5">
                <!-- 7. Strategic Advisory -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-diagram-3"></i></div>
                        <h3 class="srv-card-title">Strategic Advisory</h3>
                        <p class="srv-card-desc">Assess, Conceptualize & Execute market entry and expansion strategies for global real estate players.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>500+</h5><p>Cities</p></div>
                            <div class="srv-stat-item"><h5>200+</h5><p>Experts</p></div>
                        </div>
                        <a href="strat-ad-va" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 8. Post Sales -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-check-circle"></i></div>
                        <h3 class="srv-card-title">Post Sales</h3>
                        <p class="srv-card-desc">Providing customised service beyond the transaction, ensuring long-term value preservation and recovery.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>40+</h5><p>Mandates</p></div>
                            <div class="srv-stat-item"><h5>1200+</h5><p>Collections</p></div>
                        </div>
                        <a href="post-sales" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 9. Home Solutions -->
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="srv-card">
                        <div class="srv-icon-box"><i class="bi bi-stars"></i></div>
                        <h3 class="srv-card-title">Home Solutions</h3>
                        <p class="srv-card-desc">From effortless home loans to tailored premium interiors, we ensure you get your dream home with zero friction.</p>
                        <div class="srv-stat-wrapper">
                            <div class="srv-stat-item"><h5>35+</h5><p>Banks</p></div>
                            <div class="srv-stat-item"><h5>250+</h5><p>Staff</p></div>
                        </div>
                        <a href="home-solution" class="srv-btn-more">Learn More <i class="bi bi-arrow-right ms-2"></i></a>
                    </div>
                </div>
            </div>

        </div>
    </section></div>

    <?php include 'component/formk.php'; ?>

    <?php include 'component/footer.php'; ?>



<!-- ///////////////////////////////////////////add-for demo..///////////////////////////////// -->




</body>

</html>