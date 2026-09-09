<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 💎 Industrial & Logistics Premium Styles */
    :root {
        --plum-deep: #2d0a1c;
        --pink-primary: #c02a7c;
        --glass-bg: rgba(255, 255, 255, 0.9);
        --text-slate: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--plum-deep); overflow-x: hidden; }

    /* --- Premium Hero --- */
    .indus-hero {
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
        max-width: 800px;
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

    .indus-title {
        font-size: clamp(3rem, 6vw, 4.5rem);
        font-weight: 850;
        line-height: 1.1;
        margin-bottom: 25px;
        letter-spacing: -2px;
    }

    .indus-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 35px;
        border-left: 4px solid var(--pink-primary);
        padding-left: 20px;
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
    
    .feature-list { list-style: none; padding: 0; display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
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
        .indus-title { font-size: 2.5rem; }
        .feature-list { grid-template-columns: 1fr; }
        .service-content-details { padding: 30px; }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- 💎 Premium Hero Section -->
    <section class="indus-hero">
        <div class="hero-video-container">
            <video autoplay muted loop playsinline class="video-bg-premium">
                <source src="rkimg/Industrial_&_Logisticsss.webm" type="video/mp4">
            </video>
            <div class="hero-overlay"></div>
        </div>

        <div class="container hero-content-box">
            <div data-aos="fade-right" data-aos-duration="1000">
                <span class="hero-tagline">Industrial Excellence</span>
                <h1 class="indus-title">Industrial &<br><span style="color: var(--pink-primary);">Logistics</span> Solutions</h1>
                <p class="indus-subtitle">Providing global-standard leasing and land solutions across India’s emerging alternative real estate markets.</p>
                <a href="#connect" class="btn-connect-premium">Partner With Us <i class="fa fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </section>

    <!-- 📊 Strategy & Market Stats -->
    <section class="section-stats">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <h2 class="fw-extrabold mb-4" style="font-size: 2.8rem;">Strategic Growth & <span style="color: var(--pink-primary);">Momentum</span></h2>
                    <p class="text-secondary leading-relaxed mb-4">India is experiencing rapid growth in industrial, logistics, and warehousing sectors, driven by unified GST, freight corridors, and massive digitalization.</p>
                    <div class="stats-card-premium mt-5">
                        <img src="rkimg/Tagimg.svg" alt="Quality Tag" class="mb-4" style="width: 80px;">
                        <p class="fw-medium text-slate">We deliver scalable solutions across leasing, asset sales, debt financing, and expert project management tailored for the modern supply chain.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-4">
                        <div class="col-sm-6" data-aos="fade-down" data-aos-delay="100">
                            <div class="stats-card-premium text-center">
                                <div class="stat-number">200+</div>
                                <div class="stat-label">Years Combined Experience</div>
                            </div>
                        </div>
                        <div class="col-sm-6" data-aos="fade-down" data-aos-delay="200">
                            <div class="stats-card-premium text-center">
                                <i class="fa fa-network-wired fa-3x mb-3 text-pink"></i>
                                <div class="stat-label mt-2">Extensive Industry Network & Reach</div>
                            </div>
                        </div>
                        <div class="col-sm-12" data-aos="fade-up" data-aos-delay="300">
                            <div class="stats-card-premium d-flex align-items-center gap-4">
                                <i class="fa fa-chart-line fa-3x text-pink"></i>
                                <div class="stat-label">Data-driven solutions powered by emerging market developments and digital integration.</div>
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
                <h2 class="fw-extrabold" style="font-size: 3rem;">Tailored <span style="color: var(--pink-primary);">Outcomes</span></h2>
                <p class="text-secondary">Explore how our specialized teams support your lifecycle across alternative assets.</p>
            </div>

            <div class="custom-tabs-container" data-aos="fade-up">
                <button class="tab-btn-premium active" onclick="switchIndusTab(event, 'tab-developers')">Developers</button>
                <button class="tab-btn-premium" onclick="switchIndusTab(event, 'tab-partners')">Channel Partners</button>
                <button class="tab-btn-premium" onclick="switchIndusTab(event, 'tab-corporates')">Corporates</button>
            </div>

            <!-- Developers Content -->
            <div id="tab-developers" class="service-display-box indus-tab-content" data-aos="zoom-in">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="service-img-wrapper">
                            <img src="rkimg/Investment_Bankinggg.jpg" alt="Developers">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-content-details">
                            <h3 class="fw-extrabold mb-3">Asset Performance</h3>
                            <p class="text-secondary mb-4">Our specialized teams support you with boutique advisory and transaction services throughout the entire asset lifecycle.</p>
                            <ul class="feature-list">
                                <li><i class="fa fa-check-circle"></i> Fund Raising</li>
                                <li><i class="fa fa-check-circle"></i> Debt Financing</li>
                                <li><i class="fa fa-check-circle"></i> Portfolio Sale</li>
                                <li><i class="fa fa-check-circle"></i> Joint Ventures</li>
                                <li><i class="fa fa-check-circle"></i> BTS Leasing</li>
                                <li><i class="fa fa-check-circle"></i> Platform Tie-Ups</li>
                            </ul>
                            <a href="#connect" class="btn-connect-premium btn-sm">Get Expert Advisory</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partners Content -->
            <div id="tab-partners" class="service-display-box indus-tab-content" style="display: none;">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="service-img-wrapper">
                            <img src="rkimg/Brokerage_&_Tenant_Representationn.jpg" alt="Partners">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-content-details">
                            <h3 class="fw-extrabold mb-3">Brokerage Excellence</h3>
                            <p class="text-secondary mb-4">Aligning your goals with prime industrial availability and high-growth alternative assets.</p>
                            <ul class="feature-list">
                                <li><i class="fa fa-check-circle"></i> Warehouse Leasing</li>
                                <li><i class="fa fa-check-circle"></i> Industrial Space</li>
                                <li><i class="fa fa-check-circle"></i> Data Centre Sales</li>
                                <li><i class="fa fa-check-circle"></i> Tenant Representation</li>
                            </ul>
                            <a href="#connect" class="btn-connect-premium btn-sm">Join Our Network</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corporates Content -->
            <div id="tab-corporates" class="service-display-box indus-tab-content" style="display: none;">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="service-img-wrapper">
                            <img src="rkimg/Advisory_Servicesss.jpg" alt="Corporates">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="service-content-details">
                            <h3 class="fw-extrabold mb-3">Institutional Advisory</h3>
                            <p class="text-secondary mb-4">Comprehensive solutions aligned with business objectives to empower rapid informed decisions.</p>
                            <ul class="feature-list">
                                <li><i class="fa fa-check-circle"></i> Buy-Side Advisory</li>
                                <li><i class="fa fa-check-circle"></i> Financial Feasibility</li>
                                <li><i class="fa fa-check-circle"></i> Asset Valuation</li>
                                <li><i class="fa fa-check-circle"></i> Market Research</li>
                            </ul>
                            <a href="#connect" class="btn-connect-premium btn-sm">Request Feasibility</a>
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
        function switchIndusTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("indus-tab-content");
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