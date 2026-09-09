<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== JOINT VENTURE PAGE — PREMIUM STYLES ===== */

/* ---- HERO ---- */
.jv-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514;
}

.jv-hero-bg {
    position: absolute;
    inset: 0;
    background-image: url('rkimg/Joint_Venture-jvv.jpg');
    background-size: cover;
    background-position: center;
    opacity: 0.3;
    z-index: 0;
    transform: scale(1.05);
    animation: slowZoom 14s ease-in-out infinite alternate;
}

@keyframes slowZoom {
    from { transform: scale(1.05); }
    to   { transform: scale(1.12); }
}

.jv-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(140deg,
        rgba(10,5,20,0.96) 0%,
        rgba(45,10,28,0.78) 55%,
        rgba(192,42,124,0.14) 100%);
    z-index: 1;
}

.jv-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
    padding-bottom: 80px;
}

.jv-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    background: rgba(192,42,124,0.13);
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

.jv-hero-badge .dot {
    width: 6px; height: 6px;
    background: #ff85c0;
    border-radius: 50%;
    animation: blink 1.6s infinite;
}

@keyframes blink {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:0.3; transform:scale(0.6); }
}

.jv-hero-title {
    font-size: clamp(2.8rem, 6vw, 5.5rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    letter-spacing: -2px;
    margin-bottom: 20px;
}

.jv-hero-title .grad {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.jv-hero-desc {
    color: rgba(255,255,255,0.68);
    font-size: 1.12rem;
    line-height: 1.82;
    max-width: 560px;
    margin-bottom: 40px;
}

/* Hero buttons */
.jv-btn-primary {
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

.jv-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 22px 45px rgba(192,42,124,0.5);
    color: #fff;
}

.jv-btn-ghost {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: transparent;
    color: rgba(255,255,255,0.82);
    border: 2px solid rgba(255,255,255,0.22);
    padding: 13px 32px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.3s ease;
    backdrop-filter: blur(8px);
}

.jv-btn-ghost:hover {
    border-color: #ff85c0;
    color: #ff85c0;
    transform: translateY(-3px);
}

/* Hero right floating card */
.jv-hero-card {
    background: rgba(255,255,255,0.06);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 26px;
    overflow: hidden;
    height: 460px;
    position: relative;
}

.jv-hero-card img {
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.78;
}

.jv-hero-card-tag {
    position: absolute;
    bottom: 22px; left: 22px; right: 22px;
    background: rgba(10,5,20,0.84);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(192,42,124,0.3);
    border-radius: 16px;
    padding: 18px 22px;
}

.jv-hero-card-tag h4 {
    color: #fff;
    font-weight: 700;
    font-size: 0.98rem;
    margin-bottom: 6px;
}

.jv-hero-card-tag p {
    color: rgba(255,255,255,0.58);
    font-size: 0.82rem;
    margin: 0;
}

/* Hero feature pills */
.jv-hero-features {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 36px;
}

.jv-feature-pill {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: rgba(255,255,255,0.06);
    border: 1px solid rgba(255,255,255,0.1);
    color: rgba(255,255,255,0.75);
    padding: 7px 16px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 500;
    backdrop-filter: blur(8px);
}

.jv-feature-pill i { color: #ff85c0; font-size: 0.75rem; }

/* ---- INTRO SPLIT ---- */
.jv-intro {
    padding: 90px 0;
    background: #fff;
}

.jv-badge {
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

.jv-section-title {
    font-size: clamp(1.8rem, 3.5vw, 2.9rem);
    font-weight: 800;
    color: #2d0a1c;
    line-height: 1.18;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.jv-section-title span { color: #c02a7c; }

.jv-section-desc {
    color: #8e6f7e;
    font-size: 1rem;
    line-height: 1.8;
}

/* Key points on intro */
.jv-key-point {
    display: flex;
    gap: 16px;
    align-items: flex-start;
    padding: 18px 0;
    border-bottom: 1px solid #f1e8ef;
}

.jv-key-point:last-child { border-bottom: none; }

.jv-kp-icon {
    width: 46px; height: 46px;
    background: linear-gradient(135deg, #fce7f3, #f4c6de);
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.1rem; color: #c02a7c;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.jv-key-point:hover .jv-kp-icon {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    transform: scale(1.08);
}

.jv-kp-body h5 {
    font-size: 0.98rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 4px;
}

.jv-kp-body p {
    font-size: 0.88rem;
    color: #8e6f7e;
    margin: 0;
    line-height: 1.6;
}

/* Intro right image */
.jv-intro-img-wrap {
    position: relative;
    border-radius: 26px;
    overflow: hidden;
}

.jv-intro-img-wrap img {
    width: 100%; height: 480px;
    object-fit: cover;
    border-radius: 26px;
    display: block;
}

.jv-intro-img-badge {
    position: absolute;
    bottom: -20px; left: 30px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 20px 28px;
    border-radius: 18px;
    box-shadow: 0 20px 40px rgba(192,42,124,0.4);
}

.jv-intro-img-badge .num {
    font-size: 2.2rem;
    font-weight: 900;
    line-height: 1;
    margin-bottom: 4px;
}

.jv-intro-img-badge .lbl {
    font-size: 0.8rem;
    font-weight: 600;
    opacity: 0.85;
}

/* ---- BENEFITS GRID ---- */
.jv-benefits {
    padding: 100px 0;
    background: linear-gradient(160deg, #fff5f9 0%, #fff 40%, #fce7f3 100%);
    position: relative;
    overflow: hidden;
}

.jv-benefits::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 450px; height: 450px;
    background: radial-gradient(circle, rgba(192,42,124,0.07), transparent 65%);
    pointer-events: none;
}

.jv-benefit-card {
    background: #fff;
    border: 1px solid #f1e8ef;
    border-radius: 22px;
    padding: 36px 30px;
    height: 100%;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    overflow: hidden;
    text-align: center;
}

.jv-benefit-card::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 100%; height: 3px;
    background: linear-gradient(90deg, #ff85c0, #c02a7c);
    transform: scaleX(0);
    transition: transform 0.4s ease;
    transform-origin: left;
}

.jv-benefit-card:hover::after { transform: scaleX(1); }

.jv-benefit-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 30px 60px rgba(192,42,124,0.12);
    border-color: #f4c6de;
}

.jv-benefit-icon {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #fce7f3, #f4c6de);
    border-radius: 22px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    transition: all 0.35s ease;
}

.jv-benefit-icon img {
    width: 36px; height: 36px;
    object-fit: contain;
    filter: none;
    transition: all 0.35s ease;
}

.jv-benefit-card:hover .jv-benefit-icon {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    transform: rotate(-5deg) scale(1.1);
    box-shadow: 0 12px 28px rgba(192,42,124,0.3);
}

.jv-benefit-card:hover .jv-benefit-icon img {
    filter: brightness(0) invert(1);
}

.jv-benefit-card h4 {
    font-size: 1.05rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 12px;
    line-height: 1.35;
}

.jv-benefit-card p {
    font-size: 0.88rem;
    color: #8e6f7e;
    line-height: 1.7;
    margin: 0;
}

/* Benefit number badge */
.jv-benefit-num {
    position: absolute;
    top: 18px; right: 20px;
    font-size: 3rem;
    font-weight: 900;
    color: #f1e8ef;
    line-height: 1;
    pointer-events: none;
    transition: color 0.3s ease;
}

.jv-benefit-card:hover .jv-benefit-num {
    color: rgba(192,42,124,0.08);
}

/* ---- PROCESS STEPS ---- */
.jv-process {
    padding: 90px 0;
    background: #fff;
}

.jv-process-wrap {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 0;
    position: relative;
}

.jv-process-wrap::before {
    content: '';
    position: absolute;
    top: 36px;
    left: 12.5%;
    right: 12.5%;
    height: 2px;
    background: linear-gradient(90deg, #fce7f3, #c02a7c, #fce7f3);
    z-index: 0;
}

.jv-process-step {
    text-align: center;
    padding: 0 20px;
    position: relative;
    z-index: 1;
}

.jv-process-num {
    width: 72px; height: 72px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 24px;
    font-size: 1.3rem;
    font-weight: 900;
    color: #fff;
    box-shadow: 0 10px 28px rgba(192,42,124,0.35);
    border: 4px solid #fff;
    transition: all 0.3s ease;
}

.jv-process-step:hover .jv-process-num {
    transform: scale(1.12);
    box-shadow: 0 16px 40px rgba(192,42,124,0.45);
}

.jv-process-step h5 {
    font-size: 0.98rem;
    font-weight: 700;
    color: #2d0a1c;
    margin-bottom: 8px;
}

.jv-process-step p {
    font-size: 0.84rem;
    color: #8e6f7e;
    line-height: 1.65;
}

/* ---- CONTACT SECTION ---- */
.jv-contact {
    padding: 90px 0 100px;
    background: linear-gradient(160deg, #fff5f9, #fce7f3);
    position: relative;
    overflow: hidden;
}

.jv-contact::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(192,42,124,0.08), transparent 65%);
    pointer-events: none;
}

/* Form Card */
.jv-form-card {
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 30px 80px rgba(45,10,28,0.1);
    overflow: hidden;
    display: flex;
}

.jv-form-left {
    background: linear-gradient(160deg, #2d0a1c, #1a0511);
    padding: 52px 40px;
    width: 36%;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.jv-form-left::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(192,42,124,0.22), transparent);
}

.jv-form-left::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(255,133,192,0.1), transparent);
}

.jv-form-left-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 10px;
    position: relative; z-index: 1;
}

.jv-form-left-desc {
    color: rgba(255,255,255,0.58);
    font-size: 0.88rem;
    line-height: 1.75;
    position: relative; z-index: 1;
    margin-bottom: 36px;
}

.jv-contact-items {
    list-style: none;
    padding: 0; margin: 0;
    display: flex;
    flex-direction: column;
    gap: 16px;
    position: relative; z-index: 1;
}

.jv-contact-item {
    display: flex;
    align-items: center;
    gap: 13px;
}

.jv-ci-icon {
    width: 38px; height: 38px;
    background: rgba(192,42,124,0.18);
    border: 1px solid rgba(192,42,124,0.3);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 0.85rem; color: #ff85c0;
    flex-shrink: 0;
}

.jv-ci-text strong {
    color: rgba(255,133,192,0.8);
    display: block;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    margin-bottom: 2px;
}

.jv-ci-text span {
    color: rgba(255,255,255,0.75);
    font-size: 0.87rem;
    font-weight: 500;
}

.jv-ci-text a {
    color: rgba(255,255,255,0.75);
    font-size: 0.87rem;
    font-weight: 500;
    text-decoration: none;
}

.jv-ci-text a:hover { color: #ff85c0; }

.jv-social-row {
    display: flex;
    gap: 10px;
    position: relative; z-index: 1;
    margin-top: 30px;
}

.jv-social-btn {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.07);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: rgba(255,255,255,0.65);
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.jv-social-btn:hover {
    background: #c02a7c;
    border-color: #c02a7c;
    color: #fff;
    transform: translateY(-3px);
}

/* Right: Form */
.jv-form-right {
    flex: 1;
    padding: 52px 48px;
}

.jv-form-right h3 {
    font-size: 1.5rem;
    font-weight: 800;
    color: #2d0a1c;
    margin-bottom: 6px;
}

.jv-form-right > p {
    color: #8e6f7e;
    font-size: 0.92rem;
    margin-bottom: 32px;
}

.jv-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 18px;
    margin-bottom: 18px;
}

.jv-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.jv-field.full { grid-column: 1 / -1; }

.jv-field label {
    font-size: 0.76rem;
    font-weight: 700;
    color: #2d0a1c;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.jv-field label span { color: #c02a7c; }

.jv-input {
    background: #fff5f9;
    border: 1.5px solid #f1e8ef;
    border-radius: 12px;
    padding: 13px 18px;
    font-size: 0.95rem;
    color: #2d0a1c;
    font-family: 'Outfit', sans-serif;
    transition: all 0.3s ease;
    outline: none;
    width: 100%;
}

.jv-input::placeholder { color: #c4aab8; font-size: 0.9rem; }

.jv-input:focus {
    border-color: #c02a7c;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(192,42,124,0.08);
}

textarea.jv-input {
    resize: none;
    height: 100px;
}

.jv-submit-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: 100%;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    border: none;
    padding: 15px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s ease;
    box-shadow: 0 10px 28px rgba(192,42,124,0.28);
    font-family: 'Outfit', sans-serif;
    margin-top: 8px;
}

.jv-submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 42px rgba(192,42,124,0.42);
}

#popup-messages-jv {
    display: none;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 16px;
    text-align: center;
    color: #fff;
    animation: fadeSlideUp 0.4s ease;
}

@keyframes fadeSlideUp {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
}

/* Responsive */
@media (max-width: 991px) {
    .jv-form-card { flex-direction: column; }
    .jv-form-left { width: 100%; padding: 36px 28px; }
    .jv-form-right { padding: 36px 28px; }
    .jv-process-wrap { grid-template-columns: 1fr 1fr; gap: 30px; }
    .jv-process-wrap::before { display: none; }
}

@media (max-width: 768px) {
    .jv-form-grid { grid-template-columns: 1fr; }
    .jv-process-wrap { grid-template-columns: 1fr; }
    .jv-intro-img-badge { bottom: 10px; left: 14px; }
}
</style>

<body>
    <?php include 'component/navbar.php'; ?>

    <style>
        .intro-content { padding-top: 120px !important; }
        @media (max-width: 991px) { .intro-content { padding-top: 90px !important; } }
    </style>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="jv-hero">
        <div class="jv-hero-bg"></div>
        <div class="jv-hero-overlay"></div>

        <div class="container jv-hero-content">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="900">
                    <div class="jv-hero-badge">
                        <span class="dot"></span>
                        Strategic Partnership
                    </div>
                    <h1 class="jv-hero-title">
                        Joint <span class="grad">Venture</span><br>Opportunities
                    </h1>
                    <p class="jv-hero-desc">
                        Transform your land into a thriving development. Partnering with I Kan Housing unlocks substantial value through expert planning, marketing, and seamless execution.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#jv-contact" class="jv-btn-primary">
                            <i class="fa fa-handshake-o"></i> Partner With Us
                        </a>
                        <a href="#jv-benefits" class="jv-btn-ghost">
                            <i class="fa fa-arrow-down"></i> View Benefits
                        </a>
                    </div>

                    <div class="jv-hero-features">
                        <span class="jv-feature-pill"><i class="fa fa-check-circle"></i> Zero Upfront Cost</span>
                        <span class="jv-feature-pill"><i class="fa fa-check-circle"></i> Full Developer Expertise</span>
                        <span class="jv-feature-pill"><i class="fa fa-check-circle"></i> Maximum Returns</span>
                        <span class="jv-feature-pill"><i class="fa fa-check-circle"></i> Legal Compliance</span>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="900" data-aos-delay="200">
                    <div class="jv-hero-card">
                        <img src="rkimg/joint_vantures-jv.webp" alt="Joint Venture Opportunities I Kan Housing">
                        <div class="jv-hero-card-tag">
                            <h4>🤝 Landowner — Developer Partnership</h4>
                            <p>Your land. Our expertise. Together, we build landmarks.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== INTRO SPLIT ===== -->
    <section class="jv-intro">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="jv-badge">About Joint Ventures</div>
                    <h2 class="jv-section-title">
                        Your Land. Our <span>Expertise.</span><br>Our Shared Success.
                    </h2>
                    <p class="jv-section-desc mb-4">
                        Explore the immense potential of your land through a strategic Joint Venture. Partnering with an experienced developer can unlock substantial benefits — without you bearing the development risk.
                    </p>

                    <div class="mt-2">
                        <div class="jv-key-point">
                            <div class="jv-kp-icon"><i class="fa fa-rupee"></i></div>
                            <div class="jv-kp-body">
                                <h5>No Upfront Financial Investment</h5>
                                <p>You contribute the land; the developer handles all construction, marketing, and sales costs.</p>
                            </div>
                        </div>
                        <div class="jv-key-point">
                            <div class="jv-kp-icon"><i class="fa fa-line-chart"></i></div>
                            <div class="jv-kp-body">
                                <h5>Maximum Value Extraction</h5>
                                <p>Transform idle land into a revenue-generating, high-value asset with professional development expertise.</p>
                            </div>
                        </div>
                        <div class="jv-key-point">
                            <div class="jv-kp-icon"><i class="fa fa-shield"></i></div>
                            <div class="jv-kp-body">
                                <h5>Full Legal & Regulatory Support</h5>
                                <p>Our team handles approvals, RERA compliance, legal documentation, and all regulatory requirements.</p>
                            </div>
                        </div>
                        <div class="jv-key-point">
                            <div class="jv-kp-icon"><i class="fa fa-handshake-o"></i></div>
                            <div class="jv-kp-body">
                                <h5>Transparent Revenue Sharing</h5>
                                <p>Clear, documented profit-sharing structure with complete transparency — no hidden surprises.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <div class="jv-intro-img-wrap">
                        <img src="rkimg/Joint_Venture-jvv.jpg" alt="Joint Venture Real Estate">
                        <div class="jv-intro-img-badge">
                            <div class="num">350+</div>
                            <div class="lbl">Successful Projects</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== BENEFITS GRID ===== -->
    <section class="jv-benefits" id="jv-benefits">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="jv-badge">Landowner Advantages</div>
                <h2 class="jv-section-title">Benefits of the <span>Joint Venture</span></h2>
                <p class="jv-section-desc mx-auto" style="max-width:500px;">
                    When you partner with I Kan Housing, you unlock a comprehensive set of advantages that maximize your land's true potential.
                </p>
            </div>

            <div class="row g-4">
                <!-- Card 1 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">01</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/value-jv.webp" alt="Value Unlocking">
                        </div>
                        <h4>Value Unlocking of Your Property</h4>
                        <p>Transform idle land into a high-value asset, significantly enhancing its market worth.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="80">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">02</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/liquidity-jv.webp" alt="Liquidation">
                        </div>
                        <h4>Liquidation of the Asset</h4>
                        <p>Convert land to liquid assets without the complexities of selling independently.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="160">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">03</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/leverage-jv.webp" alt="Developer Expertise">
                        </div>
                        <h4>Leverage Developer Expertise</h4>
                        <p>Gain from decades of planning, development, marketing, and sales experience.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="240">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">04</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/stock-market-jv.webp" alt="Market Upsides">
                        </div>
                        <h4>Share in Market Upsides</h4>
                        <p>Capitalise on real estate market trends and maximize returns on your land.</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">05</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/regulation-jv.webp" alt="Regulations">
                        </div>
                        <h4>Navigate Regulations with Ease</h4>
                        <p>Ensure full compliance with all regulatory, legal, and RERA requirements.</p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="80">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">06</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/risk-mitigate-jv.webp" alt="Risk Mitigation">
                        </div>
                        <h4>Mitigate Development Risks</h4>
                        <p>Developer handles all development and sales responsibilities effectively.</p>
                    </div>
                </div>

                <!-- Card 7 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="160">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">07</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/legacy-jv.webp" alt="Legacy">
                        </div>
                        <h4>Be Part of Creating Landmarks</h4>
                        <p>Contribute to iconic developments and leave a lasting legacy in your community.</p>
                    </div>
                </div>

                <!-- Card 8 -->
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="240">
                    <div class="jv-benefit-card">
                        <div class="jv-benefit-num">08</div>
                        <div class="jv-benefit-icon">
                            <img src="rkimg/lifystyle-jv.webp" alt="Lifestyle">
                        </div>
                        <h4>Enhance Lifestyles &amp; Communities</h4>
                        <p>Facilitate positive changes and improve community lifestyles for generations.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section class="jv-process">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="jv-badge">Simple Process</div>
                <h2 class="jv-section-title">How the <span>JV Works</span></h2>
                <p class="jv-section-desc mx-auto" style="max-width:480px;">
                    A clear, structured 4-step process — from initial discussion to final handover.
                </p>
            </div>

            <div class="jv-process-wrap" data-aos="fade-up">
                <div class="jv-process-step">
                    <div class="jv-process-num">01</div>
                    <h5>Initial Discussion</h5>
                    <p>Share your land details with us. We evaluate the location, size, and development potential.</p>
                </div>
                <div class="jv-process-step">
                    <div class="jv-process-num">02</div>
                    <h5>Feasibility & Agreement</h5>
                    <p>We conduct a detailed feasibility study and draft a transparent JV agreement with clear terms.</p>
                </div>
                <div class="jv-process-step">
                    <div class="jv-process-num">03</div>
                    <h5>Development & Sales</h5>
                    <p>Our team handles all approvals, construction, marketing, and sales — end to end.</p>
                </div>
                <div class="jv-process-step">
                    <div class="jv-process-num">04</div>
                    <h5>Revenue Sharing</h5>
                    <p>Once units are sold, profits are shared as per the agreed terms — transparently and on time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== CONTACT & FORM ===== -->
    <section class="jv-contact" id="jv-contact">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-down">
                <div class="jv-badge">Let's Talk</div>
                <h2 class="jv-section-title">Start Your <span>JV Journey</span></h2>
                <p class="jv-section-desc mx-auto" style="max-width:460px;">
                    Ready to unlock your land's potential? Reach out to our Joint Venture team today.
                </p>
            </div>

            <div class="jv-form-card" data-aos="fade-up">
                <!-- Left Info -->
                <div class="jv-form-left">
                    <div>
                        <h3 class="jv-form-left-title">Contact Details</h3>
                        <p class="jv-form-left-desc">Our JV team will connect with you within 24 hours to discuss your land's potential.</p>

                        <ul class="jv-contact-items">
                            <li class="jv-contact-item">
                                <div class="jv-ci-icon"><i class="fa fa-user"></i></div>
                                <div class="jv-ci-text">
                                    <strong>Contact Person</strong>
                                    <span>Mr. Shivanshu Tiwari</span>
                                </div>
                            </li>
                            <li class="jv-contact-item">
                                <div class="jv-ci-icon"><i class="fa fa-whatsapp"></i></div>
                                <div class="jv-ci-text">
                                    <strong>WhatsApp</strong>
                                    <a href="https://wa.me/918955331454" target="_blank">+91 89553 31454</a>
                                </div>
                            </li>
                            <li class="jv-contact-item">
                                <div class="jv-ci-icon"><i class="fa fa-envelope"></i></div>
                                <div class="jv-ci-text">
                                    <strong>Mail Us</strong>
                                    <a href="mailto:info@ikanhousing.com">info@ikanhousing.com</a>
                                </div>
                            </li>
                            <li class="jv-contact-item">
                                <div class="jv-ci-icon"><i class="fa fa-map-marker"></i></div>
                                <div class="jv-ci-text">
                                    <strong>Office</strong>
                                    <span>Jaipur, Rajasthan, India</span>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <div class="jv-social-row">
                            <a href="https://www.facebook.com/IkanHousing" target="_blank" class="jv-social-btn"><i class="fa fa-facebook"></i></a>
                            <a href="https://www.instagram.com/ikanhousing" target="_blank" class="jv-social-btn"><i class="fa fa-instagram"></i></a>
                            <a href="https://www.linkedin.com/company/ikan-housing" target="_blank" class="jv-social-btn"><i class="fa fa-linkedin"></i></a>
                            <a href="https://wa.me/918955331454" target="_blank" class="jv-social-btn"><i class="fa fa-whatsapp"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Right Form -->
                <div class="jv-form-right">
                    <h3>Send Us Your Land Details</h3>
                    <p>Fill the form below and our JV specialist will get back to you.</p>

                    <form id="myFormM" action="contact.php" method="post">
                        <div class="jv-form-grid">
                            <div class="jv-field">
                                <label for="jv-fname">Full Name <span>*</span></label>
                                <input type="text" class="jv-input" id="jv-fname" name="name" placeholder="e.g. Ramesh Sharma" required>
                            </div>
                            <div class="jv-field">
                                <label for="jv-email">Email Address <span>*</span></label>
                                <input type="email" class="jv-input" id="jv-email" name="email" placeholder="you@example.com" required>
                            </div>
                            <div class="jv-field full">
                                <label for="jv-phone">Mobile Number <span>*</span></label>
                                <input type="tel" class="jv-input" id="jv-phone" name="phone" placeholder="Your 10-digit mobile number" required maxlength="10">
                            </div>
                            <div class="jv-field full">
                                <label for="jv-message">Land Details / Message <span>*</span></label>
                                <textarea class="jv-input" id="jv-message" name="message" placeholder="Describe your land — location, size, and your expectations..." required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="jv-submit-btn">
                            <i class="fa fa-paper-plane"></i> Submit JV Enquiry
                        </button>
                        <div id="popup-messages-jv"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <?php include 'component/footer.php'; ?>

    <script>
    // Form AJAX
    $(document).ready(function () {
        $("#myFormM").on('submit', function (e) {
            e.preventDefault();
            var formData = $(this).serialize();
            var btn = $(this).find('.jv-submit-btn');
            btn.html('<i class="fa fa-spinner fa-spin"></i> Submitting...').prop('disabled', true);

            $.ajax({
                url: "contact.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    showJVPopup("✅ Enquiry sent! Our JV team will contact you within 24 hours.");
                    $("#myFormM")[0].reset();
                },
                error: function () {
                    showJVPopup("❌ Something went wrong. Please try again.", true);
                },
                complete: function () {
                    btn.html('<i class="fa fa-paper-plane"></i> Submit JV Enquiry').prop('disabled', false);
                }
            });
        });

        function showJVPopup(msg, isError = false) {
            const p = $("#popup-messages-jv");
            p.text(msg).css("background-color", isError ? "#e74c3c" : "#c02a7c").fadeIn(300);
            setTimeout(() => p.fadeOut(400), 5500);
        }
    });
    </script>

</body>
</html>
