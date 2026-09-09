<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 🏨 Hospitality Premium Overhaul */
    :root {
        --hosp-plum: #1a0511;
        --hosp-plum-accent: #2d0a1c;
        --hosp-pink: #c02a7c;
        --hosp-pink-soft: #ff85c0;
        --hosp-text-slate: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--hosp-plum-accent); overflow-x: hidden; }

    /* --- Luxury Hero --- */
    .hosp-hero {
        position: relative;
        min-height: 85vh;
        display: flex;
        align-items: flex-start;
        overflow: hidden;
        background: #000;
        padding-top: 180px;
        padding-bottom: 100px;
    }

    .hero-video-box {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: 1;
    }

    .hero-video-hosp {
        width: 100%; height: 100%; object-fit: cover; opacity: 0.55;
    }

    .hero-overlay-hosp {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(26, 5, 17, 0.95) 0%, rgba(26, 5, 17, 0.3) 100%);
        z-index: 2;
    }

    .hosp-hero-content {
        position: relative;
        z-index: 3;
        color: white;
        max-width: 850px;
    }

    .hosp-badge {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: rgba(192, 42, 124, 0.15);
        border: 1px solid var(--hosp-pink-soft);
        color: var(--hosp-pink-soft);
        padding: 10px 25px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 2.5px;
        margin-bottom: 30px;
        backdrop-filter: blur(12px);
    }

    .hosp-title {
        font-size: clamp(3rem, 7vw, 4.8rem);
        font-weight: 900;
        line-height: 1.05;
        margin-bottom: 25px;
        letter-spacing: -3px;
    }

    .hosp-title span { color: var(--hosp-pink); }

    .hosp-subtitle {
        font-size: 1.3rem;
        opacity: 0.88;
        margin-bottom: 45px;
        line-height: 1.7;
        border-left: 5px solid var(--hosp-pink);
        padding-left: 25px;
    }

    /* --- Partnership Section --- */
    .partnership-stripe {
        background: white;
        padding: 50px 0;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        position: relative;
        z-index: 10;
        margin-top: -50px;
        border-radius: 40px 40px 0 0;
    }

    .partner-logos-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 40px;
    }

    .partner-logo-item img { height: 60px; filter: grayscale(0.2) opacity(0.9); transition: 0.4s; }
    .partner-logo-item:hover img { filter: grayscale(0) opacity(1); transform: scale(1.05); }
    .partner-sep { width: 1px; height: 40px; background: #e2e8f0; }

    /* --- Luxury Stats --- */
    .section-hosp-stats { padding: 120px 0; background: #faf9fb; }
    
    .hosp-stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: -80px;
        position: relative;
        z-index: 15;
    }

    .hosp-stat-card {
        background: white;
        padding: 50px 35px;
        border-radius: 35px;
        box-shadow: 0 30px 60px rgba(45, 10, 28, 0.06);
        border: 1px solid rgba(192, 42, 124, 0.05);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        text-align: center;
    }

    .hosp-stat-card:hover { transform: translateY(-12px); border-color: var(--hosp-pink); }

    .hosp-stat-val { font-size: 3.8rem; font-weight: 1000; color: var(--hosp-plum-accent); line-height: 1; margin-bottom: 8px; }
    .hosp-stat-val span { color: var(--hosp-pink); }
    .hosp-stat-lbl { font-size: 1rem; font-weight: 700; color: var(--hosp-text-slate); text-transform: uppercase; letter-spacing: 1.2px; }

    /* --- Hospitality Strategy Hub --- */
    .hosp-strategy-section { padding: 100px 0; background: white; }

    .hub-tabs-pills {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 60px;
    }

    .hosp-pill-tab {
        border: 2px solid #e2e8f0;
        background: #f8fafc;
        padding: 14px 45px;
        border-radius: 60px;
        font-weight: 800;
        color: var(--hosp-plum-accent);
        transition: all 0.4s ease;
        cursor: pointer;
    }

    .hosp-pill-tab.active {
        background: var(--hosp-pink);
        border-color: var(--hosp-pink);
        color: white;
        box-shadow: 0 15px 30px rgba(192, 42, 124, 0.3);
    }

    .hosp-service-card {
        background: #fff;
        border-radius: 40px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: 0 40px 80px rgba(0,0,0,0.05);
        margin: 10px;
    }

    .hosp-img-box { height: 500px; min-height: 100%; overflow: hidden; position: relative; }
    .hosp-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 1.5s ease; position: absolute; inset: 0; }
    .hosp-service-card:hover .hosp-img-box img { transform: scale(1.1); }

    .hosp-body-box { padding: 50px; }
    
    .hosp-spec-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
        margin-top: 30px;
    }

    .hosp-spec-item {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 700;
        color: var(--hosp-text-slate);
        padding: 15px 20px;
        background: #fff5f9;
        border-radius: 15px;
        border-left: 4px solid var(--hosp-pink);
        font-size: 0.95rem;
    }

    .hosp-spec-item i { color: var(--hosp-pink); font-size: 1.2rem; }

    .hosp-cta-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--hosp-plum-accent);
        color: white !important;
        padding: 22px 50px;
        border-radius: 20px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.4s ease;
        margin-top: 50px;
        box-shadow: 0 12px 30px rgba(26, 5, 17, 0.25);
    }

    .hosp-cta-btn:hover { background: var(--hosp-pink); transform: translateY(-7px); box-shadow: 0 20px 40px rgba(192, 42, 124, 0.4); }

    .hosp-outline-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: transparent;
        color: white !important;
        padding: 20px 45px;
        border: 2px solid white;
        border-radius: 20px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.4s ease;
        margin-top: 50px;
    }
    .hosp-outline-btn:hover { background: white; color: var(--hosp-plum-accent) !important; transform: translateY(-7px); }

    /* 🦉 Owl Carousel Customization */
    .hosp-carousel.owl-theme .owl-dots .owl-dot span { width: 12px; height: 12px; background: #e2e8f0; margin: 5px 8px; border-radius: 50%; transition: 0.3s; }
    .hosp-carousel.owl-theme .owl-dots .owl-dot.active span { background: var(--hosp-pink); width: 40px; border-radius: 20px; }
    .hosp-carousel.owl-theme .owl-nav [class*='owl-'] {
        background: var(--hosp-plum-accent) !important; color: white !important; width: 55px; height: 55px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; font-size: 22px; transition: 0.3s;
        position: absolute; top: 50%; transform: translateY(-50%); z-index: 10;
    }
    .hosp-carousel.owl-theme .owl-nav .owl-prev { left: -30px; }
    .hosp-carousel.owl-theme .owl-nav .owl-next { right: -30px; }

    @media (max-width: 1300px) { 
        .hosp-carousel.owl-theme .owl-nav { display: none; } 
    }

    @media (max-width: 991px) {
        .hosp-hero { height: auto; padding: 180px 0 100px; }
        .hosp-img-box { height: 350px; min-height: 350px; }
        .hosp-body-box { padding: 40px 24px; }
        .hosp-spec-grid { grid-template-columns: 1fr; }
        .partner-logos-wrap { flex-direction: column; gap: 20px; }
        .partner-sep { display: none; }
        .partnership-stripe { margin-top: 0; border-radius: 0; }
        
        .hosp-cta-btn, .hosp-outline-btn { 
            width: 100%; 
            justify-content: center; 
            margin-top: 20px; 
            padding: 18px 30px;
            font-size: 0.95rem;
        }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- 🏨 Cinematic Luxury Hero -->
    <section class="hosp-hero">
        <div class="hero-video-box">
            <video autoplay muted loop playsinline class="hero-video-hosp">
                <source src="rkimg/hospitality.webm" type="video/webm">
            </video>
            <div class="hero-overlay-hosp"></div>
        </div>

        <div class="container hosp-hero-content" data-aos="fade-right" data-aos-duration="1200">
            <span class="hosp-badge"><i class="fa fa-star"></i> Global Hospitality Excellence</span>
            <h1 class="hosp-title">Bespoke <span>Luxury Advisory.</span></h1>
            <p class="hosp-subtitle">Driving asset value and consistent ROI through institutional-grade feasibility, high-fidelity market insights, and world-class management partnerships.</p>
            <div class="d-flex gap-3 flex-wrap">
                <a href="#hub" class="hosp-cta-btn">Explore Adisory Hub <i class="fa fa-compass"></i></a>
                <a href="#showw" class="hosp-outline-btn">Consult Luxury Expert <i class="fa fa-user-tie"></i></a>
            </div>
        </div>
    </section>

    <!-- 🤝 Strategic Partnership Bar -->
    <section class="partnership-stripe">
        <div class="container">
            <div class="partner-logos-wrap" data-aos="zoom-in">
                <div class="partner-logo-item"><img src="img/logo-fine.png" alt="Fine Acers" style="height: 50px;"></div>
                <div class="partner-sep"></div>
                <div class="partner-logo-item"><img src="img/Ikanhousing-logo2.svg" alt="I Kan Housing"></div>
                <div class="partner-sep"></div>
                <div class="text-center">
                    <p class="mb-0 fw-bold text-uppercase opacity-75" style="letter-spacing: 2px; font-size: 11px;">Elite Hospitality Synergy</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 🏛️ Competitive Performance stats -->
    <section class="section-hosp-stats">
        <div class="container">
            <div class="hosp-stats-grid">
                <div class="hosp-stat-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="hosp-stat-val"><span>60</span>+</div>
                    <div class="hosp-stat-lbl">Management Contracts</div>
                </div>
                <div class="hosp-stat-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="hosp-stat-val"><span>1000</span>+</div>
                    <div class="hosp-stat-lbl">Studies Completed</div>
                </div>
                <div class="hosp-stat-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="hosp-stat-val"><span>600</span>+</div>
                    <div class="hosp-stat-lbl">Search Mandates</div>
                </div>
            </div>

            <div class="row mt-5 pt-5 align-items-center g-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <img src="rkimg/Tagimg.svg" alt="Quality" class="mb-4" style="height: 65px;">
                    <h2 class="fw-black mb-4" style="font-size: 3.2rem; line-height: 1.05;">Institutional Grade <br><span>Data & Vision.</span></h2>
                    <p class="text-secondary fs-5 leading-relaxed">Our alliance with Fine Acers provides comprehensive advisory across all asset lifecycle stages, ensuring consistent, long-term ROI in prime destination markets.</p>
                </div>
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="p-5 rounded-5" style="background: var(--hosp-plum-accent); color: white; box-shadow: 0 40px 80px rgba(0,0,0,0.2);">
                        <h4 class="fw-bold mb-4 text-hosp-pink"><i class="fa fa-quote-left me-3"></i>The Strategic Edge</h4>
                        <p class="opacity-75 fs-5">"By leveraging in-depth research and powerful insights, we identify the ideal investment opportunities that balance financial growth with luxury lifestyle."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🧭 Hospitality Advisory Hub -->
    <section class="hosp-strategy-section" id="hub">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="hosp-badge">Service Spectrum</span>
                <h2 class="fw-black mb-3" style="font-size: 3.5rem;">Solutions For <span style="color: var(--hosp-pink);">Stakeholders</span></h2>
                <p class="text-secondary mx-auto" style="max-width: 650px;">World-class advisory supporting owners, developers, and institutional investors across various hospitality asset types.</p>
            </div>

            <div class="hub-tabs-pills" data-aos="fade-up">
                <button class="hosp-pill-tab active" onclick="switchHospTab(event, 'hosp-devs')">Developers & Owners</button>
                <button class="hosp-pill-tab" onclick="switchHospTab(event, 'hosp-corps')">Institutional Investors</button>
            </div>

            <!-- Developers Content -->
            <div class="hosp-tab-panel active" id="hosp-devs">
                <div class="owl-carousel owl-theme hosp-carousel">
                    <!-- Slide 1 -->
                    <div class="hosp-service-card" data-aos="fade-up">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6"><div class="hosp-img-box"><img src="rkimg/Consulting_Valuations.jpg" alt="Consulting"></div></div>
                            <div class="col-lg-6">
                                <div class="hosp-body-box">
                                    <h3 class="fw-black mb-4">Consulting & Valuations</h3>
                                    <p class="text-secondary fs-5">Determining the absolute absolute feasibility of your project with data-driven modeling and operator insights.</p>
                                    <div class="hosp-spec-grid">
                                        <div class="hosp-spec-item"><i class="fa fa-line-chart"></i> Economic Feasibility</div>
                                        <div class="hosp-spec-item"><i class="fa fa-shield"></i> Strategic Valuation</div>
                                        <div class="hosp-spec-item"><i class="fa fa-users"></i> Operator Selection</div>
                                        <div class="hosp-spec-item"><i class="fa fa-file-text"></i> Contract Negotiation</div>
                                    </div>
                                    <a href="#showw" class="hosp-cta-btn">Initiate Audit</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="hosp-service-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6 order-lg-2"><div class="hosp-img-box"><img src="rkimg/Asset_Management_Services.jpg" alt="Asset Management"></div></div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="hosp-body-box">
                                    <h3 class="fw-black mb-4">Asset Management</h3>
                                    <p class="text-secondary fs-5">Maximizing operational performance through digital strategy, revenue optimization, and detailed audits.</p>
                                    <div class="hosp-spec-grid">
                                        <div class="hosp-spec-item"><i class="fa fa-cogs"></i> Pre-Opening Prep</div>
                                        <div class="hosp-spec-item"><i class="fa fa-laptop"></i> Digital Strategy</div>
                                        <div class="hosp-spec-item"><i class="fa fa-search-plus"></i> Operating Audits</div>
                                        <div class="hosp-spec-item"><i class="fa fa-wrench"></i> Troubleshooting</div>
                                    </div>
                                    <a href="#showw" class="hosp-cta-btn">Optimize My Asset</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corporates Content -->
            <div class="hosp-tab-panel" id="hosp-corps" style="display: none;">
                <div class="owl-carousel owl-theme hosp-carousel">
                     <!-- Slide 1 -->
                     <div class="hosp-service-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6"><div class="hosp-img-box"><img src="rkimg/Capital-Markets_Transaction_Advisory.jpg" alt="Capital Markets"></div></div>
                            <div class="col-lg-6">
                                <div class="hosp-body-box">
                                    <h3 class="fw-black mb-4">Capital Markets & Transactions</h3>
                                    <p class="text-secondary fs-5">Exclusive buy-side and sell-side brokerage leveraging innovative transaction structures for maximum results.</p>
                                    <div class="hosp-spec-grid">
                                        <div class="hosp-spec-item"><i class="fa fa-bank"></i> Equity Raising</div>
                                        <div class="hosp-spec-item"><i class="fa fa-exchange"></i> Brokerage</div>
                                        <div class="hosp-spec-item"><i class="fa fa-handshake-o"></i> Debt Advisory</div>
                                        <div class="hosp-spec-item"><i class="fa fa-magic"></i> Price Optimization</div>
                                    </div>
                                    <a href="#showw" class="hosp-cta-btn">Review Transaction Process</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="hosp-service-card">
                        <div class="row g-0 align-items-center">
                            <div class="col-lg-6 order-lg-2"><div class="hosp-img-box"><img src="rkimg/Executive_Search.jpg" alt="Executive Search"></div></div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="hosp-body-box">
                                    <h3 class="fw-black mb-4">Executive Search</h3>
                                    <p class="text-secondary fs-5">Global database of assets and industry talent, providing exclusive head-hunting for senior hospitality roles.</p>
                                    <div class="hosp-spec-grid">
                                        <div class="hosp-spec-item"><i class="fa fa-id-card"></i> Senior Placement</div>
                                        <div class="hosp-spec-item"><i class="fa fa-graduation-cap"></i> HR Advisory</div>
                                        <div class="hosp-spec-item"><i class="fa fa-database"></i> Global Data</div>
                                        <div class="hosp-spec-item"><i class="fa fa-sliders"></i> Talent Assessment</div>
                                    </div>
                                    <a href="#showw" class="hosp-cta-btn">Search Leadership</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <?php include 'component/explore.php'; ?>

    <div id="showw">
        <?php include 'component/formk.php'; ?>
    </div>

    <?php include 'component/footer.php'; ?>

    <script>
        $(document).ready(function(){
            $(".hosp-carousel").owlCarousel({
                items: 1,
                loop: false,
                nav: true,
                dots: true,
                autoplay: false,
                smartSpeed: 800,
                navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
            });
        });

        function switchHospTab(evt, panelId) {
            var i, panels, tabs;
            panels = document.getElementsByClassName("hosp-tab-panel");
            for (i = 0; i < panels.length; i++) {
                panels[i].style.display = "none";
                panels[i].classList.remove("active");
            }
            tabs = document.getElementsByClassName("hosp-pill-tab");
            for (i = 0; i < tabs.length; i++) {
                tabs[i].classList.remove("active");
            }
            
            var target = document.getElementById(panelId);
            target.style.display = "block";
            target.classList.add("active");
            evt.currentTarget.classList.add("active");

            // Refresh carousels
            $(".hosp-carousel").trigger('refresh.owl.carousel');
        }
    </script>

</body>
</html>