<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* 
================================================================
    COMMERCIAL LEASING — UNIFIED DESIGN SYSTEM (PREMIUM POLISH)
    Aligning with I Kan Housing Brand Identity
================================================================
*/

:root {
    --cl-plum: #2d0a1c;
    --cl-plum-deep: #1a0511;
    --cl-pink: #c02a7c;
    --cl-pink-light: #ff85c0;
    --cl-bg-light: #fdfafd;
    --cl-text-muted: #8e6f7e;
    --cl-glass: rgba(255, 255, 255, 0.7);
    --cl-glass-border: rgba(255, 255, 255, 0.2);
    --cl-shadow: 0 20px 50px rgba(45, 10, 28, 0.1);
    --cl-transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
}

body {
    background: #fff;
    font-family: 'Outfit', sans-serif;
    color: #2d0a1c;
    overflow-x: hidden;
}

/* ---- PREMIUM BACKGROUND ATMOSPHERE ---- */
.cl-ambient {
    position: fixed;
    inset: 0;
    z-index: -1;
    pointer-events: none;
    opacity: 0.4;
}
.cl-glow {
    position: absolute;
    width: 600px; height: 600px;
    border-radius: 50%;
    filter: blur(120px);
}
.cl-glow-1 { top: -10%; left: -10%; background: rgba(192, 42, 124, 0.08); }
.cl-glow-2 { bottom: -10%; right: -10%; background: rgba(45, 10, 28, 0.05); }

/* ---- PREMIUM HERO ---- */
.cl-hero {
    position: relative;
    height: 90vh;
    display: flex;
    align-items: center;
    background: #000;
    overflow: hidden;
    padding-top: 110px;
}

.cl-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.45;
}

.cl-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to right, rgba(26,5,17,0.95) 10%, rgba(26,5,17,0.1) 100%);
    z-index: 1;
}

.cl-hero-content {
    position: relative;
    z-index: 5;
}

.cl-badge {
    display: inline-block;
    background: rgba(192, 42, 124, 0.1);
    border: 1px solid rgba(192, 42, 124, 0.2);
    color: var(--cl-pink-light);
    padding: 10px 30px;
    border-radius: 100px;
    font-size: 0.8rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 3px;
    margin-bottom: 30px;
    backdrop-filter: blur(20px);
    animation: fadeInUp 1s ease-out;
}

.story-title {
    font-size: clamp(3.5rem, 9vw, 6.5rem);
    font-weight: 950;
    color: #fff;
    line-height: 0.95;
    letter-spacing: -4px;
    margin-bottom: 30px;
}

.story-title span {
    background: linear-gradient(135deg, var(--cl-pink-light), #fff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.cl-hero-desc {
    font-size: 1.25rem;
    color: rgba(255,255,255,0.7);
    max-width: 650px;
    line-height: 1.7;
    margin-bottom: 50px;
    font-weight: 300;
}

/* ---- PREMIUM CARDS ---- */
.service-hub-card {
    background: var(--cl-glass);
    padding: 60px 45px;
    border-radius: 40px;
    border: 1px solid rgba(255, 255, 255, 0.5);
    box-shadow: 0 10px 40px rgba(0,0,0,0.02);
    transition: var(--cl-transition);
    height: 100%;
    position: relative;
    backdrop-filter: blur(15px);
}

.service-hub-card:hover {
    transform: translateY(-15px) scale(1.02);
    background: #fff;
    border-color: rgba(192, 42, 124, 0.1);
    box-shadow: var(--cl-shadow);
}

.icon-box {
    width: 75px; height: 75px;
    background: #fff5f9;
    border-radius: 24px;
    display: flex; align-items: center; justify-content: center;
    color: var(--cl-pink);
    font-size: 2rem;
    margin-bottom: 30px;
    transition: 0.4s;
}

.service-hub-card:hover .icon-box {
    background: var(--cl-pink);
    color: #fff;
    transform: rotate(10deg);
}

/* ---- STRIPS (SEGMENTS) ---- */
.cl-solutions {
    padding: 150px 0;
    background: var(--cl-plum-deep);
    color: #fff;
}

.cl-strips-wrapper {
    display: flex;
    gap: 20px;
    height: 650px;
    margin-top: 80px;
}

.cl-strip {
    position: relative;
    flex: 1;
    border-radius: 50px;
    overflow: hidden;
    cursor: pointer;
    transition: flex 1s cubic-bezier(0.23, 1, 0.32, 1);
    border: 1px solid rgba(255,255,255,0.05);
}

.cl-strip:hover {
    flex: 4;
    border-color: rgba(192, 42, 124, 0.3);
}

.cl-strip-img {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    filter: grayscale(0.5) brightness(0.6);
    transition: transform 1.5s var(--cl-transition), filter 1s ease;
}

.cl-strip:hover .cl-strip-img {
    filter: grayscale(0) brightness(0.8);
    transform: scale(1.08);
}

.cl-strip-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(26,5,17,0.95) 0%, transparent 60%);
    padding: 50px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out 0.2s;
}

.cl-strip:hover .cl-strip-overlay {
    opacity: 1;
    transform: translateY(0);
}

.cl-strip-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 15px 35px;
    background: var(--cl-pink);
    color: #fff;
    border-radius: 100px;
    font-size: 0.9rem;
    font-weight: 800;
    text-decoration: none !important;
    margin-top: 25px;
    width: fit-content;
}

.cl-strip-vertical-title {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%) rotate(-90deg);
    white-space: nowrap;
    font-size: 1.6rem;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 6px;
    opacity: 0.5;
    transition: 0.4s ease;
    pointer-events: none;
    color: #fff;
}

.cl-strip:hover .cl-strip-vertical-title {
    opacity: 0;
}

/* ---- SIDEBAR & PANELS ---- */
.cl-services {
    padding: 150px 0;
    background: var(--cl-bg-light);
}

.cl-sidebar {
    background: #fff;
    padding: 45px;
    border-radius: 50px;
    box-shadow: 0 30px 60px rgba(0,0,0,0.03);
    border: 1px solid rgba(192, 42, 124, 0.08);
    position: sticky;
    top: 120px;
    transition: var(--cl-transition);
}

.cl-nav-link {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 22px 30px;
    border-radius: 20px;
    color: var(--cl-text-muted);
    font-weight: 800;
    transition: var(--cl-transition);
    margin-bottom: 12px;
    text-decoration: none !important;
}

.cl-nav-link.active {
    background: var(--cl-plum);
    color: #fff;
    box-shadow: 0 15px 30px rgba(45, 10, 28, 0.2);
}

.cl-detail-card {
    background: #fff;
    border-radius: 60px;
    overflow: hidden;
    box-shadow: var(--cl-shadow);
    border: 1px solid rgba(45,10,28,0.03);
    animation: slideInRight 0.8s var(--cl-transition);
}

/* Animations */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}
@keyframes slideInRight {
    from { opacity: 0; transform: translateX(50px); }
    to { opacity: 1; transform: translateX(0); }
}

/* ---- IMMERSIVE MODALS ---- */
.cl-modal {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 10000;
    background: rgba(26,5,17,0.98);
    align-items: center; justify-content: center;
    padding: 20px;
    opacity: 0;
    transition: opacity 0.6s ease;
    backdrop-filter: blur(10px);
}

.cl-modal.active {
    opacity: 1;
}

.cl-modal-container {
    background: #fff;
    width: 100%; 
    max-width: 1000px;
    max-height: 85vh;
    border-radius: 40px;
    overflow-y: auto;
    overflow-x: hidden;
    position: relative;
    transform: translateY(40px);
    transition: transform 0.8s cubic-bezier(0.165, 0.84, 0.44, 1);
    box-shadow: 0 50px 100px rgba(0,0,0,0.5);
    border: 1px solid rgba(255,255,255,0.1);
}

.cl-modal.active .cl-modal-container {
    transform: translateY(0);
}

.cl-modal-container::-webkit-scrollbar {
    width: 8px;
}
.cl-modal-container::-webkit-scrollbar-thumb {
    background: rgba(192, 42, 124, 0.2);
    border-radius: 10px;
}

.cl-modal-close {
    position: absolute;
    top: 25px; right: 25px;
    width: 45px; height: 45px;
    background: #fff;
    border: none;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: var(--cl-plum);
    font-size: 1.2rem;
    cursor: pointer;
    z-index: 100;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: 0.3s;
}

.cl-modal-close:hover {
    transform: rotate(90deg);
    background: var(--cl-pink);
    color: #fff;
}

.cl-feature-tile {
    background: #fdfafd;
    border-radius: 25px;
    padding: 25px;
    border: 1px solid rgba(192, 42, 124, 0.05);
    transition: 0.3s;
}

.cl-feature-tile:hover {
    background: #fff;
    border-color: var(--cl-pink);
    transform: translateY(-5px);
}

@media (max-width: 991px) {
    .cl-hero { height: auto; padding: 180px 0 100px; }
    .story-title { font-size: 4rem; letter-spacing: -2px; }
    .cl-strips-wrapper { height: auto; flex-direction: column; }
    .cl-strip { height: 200px; }
    .cl-strip:hover { height: 500px; }
    .cl-modal-container { border-radius: 30px; }
}
</style>

<body class="cl-body">
    <!-- Premium Ambient Layer -->
    <div class="cl-ambient">
        <div class="cl-glow cl-glow-1"></div>
        <div class="cl-glow cl-glow-2"></div>
    </div>

    <?php include 'component/navbar.php'; ?>

    <!-- ===== PREMIUM HERO ===== -->
    <section class="cl-hero">
        <video autoplay muted loop playsinline class="cl-hero-video">
            <source src="rkimg/Commercial_Leasing_Advisory.webm" type="video/webm">
        </video>
        <div class="cl-hero-overlay"></div>
        <div class="container cl-hero-content">
            <div class="row">
                <div class="col-lg-10" data-aos="fade-up">
                    <div class="cl-badge">Workspace Intelligence</div>
                    <h1 class="story-title">Bridging <span>Ambition</span> & Workspace</h1>
                    <p class="cl-hero-desc">Bespoke workspace strategies and deep market intelligence. We engineer operational excellence for global leaders and emerging enterprises alike.</p>
                    <div class="d-flex gap-3">
                        <a href="#showw" class="btn btn-primary px-5 py-3 rounded-pill fw-bold" style="background-color: var(--cl-pink); border: none;">Initiate Strategy Session</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== ADVISORY CORE ===== -->
    <section class="py-5 bg-white position-relative overflow-hidden">
        <div class="container py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <div class="cl-badge">The Strategy</div>
                <h2 class="fw-bold mb-4" style="font-size: 3.5rem;">Operational <span style="color: var(--cl-pink);">Excellence</span></h2>
                <div class="mx-auto" style="width: 80px; height: 4px; background: var(--cl-pink); border-radius: 2px; margin-bottom: 30px;"></div>
                <p class="text-muted mx-auto" style="max-width: 850px; font-size: 1.25rem; font-weight: 300;">
                    Moving beyond standard space sourcing, we provide a holistic Solutions Framework that aligns real estate with global talent and growth targets.
                </p>
            </div>

            <div class="row g-5" data-aos="fade-up" data-aos-delay="200">
                <div class="col-md-4">
                    <div class="service-hub-card text-center">
                        <div class="icon-box mx-auto"><i class="bi bi-rocket-takeoff"></i></div>
                        <h4 class="fw-bold mb-4" style="font-size: 1.5rem;">Advisory-First</h4>
                        <p class="text-muted" style="line-height: 1.8;">Building long-term portfolios through proprietary data and multi-market foresight.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-hub-card text-center">
                        <div class="icon-box mx-auto"><i class="bi bi-graph-up-arrow"></i></div>
                        <h4 class="fw-bold mb-4" style="font-size: 1.5rem;">Precision Analytics</h4>
                        <p class="text-muted" style="line-height: 1.8;">Leveraging deep-market metrics to pinpoint spaces that maximize operational yield.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-hub-card text-center">
                        <div class="icon-box mx-auto"><i class="bi bi-buildings"></i></div>
                        <h4 class="fw-bold mb-4" style="font-size: 1.5rem;">Global Reach</h4>
                        <p class="text-muted" style="line-height: 1.8;">Elite reputation for managing complex high-value transactions across the globe.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== WORKPLACE DESK ===== -->
    <section class="cl-services">
        <div class="container">
            <div class="row mb-5" data-aos="fade-up">
                <div class="col-lg-8">
                    <div class="cl-badge">Solutions Hub</div>
                    <h2 class="fw-bold" style="font-size: 2.5rem;">What We Can Do <span style="color: var(--cl-pink);">For You</span></h2>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-lg-4" data-aos="fade-right">
                    <aside class="cl-sidebar">
                        <h4 class="fw-bold mb-3">Workplace Desk</h4>
                        <p class="small text-muted mb-4">Aligning organizational goals with optimized real estate.</p>
                        <div class="cl-nav-links">
                            <a href="javascript:void(0)" class="cl-nav-link active" onclick="switchDetailCard('leasing', this)">
                                <i class="fa fa-key me-2"></i> Leasing Services
                            </a>
                            <a href="javascript:void(0)" class="cl-nav-link" onclick="switchDetailCard('transaction', this)">
                                <i class="fa fa-exchange me-2"></i> Transaction Mgmt
                            </a>
                            <a href="javascript:void(0)" class="cl-nav-link" onclick="switchDetailCard('advisory', this)">
                                <i class="fa fa-shield me-2"></i> Advisory Services
                            </a>
                        </div>
                    </aside>
                </div>

                <div class="col-lg-8" data-aos="fade-left">
                    <div class="cl-content">
                        <!-- LEASING -->
                        <div class="cl-detail-card active" id="leasing">
                            <div class="position-relative overflow-hidden" style="height: 350px;">
                                <img src="rkimg/Leasing_Services.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Leasing">
                            </div>
                            <div class="p-5">
                                <h3 class="fw-bold mb-3">Strategic Sourcing</h3>
                                <p class="text-muted mb-4">We pinpoint high-value locations that optimize both brand presence and operational logistics.</p>
                                <div class="row g-2 mb-4">
                                    <div class="col-6 small fw-bold"><i class="fa fa-check text-primary me-2" style="color: var(--cl-pink) !important;"></i> Market Advisory</div>
                                    <div class="col-6 small fw-bold"><i class="fa fa-check text-primary me-2" style="color: var(--cl-pink) !important;"></i> Deal Engineering</div>
                                    <div class="col-6 small fw-bold"><i class="fa fa-check text-primary me-2" style="color: var(--cl-pink) !important;"></i> Site Selection</div>
                                    <div class="col-6 small fw-bold"><i class="fa fa-check text-primary me-2" style="color: var(--cl-pink) !important;"></i> Lease Audits</div>
                                </div>
                                <a href="#showw" class="btn btn-primary rounded-pill px-4" style="background-color: var(--cl-pink); border: none;">Request Space Sourcing</a>
                            </div>
                        </div>

                        <!-- TRANSACTION -->
                        <div class="cl-detail-card" id="transaction" style="display:none;">
                            <div class="position-relative overflow-hidden" style="height: 350px;">
                                <img src="rkimg/Transaction_Managementery.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Transaction">
                            </div>
                            <div class="p-5">
                                <h3 class="fw-bold mb-3">Portfolio Management</h3>
                                <p class="text-muted mb-4">Engineering institutions-grade transactions across diverse geographies with precision-based planning.</p>
                                <a href="#showw" class="btn btn-primary rounded-pill px-4" style="background-color: var(--cl-pink); border: none;">Manage Transactions</a>
                            </div>
                        </div>

                        <!-- ADVISORY -->
                        <div class="cl-detail-card" id="advisory" style="display:none;">
                            <div class="position-relative overflow-hidden" style="height: 350px;">
                                <img src="rkimg/Advisory_Servicesery.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Advisory">
                            </div>
                            <div class="p-5">
                                <h3 class="fw-bold mb-3">Bespoke Advisory</h3>
                                <p class="text-muted mb-4">Designing future-ready agile workspaces through deep-market intelligence and efficiency studies.</p>
                                <a href="#showw" class="btn btn-primary rounded-pill px-4" style="background-color: var(--cl-pink); border: none;">Consult Strategy</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== PREMIUM SOLUTIONS STRIPS ===== -->
    <section class="cl-solutions">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="cl-badge">Segments</div>
                <h2 class="fw-bold text-white mb-3" style="font-size: 2.5rem;">Tailored Asset <span style="color: var(--cl-pink-light);">Strategy</span></h2>
                <p style="color:rgba(255,255,255,0.6); max-width:600px; margin:0 auto;">Leveraging deep specialization across every niche of commercial real estate.</p>
            </div>

            <div class="cl-strips-wrapper" data-aos="fade-up">
                <!-- 1. Large Corps -->
                <div class="cl-strip" onclick="openClModal(1)">
                    <img src="rkimg/Large-Corporations.jpg" class="cl-strip-img" alt="Corporations">
                    <div class="cl-strip-vertical-title">Corporations</div>
                    <div class="cl-strip-overlay">
                        <h3 class="fw-bold mb-2">Large Corporations</h3>
                        <p class="small opacity-75 mb-4">Strategic portfolio management for global leaders.</p>
                        <a href="javascript:void(0)" class="cl-strip-btn">View Strategy <i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 2. Startups -->
                <div class="cl-strip" onclick="openClModal(2)">
                    <img src="rkimg/Start-ups_and_Small_Businesses.jpg" class="cl-strip-img" alt="Startups">
                    <div class="cl-strip-vertical-title">SMEs & Startups</div>
                    <div class="cl-strip-overlay">
                        <h3 class="fw-bold mb-2">SMEs & Startups</h3>
                        <p class="small opacity-75 mb-4">Agile leasing models designed to scale with expansion.</p>
                        <a href="javascript:void(0)" class="cl-strip-btn">View Strategy <i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 3. Flexible -->
                <div class="cl-strip" onclick="openClModal(3)">
                    <img src="rkimg/Flexible_Office_Spaces.jpg" class="cl-strip-img" alt="Flexible">
                    <div class="cl-strip-vertical-title">Agile Space</div>
                    <div class="cl-strip-overlay">
                        <h3 class="fw-bold mb-2">Agile & Flexible</h3>
                        <p class="small opacity-75 mb-4">Managed workspace solutions for modern enterprise agility.</p>
                        <a href="javascript:void(0)" class="cl-strip-btn">View Strategy <i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 4. GCC -->
                <div class="cl-strip" onclick="openClModal(4)">
                    <img src="rkimg/Shared_Service_Centres.jpg" class="cl-strip-img" alt="GCC">
                    <div class="cl-strip-vertical-title">GCC Hubs</div>
                    <div class="cl-strip-overlay">
                        <h3 class="fw-bold mb-2">GCC Centres</h3>
                        <p class="small opacity-75 mb-4">Strategic site selection for global delivery excellence.</p>
                        <a href="javascript:void(0)" class="cl-strip-btn">View Strategy <i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 5. Built-to-suit -->
                <div class="cl-strip" onclick="openClModal(5)">
                    <img src="rkimg/Built-to-suit_Campuses.jpg" class="cl-strip-img" alt="Campuses">
                    <div class="cl-strip-vertical-title">Built-to-Suit</div>
                    <div class="cl-strip-overlay">
                        <h3 class="fw-bold mb-2">Built-to-Suit</h3>
                        <p class="small opacity-75 mb-4">Bespoke campus lifecycle management from blueprint to operation.</p>
                        <a href="javascript:void(0)" class="cl-strip-btn">View Strategy <i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                </div>

                <!-- 6. Data Centres -->
                <div class="cl-strip" onclick="openClModal(6)">
                    <img src="rkimg/Data_Centres.jpg" class="cl-strip-img" alt="Data Centers">
                    <div class="cl-strip-vertical-title">Infrastructure</div>
                    <div class="cl-strip-overlay">
                        <h3 class="fw-bold mb-2">Data Centres</h3>
                        <p class="small opacity-75 mb-4">Mission-critical advisory for the digital economy backbone.</p>
                        <a href="javascript:void(0)" class="cl-strip-btn">View Strategy <i class="fa fa-chevron-right ms-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FUTURISTIC CTA ===== -->
    <section class="py-5" style="background: #fff;">
        <div class="container py-5">
            <div class="p-5 rounded-5 text-center position-relative overflow-hidden" style="background: var(--cl-plum-deep); color: #fff;">
                <h2 class="fw-bold mb-4" style="font-size: 3rem;">Accelerate Your <span style="color: var(--cl-pink-light);">Workspace Journey</span></h2>
                <p class="opacity-75 mb-5 mx-auto" style="max-width: 700px;">Equip your organization with future-ready agile spaces designed for growth, talent retention, and operational scalability.</p>
                <a href="#showw" class="btn btn-primary px-5 py-3 rounded-pill fw-bold" style="background-color: var(--cl-pink); border: none;">Book Strategy Session</a>
            </div>
        </div>
    </section>

    <!-- ===== IMMERSIVE MODALS ===== -->
    <!-- Modal 1: Corporations -->
    <div class="cl-modal" id="cl-modal1">
        <div class="cl-modal-container">
            <button class="cl-modal-close" onclick="closeClModal()"><i class="fa fa-times"></i></button>
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="rkimg/Large-Corporations.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Corporations">
                </div>
                <div class="col-lg-7 p-5">
                    <div class="cl-badge mb-3">Enterprise</div>
                    <h2 class="fw-bold mb-4">Large Corporations</h2>
                    <p class="text-muted mb-5">Strategic portfolio management and site selection for global industry leaders.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-briefcase mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Managed Portfolio</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-line-chart mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Efficiency Analytics</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2: SMEs -->
    <div class="cl-modal" id="cl-modal2">
        <div class="cl-modal-container">
            <button class="cl-modal-close" onclick="closeClModal()"><i class="fa fa-times"></i></button>
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="rkimg/Start-ups_and_Small_Businesses.jpg" style="width:100%; height:100%; object-fit:cover;" alt="SMEs">
                </div>
                <div class="col-lg-7 p-5">
                    <div class="cl-badge mb-3">Growth</div>
                    <h2 class="fw-bold mb-4">SMEs & Startups</h2>
                    <p class="text-muted mb-5">Agile leasing models designed to scale as fast as your business growth.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-bolt mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Agile Leasing</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-rocket mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Rapid Expansion</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- (Adding similar modals for 3-6) -->
    <!-- Modal 3: Agile Space -->
    <div class="cl-modal" id="cl-modal3">
        <div class="cl-modal-container">
            <button class="cl-modal-close" onclick="closeClModal()"><i class="fa fa-times"></i></button>
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="rkimg/Flexible_Office_Spaces.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Agile">
                </div>
                <div class="col-lg-7 p-5">
                    <div class="cl-badge mb-3">Agile Solution</div>
                    <h2 class="fw-bold mb-4">Agile & Flexible Spaces</h2>
                    <p class="text-muted mb-5">Managed workspace solutions that combine luxury hospitality with enterprise utility.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-refresh mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Hybrid Ready</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-arrows-alt mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Dynamic Scale</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 4: GCC Hubs -->
    <div class="cl-modal" id="cl-modal4">
        <div class="cl-modal-container">
            <button class="cl-modal-close" onclick="closeClModal()"><i class="fa fa-times"></i></button>
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="rkimg/Shared_Service_Centres.jpg" style="width:100%; height:100%; object-fit:cover;" alt="GCC">
                </div>
                <div class="col-lg-7 p-5">
                    <div class="cl-badge mb-3">Global Hubs</div>
                    <h2 class="fw-bold mb-4">GCC Centres</h2>
                    <p class="text-muted mb-5">Strategic site selection for global delivery excellence and delivery centers.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-shield mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Data Compliance</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-users mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Labour Analytics</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 5: Built-to-Suit -->
    <div class="cl-modal" id="cl-modal5">
        <div class="cl-modal-container">
            <button class="cl-modal-close" onclick="closeClModal()"><i class="fa fa-times"></i></button>
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="rkimg/Built-to-suit_Campuses.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Campus">
                </div>
                <div class="col-lg-7 p-5">
                    <div class="cl-badge mb-3">Custom Built</div>
                    <h2 class="fw-bold mb-4">Built-to-Suit</h2>
                    <p class="text-muted mb-5">Bespoke campus lifecycle management from blueprint to operations.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-pencil mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Bespoke Design</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-leaf mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">ESG Integration</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 6: Data Centres -->
    <div class="cl-modal" id="cl-modal6">
        <div class="cl-modal-container">
            <button class="cl-modal-close" onclick="closeClModal()"><i class="fa fa-times"></i></button>
            <div class="row g-0">
                <div class="col-lg-5 d-none d-lg-block">
                    <img src="rkimg/Data_Centres.jpg" style="width:100%; height:100%; object-fit:cover;" alt="Infrastructure">
                </div>
                <div class="col-lg-7 p-5">
                    <div class="cl-badge mb-3">Digital Backbone</div>
                    <h2 class="fw-bold mb-4">Data Centres</h2>
                    <p class="text-muted mb-5">Mission-critical facility advisory for the backbone of modern digital scale.</p>
                    <div class="row g-4">
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-server mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Scalable Power</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="cl-feature-tile">
                                <i class="fa fa-signal mb-2" style="color:var(--cl-pink);"></i>
                                <h6 class="fw-bold mb-0">Connectivity</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

    <script>
    function switchDetailCard(id, btn) {
        document.querySelectorAll('.cl-nav-link').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.cl-detail-card').forEach(el => {
            el.classList.remove('active');
            el.style.display = 'none';
        });
        
        btn.classList.add('active');
        const card = document.getElementById(id);
        card.style.display = 'block';
        setTimeout(() => card.classList.add('active'), 10);

        if(window.innerWidth < 992) {
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    function openClModal(id) {
        const modal = document.getElementById('cl-modal' + id);
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('active'), 10);
        document.body.style.overflow = 'hidden';
    }

    function closeClModal() {
        document.querySelectorAll('.cl-modal').forEach(el => {
            el.classList.remove('active');
            setTimeout(() => el.style.display = 'none', 600);
        });
        document.body.style.overflow = 'auto';
    }

    window.onclick = function(event) {
        if (event.target.classList.contains('cl-modal')) closeClModal();
    }
    </script>

</body>
</html>
