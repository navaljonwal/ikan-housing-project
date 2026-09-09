<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 🏔️ Land Services Premium Overhaul */
    :root {
        --plum-deep: #1a0511;
        --plum-mid: #2d0a1c;
        --pink-hot: #c02a7c;
        --pink-light: #ff85c0;
        --slate-text: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--plum-mid); overflow-x: hidden; }

    /* --- Cinematic Land Hero --- */
    .land-hero {
        position: relative;
        height: 85vh;
        min-height: 650px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: #000;
        padding-top: 120px;
    }

    .hero-video-wrapper {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: 1;
    }

    .hero-video-land {
        width: 100%; height: 100%; object-fit: cover; opacity: 0.6;
    }

    .hero-overlay-land {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(26, 5, 17, 0.92) 0%, rgba(26, 5, 17, 0.2) 100%);
        z-index: 2;
    }

    .land-hero-content {
        position: relative;
        z-index: 3;
        color: white;
        max-width: 850px;
    }

    .land-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(192, 42, 124, 0.15);
        border: 1px solid var(--pink-light);
        color: var(--pink-light);
        padding: 10px 24px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        margin-bottom: 30px;
        backdrop-filter: blur(12px);
    }

    .land-title {
        font-size: clamp(3rem, 7vw, 5rem);
        font-weight: 950;
        line-height: 1;
        margin-bottom: 25px;
        letter-spacing: -3px;
    }

    .land-title span { color: var(--pink-hot); }

    .land-subtitle {
        font-size: 1.3rem;
        opacity: 0.88;
        margin-bottom: 45px;
        line-height: 1.6;
        border-left: 5px solid var(--pink-hot);
        padding-left: 25px;
    }

    /* --- Competitive Scale Stats --- */
    .section-land-stats { padding: 120px 0; background: #faf9fb; }
    
    .land-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 35px;
        margin-top: -80px;
        position: relative;
        z-index: 10;
    }

    .land-stat-card {
        background: white;
        padding: 55px 45px;
        border-radius: 40px;
        box-shadow: 0 40px 80px rgba(45, 10, 28, 0.08);
        border: 1px solid rgba(192, 42, 124, 0.08);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-align: center;
    }

    .land-stat-card:hover { transform: translateY(-15px); border-color: var(--pink-hot); }

    .land-stat-val { font-size: 4rem; font-weight: 1000; color: var(--plum-mid); line-height: 1; margin-bottom: 12px; letter-spacing: -1px; }
    .land-stat-val span { color: var(--pink-hot); }
    .land-stat-lbl { font-size: 1.15rem; font-weight: 700; color: var(--slate-text); text-transform: uppercase; letter-spacing: 1.5px; }

    /* --- Strategic Land Hub --- */
    .land-strategy-section { padding: 100px 0; background: white; }

    .category-pills {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 70px;
    }

    .pill-tab {
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        padding: 14px 40px;
        border-radius: 60px;
        font-weight: 800;
        color: var(--plum-mid);
        transition: all 0.4s ease;
        cursor: pointer;
    }

    .pill-tab.active {
        background: var(--pink-hot);
        border-color: var(--pink-hot);
        color: white;
        box-shadow: 0 15px 30px rgba(192, 42, 124, 0.3);
    }

    .strategy-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
    }

    .strategy-card {
        background: #fff;
        border-radius: 45px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: 0 50px 100px rgba(0,0,0,0.05);
        transition: all 0.4s ease;
        display: none; /* Controlled by JS */
    }

    .strategy-card.active { display: block; animation: zoomFadeIn 0.6s ease forwards; }

    @keyframes zoomFadeIn {
        from { opacity: 0; transform: scale(0.95) translateY(20px); }
        to { opacity: 1; transform: scale(1) translateY(0); }
    }

    .card-img-box { min-height: 480px; height: 100%; overflow: hidden; position: relative; }
    .card-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 1.2s ease; position: absolute; inset: 0; }
    .strategy-card:hover .card-img-box img { transform: scale(1.1); }

    .card-text-box { padding: 60px; }
    
    .land-spec-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 35px;
    }

    .land-spec-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        color: var(--slate-text);
        padding: 15px 20px;
        background: #fff5f9;
        border-radius: 16px;
        border-left: 4px solid var(--pink-hot);
        font-size: 0.95rem;
    }

    .land-spec-item i { color: var(--pink-hot); font-size: 1.1rem; }

    .cta-land-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--plum-mid);
        color: white !important;
        padding: 20px 45px;
        border-radius: 18px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.4s ease;
        margin-top: 45px;
        box-shadow: 0 10px 25px rgba(26, 5, 17, 0.2);
    }

    .cta-land-btn:hover { background: var(--pink-hot); transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 40px rgba(192, 42, 124, 0.4); }

    /* 🦉 Owl Carousel Premium Overrides */
    .land-strategy-carousel.owl-theme .owl-dots .owl-dot span {
        width: 12px; height: 12px; background: #e2e8f0; margin: 5px 7px; border-radius: 50%; transition: all 0.3s ease;
    }
    .land-strategy-carousel.owl-theme .owl-dots .owl-dot.active span {
        background: var(--pink-hot); width: 30px; border-radius: 20px;
    }
    .land-strategy-carousel.owl-theme .owl-nav [class*='owl-'] {
        background: var(--plum-mid) !important; color: white !important; width: 45px; height: 45px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 20px; transition: all 0.3s ease;
        position: absolute; top: 50%; transform: translateY(-50%); z-index: 10;
    }
    .land-strategy-carousel.owl-theme .owl-nav .owl-prev { left: -60px; }
    .land-strategy-carousel.owl-theme .owl-nav .owl-next { right: -60px; }
    .land-strategy-carousel.owl-theme .owl-nav [class*='owl-']:hover { background: var(--pink-hot) !important; box-shadow: 0 5px 15px rgba(192, 42, 124, 0.3); }

    @media (max-width: 1200px) {
        .land-strategy-carousel.owl-theme .owl-nav { display: none; }
    }

    @media (max-width: 991px) {
        .strategy-grid { grid-template-columns: 1fr; }
        .card-img-box { min-height: 320px; height: 320px; }
        .card-text-box { padding: 40px 24px; }
        .land-spec-grid { grid-template-columns: 1fr; }
        .land-hero { height: auto; padding: 180px 0 120px; }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- 🏔️ Premium Land Hero -->
    <section class="land-hero">
        <div class="hero-video-wrapper">
            <video autoplay muted loop playsinline class="hero-video-land">
                <source src="rkimg/Land_Servicesv.webm" type="video/webm">
            </video>
            <div class="hero-overlay-land"></div>
        </div>

        <div class="container land-hero-content" data-aos="fade-right" data-aos-duration="1200">
            <span class="land-badge"><i class="fa fa-map-marker"></i> Nation-Wide Land Portfolio</span>
            <h1 class="land-title">Mapping Potential. <span>Executing Scale.</span></h1>
            <p class="land-subtitle">Leveraging multi-market expertise in financial and technical feasibility analysis to maximize absolute value for developers, corporations, and private equity funds.</p>
            <div class="d-flex gap-3 flex-wrap">
                <a href="#hub" class="cta-land-btn">Explore Strategic Portfolio <i class="fa fa-arrow-down"></i></a>
                <a href="#showw" class="btn btn-outline-light rounded-pill px-5 py-3 fw-bold" style="border-width: 2px;">Consult Land Expert</a>
            </div>
        </div>
    </section>

    <!-- 🏦 Scale & Expertise Grid -->
    <section class="section-land-stats">
        <div class="container">
            <div class="land-stats-grid">
                <div class="land-stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="land-stat-val"><span>100</span>+</div>
                    <div class="land-stat-lbl">Strategic Transactions</div>
                </div>
                <div class="land-stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="land-stat-val"><span>18K</span> Cr+</div>
                    <div class="land-stat-lbl">Aggregated Deal Value</div>
                </div>
                <div class="land-stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="land-stat-val"><span>3,000</span>+</div>
                    <div class="land-stat-lbl">Acres Successfully Managed</div>
                </div>
            </div>

            <div class="row mt-5 pt-5 align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="rkimg/Tagimg.svg" alt="Scale" class="mb-4" style="height: 65px;">
                    <h2 class="fw-black mb-4" style="font-size: 3.2rem; line-height: 1.05;">Long-Term <span>Value Creation.</span></h2>
                    <p class="text-secondary fs-5 leading-relaxed">Our transaction managers identify the right sustainable business models for our clients, ensuring every acre is leveraged for its maximum absolute potential.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="p-5 rounded-5" style="background: var(--plum-mid); color: white; box-shadow: 0 30px 60px rgba(0,0,0,0.15);">
                        <h4 class="fw-bold mb-4 text-pink-hot"><i class="fa fa-globe me-3"></i>Global Best Practices</h4>
                        <p class="opacity-75 fs-5 mb-0">"By challenging the status quo and rethinking conventional land-use strategies, we shape and lead the market with transparency and data-backed foresight."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🧭 Land Strategy Hub -->
    <section class="land-strategy-section" id="hub">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="land-badge">Our Solutions</span>
                <h2 class="fw-black mb-3" style="font-size: 3.5rem;">Dedicated To <span>Your Success</span></h2>
                <p class="text-secondary mx-auto" style="max-width: 650px;">Bespoke land advisory and acquisition services tailored for specific market stakeholders.</p>
            </div>

            <div class="category-pills" data-aos="fade-up">
                <button class="pill-tab active" onclick="filterLandTabs(event, 'devs')">Developers</button>
                <button class="pill-tab" onclick="filterLandTabs(event, 'partners')">Channel Partners</button>
                <button class="pill-tab" onclick="filterLandTabs(event, 'corps')">Corporates</button>
            </div>

            <!-- Developers Content -->
            <div class="land-tab-group active" id="tab-devs">
                <div class="owl-carousel owl-theme land-strategy-carousel">
                    <div class="strategy-card active" data-aos="fade-up">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6"><div class="card-img-box"><img src="rkimg/Strategic_Solutionss.jpg" alt="Strategic"></div></div>
                            <div class="col-lg-6">
                                <div class="card-text-box">
                                    <h3 class="fw-black mb-4">Strategic Solutions</h3>
                                    <p class="text-secondary fs-5">Comprehensive mapping and advisory for identifying high-yield land opportunities before they hit the market.</p>
                                    <div class="land-spec-grid">
                                        <div class="land-spec-item"><i class="fa fa-map"></i> Land Mapping</div>
                                        <div class="land-spec-item"><i class="fa fa-line-chart"></i> Evaluation</div>
                                        <div class="land-spec-item"><i class="fa fa-search"></i> Advisory</div>
                                        <div class="land-spec-item"><i class="fa fa-building"></i> Built-to-Suit</div>
                                    </div>
                                    <a href="#showw" class="cta-land-btn">Request Portfolio Access</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="strategy-card active" data-aos="fade-up" data-aos-delay="200">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6 order-lg-2"><div class="card-img-box"><img src="rkimg/Acquisition_&_Dispositionn.jpg" alt="Acquisition"></div></div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="card-text-box">
                                    <h3 class="fw-black mb-4">Acquisition & JV</h3>
                                    <p class="text-secondary fs-5">Structuring complex joint developments and ventures to maximize asset liquidity and revenue sharing.</p>
                                    <div class="land-spec-grid">
                                        <div class="land-spec-item"><i class="fa fa-handshake-o"></i> Joint Venture</div>
                                        <div class="land-spec-item"><i class="fa fa-pie-chart"></i> Profit Share</div>
                                        <div class="land-spec-item"><i class="fa fa-briefcase"></i> DM Strategies</div>
                                        <div class="land-spec-item"><i class="fa fa-file-text-o"></i> Feasibility</div>
                                    </div>
                                    <a href="#showw" class="cta-land-btn">Explore JV Structures</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Partners Content -->
            <div class="land-tab-group" id="tab-partners" style="display:none;">
                 <div class="owl-carousel owl-theme land-strategy-carousel">
                     <div class="strategy-card active">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6"><div class="card-img-box"><img src="rkimg/Outright_Salee.jpg" alt="Partners"></div></div>
                            <div class="col-lg-6">
                                <div class="card-text-box">
                                    <h3 class="fw-black mb-4">Channel Collaboration</h3>
                                    <p class="text-secondary fs-5">Partnering with world-class agencies to leverage our unique land-selling strategies and extract maximum asset value.</p>
                                    <div class="land-spec-grid">
                                        <div class="land-spec-item"><i class="fa fa-rocket"></i> Outright Sale</div>
                                        <div class="land-spec-item"><i class="fa fa-users"></i> Large Network</div>
                                        <div class="land-spec-item"><i class="fa fa-tag"></i> Value Extraction</div>
                                        <div class="land-spec-item"><i class="fa fa-check-square"></i> Full Support</div>
                                    </div>
                                    <a href="#showw" class="cta-land-btn">Join as Partner</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corporates Content -->
            <div class="land-tab-group" id="tab-corps" style="display:none;">
                <div class="owl-carousel owl-theme land-strategy-carousel">
                    <div class="strategy-card active">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6"><div class="card-img-box"><img src="rkimg/Portfolio_Managementt.jpg" alt="Portfolio"></div></div>
                            <div class="col-lg-6">
                                <div class="card-text-box">
                                    <h3 class="fw-black mb-4">Portfolio Strategy</h3>
                                    <p class="text-secondary fs-5">Helping institutions and corporate agencies manage land portfolios through restructuring and valuation strategy.</p>
                                    <div class="land-spec-grid">
                                        <div class="land-spec-item"><i class="fa fa-database"></i> Consolidation</div>
                                        <div class="land-spec-item"><i class="fa fa-refresh"></i> Restructuring</div>
                                        <div class="land-spec-item"><i class="fa fa-list-alt"></i> Evaluation</div>
                                        <div class="land-spec-item"><i class="fa fa-shield"></i> Risk Mitigation</div>
                                    </div>
                                    <a href="#showw" class="cta-land-btn">Initiate Audit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php include 'component/explore.php'; ?>

    <!-- Anchor for CTAs -->
    <div id="showw">
        <?php include 'component/formk.php'; ?>
    </div>

    <?php include 'component/footer.php'; ?>

    <script>
        $(document).ready(function(){
            $(".land-strategy-carousel").owlCarousel({
                items: 1,
                loop: false,
                nav: true,
                dots: true,
                autoplay: false,
                smartSpeed: 800,
                navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
            });
        });

        function filterLandTabs(evt, persona) {
            var i, groups, pills;
            groups = document.getElementsByClassName("land-tab-group");
            for (i = 0; i < groups.length; i++) {
                groups[i].style.display = "none";
                groups[i].classList.remove("active");
            }
            pills = document.getElementsByClassName("pill-tab");
            for (i = 0; i < pills.length; i++) {
                pills[i].classList.remove("active");
            }
            
            var target = document.getElementById("tab-" + persona);
            target.style.display = "block";
            target.classList.add("active");
            evt.currentTarget.classList.add("active");

            // Refresh carousels to handle width calculation on hidden elements
            $(".land-strategy-carousel").trigger('refresh.owl.carousel');
        }
    </script>

</body>
</html>