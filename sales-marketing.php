<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== SALES & MARKETING PAGE STYLES ===== */

/* --- Hero Section --- */
.sm-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0d0516;
}

.sm-hero-video {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.35;
    z-index: 0;
}

.sm-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(13,5,22,0.92) 0%, rgba(45,10,28,0.75) 50%, rgba(192,42,124,0.15) 100%);
    z-index: 1;
}

.sm-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
}

.sm-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192, 42, 124, 0.15);
    border: 1px solid rgba(192, 42, 124, 0.4);
    color: #ff85c0;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 28px;
    backdrop-filter: blur(10px);
}

.sm-hero-badge span {
    width: 6px;
    height: 6px;
    background: #ff85c0;
    border-radius: 50%;
    animation: pulse-dot 1.5s infinite;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.4; transform: scale(0.7); }
}

.sm-hero-title {
    font-size: clamp(2.8rem, 6vw, 5.5rem);
    font-weight: 900;
    line-height: 1.05;
    color: #fff;
    letter-spacing: -2px;
    margin-bottom: 24px;
}

.sm-hero-title .highlight {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.sm-hero-desc {
    font-size: 1.15rem;
    color: rgba(255,255,255,0.7);
    max-width: 560px;
    line-height: 1.8;
    margin-bottom: 40px;
}

.sm-hero-btns {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.btn-sm-primary {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    color: #fff;
    border: none;
    padding: 16px 36px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.4s ease;
    box-shadow: 0 10px 30px rgba(192, 42, 124, 0.35);
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-sm-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(192, 42, 124, 0.5);
    color: #fff;
}

.btn-sm-outline {
    background: transparent;
    color: #fff;
    border: 2px solid rgba(255,255,255,0.3);
    padding: 14px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    backdrop-filter: blur(10px);
}

.btn-sm-outline:hover {
    border-color: #ff85c0;
    color: #ff85c0;
    transform: translateY(-3px);
}

/* Hero Stats */
.sm-hero-stats {
    display: flex;
    gap: 40px;
    padding-top: 60px;
    border-top: 1px solid rgba(255,255,255,0.1);
    margin-top: 60px;
}

.sm-stat-item {
    text-align: center;
}

.sm-stat-num {
    font-size: 2.2rem;
    font-weight: 900;
    color: #ff85c0;
    line-height: 1;
    margin-bottom: 6px;
}

.sm-stat-label {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.5);
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* Hero right image/card */
.sm-hero-card {
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 24px;
    overflow: hidden;
    height: 480px;
    position: relative;
}

.sm-hero-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.85;
}

.sm-hero-card-tag {
    position: absolute;
    bottom: 24px;
    left: 24px;
    right: 24px;
    background: rgba(13,5,22,0.85);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(192,42,124,0.3);
    border-radius: 16px;
    padding: 20px;
}

.sm-hero-card-tag h4 {
    color: #fff;
    font-weight: 700;
    font-size: 1rem;
    margin-bottom: 6px;
}

.sm-hero-card-tag p {
    color: rgba(255,255,255,0.6);
    font-size: 0.82rem;
    margin: 0;
}

/* ===== WHAT WE OFFER SECTION ===== */
.sm-offer-section {
    padding: 100px 0;
    background: #fff;
}

.sm-section-badge {
    display: inline-block;
    background: #fce7f3;
    color: #c02a7c;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.sm-section-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 800;
    color: #2d0a1c;
    line-height: 1.2;
    margin-bottom: 16px;
}

.sm-section-title span {
    color: #c02a7c;
}

.sm-section-desc {
    color: #8e6f7e;
    font-size: 1.05rem;
    line-height: 1.8;
    max-width: 540px;
}

/* Service Cards */
.sm-service-card {
    background: #fff;
    border: 1px solid #f1e8ef;
    border-radius: 20px;
    padding: 36px 32px;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    cursor: pointer;
}

.sm-service-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, #ff85c0, #c02a7c);
    transform: scaleX(0);
    transition: transform 0.4s ease;
    transform-origin: left;
}

.sm-service-card:hover::before {
    transform: scaleX(1);
}

.sm-service-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(192, 42, 124, 0.12);
    border-color: #f8d0e8;
}

.sm-serv-icon {
    width: 64px;
    height: 64px;
    background: linear-gradient(135deg, #fce7f3, #f9d0e8);
    border-radius: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.6rem;
    margin-bottom: 24px;
    transition: all 0.3s ease;
}

.sm-service-card:hover .sm-serv-icon {
    background: linear-gradient(135deg, #c02a7c, #ff85c0);
    transform: rotate(-5deg) scale(1.1);
}

.sm-service-card:hover .sm-serv-icon i {
    color: #fff !important;
}

.sm-serv-title {
    font-size: 1.15rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 12px;
}

.sm-serv-desc {
    color: #8e6f7e;
    font-size: 0.92rem;
    line-height: 1.7;
    margin-bottom: 20px;
}

.sm-serv-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.sm-tag {
    background: #fce7f3;
    color: #c02a7c;
    padding: 4px 12px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
}

/* ===== INTERACTIVE TAB SECTION ===== */
.sm-tab-section {
    padding: 100px 0;
    background: #fff5f9;
}

.sm-tabs-nav {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.sm-tab-btn {
    background: #fff;
    border: 1px solid #f1e8ef;
    border-radius: 14px;
    padding: 18px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-align: left;
    width: 100%;
}

.sm-tab-btn:hover {
    border-color: #f8d0e8;
    transform: translateX(5px);
}

.sm-tab-btn.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    border-color: #c02a7c;
    transform: translateX(5px);
    box-shadow: 0 10px 25px rgba(192, 42, 124, 0.25);
}

.sm-tab-btn-icon {
    width: 44px;
    height: 44px;
    background: #fce7f3;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    color: #c02a7c;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.sm-tab-btn.active .sm-tab-btn-icon {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

.sm-tab-btn-text h5 {
    font-size: 0.95rem;
    font-weight: 700;
    color: #2d0a1c;
    margin: 0 0 4px;
    transition: color 0.3s;
}

.sm-tab-btn.active .sm-tab-btn-text h5 {
    color: #fff;
}

.sm-tab-btn-text p {
    font-size: 0.78rem;
    color: #8e6f7e;
    margin: 0;
    transition: color 0.3s;
}

.sm-tab-btn.active .sm-tab-btn-text p {
    color: rgba(255,255,255,0.7);
}

/* Tab Content */
.sm-tab-content-area {
    position: relative;
}

.sm-tab-panel {
    display: none;
    animation: fadeSlideIn 0.4s ease;
}

.sm-tab-panel.active {
    display: block;
}

@keyframes fadeSlideIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.sm-panel-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(45,10,28,0.08);
}

.sm-panel-img {
    height: 300px;
    overflow: hidden;
    position: relative;
}

.sm-panel-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.sm-panel-card:hover .sm-panel-img img {
    transform: scale(1.05);
}

.sm-panel-img-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(13,5,22,0.7), transparent 60%);
}

.sm-panel-body {
    padding: 36px;
}

.sm-panel-body h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #2d0a1c;
    margin-bottom: 16px;
}

.sm-panel-list {
    list-style: none;
    padding: 0;
    margin: 0 0 28px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.sm-panel-list li {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.92rem;
    color: #3a1d2e;
    font-weight: 500;
    padding: 10px 14px;
    background: #fff5f9;
    border-radius: 10px;
    border-left: 3px solid #c02a7c;
}

.sm-panel-list li i {
    color: #c02a7c;
    font-size: 0.85rem;
    flex-shrink: 0;
}

/* ===== STATS BAR ===== */
.sm-stats-bar {
    padding: 80px 0;
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 50%, #0d0516 100%);
    position: relative;
    overflow: hidden;
}

.sm-stats-bar::before {
    content: '';
    position: absolute;
    top: -50%;
    left: 50%;
    transform: translateX(-50%);
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(192,42,124,0.15) 0%, transparent 70%);
    pointer-events: none;
}

.sm-stat-card {
    text-align: center;
    padding: 40px 20px;
    position: relative;
}

.sm-stat-card::after {
    content: '';
    position: absolute;
    right: 0; top: 20%; bottom: 20%;
    width: 1px;
    background: rgba(255,255,255,0.08);
}

.sm-stat-card:last-child::after {
    display: none;
}

.sm-stat-icon {
    width: 56px;
    height: 56px;
    background: rgba(192,42,124,0.15);
    border: 1px solid rgba(192,42,124,0.3);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 1.3rem;
    color: #ff85c0;
}

.sm-stat-big {
    font-size: clamp(2.2rem, 4vw, 3.2rem);
    font-weight: 900;
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 8px;
}

.sm-stat-lbl {
    color: rgba(255,255,255,0.6);
    font-size: 0.88rem;
    font-weight: 500;
    letter-spacing: 0.5px;
}

/* ===== APPROACH SECTION ===== */
.sm-approach {
    padding: 100px 0;
    background: #fff;
}

.sm-approach-step {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding: 32px;
    border-radius: 20px;
    transition: all 0.3s ease;
    position: relative;
}

.sm-approach-step::after {
    content: '';
    position: absolute;
    left: 55px;
    bottom: 0;
    width: 1px;
    height: 100%;
    border-left: 2px dashed #f8d0e8;
    z-index: 0;
}

.sm-approach-step:last-child::after {
    display: none;
}

.sm-approach-step:hover {
    background: #fff5f9;
}

.sm-step-num {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-weight: 900;
    font-size: 1.1rem;
    flex-shrink: 0;
    position: relative;
    z-index: 1;
    box-shadow: 0 8px 20px rgba(192,42,124,0.3);
}

.sm-step-body h4 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 8px;
}

.sm-step-body p {
    color: #8e6f7e;
    font-size: 0.92rem;
    line-height: 1.7;
    margin: 0;
}

/* ===== CTA SECTION ===== */
.sm-cta {
    padding: 100px 0;
    background: linear-gradient(135deg, #fce7f3 0%, #fff5f9 50%, #fce7f3 100%);
    position: relative;
    overflow: hidden;
}

.sm-cta::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(192,42,124,0.1), transparent);
    border-radius: 50%;
}

.sm-cta-box {
    background: linear-gradient(135deg, #2d0a1c, #1a0511);
    border-radius: 32px;
    padding: 70px 60px;
    position: relative;
    overflow: hidden;
    text-align: center;
}

.sm-cta-box::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(192,42,124,0.2), transparent);
    border-radius: 50%;
}

.sm-cta-box h2 {
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
}

.sm-cta-box h2 span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.sm-cta-box p {
    color: rgba(255,255,255,0.65);
    font-size: 1.05rem;
    margin-bottom: 40px;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

/* Responsive */
@media (max-width: 768px) {
    .sm-hero-stats { gap: 20px; flex-wrap: wrap; justify-content: center; }
    .sm-panel-list { grid-template-columns: 1fr; }
    .sm-cta-box { padding: 40px 24px; }
    .sm-tab-section .row { flex-direction: column-reverse; }
}
</style>

<body>
    <?php include 'component/navbar.php'; ?>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="sm-hero">
        <video autoplay muted loop playsinline class="sm-hero-video">
            <source src="rkimg/Sales_&_Marketing.webm" type="video/webm">
        </video>
        <div class="sm-hero-overlay"></div>

        <div class="container sm-hero-content">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="sm-hero-badge">
                        <span></span> Integrated Go-To-Market
                    </div>
                    <h1 class="sm-hero-title">
                        Sales &<br><span class="highlight">Marketing</span><br>Redefined.
                    </h1>
                    <p class="sm-hero-desc">
                        Crafting bespoke strategies and designing tailored campaigns to meet each client's unique requirements — from launch to final closure.
                    </p>
                    <div class="sm-hero-btns">
                        <a href="#showw" class="btn-sm-primary">
                            <i class="fa fa-handshake-o"></i> Let's Connect
                        </a>
                        <a href="#services" class="btn-sm-outline">
                            <i class="fa fa-arrow-down"></i> Explore Services
                        </a>
                    </div>

                    <div class="sm-hero-stats">
                        <div class="sm-stat-item">
                            <div class="sm-stat-num">6000+</div>
                            <div class="sm-stat-label">Client Relationships</div>
                        </div>
                        <div class="sm-stat-item">
                            <div class="sm-stat-num">14+</div>
                            <div class="sm-stat-label">Years Experience</div>
                        </div>
                        <div class="sm-stat-item">
                            <div class="sm-stat-num">100+</div>
                            <div class="sm-stat-label">Projects Delivered</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                    <div class="sm-hero-card">
                        <img src="rkimg/Sales_&_MarketingA.jpg" alt="Sales & Marketing I Kan Housing">
                        <div class="sm-hero-card-tag">
                            <h4>🚀 End-to-End Go-To-Market</h4>
                            <p>Strategic sales, marketing & communication — all under one roof.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section class="sm-offer-section" id="services">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="sm-section-badge">What We Offer</div>
                    <h2 class="sm-section-title">Integrated <span>Sales Solutions</span> for Developers</h2>
                    <p class="sm-section-desc">
                        We help our clients develop efficient sales and marketing strategies through comprehensive services, adapting to evolving market needs to maximize revenue.
                    </p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="row g-3 text-center">
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#fff5f9;">
                                <div style="font-size:1.8rem; margin-bottom:6px;">📊</div>
                                <div style="font-size:0.78rem; font-weight:600; color:#2d0a1c;">Market Analysis</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#fce7f3;">
                                <div style="font-size:1.8rem; margin-bottom:6px;">🎯</div>
                                <div style="font-size:0.78rem; font-weight:600; color:#2d0a1c;">Targeted Campaigns</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#fff5f9;">
                                <div style="font-size:1.8rem; margin-bottom:6px;">💼</div>
                                <div style="font-size:0.78rem; font-weight:600; color:#2d0a1c;">Channel Partners</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#fce7f3;">
                                <div style="font-size:1.8rem; margin-bottom:6px;">🏆</div>
                                <div style="font-size:0.78rem; font-weight:600; color:#2d0a1c;">Premium Clients</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#fff5f9;">
                                <div style="font-size:1.8rem; margin-bottom:6px;">📱</div>
                                <div style="font-size:0.78rem; font-weight:600; color:#2d0a1c;">Digital Outreach</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="p-3 rounded-3" style="background:#fce7f3;">
                                <div style="font-size:1.8rem; margin-bottom:6px;">🤝</div>
                                <div style="font-size:0.78rem; font-weight:600; color:#2d0a1c;">Closure Support</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Service Cards Grid -->
            <div class="row g-4 mt-3">
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="sm-service-card">
                        <div class="sm-serv-icon">
                            <i class="fa fa-search" style="color:#c02a7c;"></i>
                        </div>
                        <h4 class="sm-serv-title">Project Feasibility Study</h4>
                        <p class="sm-serv-desc">Deep-dive market intelligence to evaluate project viability before you invest — competition mapping, micromarket analysis & buyer profiling.</p>
                        <div class="sm-serv-tags">
                            <span class="sm-tag">Project Understanding</span>
                            <span class="sm-tag">Micromarket Analysis</span>
                            <span class="sm-tag">Competition Research</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="sm-service-card">
                        <div class="sm-serv-icon">
                            <i class="fa fa-line-chart" style="color:#c02a7c;"></i>
                        </div>
                        <h4 class="sm-serv-title">Sales Strategy</h4>
                        <p class="sm-serv-desc">From optimal pricing models to channel partner activation — we craft strategies that accelerate velocity and build pipeline momentum.</p>
                        <div class="sm-serv-tags">
                            <span class="sm-tag">Pricing Strategy</span>
                            <span class="sm-tag">Channel Partners</span>
                            <span class="sm-tag">Inventory Mgmt</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="sm-service-card">
                        <div class="sm-serv-icon">
                            <i class="fa fa-rocket" style="color:#c02a7c;"></i>
                        </div>
                        <h4 class="sm-serv-title">Go-To-Market Strategy</h4>
                        <p class="sm-serv-desc">Holistic launch blueprints — communication strategy, buyer sourcing, campaign planning & dimensioning for maximum market impact.</p>
                        <div class="sm-serv-tags">
                            <span class="sm-tag">Communication Plan</span>
                            <span class="sm-tag">Buyer Sourcing</span>
                            <span class="sm-tag">Campaign Design</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="sm-service-card">
                        <div class="sm-serv-icon">
                            <i class="fa fa-users" style="color:#c02a7c;"></i>
                        </div>
                        <h4 class="sm-serv-title">Affiliation Strategy</h4>
                        <p class="sm-serv-desc">Building loyalty ecosystems, smart customer segmentation and high-converting referral programs that drive organic, sustainable growth.</p>
                        <div class="sm-serv-tags">
                            <span class="sm-tag">Loyalty Programs</span>
                            <span class="sm-tag">Segmentation</span>
                            <span class="sm-tag">Referral Systems</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="sm-service-card">
                        <div class="sm-serv-icon">
                            <i class="fa fa-exchange" style="color:#c02a7c;"></i>
                        </div>
                        <h4 class="sm-serv-title">Transaction Management</h4>
                        <p class="sm-serv-desc">Tech-enabled transaction closure — from site visits & digitization to call centre support and final deal execution with zero friction.</p>
                        <div class="sm-serv-tags">
                            <span class="sm-tag">Tech Platform</span>
                            <span class="sm-tag">Site Visits</span>
                            <span class="sm-tag">Final Closure</span>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="sm-service-card" style="background: linear-gradient(135deg, #2d0a1c, #1a0511);">
                        <div class="sm-serv-icon" style="background: rgba(255,133,192,0.15);">
                            <i class="fa fa-star" style="color:#ff85c0;"></i>
                        </div>
                        <h4 class="sm-serv-title" style="color:#fff;">Competitive Edge</h4>
                        <p class="sm-serv-desc" style="color:rgba(255,255,255,0.65);">Our cutting-edge, tech-enabled solutions and accelerated sales velocity deliver improved cash flow and unparalleled market positioning..</p>
                        <a href="#showw" class="btn-sm-primary" style="font-size:0.88rem; padding:12px 24px; display:inline-flex; margin-top:8px;">
                            Get Started <i class="fa fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS BAR ===== -->
    <section class="sm-stats-bar">
        <div class="container">
            <div class="row g-0">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="sm-stat-card">
                        <div class="sm-stat-icon"><i class="fa fa-users"></i></div>
                        <div class="sm-stat-big">6000+</div>
                        <div class="sm-stat-lbl">Client Relationships</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="sm-stat-card">
                        <div class="sm-stat-icon"><i class="fa fa-building"></i></div>
                        <div class="sm-stat-big">100+</div>
                        <div class="sm-stat-lbl">Projects Delivered</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="sm-stat-card">
                        <div class="sm-stat-icon"><i class="fa fa-trophy"></i></div>
                        <div class="sm-stat-big">14+</div>
                        <div class="sm-stat-lbl">Years in Market</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="sm-stat-card">
                        <div class="sm-stat-icon"><i class="fa fa-handshake-o"></i></div>
                        <div class="sm-stat-big">5000+</div>
                        <div class="sm-stat-lbl">Satisfied Families</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== INTERACTIVE TAB SECTION ===== -->
    <section class="sm-tab-section" id="what-we-do">
        <div class="container">
            <div class="text-center mb-5">
                <div class="sm-section-badge">For Developers</div>
                <h2 class="sm-section-title">What We Can Do <span>For You</span></h2>
                <p class="text-muted mx-auto" style="max-width:500px;">An experienced, dependable team — your one-stop solution for end-to-end real estate sales excellence.</p>
            </div>

            <div class="row g-5 align-items-start">
                <!-- Tabs Nav -->
                <div class="col-lg-4" data-aos="fade-right">
                    <div class="sm-tabs-nav">
                        <button class="sm-tab-btn active" onclick="switchTab('study', this)">
                            <div class="sm-tab-btn-icon"><i class="fa fa-flask"></i></div>
                            <div class="sm-tab-btn-text">
                                <h5>Project Feasibility Study</h5>
                                <p>Market intelligence & viability</p>
                            </div>
                        </button>
                        <button class="sm-tab-btn" onclick="switchTab('strategy', this)">
                            <div class="sm-tab-btn-icon"><i class="fa fa-line-chart"></i></div>
                            <div class="sm-tab-btn-text">
                                <h5>Sales Strategy</h5>
                                <p>Pricing & channel activation</p>
                            </div>
                        </button>
                        <button class="sm-tab-btn" onclick="switchTab('market', this)">
                            <div class="sm-tab-btn-icon"><i class="fa fa-rocket"></i></div>
                            <div class="sm-tab-btn-text">
                                <h5>Go-To-Market Strategy</h5>
                                <p>Launch blueprints & campaigns</p>
                            </div>
                        </button>
                        <button class="sm-tab-btn" onclick="switchTab('affiliation', this)">
                            <div class="sm-tab-btn-icon"><i class="fa fa-users"></i></div>
                            <div class="sm-tab-btn-text">
                                <h5>Affiliation Strategy</h5>
                                <p>Loyalty & referral programs</p>
                            </div>
                        </button>
                        <button class="sm-tab-btn" onclick="switchTab('transaction', this)">
                            <div class="sm-tab-btn-icon"><i class="fa fa-exchange"></i></div>
                            <div class="sm-tab-btn-text">
                                <h5>Transaction Management</h5>
                                <p>Tech-enabled deal closure</p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="col-lg-8" data-aos="fade-left">
                    <div class="sm-tab-content-area">

                        <div class="sm-tab-panel active" id="tab-study">
                            <div class="sm-panel-card">
                                <div class="sm-panel-img">
                                    <img src="rkimg/Project_Feasibility_Study.jpg" alt="Project Feasibility Study">
                                    <div class="sm-panel-img-overlay"></div>
                                </div>
                                <div class="sm-panel-body">
                                    <h3>Project Feasibility Study</h3>
                                    <p style="color:#8e6f7e; margin-bottom:24px; font-size:0.95rem; line-height:1.75;">A thorough market intelligence exercise that determines your project's viability and positions it for maximum success before a single brick is laid.</p>
                                    <ul class="sm-panel-list">
                                        <li><i class="fa fa-check-circle"></i> Project Understanding</li>
                                        <li><i class="fa fa-check-circle"></i> Micromarket Analysis</li>
                                        <li><i class="fa fa-check-circle"></i> Competition Analysis</li>
                                        <li><i class="fa fa-check-circle"></i> Buyer Persona Research</li>
                                    </ul>
                                    <a href="#showw" class="btn-sm-primary" style="font-size:0.9rem; padding:14px 28px;">
                                        <i class="fa fa-phone"></i> Connect With Us
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="sm-tab-panel" id="tab-strategy">
                            <div class="sm-panel-card">
                                <div class="sm-panel-img">
                                    <img src="rkimg/Sales_Strategy.jpg" alt="Sales Strategy">
                                    <div class="sm-panel-img-overlay"></div>
                                </div>
                                <div class="sm-panel-body">
                                    <h3>Sales Strategy</h3>
                                    <p style="color:#8e6f7e; margin-bottom:24px; font-size:0.95rem; line-height:1.75;">End-to-end sales planning that maximizes inventory movement through intelligent pricing, channel activation and cross-selling opportunities.</p>
                                    <ul class="sm-panel-list">
                                        <li><i class="fa fa-check-circle"></i> Pricing Strategy</li>
                                        <li><i class="fa fa-check-circle"></i> Channel Partner Activation</li>
                                        <li><i class="fa fa-check-circle"></i> Domestic & Int'l Cross-Selling</li>
                                        <li><i class="fa fa-check-circle"></i> Inventory Management</li>
                                        <li><i class="fa fa-check-circle"></i> Customer Value Proposition</li>
                                    </ul>
                                    <a href="#showw" class="btn-sm-primary" style="font-size:0.9rem; padding:14px 28px;">
                                        <i class="fa fa-phone"></i> Connect With Us
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="sm-tab-panel" id="tab-market">
                            <div class="sm-panel-card">
                                <div class="sm-panel-img">
                                    <img src="rkimg/Go-To-Market_Strategy.jpg" alt="Go-To-Market Strategy">
                                    <div class="sm-panel-img-overlay"></div>
                                </div>
                                <div class="sm-panel-body">
                                    <h3>Go-To-Market Strategy</h3>
                                    <p style="color:#8e6f7e; margin-bottom:24px; font-size:0.95rem; line-height:1.75;">A comprehensive launch blueprint that aligns communication, buyer acquisition and campaign management for explosive market entry.</p>
                                    <ul class="sm-panel-list">
                                        <li><i class="fa fa-check-circle"></i> Communication Strategy</li>
                                        <li><i class="fa fa-check-circle"></i> Buyer Sourcing</li>
                                        <li><i class="fa fa-check-circle"></i> Campaign Planning</li>
                                        <li><i class="fa fa-check-circle"></i> Campaign Dimensioning</li>
                                    </ul>
                                    <a href="#showw" class="btn-sm-primary" style="font-size:0.9rem; padding:14px 28px;">
                                        <i class="fa fa-phone"></i> Connect With Us
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="sm-tab-panel" id="tab-affiliation">
                            <div class="sm-panel-card">
                                <div class="sm-panel-img">
                                    <img src="rkimg/Affiliation_Strategy.jpg" alt="Affiliation Strategy">
                                    <div class="sm-panel-img-overlay"></div>
                                </div>
                                <div class="sm-panel-body">
                                    <h3>Affiliation Strategy</h3>
                                    <p style="color:#8e6f7e; margin-bottom:24px; font-size:0.95rem; line-height:1.75;">Building lasting loyalty ecosystems that transform satisfied clients into brand advocates — driving organic, high-quality lead generation.</p>
                                    <ul class="sm-panel-list">
                                        <li><i class="fa fa-check-circle"></i> Loyalty Programs</li>
                                        <li><i class="fa fa-check-circle"></i> Customer Segmentation</li>
                                        <li><i class="fa fa-check-circle"></i> Referral Systems</li>
                                        <li><i class="fa fa-check-circle"></i> Partner Network</li>
                                    </ul>
                                    <a href="#showw" class="btn-sm-primary" style="font-size:0.9rem; padding:14px 28px;">
                                        <i class="fa fa-phone"></i> Connect With Us
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="sm-tab-panel" id="tab-transaction">
                            <div class="sm-panel-card">
                                <div class="sm-panel-img">
                                    <img src="rkimg/Transaction_Management.jpg" alt="Transaction Management">
                                    <div class="sm-panel-img-overlay"></div>
                                </div>
                                <div class="sm-panel-body">
                                    <h3>Transaction Management</h3>
                                    <p style="color:#8e6f7e; margin-bottom:24px; font-size:0.95rem; line-height:1.75;">Technology-powered transaction management that ensures seamless site experiences and friction-free closures every single time.</p>
                                    <ul class="sm-panel-list">
                                        <li><i class="fa fa-check-circle"></i> Technology Platform</li>
                                        <li><i class="fa fa-check-circle"></i> Call Centre Support</li>
                                        <li><i class="fa fa-check-circle"></i> Face-to-Face Meetings</li>
                                        <li><i class="fa fa-check-circle"></i> Final Transaction Closure</li>
                                        <li><i class="fa fa-check-circle"></i> Site Digitization</li>
                                        <li><i class="fa fa-check-circle"></i> Onsite Mobilization</li>
                                    </ul>
                                    <a href="#showw" class="btn-sm-primary" style="font-size:0.9rem; padding:14px 28px;">
                                        <i class="fa fa-phone"></i> Connect With Us
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== OUR APPROACH ===== -->
    <section class="sm-approach">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="sm-section-badge">Our Process</div>
                    <h2 class="sm-section-title">How We <span>Drive Results</span></h2>
                    <p class="sm-section-desc">A proven, structured methodology that takes your project from concept to complete sell-out with precision and efficiency.</p>
                    <div class="mt-4">
                        <img src="rkimg/sales-marketing1.png" alt="Our Approach" class="img-fluid rounded-4 shadow-sm">
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="sm-approach-step">
                        <div class="sm-step-num">01</div>
                        <div class="sm-step-body">
                            <h4>Discovery & Feasibility</h4>
                            <p>We begin with exhaustive project analysis — understanding the micromarket, competition landscape and buyer personas to build a solid foundation for your strategy.</p>
                        </div>
                    </div>
                    <div class="sm-approach-step">
                        <div class="sm-step-num">02</div>
                        <div class="sm-step-body">
                            <h4>Strategy & Blueprint</h4>
                            <p>Custom sales and marketing blueprints are crafted — pricing rationale, channel mix, inventory phasing and a go-to-market communication plan aligned to your goals.</p>
                        </div>
                    </div>
                    <div class="sm-approach-step">
                        <div class="sm-step-num">03</div>
                        <div class="sm-step-body">
                            <h4>Campaign Execution</h4>
                            <p>Multi-channel campaigns are launched with precision — digital outreach, events, channel partner activation and buyer sourcing at full throttle.</p>
                        </div>
                    </div>
                    <div class="sm-approach-step">
                        <div class="sm-step-num">04</div>
                        <div class="sm-step-body">
                            <h4>Transaction & Closure</h4>
                            <p>Supported by technology platforms, call centres and an on-ground team — we drive site visits to final closure with zero friction and maximum velocity.</p>
                        </div>
                    </div>
                    <div class="sm-approach-step">
                        <div class="sm-step-num">05</div>
                        <div class="sm-step-body">
                            <h4>Review & Optimize</h4>
                            <p>Continuous performance tracking and iterative strategy refinement ensures we keep adapting to market signals and consistently improving results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="sm-cta">
        <div class="container">
            <div class="sm-cta-box" data-aos="zoom-in">
                <div class="sm-section-badge" style="background:rgba(255,133,192,0.15); color:#ff85c0; margin-bottom:24px;">Ready to Scale?</div>
                <h2>Let's Build Your <span>Sales Engine</span> Together</h2>
                <p>Whether you're launching a new project or optimizing existing inventory — our team is ready to craft a winning strategy.</p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="#showw" class="btn-sm-primary">
                        <i class="fa fa-phone"></i> Book a Free Consultation
                    </a>
                    <a href="contact" class="btn-sm-outline" style="border-color: rgba(255,133,192,0.4); color:#ff85c0;">
                        <i class="fa fa-envelope"></i> Send Us a Message
                    </a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

    <script>
    // Tab switching function
    function switchTab(tabId, btn) {
        // Deactivate all tabs
        document.querySelectorAll('.sm-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.sm-tab-panel').forEach(p => p.classList.remove('active'));

        // Activate clicked
        btn.classList.add('active');
        document.getElementById('tab-' + tabId).classList.add('active');
    }

    // Counter animation
    function animateCounter(el) {
        const target = parseFloat(el.getAttribute('data-target'));
        const isFloat = target % 1 !== 0;
        const duration = 2000;
        const stepTime = 30;
        const steps = duration / stepTime;
        const increment = target / steps;
        let current = 0;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                current = target;
                clearInterval(timer);
            }
            el.textContent = (isFloat ? current.toFixed(1) : Math.floor(current)) + '+';
        }, stepTime);
    }

    // Intersection Observer for counter
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                const counters = entry.target.querySelectorAll('.sm-stat-big');
                counters.forEach(c => {
                    const text = c.textContent.replace(/[^0-9.]/g, '');
                    c.setAttribute('data-target', text);
                    animateCounter(c);
                });
            }
        });
    }, { threshold: 0.5 });

    const statsBar = document.querySelector('.sm-stats-bar');
    if (statsBar) observer.observe(statsBar);
    </script>

</body>
</html>