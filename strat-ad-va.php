<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== STRATEGIC ADVISORY — PREMIUM PINK & PLUM DESIGN ===== */

/* ---- HERO SECTION ---- */
.sa-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514;
}

.sa-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.3;
    z-index: 0;
}

.sa-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,5,20,0.92) 0%, rgba(45,10,28,0.7) 50%, rgba(192,42,124,0.15) 100%);
    z-index: 1;
}

.sa-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
    padding-bottom: 80px;
}

.sa-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192,42,124,0.12);
    border: 1px solid rgba(192,42,124,0.35);
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

.sa-hero-title {
    font-size: clamp(2.5rem, 6vw, 5.5rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    letter-spacing: -2px;
    margin-bottom: 25px;
}

.sa-hero-title span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.sa-hero-desc {
    color: rgba(255,255,255,0.7);
    font-size: 1.15rem;
    line-height: 1.8;
    max-width: 600px;
    margin-bottom: 40px;
}

/* ---- COMPETITIVE EDGE ---- */
.sa-edge {
    padding: 100px 0;
    background: #fff;
}

.sa-edge-card {
    background: #fff;
    border-radius: 30px;
    padding: 40px;
    height: 100%;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 15px 45px rgba(45,10,28,0.03);
    transition: all 0.4s ease;
}

.sa-edge-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(192,42,124,0.1);
    border-color: rgba(192,42,124,0.15);
}

.sa-stat-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-top: 30px;
}

.sa-stat-item {
    background: #fff5f9;
    padding: 25px;
    border-radius: 20px;
    border-bottom: 3px solid #c02a7c;
}

.sa-stat-num {
    font-size: 2.5rem;
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 5px;
}

.sa-stat-num span { color: #c02a7c; }

.sa-stat-label {
    font-size: 0.85rem;
    color: #8e6f7e;
    font-weight: 700;
    line-height: 1.4;
}

/* ---- AUDIENCE SECTION ---- */
.sa-audience {
    padding: 100px 0;
    background: #fcf6fa;
}

.sa-badge {
    display: inline-block;
    background: rgba(192,42,124,0.08);
    color: #c02a7c;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 15px;
}

.sa-section-title {
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 850;
    color: #2d0a1c;
    margin-bottom: 20px;
}

.sa-section-title span { color: #c02a7c; }

.sa-pill-tabs {
    display: flex;
    gap: 15px;
    margin-bottom: 50px;
}

.sa-pill {
    background: #fff;
    border: 1px solid #e1d4dc;
    color: #8e6f7e;
    padding: 12px 28px;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex; align-items: center; gap: 10px;
}

.sa-pill.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    border-color: #c02a7c;
    box-shadow: 0 10px 25px rgba(192,42,124,0.25);
}

/* PANELS */
.sa-panel {
    display: none;
}

.sa-panel.active {
    display: grid;
    grid-template-columns: 350px 1fr;
    gap: 50px;
    animation: saFadeUp 0.6s ease-out;
}

@keyframes saFadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.sa-sidebar {
    background: #fff;
    border-radius: 30px;
    padding: 35px;
    border: 1px solid rgba(45,10,28,0.05);
    height: fit-content;
    position: sticky;
    top: 100px;
}

.sa-nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px 20px;
    border-radius: 18px;
    color: #2d0a1c;
    font-weight: 700;
    font-size: 0.92rem;
    text-decoration: none !important;
    transition: all 0.3s ease;
    margin-bottom: 10px;
}

.sa-nav-link i {
    width: 35px; height: 35px;
    background: #fff5f9;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 0.9rem;
}

.sa-nav-link.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    box-shadow: 0 12px 24px rgba(192,42,124,0.2);
}

.sa-nav-link.active i {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

/* Detail Card */
.sa-detail-card {
    display: none;
    background: #fff;
    border-radius: 40px;
    overflow: hidden;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 20px 50px rgba(45,10,28,0.04);
}

.sa-detail-card.active {
    display: block;
    animation: saCardSlide 0.5s ease-out;
}

@keyframes saCardSlide {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

.sa-card-img {
    width: 100%; height: 400px;
    object-fit: cover;
}

.sa-card-body {
    padding: 50px;
}

.sa-card-body h3 {
    font-size: 2rem;
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 20px;
}

.sa-card-body p {
    color: #8e6f7e;
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 30px;
}

.sa-feature-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 35px;
}

.sa-list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    color: #3a1d2e;
    font-size: 0.9rem;
}

.sa-list-item i { color: #c02a7c; }

/* ---- CTA ---- */
.sa-cta {
    padding: 100px 0;
    background: #fff;
}

.sa-cta-box {
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 60%, #0a0514 100%);
    border-radius: 50px;
    padding: 90px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.sa-cta-box h2 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 950;
    color: #fff;
    margin-bottom: 25px;
}

.sa-cta-box h2 span { color: #ff85c0; }

.sa-btn-primary {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 20px 50px;
    border-radius: 60px;
    font-weight: 800;
    font-size: 1.15rem;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.4s ease;
    box-shadow: 0 15px 35px rgba(192,42,124,0.3);
}

.sa-btn-primary:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(192,42,124,0.5);
    color: #fff;
}

@media (max-width: 1199px) {
    .sa-panel.active { grid-template-columns: 1fr; }
    .sa-sidebar { position: static; }
}

@media (max-width: 767px) {
    .sa-feature-list { grid-template-columns: 1fr; }
}
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <style>
        .intro-content { padding-top: 120px !important; }
        @media (max-width: 991px) { .intro-content { padding-top: 90px !important; } }
    </style>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="sa-hero">
        <video autoplay muted loop playsinline class="sa-hero-video">
            <source src="rkimg/strat-ad-va.webm" type="video/webm">
        </video>
        <div class="sa-hero-overlay"></div>
        <div class="container sa-hero-content">
            <div class="row">
                <div class="col-lg-10" data-aos="fade-up">
                    <div class="sa-hero-badge">Data-Driven Advisory</div>
                    <h1 class="sa-hero-title">Strategic Advisory <span>& Valuations</span></h1>
                    <p class="sa-hero-desc">Assess, strategize, conceptualize, and execute unique market strategies for real estate opportunities with our specialized team of experts.</p>
                    <div class="d-flex gap-3">
                        <a href="#showw" class="sa-btn-primary">Connect With Experts Now <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== COMPETITIVE EDGE ===== -->
    <section class="sa-edge">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="sa-edge-card">
                        <img src="rkimg/Tagimg.svg" alt="Edge" class="img-fluid mb-4" style="max-height: 40px;">
                        <h4 style="font-weight:900; color:#2d0a1c; margin-bottom:20px;">The Multiplier Effect</h4>
                        <p style="color:#8e6f7e; font-size:1rem; line-height:1.7;">We create a multiplier effect by synergizing the whole rather than focusing solely on individual parts, backed by over 200 years of combined team experience.</p>
                        
                        <div class="sa-stat-grid">
                            <div class="sa-stat-item">
                                <div class="sa-stat-num"><span>500</span>+</div>
                                <div class="sa-stat-label">Assignments across 75+ cities</div>
                            </div>
                            <div class="sa-stat-item">
                                <div class="sa-stat-num"><span>$6</span>B</div>
                                <div class="sa-stat-label">Worth of assets valued in FY 2023</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="ps-lg-5">
                        <div class="sa-badge">Our Advantage</div>
                        <h2 class="sa-section-title">Synergizing <span>Intelligence & Reality</span></h2>
                        <p class="res-section-desc" style="font-size:1.1rem; line-height:1.8; color:#8e6f7e; margin-bottom:35px;">
                            We provide our clients with factual, data-driven market evaluations and identify potential opportunities, both emerging and overlooked. Our expertise spans across Tier I, II and III cities.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="sa-nav-link active" style="padding:0; width:45px; height:45px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fa fa-map-marker" style="margin:0;"></i>
                                    </div>
                                    <p style="font-size:0.92rem; font-weight:700; color:#2d0a1c; margin:0;">Specialists across 6 major offices nationwide.</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3">
                                    <div class="sa-nav-link active" style="padding:0; width:45px; height:45px; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fa fa-line-chart" style="margin:0;"></i>
                                    </div>
                                    <p style="font-size:0.92rem; font-weight:700; color:#2d0a1c; margin:0;">Unmatched depth in market trend analysis.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== AUDIENCE SECTION ===== -->
    <section class="sa-audience" id="services">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="sa-badge">Solutions Framework</div>
                    <h2 class="sa-section-title">What We Can Do <span>For You</span></h2>
                </div>
            </div>

            <div class="sa-pill-tabs" data-aos="fade-up">
                <div class="sa-pill active" onclick="switchMainTab('developers', this)">
                    <i class="fa fa-building"></i> For Developers
                </div>
                <div class="sa-pill" onclick="switchMainTab('corporates', this)">
                    <i class="fa fa-id-card"></i> For Corporates
                </div>
            </div>

            <!-- PANEL: DEVELOPERS -->
            <div class="sa-panel active" id="panel-developers">
                <aside class="sa-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px;">Developer Desk</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Research-based insights through data-backed advisory.</p>
                    <div class="sa-nav-links">
                        <a href="javascript:void(0)" class="sa-nav-link active" onclick="switchDetailCard('feasibility', this)">
                            <i class="fa fa-pie-chart"></i> Market Research
                        </a>
                        <a href="javascript:void(0)" class="sa-nav-link" onclick="switchDetailCard('financial', this)">
                            <i class="fa fa-calculator"></i> Financial Plans
                        </a>
                        <a href="javascript:void(0)" class="sa-nav-link" onclick="switchDetailCard('development', this)">
                            <i class="fa fa-cubes"></i> Best Use Studies
                        </a>
                        <a href="javascript:void(0)" class="sa-nav-link" onclick="switchDetailCard('location', this)">
                            <i class="fa fa-map-o"></i> Expansion Strategy
                        </a>
                    </div>
                </aside>

                <div class="sa-content">
                    <div class="sa-detail-card active" id="feasibility">
                        <img src="rkimg/Feasibility_Analysis&MarketResearchh.jpg" class="sa-card-img" alt="Research">
                        <div class="sa-card-body">
                            <h3>Feasibility Analysis & Market Research</h3>
                            <p>Maximizing returns and minimizing risk through in-depth evaluation of demographic variables and socioeconomic sensitivities.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Demographic Analysis</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Market Trend Analysis</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Due Diligence</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Intelligence Services</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Get Market Insights</a>
                        </div>
                    </div>

                    <div class="sa-detail-card" id="financial">
                        <img src="rkimg/Financial_Feasibility_&_Business_Plansn.jpg" class="sa-card-img" alt="Financial">
                        <div class="sa-card-body">
                            <h3>Financial Feasibility & Business Plans</h3>
                            <p>Offering expertise to turn your real estate vision into a financial reality through rigorous forecasting prior to planning.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Project Forecasting</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Business Planning</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Investment Advisory</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Capital Planning</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Consult Financials</a>
                        </div>
                    </div>

                    <div class="sa-detail-card" id="development">
                        <img src="rkimg/Development_Advisory&Best_UseAssessmentt.jpg" class="sa-card-img" alt="Advisory">
                        <div class="sa-card-body">
                            <h3>Development Advisory</h3>
                            <p>Empowering you to make informed decisions across multiple asset classes and project typologies with Best-Use studies.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Highest & Best Use</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Demand Assessment</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Vision Development</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Master Planning</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Explore Advisory</a>
                        </div>
                    </div>

                    <div class="sa-detail-card" id="location">
                        <img src="rkimg/Location_Consulting_Development_Due_Diligence_&_Expansion_Strategyy.jpg" class="sa-card-img" alt="Location">
                        <div class="sa-card-body">
                            <h3>Market Entry & Expansion Strategy</h3>
                            <p>Optimum development evaluation leveraging scale efficiencies to maximize financial returns across new geographies.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Market Entry Strategy</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Benchmarking</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Occupier Mapping</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Location Advisory</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Plan Expansion</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: CORPORATES -->
            <div class="sa-panel" id="panel-corporates">
                <aside class="sa-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px;">Corporate Advisory</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Aligning business, finance, and growth via optimized real estate.</p>
                    <div class="sa-nav-links">
                        <a href="javascript:void(0)" class="hs-nav-link active" onclick="switchDetailCard('alternatives', this)">
                            <i class="fa fa-server"></i> Alternatives Advisory
                        </a>
                        <a href="javascript:void(0)" class="hs-nav-link" onclick="switchDetailCard('infrastructure', this)">
                            <i class="fa fa-industry"></i> Govt Infrastructure
                        </a>
                        <a href="javascript:void(0)" class="hs-nav-link" onclick="switchDetailCard('portfolio', this)">
                            <i class="fa fa-briefcase"></i> Portfolio Planning
                        </a>
                        <a href="javascript:void(0)" class="hs-nav-link" onclick="switchDetailCard('valuation', this)">
                            <i class="fa fa-balance-scale"></i> Valuation Advisory
                        </a>
                    </div>
                </aside>

                <div class="sa-content">
                    <div class="sa-detail-card active" id="alternatives">
                        <img src="rkimg/Alternatives_Advisoryyy.jpg" class="sa-card-img" alt="Alt">
                        <div class="sa-card-body">
                            <h3>Alternatives Advisory</h3>
                            <p>Specialized advisory for Student Housing, Senior Living, Co-Working, and Warehousing/Logistics portfolios.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Healthcare Assets</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Student Housing</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Educational Assets</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Industrial/Logistics</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Explore Assets</a>
                        </div>
                    </div>

                    <div class="sa-detail-card" id="infrastructure">
                        <img src="rkimg/Infrastructure_&_Government_Advisoryya.jpg" class="sa-card-img" alt="Govt">
                        <div class="sa-card-body">
                            <h3>Infrastructure & Govt Advisory</h3>
                            <p>PPP Advisory and DPR preparation for Smart Cities, Sports Infrastructure, and Urban Planning studies.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> PPP Advisory</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Preparing DPRs</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Smart City Studies</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Urban Planning</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">View Projects</a>
                        </div>
                    </div>

                    <div class="sa-detail-card" id="portfolio">
                        <img src="rkimg/PortfolioPlanning&Optimizationna.jpg" class="sa-card-img" alt="Portfolio">
                        <div class="sa-card-body">
                            <h3>Portfolio Planning & Optimization</h3>
                            <p>Rationalization of real estate portfolios through transaction management and professional lease administration.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Portfolio Optimization</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Rationalization</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Lease Admin</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Transaction Mgmt</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Talk to Strategy</a>
                        </div>
                    </div>

                    <div class="sa-detail-card" id="valuation">
                        <img src="rkimg/ValuationAdvisorym.jpg" class="sa-card-img" alt="Valuation">
                        <div class="sa-card-body">
                            <h3>Valuation Advisory</h3>
                            <p>Assessing the right value for real estate assets using knowledge-backed local market insights across all asset types.</p>
                            <div class="sa-feature-list">
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Land & Property Valuation</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> Mortgage Valuation</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> IPO / REIT Listings</div>
                                <div class="sa-list-item"><i class="fa fa-check-circle"></i> M&A Valuation</div>
                            </div>
                            <a href="#showw" class="sa-btn-primary" style="padding:15px 35px; font-size:1rem;">Book Valuation</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="sa-cta">
        <div class="container">
            <div class="sa-cta-box" data-aos="zoom-in">
                <h2>Uncover the <span>Potential</span></h2>
                <p>Allow our specialized team to identify emerging opportunities and factual evaluations for your real estate assets.</p>
                <a href="#showw" class="sa-btn-primary">Connect With Us Now <i class="fa fa-comments"></i></a>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

    <script>
    function switchMainTab(id, btn) {
        document.querySelectorAll('.sa-pill').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.sa-panel').forEach(el => el.classList.remove('active'));
        
        btn.classList.add('active');
        const panel = document.getElementById('panel-' + id);
        panel.classList.add('active');
        
        // Reset sub-tabs
        const firstLink = panel.querySelector('.sa-nav-link');
        const firstCard = panel.querySelector('.sa-detail-card');
        panel.querySelectorAll('.sa-nav-link').forEach(l => l.classList.remove('active'));
        panel.querySelectorAll('.sa-detail-card').forEach(c => c.classList.remove('active'));
        if(firstLink) firstLink.classList.add('active');
        if(firstCard) firstCard.classList.add('active');
    }

    function switchDetailCard(id, btn) {
        const panel = btn.closest('.sa-panel');
        panel.querySelectorAll('.sa-nav-link').forEach(el => el.classList.remove('active'));
        panel.querySelectorAll('.sa-detail-card').forEach(el => el.classList.remove('active'));
        
        btn.classList.add('active');
        const card = panel.querySelector('#' + id);
        card.classList.add('active');

        if(window.innerWidth < 1200) {
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    </script>

</body>
</html>