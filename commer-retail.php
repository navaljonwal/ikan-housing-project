<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 💎 Commercial & Retail Premium Styles */
    :root {
        --plum-deep: #2d0a1c;
        --pink-primary: #c02a7c;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --text-slate: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--plum-deep); overflow-x: hidden; }

    /* --- Premium Hero --- */
    .retail-hero {
        position: relative;
        height: 85vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: #000;
        padding-top: 110px;
    }

    .hero-video-container {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .video-bg-premium {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.6;
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        background: linear-gradient(to right, rgba(45, 10, 28, 0.9) 0%, rgba(45, 10, 28, 0.2) 100%);
        z-index: 2;
    }

    .hero-content-box {
        position: relative;
        z-index: 3;
        color: white;
        max-width: 850px;
    }

    .hero-tagline {
        display: inline-block;
        background: var(--pink-primary);
        color: white;
        padding: 8px 16px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 25px;
    }

    .retail-title {
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 850;
        line-height: 1.1;
        margin-bottom: 25px;
        letter-spacing: -2px;
    }

    .retail-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 35px;
        border-left: 4px solid var(--pink-primary);
        padding-left: 20px;
        max-width: 600px;
    }

    /* --- Competitive Edge --- */
    .section-stats { padding: 100px 0; background: #f8fafc; }
    
    .stats-card-premium {
        background: white;
        padding: 40px;
        border-radius: 30px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        height: 100%;
        transition: all 0.4s ease;
    }

    .stats-card-premium:hover { transform: translateY(-10px); color: var(--pink-primary); }

    .stat-number { font-size: 3.5rem; font-weight: 850; margin-bottom: 10px; color: var(--pink-primary); }
    .stat-label { font-size: 1.1rem; font-weight: 600; color: var(--plum-deep); }

    /* --- Service Hub Tabs --- */
    .service-hub-section { padding: 100px 0; }
    
    .custom-tabs-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 50px;
        flex-wrap: wrap;
    }

    .tab-btn-premium {
        background: #f1f5f9;
        border: none;
        padding: 15px 35px;
        border-radius: 12px;
        font-weight: 700;
        color: var(--text-slate);
        transition: all 0.3s ease;
    }

    .tab-btn-premium.active { background: var(--pink-primary); color: white; box-shadow: 0 10px 20px rgba(192, 42, 124, 0.3); }

    .service-display-box {
        background: white;
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 30px 60px rgba(0,0,0,0.08);
        border: 1px solid #f1f5f9;
    }

    .service-img-wrapper { height: 450px; overflow: hidden; position: relative; }
    .service-img-wrapper img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.8s ease; }
    .service-display-box:hover .service-img-wrapper img { transform: scale(1.05); }

    .service-content-details { padding: 50px; }
    
    .feature-list { list-style: none; padding: 0; display: grid; grid-template-columns: 1fr; gap: 15px; }
    .feature-list li { display: flex; align-items: center; gap: 10px; font-weight: 600; color: var(--text-slate); }
    .feature-list li i { color: var(--pink-primary); font-size: 18px; }

    .btn-connect-premium {
        display: inline-block;
        background: var(--plum-deep);
        color: white !important;
        padding: 16px 35px;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: 30px;
        border: none;
    }
    .btn-connect-premium:hover { background: var(--pink-primary); transform: translateX(5px); }

    @media (max-width: 768px) {
        .retail-hero { height: auto; padding: 150px 0 100px; }
        .feature-list { grid-template-columns: 1fr; }
        .service-content-details { padding: 30px; }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- 💎 Premium Hero Section -->
    <section class="retail-hero">
        <div class="hero-video-container">
            <video autoplay muted loop playsinline class="video-bg-premium">
                <!-- Using MKV as in legacy, but browser-standard Source tags should follow if available -->
                <source src="rkimg/Commercial_&_Retail_Strata_Salesdf.mkv" type="video/x-matroska">
                <source src="rkimg/Commercial_&_Retail_Strata_Salesdf.mp4" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
        </div>

        <div class="container hero-content-box">
            <div data-aos="fade-right" data-aos-duration="1000">
                <span class="hero-tagline">Sales & Investment</span>
                <h1 class="retail-title">Commercial & <span style="color: var(--pink-primary);">Retail Strata Sales</span></h1>
                <p class="retail-subtitle">Empowering your success through our integrated strata sales model, centered on high-growth asset ownership across India.</p>
                <a href="#connect" class="btn-connect-premium">Partner With Us <i class="fa fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- 📊 Strategy & Market Stats -->
    <section class="section-stats">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="fw-extrabold mb-4" style="font-size: 2.8rem;">Strategic <span style="color: var(--pink-primary);">Ownership</span> Model</h2>
                    <p class="text-secondary leading-relaxed mb-4">Finding the right office environment requires a deep understanding of both space and people. We guide you through the strata sales model to maximize asset value.</p>
                    <div class="stats-card-premium mt-5">
                        <img src="rkimg/Tagimg.svg" alt="Quality Tag" class="mb-4" style="width: 80px;">
                        <p class="fw-medium text-slate">Our goal is to scale rapidly and extend our specialized ownership services to emerging tier-1 and tier-2 cities in the near future.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-sm-6" data-aos="fade-down" data-aos-delay="100">
                            <div class="stats-card-premium text-center">
                                <div class="stat-number">250+</div>
                                <div class="stat-label">Business Experts</div>
                            </div>
                        </div>
                        <div class="col-sm-6" data-aos="fade-down" data-aos-delay="200">
                            <div class="stats-card-premium text-center">
                                <i class="fa fa-building fa-3x mb-3 text-pink"></i>
                                <div class="stat-label mt-2">Over 950,000 sq. ft. of space transacted</div>
                            </div>
                        </div>
                        <div class="col-sm-12" data-aos="fade-up" data-aos-delay="300">
                            <div class="stats-card-premium d-flex align-items-center gap-4">
                                <i class="fa fa-network-wired fa-3x text-pink"></i>
                                <div class="stat-label">Strong networks, extensive market insights, and deep regional expertise for every strata sale.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🧭 Interactive Service Hub -->
    <section class="service-hub-section" id="services">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-extrabold" style="font-size: 3rem;">Service <span style="color: var(--pink-primary);">Specialization</span></h2>
                <p class="text-secondary">Customized commercial real estate solutions tailored to your investment objectives.</p>
            </div>

            <div class="custom-tabs-container" data-aos="fade-up">
                <button class="tab-btn-premium active" onclick="switchRetailTab(event, 'tab-developers')">Developers</button>
                <button class="tab-btn-premium" onclick="switchRetailTab(event, 'tab-partners')">Channel Partners</button>
                <button class="tab-btn-premium" onclick="switchRetailTab(event, 'tab-corporates')">Corporates</button>
            </div>

            <!-- Developers Content -->
            <div id="tab-developers" class="service-display-box retail-tab-content" data-aos="zoom-in">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="service-img-wrapper">
                            <img src="rkimg/Transaction_Managementtt2.jpg" alt="Developers">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-content-details">
                            <h3 class="fw-extrabold mb-3">Developer Services</h3>
                            <p class="text-secondary mb-4">We offer customized services including market research, property marketing, and sophisticated lease administration.</p>
                            <ul class="feature-list">
                                <li><i class="fa fa-check-circle"></i> Research Advisory</li>
                                <li><i class="fa fa-check-circle"></i> Transaction Management</li>
                                <li><i class="fa fa-check-circle"></i> Property Listing</li>
                                <li><i class="fa fa-check-circle"></i> Strata Sales Strategy</li>
                            </ul>
                            <a href="#connect" class="btn-connect-premium btn-sm">Connect with Experts</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partners Content -->
            <div id="tab-partners" class="service-display-box retail-tab-content" style="display: none;">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="service-img-wrapper">
                            <img src="rkimg/Research_Advisoryy1.jpg" alt="Partners">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-content-details">
                            <h3 class="fw-extrabold mb-3">Partner Empowerment</h3>
                            <p class="text-secondary mb-4">Empowering our channel partners to become knowledgeable advisors for their customers.</p>
                            <ul class="feature-list">
                                <li><i class="fa fa-check-circle"></i> Market Intelligence</li>
                                <li><i class="fa fa-check-circle"></i> Strategic Location Advisory</li>
                                <li><i class="fa fa-check-circle"></i> Knowledge Management</li>
                                <li><i class="fa fa-check-circle"></i> Network Expansion</li>
                            </ul>
                            <a href="#connect" class="btn-connect-premium btn-sm">Growth Opportunity</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corporates Content -->
            <div id="tab-corporates" class="service-display-box retail-tab-content" style="display: none;">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="service-img-wrapper">
                            <img src="rkimg/Transaction_Managementtt2.jpg" alt="Corporates">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-content-details">
                            <h3 class="fw-extrabold mb-3">Corporate Investment</h3>
                            <p class="text-secondary mb-4">Help you select the right property at optimal costs, aligned with your business objectives.</p>
                            <ul class="feature-list">
                                <li><i class="fa fa-check-circle"></i> Investment Advisory</li>
                                <li><i class="fa fa-check-circle"></i> Data-Driven Sourcing</li>
                                <li><i class="fa fa-check-circle"></i> Asset Disposition</li>
                                <li><i class="fa fa-check-circle"></i> Divestment Strategy</li>
                            </ul>
                            <a href="#connect" class="btn-connect-premium btn-sm">Request Advisory</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>

    <div id="connect">
        <?php include 'component/formk.php'; ?>
    </div>

    <?php include 'component/footer.php'; ?>

    <script>
        function switchRetailTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("retail-tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tab-btn-premium");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>