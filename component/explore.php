<!-- ===== EXPLORE OTHER SERVICES — MARQUEE RESTORATION (NON-CLICKABLE) ===== -->
<style>
.explore-section {
    padding: 80px 0 90px;
    background: #fff;
    position: relative;
    overflow: hidden;
}

.explore-section::before {
    content: '';
    position: absolute;
    top: -120px; left: 50%;
    transform: translateX(-50%);
    width: 700px; height: 700px;
    background: radial-gradient(circle, rgba(192,42,124,0.05) 0%, transparent 65%);
    pointer-events: none;
}

/* Header */
.explore-header {
    text-align: center;
    margin-bottom: 56px;
}

.explore-badge {
    display: inline-block;
    background: #fce7f3;
    color: #c02a7c;
    padding: 6px 20px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 18px;
}

.explore-title {
    font-size: clamp(1.9rem, 3.5vw, 2.8rem);
    font-weight: 800;
    color: #2d0a1c;
    margin-bottom: 12px;
    line-height: 1.2;
}

.explore-title span {
    color: #c02a7c;
}

.explore-subtitle {
    color: #8e6f7e;
    font-size: 1rem;
    max-width: 460px;
    margin: 0 auto;
    line-height: 1.7;
}

/* ===== MARQUEE TRACK ===== */
.explore-marquee-wrap {
    overflow: hidden;
    position: relative;
    margin-bottom: 20px;
}

/* Fade edges */
.explore-marquee-wrap::before,
.explore-marquee-wrap::after {
    content: '';
    position: absolute;
    top: 0; bottom: 0;
    width: 150px;
    z-index: 2;
    pointer-events: none;
}

.explore-marquee-wrap::before {
    left: 0;
    background: linear-gradient(to right, #fff, transparent);
}

.explore-marquee-wrap::after {
    right: 0;
    background: linear-gradient(to left, #fff, transparent);
}

.explore-track {
    display: flex;
    gap: 20px;
    width: max-content;
    animation: marqueeLeft 40s linear infinite;
}

.explore-track.reverse {
    animation: marqueeRight 40s linear infinite;
}

@keyframes marqueeLeft {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

@keyframes marqueeRight {
    0%   { transform: translateX(-50%); }
    100% { transform: translateX(0); }
}

/* ===== Service Card (Non-Clickable) ===== */
.explore-card {
    display: flex;
    align-items: center;
    gap: 14px;
    background: #fff;
    border: 1.5px solid #f1e8ef;
    border-radius: 16px;
    padding: 18px 26px;
    min-width: 220px;
    transition: all 0.3s ease;
    flex-shrink: 0;
    user-select: none;
}

.explore-card-icon {
    width: 48px; height: 48px;
    background: #fce7f3;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

.explore-card-icon img {
    width: 26px; height: 26px;
    object-fit: contain;
}

.explore-card-label {
    font-size: 0.9rem;
    font-weight: 600;
    color: #2d0a1c;
    line-height: 1.3;
}

/* CTA strip */
.explore-cta-strip {
    text-align: center;
    margin-top: 40px;
}

.btn-explore-all {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 14px 36px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none !important;
    transition: all 0.4s ease;
    box-shadow: 0 10px 28px rgba(192,42,124,0.2);
}

.btn-explore-all:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(192,42,124,0.35);
    color: #fff;
}
</style>

<section class="explore-section">
    <div class="container">
        <!-- Header -->
        <div class="explore-header" data-aos="fade-down">
            <div class="explore-badge">Our Ecosystem</div>
            <h2 class="explore-title">Explore Our <span>Other Services</span></h2>
            <p class="explore-subtitle">A comprehensive suite of real estate solutions — all under one trusted roof.</p>
        </div>
    </div>

    <!-- ROW 1: Left scroll (Non-Clickable) -->
    <div class="explore-marquee-wrap mb-4" data-aos="fade-up">
        <div class="explore-track">
            <!-- Set 1 -->
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/digital.svg" alt="Digital"></div>
                <span class="explore-card-label">Digital Agency</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/creative.svg" alt="Creative"></div>
                <span class="explore-card-label">Creative Agency</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/land.svg" alt="Land"></div>
                <span class="explore-card-label">Land Services</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/Retail.svg" alt="Retail"></div>
                <span class="explore-card-label">Retail Services</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/invest.svg" alt="Investment"></div>
                <span class="explore-card-label">Investment Banking</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/commercial.svg" alt="Commercial"></div>
                <span class="explore-card-label">Retail Strata</span>
            </div>
            <!-- Set 2 (for loop) -->
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/digital.svg" alt="Digital"></div>
                <span class="explore-card-label">Digital Agency</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/creative.svg" alt="Creative"></div>
                <span class="explore-card-label">Creative Agency</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/land.svg" alt="Land"></div>
                <span class="explore-card-label">Land Services</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/Retail.svg" alt="Retail"></div>
                <span class="explore-card-label">Retail Services</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/invest.svg" alt="Investment"></div>
                <span class="explore-card-label">Investment Banking</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/commercial.svg" alt="Commercial"></div>
                <span class="explore-card-label">Retail Strata</span>
            </div>
        </div>
    </div>

    <!-- ROW 2: Right scroll (Non-Clickable) -->
    <div class="explore-marquee-wrap" data-aos="fade-up" data-aos-delay="100">
        <div class="explore-track reverse">
            <!-- Set 1 -->
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/hospitality.svg" alt="Hospitality"></div>
                <span class="explore-card-label">Hospitality</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/industrial.svg" alt="Logistics"></div>
                <span class="explore-card-label">Industrial & Logistics</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/strategic.svg" alt="Strategic"></div>
                <span class="explore-card-label">Strategic Advisory</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/flexible.svg" alt="Flexible"></div>
                <span class="explore-card-label">Workspaces</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/apartmnt.svg" alt="Apartment"></div>
                <span class="explore-card-label">Society Management</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/invest.svg" alt="Sales"></div>
                <span class="explore-card-label">Sales & Marketing</span>
            </div>
            <!-- Set 2 (for loop) -->
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/hospitality.svg" alt="Hospitality"></div>
                <span class="explore-card-label">Hospitality</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/industrial.svg" alt="Logistics"></div>
                <span class="explore-card-label">Industrial & Logistics</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/strategic.svg" alt="Strategic"></div>
                <span class="explore-card-label">Strategic Advisory</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/flexible.svg" alt="Flexible"></div>
                <span class="explore-card-label">Workspaces</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/apartmnt.svg" alt="Apartment"></div>
                <span class="explore-card-label">Society Management</span>
            </div>
            <div class="explore-card">
                <div class="explore-card-icon"><img src="svg-img/invest.svg" alt="Sales"></div>
                <span class="explore-card-label">Sales & Marketing</span>
            </div>
        </div>
    </div>

    <!-- CTA Strip -->
    <div class="explore-cta-strip" data-aos="fade-up">
        <a href="services" class="btn-explore-all">
            View All Services <i class="fa fa-arrow-right"></i>
        </a>
    </div>
</section>