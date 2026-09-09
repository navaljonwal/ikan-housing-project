<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== RESIDENTIAL PAGE — PREMIUM STYLES ===== */

/* ---- HERO ---- */
.res-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514;
}

.res-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.32;
    z-index: 0;
}

.res-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,5,20,0.95) 0%, rgba(45,10,28,0.72) 55%, rgba(192,42,124,0.12) 100%);
    z-index: 1;
}

.res-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
    padding-bottom: 60px;
}

.res-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192,42,124,0.14);
    border: 1px solid rgba(192,42,124,0.38);
    color: #ff85c0;
    padding: 8px 22px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 28px;
    backdrop-filter: blur(10px);
}

.res-hero-badge .dot {
    width: 6px; height: 6px;
    background: #ff85c0;
    border-radius: 50%;
    animation: blink 1.6s infinite;
}

@keyframes blink {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:0.3; transform:scale(0.65); }
}

.res-hero-title {
    font-size: clamp(3rem, 6vw, 5.8rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.04;
    letter-spacing: -2.5px;
    margin-bottom: 24px;
}

.res-hero-title .grad {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.res-hero-desc {
    color: rgba(255,255,255,0.68);
    font-size: 1.12rem;
    line-height: 1.82;
    max-width: 540px;
    margin-bottom: 40px;
}

.res-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 15px 36px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.4s ease;
    box-shadow: 0 12px 32px rgba(192,42,124,0.35);
}

.res-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 45px rgba(192,42,124,0.5);
    color: #fff;
}

.res-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: transparent;
    color: rgba(255,255,255,0.85);
    border: 2px solid rgba(255,255,255,0.25);
    padding: 13px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
}

.res-btn-ghost:hover {
    border-color: #ff85c0;
    color: #ff85c0;
    transform: translateY(-3px);
}

/* Hero Stats */
.res-hero-stats {
    display: flex;
    gap: 0;
    margin-top: 64px;
    padding-top: 40px;
    border-top: 1px solid rgba(255,255,255,0.08);
}

.res-stat {
    flex: 1;
    padding-right: 32px;
    border-right: 1px solid rgba(255,255,255,0.08);
    margin-right: 32px;
}

.res-stat:last-child {
    border-right: none;
    margin-right: 0;
    padding-right: 0;
}

.res-stat-num {
    font-size: 2.5rem;
    font-weight: 900;
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1;
    margin-bottom: 6px;
}

.res-stat-lbl {
    font-size: 0.8rem;
    color: rgba(255,255,255,0.48);
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Hero Right Card */
.res-hero-img-card {
    border-radius: 26px;
    overflow: hidden;
    height: 490px;
    border: 1px solid rgba(255,255,255,0.1);
    position: relative;
}

.res-hero-img-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.88;
}

.res-hero-img-tag {
    position: absolute;
    bottom: 22px; left: 22px; right: 22px;
    background: rgba(10,5,20,0.82);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(192,42,124,0.3);
    border-radius: 16px;
    padding: 18px 22px;
}

.res-hero-img-tag h4 {
    color: #fff;
    font-weight: 700;
    font-size: 0.98rem;
    margin-bottom: 5px;
}

.res-hero-img-tag p {
    color: rgba(255,255,255,0.58);
    font-size: 0.82rem;
    margin: 0;
}

/* ---- STATS BAR ---- */
.res-stats-bar {
    padding: 70px 0;
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 60%, #0a0514 100%);
    position: relative;
    overflow: hidden;
}

.res-stats-bar::before {
    content: '';
    position: absolute;
    top: -80px; left: 50%;
    transform: translateX(-50%);
    width: 500px; height: 500px;
    background: radial-gradient(circle, rgba(192,42,124,0.15), transparent 65%);
    pointer-events: none;
}

.res-stat-card {
    text-align: center;
    padding: 30px 20px;
    position: relative;
}

.res-stat-card::after {
    content: '';
    position: absolute;
    right: 0; top: 20%; bottom: 20%;
    width: 1px;
    background: rgba(255,255,255,0.07);
}

.res-stat-card:last-child::after { display: none; }

.res-stat-icon {
    width: 52px; height: 52px;
    background: rgba(192,42,124,0.14);
    border: 1px solid rgba(192,42,124,0.28);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; color: #ff85c0;
    margin: 0 auto 18px;
}

.res-stat-big {
    font-size: clamp(2rem, 3.5vw, 3rem);
    font-weight: 900;
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    line-height: 1; margin-bottom: 8px;
}

.res-stat-label {
    color: rgba(255,255,255,0.55);
    font-size: 0.85rem;
    font-weight: 500;
}

/* ---- SECTION HELPERS ---- */
.res-badge {
    display: inline-block;
    background: #fce7f3;
    color: #c02a7c;
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 16px;
}

.res-section-title {
    font-size: clamp(1.9rem, 3.5vw, 2.9rem);
    font-weight: 800;
    color: #2d0a1c;
    line-height: 1.18;
    margin-bottom: 14px;
    letter-spacing: -0.5px;
}

.res-section-title span { color: #c02a7c; }

.res-section-desc {
    color: #8e6f7e;
    font-size: 1rem;
    line-height: 1.78;
}

/* ---- AUDIENCE TABS SECTION ---- */
.res-audience {
    padding: 96px 0;
    background: #fff;
}

/* Audience pill tabs */
.res-pill-tabs {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
    margin-bottom: 0;
    justify-content: flex-end;
}

.res-pill {
    background: #fff5f9;
    border: 1.5px solid #f1e8ef;
    color: #8e6f7e;
    padding: 9px 20px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    outline: none;
    display: flex;
    align-items: center;
    gap: 7px;
}

.res-pill.active,
.res-pill:hover {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    border-color: #c02a7c;
    color: #fff;
    box-shadow: 0 8px 20px rgba(192,42,124,0.22);
    transform: translateY(-2px);
}

@media (max-width: 991px) {
    .res-pill-tabs { justify-content: flex-start; margin-top: 20px; }
}

/* Audience wrapper — outer flex row */
.res-audience-panel {
    display: none;
}

.res-audience-panel.active {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 36px;
    align-items: start;
    animation: tabFadeIn 0.45s ease;
}

@keyframes tabFadeIn {
    from { opacity: 0; transform: translateY(14px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Sticky LEFT panel */
.res-audience-left {
    position: sticky;
    top: 100px;            /* below fixed navbar */
    background: #fff;
    border: 1px solid #f1e8ef;
    border-radius: 22px;
    padding: 28px 24px;
    box-shadow: 0 4px 20px rgba(45,10,28,0.05);
}

.res-audience-left h3 {
    font-size: 1.25rem;
    font-weight: 800;
    color: #2d0a1c;
    margin-bottom: 10px;
}

.res-audience-desc {
    color: #8e6f7e;
    font-size: 0.9rem;
    line-height: 1.75;
    margin-bottom: 22px;
    padding-bottom: 18px;
    border-bottom: 1px solid #f1e8ef;
}

.res-audience-links {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.res-audience-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 16px;
    background: #fff5f9;
    border: 1px solid #f1e8ef;
    border-radius: 12px;
    color: #2d0a1c;
    font-size: 0.88rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.res-audience-link i {
    width: 30px;
    height: 30px;
    background: #fce7f3;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #c02a7c;
    font-size: 0.78rem;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.res-audience-link:hover,
.res-audience-link.active-link {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    border-color: #c02a7c;
    color: #fff;
    transform: translateX(4px);
    box-shadow: 0 6px 18px rgba(192,42,124,0.22);
}

.res-audience-link:hover i,
.res-audience-link.active-link i {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

/* RIGHT: tabbed content column */
.res-audience-right {
    display: flex;
    flex-direction: column;
    gap: 20px;
    /* Removed max-height and overflow to allow tabbed interface */
    padding-right: 0;
}


/* Responsive */
@media (max-width: 991px) {
    .res-audience-panel.active {
        grid-template-columns: 1fr;
        gap: 24px;
    }
    .res-audience-left {
        position: static;
        padding: 22px 18px;
    }
    .res-audience-right {
        max-height: none;
        overflow-y: visible;
    }
}

/* Service detail card */
.res-detail-card {
    display: none;
    background: #fff;
    border: 1px solid #f1e8ef;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.35s ease;
    animation: resDetailFade 0.5s ease-out forwards;
}

.res-detail-card.active {
    display: block;
}

@keyframes resDetailFade {
    from { opacity: 0; transform: translateY(12px); }
    to { opacity: 1; transform: translateY(0); }
}


.res-detail-card:hover {
    box-shadow: 0 18px 45px rgba(192,42,124,0.1);
    border-color: #f4c6de;
    transform: translateY(-4px);
}

.res-detail-card-img {
    width: 100%;
    height: 210px;
    object-fit: cover;
    display: block;
    transition: transform 0.5s ease;
}

.res-detail-card:hover .res-detail-card-img {
    transform: scale(1.04);
}

.res-detail-card-img-wrap {
    overflow: hidden;
    position: relative;
}

.res-detail-card-img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(45,10,28,0.5), transparent 55%);
}

.res-detail-body {
    padding: 26px 28px;
}

.res-detail-body h3 {
    font-size: 1.2rem;
    font-weight: 800;
    color: #2d0a1c;
    margin-bottom: 12px;
}

.res-detail-body p {
    color: #8e6f7e;
    font-size: 0.92rem;
    line-height: 1.75;
    margin-bottom: 16px;
}

/* Business sub-cards */
.res-biz-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    margin-bottom: 20px;
}

.res-biz-item {
    background: #fff5f9;
    border-radius: 12px;
    padding: 14px 16px;
    border-left: 3px solid #c02a7c;
}

.res-biz-item h6 {
    font-size: 0.82rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 4px;
}

.res-biz-item p {
    font-size: 0.78rem;
    color: #8e6f7e;
    margin: 0;
    line-height: 1.5;
}

/* Developers list */
.res-dev-list {
    list-style: none;
    padding: 0; margin: 0 0 20px;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.res-dev-list li {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 0.89rem;
    color: #3a1d2e;
    line-height: 1.5;
}

.res-dev-list li i {
    color: #c02a7c;
    margin-top: 3px;
    font-size: 0.8rem;
    flex-shrink: 0;
}

.res-inline-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 11px 26px;
    border-radius: 50px;
    font-size: 0.88rem;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 8px 18px rgba(192,42,124,0.25);
}

.res-inline-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 14px 30px rgba(192,42,124,0.38);
    color: #fff;
}

/* ---- APPROACH STEPS ---- */
.res-approach {
    padding: 96px 0;
    background: #fff5f9;
}

.res-steps {
    display: flex;
    flex-direction: column;
    gap: 0;
}

.res-step {
    display: flex;
    gap: 24px;
    align-items: flex-start;
    padding: 28px 30px;
    border-radius: 18px;
    transition: background 0.3s ease;
    position: relative;
}

.res-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 55px;
    bottom: 0;
    height: 100%;
    width: 2px;
    border-left: 2px dashed #f4c6de;
    z-index: 0;
}

.res-step:hover { background: #fce7f3; }

.res-step-num {
    width: 50px; height: 50px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: #fff;
    font-weight: 900;
    font-size: 1.05rem;
    flex-shrink: 0;
    position: relative; z-index: 1;
    box-shadow: 0 8px 20px rgba(192,42,124,0.28);
}

.res-step-body h4 {
    font-size: 1.04rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 7px;
}

.res-step-body p {
    font-size: 0.9rem;
    color: #8e6f7e;
    line-height: 1.72;
    margin: 0;
}

/* ---- CTA ---- */
.res-cta {
    padding: 90px 0;
    background: #fff;
}

.res-cta-box {
    background: linear-gradient(135deg, #2d0a1c, #1a0511);
    border-radius: 30px;
    padding: 70px 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.res-cta-box::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 280px; height: 280px;
    background: radial-gradient(circle, rgba(192,42,124,0.2), transparent);
    border-radius: 50%;
}

.res-cta-box::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(255,133,192,0.08), transparent);
    border-radius: 50%;
}

.res-cta-box h2 {
    font-size: clamp(1.8rem, 3.2vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 14px;
    position: relative; z-index: 1;
}

.res-cta-box h2 span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.res-cta-box p {
    color: rgba(255,255,255,0.62);
    font-size: 1.02rem;
    max-width: 480px;
    margin: 0 auto 36px;
    position: relative; z-index: 1;
}

.res-cta-btns {
    display: flex;
    gap: 14px;
    justify-content: center;
    flex-wrap: wrap;
    position: relative; z-index: 1;
}

/* Responsive */
@media (max-width: 900px) {
    .res-audience-panel.active { flex-direction: column; }
    .res-audience-left { flex: none; width: 100%; }
    .res-audience-right { max-height: none; }
    .res-biz-grid { grid-template-columns: 1fr; }
    .res-hero-stats { flex-wrap: wrap; gap: 20px; }
    .res-stat { border-right: none; }
}

@media (max-width: 576px) {
    .res-cta-box { padding: 40px 24px; }
    .res-hero-title { font-size: 2.8rem; }
}
</style>

<body>
    <?php include 'component/navbar.php'; ?>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="res-hero">
        <video autoplay muted loop playsinline class="res-hero-video">
            <source src="rkimg/Residential.webm" type="video/webm">
        </video>
        <div class="res-hero-overlay"></div>

        <div class="container res-hero-content">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="res-hero-badge">
                        <span class="dot"></span>
                        Residential Real Estate
                    </div>
                    <h1 class="res-hero-title">
                        Your Dream<br><span class="grad">Home</span><br>Awaits.
                    </h1>
                    <p class="res-hero-desc">
                        Creating a complete sales ecosystem for end-to-end client and customer satisfaction in residential real estate — from first inquiry to final handover.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#showw" class="res-btn-primary">
                            <i class="fa fa-handshake-o"></i> Let's Connect
                        </a>
                        <a href="#what-we-do" class="res-btn-ghost">
                            <i class="fa fa-arrow-down"></i> Explore Services
                        </a>
                    </div>

                    <div class="res-hero-stats">
                        <div class="res-stat">
                            <div class="res-stat-num">350+</div>
                            <div class="res-stat-lbl">Projects Executed</div>
                        </div>
                        <div class="res-stat">
                            <div class="res-stat-num">10K+</div>
                            <div class="res-stat-lbl">Houses Sold</div>
                        </div>
                        <div class="res-stat">
                            <div class="res-stat-num">15K+</div>
                            <div class="res-stat-lbl">Channel Partners</div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                    <div class="res-hero-img-card">
                        <img src="rkimg/Residential_real_estate.jpg" alt="Residential Real Estate I Kan Housing">
                        <div class="res-hero-img-tag">
                            <h4>🏡 360° Residential Sales Solutions</h4>
                            <p>Enabling clients to focus on core business while we drive results.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS BAR ===== -->
    <section class="res-stats-bar">
        <div class="container">
            <div class="row g-0">
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="res-stat-card">
                        <div class="res-stat-icon"><i class="fa fa-building"></i></div>
                        <div class="res-stat-big">350+</div>
                        <div class="res-stat-label">Projects Executed</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="res-stat-card">
                        <div class="res-stat-icon"><i class="fa fa-home"></i></div>
                        <div class="res-stat-big">10,000+</div>
                        <div class="res-stat-label">Houses Sold</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="res-stat-card">
                        <div class="res-stat-icon"><i class="fa fa-users"></i></div>
                        <div class="res-stat-big">15,000+</div>
                        <div class="res-stat-label">Channel Partners</div>
                    </div>
                </div>
                <div class="col-6 col-md-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="res-stat-card">
                        <div class="res-stat-icon"><i class="fa fa-trophy"></i></div>
                        <div class="res-stat-big">14+</div>
                        <div class="res-stat-label">Years of Excellence</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== AUDIENCE TABS SECTION ===== -->
    <section class="res-audience" id="what-we-do">
        <div class="container">
            <div class="row align-items-end mb-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="res-badge">For Every Stakeholder</div>
                    <h2 class="res-section-title">What We Can Do <span>For You</span></h2>
                    <p class="res-section-desc">We serve developers, channel partners, corporates and consumers with tailored solutions — powering the full residential real estate ecosystem.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="res-pill-tabs" id="resTabs">
                        <button class="res-pill active" onclick="switchResTab('developers', this)">
                            <i class="fa fa-building"></i> Developers
                        </button>
                        <button class="res-pill" onclick="switchResTab('partners', this)">
                            <i class="fa fa-handshake-o"></i> Channel Partners
                        </button>
                        <button class="res-pill" onclick="switchResTab('corporates', this)">
                            <i class="fa fa-briefcase"></i> Corporates
                        </button>
                        <button class="res-pill" onclick="switchResTab('consumers', this)">
                            <i class="fa fa-user"></i> Consumers
                        </button>
                    </div>
                </div>
            </div>

            <!-- ---- TAB: DEVELOPERS ---- -->
            <div class="res-audience-panel active" id="tab-developers">
                <div class="res-audience-left" data-aos="fade-right">
                    <h3 style="font-size:1.4rem; font-weight:800; color:#2d0a1c; margin-bottom:12px;">For Developers</h3>
                    <p class="res-audience-desc">We offer 360-degree sales and marketing solutions for developers, backed by comprehensive services throughout your project lifecycle.</p>
                    <div class="res-audience-links">
                        <a href="javascript:void(0)" class="res-audience-link active-link" onclick="switchDetailTab('sales', this)">
                            <i class="fa fa-chart-line"></i> Sales & Marketing
                        </a>
                        <a href="javascript:void(0)" class="res-audience-link" onclick="switchDetailTab('business', this)">
                            <i class="fa fa-briefcase"></i> Business Solutions
                        </a>
                        <a href="javascript:void(0)" class="res-audience-link" onclick="switchDetailTab('second', this)">
                            <i class="fa fa-home"></i> Second Homes
                        </a>
                        <a href="javascript:void(0)" class="res-audience-link" onclick="switchDetailTab('luxury', this)">
                            <i class="fa fa-diamond"></i> Luxury Homes
                        </a>
                    </div>
                </div>


                <div class="res-audience-right">
                    <!-- Sales & Marketing -->
                    <div class="res-detail-card active" id="sales">

                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Sales_&_MarketingA.jpg" alt="Sales & Marketing" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Sales &amp; Marketing</h3>
                            <p>We employ a distinct, multi-pronged approach that sets us apart in the Indian residential property market. Our seamless, customized, and comprehensive strategies effectively market and manage your properties.</p>
                            <ul class="res-dev-list">
                                <li><i class="fa fa-check-circle"></i> Project planning and strategy throughout the lifecycle</li>
                                <li><i class="fa fa-check-circle"></i> Channel Partner (CP) sourcing and outreach</li>
                                <li><i class="fa fa-check-circle"></i> Digital marketing & performance campaigns</li>
                                <li><i class="fa fa-check-circle"></i> Pre-sales lead generation and servicing</li>
                                <li><i class="fa fa-check-circle"></i> On-ground sales execution through direct agents</li>
                                <li><i class="fa fa-check-circle"></i> Post-sales CRM — payments and milestones</li>
                                <li><i class="fa fa-check-circle"></i> Home loan solutions and tie-ups</li>
                            </ul>
                            <a href="sales-marketing" class="res-inline-btn">
                                <i class="fa fa-arrow-right"></i> Read More
                            </a>
                        </div>
                    </div>

                    <!-- Business Solutions -->
                    <div class="res-detail-card" id="business">
                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Business_Solutions1.jpg" alt="Business Solutions" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Business Solutions</h3>
                            <p>Beyond core offerings, we provide comprehensive Business Solutions encompassing Digital, Creative, Post-Sales, and Home Services.</p>
                            <div class="res-biz-grid">
                                <div class="res-biz-item">
                                    <h6>Tech-enabled Services</h6>
                                    <p>Performance marketing, website management, social media & analytics reporting.</p>
                                </div>
                                <div class="res-biz-item">
                                    <h6>Brand Communication</h6>
                                    <p>Innovative partner across traditional, new & emerging media channels.</p>
                                </div>
                                <div class="res-biz-item">
                                    <h6>Customer Experience</h6>
                                    <p>Structured collections framework bridging developers and homebuyers.</p>
                                </div>
                                <div class="res-biz-item">
                                    <h6>Home Services</h6>
                                    <p>Home loan assistance, interior design, furnishing and more.</p>
                                </div>
                            </div>
                            <a href="#showw" class="res-inline-btn">
                                <i class="fa fa-phone"></i> Connect With Us
                            </a>
                        </div>
                    </div>

                    <!-- Second Homes -->
                    <div class="res-detail-card" id="second">
                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Second_Homes1.jpg" alt="Second Homes" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Second Homes</h3>
                            <p>As experienced real estate consultants, we understand the unique challenges and opportunities involved in purchasing a second home — whether it's a serene bungalow in the mountains or a luxurious beachfront villa.</p>
                            <p>Whether you're looking for a vacation retreat, a sound investment opportunity, or a source of rental income — buying a second home is a smart financial decision that offers both enjoyment and long-term value.</p>
                            <a href="#showw" class="res-inline-btn">
                                <i class="fa fa-phone"></i> Connect With Us
                            </a>
                        </div>
                    </div>

                    <!-- Luxury Homes -->
                    <div class="res-detail-card" id="luxury">
                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Luxury_Homes1.jpg" alt="Luxury Homes" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Luxury Homes</h3>
                            <p>Luxury homes are the epitome of opulence and comfort. We specialize in helping you find the perfect one. Purchasing a luxury home is a significant investment and a life-changing decision.</p>
                            <p>Our network of elite advisors brings deep market knowledge and a keen understanding of your unique preferences, ensuring we match you with a home that truly reflects your lifestyle.</p>
                            <a href="#showw" class="res-inline-btn">
                                <i class="fa fa-phone"></i> Connect With Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---- TAB: CHANNEL PARTNERS ---- -->
            <div class="res-audience-panel" id="tab-partners">
                <div class="res-audience-left" data-aos="fade-right">
                    <h3 style="font-size:1.4rem; font-weight:800; color:#2d0a1c; margin-bottom:12px;">For Channel Partners</h3>
                    <p class="res-audience-desc">Our automated, tech-driven platform and extensive market network empowers our Channel Partners to become knowledgeable, transparent property consultants.</p>
                    <div class="res-audience-links">
                        <a href="javascript:void(0)" class="res-audience-link active-link" onclick="switchDetailTab('partner-main', this)">
                            <i class="fa fa-handshake-o"></i> Empowering Partners
                        </a>
                    </div>
                </div>
                <div class="res-audience-right">
                    <div class="res-detail-card active" id="partner-main">

                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Residential_real_estatee.jpg" alt="Channel Partners" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Empowering Channel Partners</h3>
                            <p>Access to our automated, tech-driven platform, extensive market network, and innovative solutions empowers our Channel Partners to become knowledgeable and transparent property consultants for their valued customers.</p>
                            <ul class="res-dev-list">
                                <li><i class="fa fa-check-circle"></i> Tech-enabled platform access & real-time data</li>
                                <li><i class="fa fa-check-circle"></i> 15,000+ strong channel partner network</li>
                                <li><i class="fa fa-check-circle"></i> Training, onboarding & knowledge support</li>
                                <li><i class="fa fa-check-circle"></i> Dedicated relationship management</li>
                                <li><i class="fa fa-check-circle"></i> High-commission deals across premium inventory</li>
                            </ul>
                            <a href="#showw" class="res-inline-btn"><i class="fa fa-handshake-o"></i> Partner With Us</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---- TAB: CORPORATES ---- -->
            <div class="res-audience-panel" id="tab-corporates">
                <div class="res-audience-left" data-aos="fade-right">
                    <h3 style="font-size:1.4rem; font-weight:800; color:#2d0a1c; margin-bottom:12px;">For Corporates</h3>
                    <p class="res-audience-desc">We help corporates with divestment by creating effective strategies to market and sell properties at the right time and the right price.</p>
                    <div class="res-audience-links">
                        <a href="javascript:void(0)" class="res-audience-link active-link" onclick="switchDetailTab('corp-divest', this)">
                            <i class="fa fa-briefcase"></i> Divestment Solutions
                        </a>
                    </div>
                </div>
                <div class="res-audience-right">
                    <div class="res-detail-card active" id="corp-divest">

                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Business_Solutions.jpg" alt="Corporate Divestment" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Corporate Divestment Solutions</h3>
                            <p>We help corporates with divestment by creating effective strategies to market and sell properties. Our experts design tailored campaigns that reach the right buyers at the right time.</p>
                            <ul class="res-dev-list">
                                <li><i class="fa fa-check-circle"></i> Strategic property divestment planning</li>
                                <li><i class="fa fa-check-circle"></i> Market analysis & optimal pricing</li>
                                <li><i class="fa fa-check-circle"></i> Targeted buyer outreach & campaigns</li>
                                <li><i class="fa fa-check-circle"></i> Transaction support & legal coordination</li>
                            </ul>
                            <a href="#showw" class="res-inline-btn"><i class="fa fa-phone"></i> Talk to an Expert</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ---- TAB: CONSUMERS ---- -->
            <div class="res-audience-panel" id="tab-consumers">
                <div class="res-audience-left" data-aos="fade-right">
                    <h3 style="font-size:1.4rem; font-weight:800; color:#2d0a1c; margin-bottom:12px;">For Consumers</h3>
                    <p class="res-audience-desc">Whether you're a first-time homebuyer or a seasoned investor, we facilitate a seamless home-buying experience through a comprehensive range of services.</p>
                    <div class="res-audience-links">
                        <a href="javascript:void(0)" class="res-audience-link active-link" onclick="switchDetailTab('cons-journey', this)">
                            <i class="fa fa-home"></i> Buying Journey
                        </a>
                    </div>
                </div>
                <div class="res-audience-right">
                    <div class="res-detail-card active" id="cons-journey">

                        <div class="res-detail-card-img-wrap">
                            <img src="rkimg/Second-home.jpg" alt="Home Buyers" class="res-detail-card-img">
                        </div>
                        <div class="res-detail-body">
                            <h3>Your Seamless Home-Buying Journey</h3>
                            <p>Whether you're a first-time homebuyer or a seasoned investor, we understand the importance of finding the perfect home. Our goal is to facilitate a seamless home-buying experience.</p>
                            <ul class="res-dev-list">
                                <li><i class="fa fa-check-circle"></i> Personalized property search & shortlisting</li>
                                <li><i class="fa fa-check-circle"></i> Home loan assistance & financial planning</li>
                                <li><i class="fa fa-check-circle"></i> Legal support & documentation</li>
                                <li><i class="fa fa-check-circle"></i> End-to-end transaction management</li>
                                <li><i class="fa fa-check-circle"></i> Post-purchase home services</li>
                            </ul>
                            <a href="#showw" class="res-inline-btn"><i class="fa fa-search"></i> Find Your Home</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== OUR APPROACH ===== -->
    <section class="res-approach">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="res-badge">Our Methodology</div>
                    <h2 class="res-section-title">How We <span>Drive Success</span></h2>
                    <p class="res-section-desc">A proven, structured approach that takes residential projects from concept to complete sell-out — with precision, speed, and excellence.</p>
                    <img src="rkimg/Residential.jpg" alt="Our Residential Approach" class="img-fluid rounded-4 shadow mt-4">
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="res-steps">
                        <div class="res-step">
                            <div class="res-step-num">01</div>
                            <div class="res-step-body">
                                <h4>Project Understanding & Strategy</h4>
                                <p>We deep-dive into your project — understanding the vision, micromarket dynamics, competition landscape, and target buyer personas to craft a winning strategy.</p>
                            </div>
                        </div>
                        <div class="res-step">
                            <div class="res-step-num">02</div>
                            <div class="res-step-body">
                                <h4>Channel Partner Activation</h4>
                                <p>Leveraging our 15,000+ channel partner network, we activate a powerful distribution ecosystem that brings qualified buyers to your project from day one.</p>
                            </div>
                        </div>
                        <div class="res-step">
                            <div class="res-step-num">03</div>
                            <div class="res-step-body">
                                <h4>Digital Marketing & Lead Generation</h4>
                                <p>Performance marketing campaigns, social media outreach, and creative communication strategies that generate high-quality, conversion-ready leads.</p>
                            </div>
                        </div>
                        <div class="res-step">
                            <div class="res-step-num">04</div>
                            <div class="res-step-body">
                                <h4>On-Ground Sales Execution</h4>
                                <p>Our dedicated on-ground team manages site visits, client interactions, negotiations, and ensures every potential buyer is nurtured through to closure.</p>
                            </div>
                        </div>
                        <div class="res-step">
                            <div class="res-step-num">05</div>
                            <div class="res-step-body">
                                <h4>Post-Sales CRM & Handover</h4>
                                <p>We don't stop at closure — our post-sales CRM, payment milestone management, and home services ensure buyers feel supported long after the deal is done.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="res-cta">
        <div class="container">
            <div class="res-cta-box" data-aos="zoom-in">
                <div class="res-badge" style="background:rgba(255,133,192,0.12); color:#ff85c0; margin-bottom:22px;">Start Your Journey</div>
                <h2>Ready to Find Your <span>Dream Home?</span></h2>
                <p>Whether you're a developer, investor, or first-time buyer — our team is ready to guide you every step of the way.</p>
                <div class="res-cta-btns">
                    <a href="#showw" class="res-btn-primary">
                        <i class="fa fa-phone"></i> Book a Free Consultation
                    </a>
                    <a href="contact" class="res-btn-ghost" style="border-color:rgba(255,133,192,0.35); color:#ff85c0;">
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
    // Main Audience Tab Switcher
    function switchResTab(tabId, btn) {
        document.querySelectorAll('.res-pill').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.res-audience-panel').forEach(p => p.classList.remove('active'));
        btn.classList.add('active');
        const activePanel = document.getElementById('tab-' + tabId);
        activePanel.classList.add('active');

        // Set first inner detail link and card as active for this main tab
        const firstLink = activePanel.querySelector('.res-audience-link');
        const firstCard = activePanel.querySelector('.res-detail-card');
        
        activePanel.querySelectorAll('.res-audience-link').forEach(l => l.classList.remove('active-link'));
        activePanel.querySelectorAll('.res-detail-card').forEach(c => c.classList.remove('active'));
        
        if (firstLink) firstLink.classList.add('active-link');
        if (firstCard) firstCard.classList.add('active');
    }

    // Inner Detail Tab Switcher (The "Hide/Show" logic)
    function switchDetailTab(cardId, element) {
        const panel = element.closest('.res-audience-panel');
        if (!panel) return;

        // Update Links
        panel.querySelectorAll('.res-audience-link').forEach(link => link.classList.remove('active-link'));
        element.classList.add('active-link');

        // Update Cards
        panel.querySelectorAll('.res-detail-card').forEach(card => card.classList.remove('active'));
        const targetCard = panel.querySelector('#' + cardId);
        if (targetCard) {
            targetCard.classList.add('active');
            
            // On mobile, scroll to card if panel is stacked
            if (window.innerWidth < 992) {
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    }

    // Counter animation
    const resObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                entry.target.classList.add('counted');
                entry.target.querySelectorAll('.res-stat-big').forEach(el => {
                    const raw = el.textContent.replace(/[^0-9]/g, '');
                    const target = parseInt(raw);
                    if (!target) return;
                    const suffix = el.textContent.replace(/[0-9,]/g, '').trim();
                    let current = 0;
                    const step = Math.ceil(target / 60);
                    const timer = setInterval(() => {
                        current = Math.min(current + step, target);
                        el.textContent = current.toLocaleString() + suffix;
                        if (current >= target) clearInterval(timer);
                    }, 30);
                });
            }
        });
    }, { threshold: 0.4 });

    const statsBar = document.querySelector('.res-stats-bar');
    if (statsBar) resObserver.observe(statsBar);

    // Init: set first link active on page load
    document.querySelectorAll('.res-audience-panel.active').forEach(panel => {
        const firstLink = panel.querySelector('.res-audience-link');
        if (firstLink) firstLink.classList.add('active-link');
    });
    </script>

</body>
</html>