<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== HOME SOLUTIONS — PREMIUM PINK & PLUM DESIGN ===== */

/* ---- HERO SECTION ---- */
.hs-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514;
}

.hs-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.35;
    z-index: 0;
}

.hs-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,5,20,0.92) 0%, rgba(45,10,28,0.7) 50%, rgba(192,42,124,0.15) 100%);
    z-index: 1;
}

.hs-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
    padding-bottom: 80px;
}

.hs-hero-badge {
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

.hs-hero-title {
    font-size: clamp(3rem, 6.5vw, 6rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    letter-spacing: -2px;
    margin-bottom: 25px;
}

.hs-hero-title span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hs-hero-desc {
    color: rgba(255,255,255,0.7);
    font-size: 1.15rem;
    line-height: 1.8;
    max-width: 580px;
    margin-bottom: 40px;
}

/* ---- COMPETITIVE EDGE ---- */
.hs-edge {
    padding: 100px 0;
    background: #fff;
}

.hs-edge-card {
    background: #fff;
    border-radius: 30px;
    padding: 40px;
    height: 100%;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 15px 45px rgba(45,10,28,0.03);
    transition: all 0.4s ease;
}

.hs-edge-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(192,42,124,0.1);
    border-color: rgba(192,42,124,0.15);
}

.hs-stat-box {
    margin-bottom: 30px;
}

.hs-stat-num {
    font-size: 3.5rem;
    font-weight: 900;
    color: #2d0a1c;
    line-height: 1;
    margin-bottom: 10px;
}

.hs-stat-num span { color: #c02a7c; }

.hs-stat-label {
    color: #8e6f7e;
    font-size: 1rem;
    font-weight: 600;
}

.hs-feature-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
}

.hs-feature-icon {
    width: 45px; height: 45px;
    background: #fff5f9;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 1.2rem;
    flex-shrink: 0;
}

.hs-feature-text {
    font-size: 0.95rem;
    color: #3a1d2e;
    line-height: 1.6;
}

/* ---- AUDIENCE SECTION ---- */
.hs-audience {
    padding: 100px 0;
    background: #fff5f9;
}

.hs-badge {
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

.hs-section-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 850;
    color: #2d0a1c;
    margin-bottom: 15px;
}

.hs-section-title span { color: #c02a7c; }

.hs-pill-tabs {
    display: flex;
    gap: 12px;
    margin-top: 30px;
}

.hs-pill {
    background: #fff;
    border: 1px solid #e1d4dc;
    color: #8e6f7e;
    padding: 10px 24px;
    border-radius: 50px;
    font-size: 0.9rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex; align-items: center; gap: 8px;
}

.hs-pill.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    border-color: #c02a7c;
    box-shadow: 0 10px 25px rgba(192,42,124,0.25);
}

/* AUDIENCE PANELS */
.hs-panel {
    display: none;
    margin-top: 50px;
}

.hs-panel.active {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 50px;
    animation: hsFadeUp 0.5s ease-out;
}

@keyframes hsFadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.hs-sidebar {
    background: #fff;
    border-radius: 25px;
    padding: 30px;
    border: 1px solid rgba(45,10,28,0.05);
}

.hs-nav-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 18px;
    border-radius: 15px;
    color: #2d0a1c;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none !important;
    transition: all 0.3s ease;
    margin-bottom: 8px;
}

.hs-nav-link i {
    width: 32px; height: 32px;
    background: #fff5f9;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 0.85rem;
}

.hs-nav-link.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    box-shadow: 0 10px 20px rgba(192,42,124,0.2);
}

.hs-nav-link.active i {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

/* Service Info Card */
.hs-detail-card {
    display: none;
    background: #fff;
    border-radius: 35px;
    overflow: hidden;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 15px 45px rgba(45,10,28,0.03);
    animation: hsCardFade 0.4s ease-out;
}

.hs-detail-card.active {
    display: block;
}

@keyframes hsCardFade {
    from { opacity: 0; transform: translateX(15px); }
    to { opacity: 1; transform: translateX(0); }
}

.hs-card-img {
    width: 100%; height: 350px;
    object-fit: cover;
}

.hs-card-body {
    padding: 45px;
}

.hs-card-body h3 {
    font-size: 1.8rem;
    font-weight: 850;
    color: #2d0a1c;
    margin-bottom: 15px;
}

.hs-card-body p {
    color: #8e6f7e;
    font-size: 1.05rem;
    line-height: 1.8;
    margin-bottom: 25px;
}

.hs-feature-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 30px;
}

.hs-list-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
    color: #3a1d2e;
    font-size: 0.95rem;
}

.hs-list-item i { color: #c02a7c; }

/* ---- CTA ---- */
.hs-cta {
    padding: 100px 0;
    background: #fff;
}

.hs-cta-box {
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 60%, #0a0514 100%);
    border-radius: 40px;
    padding: 80px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.hs-cta-box h2 {
    font-size: clamp(2rem, 5vw, 3.5rem);
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
}

.hs-cta-box h2 span { color: #ff85c0; }

.hs-cta-box p {
    color: rgba(255,255,255,0.6);
    font-size: 1.2rem;
    max-width: 700px;
    margin: 0 auto 40px;
}

.hs-btn-primary {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 18px 45px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 1.1rem;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.4s ease;
    box-shadow: 0 15px 35px rgba(192,42,124,0.3);
}

.hs-btn-primary:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(192,42,124,0.45);
    color: #fff;
}

@media (max-width: 991px) {
    .hs-panel.active { grid-template-columns: 1fr; }
    .hs-feature-list { grid-template-columns: 1fr; }
}
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="hs-hero">
        <video autoplay muted loop playsinline class="hs-hero-video">
            <source src="rkimg/Home_Solutionss.webm" type="video/webm">
        </video>
        <div class="hs-hero-overlay"></div>
        <div class="container hs-hero-content">
            <div class="row">
                <div class="col-lg-8" data-aos="fade-up">
                    <div class="hs-hero-badge">Expert Home Guidance</div>
                    <h1 class="hs-hero-title">Seamless Journey to Your <span>Dream Home</span></h1>
                    <p class="hs-hero-desc">Providing personalized assistance and tech-driven solutions for home loans, interiors, and smarter living.</p>
                    <div class="d-flex gap-3">
                        <a href="#showw" class="hs-btn-primary">Connect With Us Now <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== COMPETITIVE EDGE ===== -->
    <section class="hs-edge">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="hs-edge-card">
                        <div class="hs-stat-box">
                            <div class="hs-stat-num"><span>15</span>+</div>
                            <div class="hs-stat-label">Years of cumulative product experience</div>
                        </div>
                        <div class="hs-feature-item">
                            <div class="hs-feature-icon"><i class="fa fa-university"></i></div>
                            <div class="hs-feature-text">Partnerships with leading Indian banks, HFCs, and NBFCs for the best loan rates.</div>
                        </div>
                        <div class="hs-feature-item">
                            <div class="hs-feature-icon"><i class="fa fa-magic"></i></div>
                            <div class="hs-feature-text">Global service providers for interiors, home automation, and smart furniture.</div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="ps-4">
                        <div class="hs-badge">Why Choose Us</div>
                        <h2 class="hs-section-title">A Sole Focus on <span>Holistic Excellence</span></h2>
                        <p class="res-section-desc" style="font-size: 1.1rem; line-height: 1.8; color: #8e6f7e; margin-bottom: 30px;">
                            Our mission is to deliver comprehensive services that address every single home-related need of our consumers. From financial eligibility to smart home possession.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="hs-feature-icon" style="background:#fff;"><i class="fa fa-check-circle"></i></div>
                                    <div>
                                        <h5 style="font-weight:800; color:#2d0a1c; font-size:1rem;">Tech-Driven Solutions</h5>
                                        <p style="font-size:0.85rem; color:#8e6f7e;">Real-time dashboards and automated tracking.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="hs-feature-icon" style="background:#fff;"><i class="fa fa-check-circle"></i></div>
                                    <div>
                                        <h5 style="font-weight:800; color:#2d0a1c; font-size:1rem;">Global Partnerships</h5>
                                        <p style="font-size:0.85rem; color:#8e6f7e;">Access to elite interior designers and smart tech.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== AUDIENCE & SERVICES ===== -->
    <section class="hs-audience" id="services">
        <div class="container">
            <div class="row align-items-end mb-5">
                <div class="col-lg-7" data-aos="fade-right">
                    <div class="hs-badge">What We Do For You</div>
                    <h2 class="hs-section-title">Tailored Solutions for <span>Every Stakeholder</span></h2>
                </div>
                <div class="col-lg-5" data-aos="fade-left">
                    <div class="hs-pill-tabs">
                        <div class="hs-pill active" onclick="switchAudiTab('developers', this)">
                            <i class="fa fa-building"></i> Developers
                        </div>
                        <div class="hs-pill" onclick="switchAudiTab('partners', this)">
                            <i class="fa fa-handshake-o"></i> Channel Partners
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: DEVELOPERS -->
            <div class="hs-panel active" id="panel-developers">
                <aside class="hs-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px; font-size:1.2rem;">For Developers</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Enabling developers to deliver maximum value to homebuyers.</p>
                    <div class="hs-nav-links">
                        <a href="javascript:void(0)" class="hs-nav-link active" onclick="switchDetailCard('loans', this)">
                            <i class="fa fa-money"></i> Home Loan Products
                        </a>
                        <a href="javascript:void(0)" class="hs-nav-link" onclick="switchDetailCard('ops', this)">
                            <i class="fa fa-rocket"></i> Smarter Operations
                        </a>
                        <a href="javascript:void(0)" class="hs-nav-link" onclick="switchDetailCard('furnished', this)">
                            <i class="fa fa-home"></i> Furnished Homes
                        </a>
                    </div>
                </aside>

                <div class="hs-content">
                    <div class="hs-detail-card active" id="loans">
                        <img src="rkimg/Home_Loan_Products_and_Schemes1.jpg" class="hs-card-img" alt="Home Loan">
                        <div class="hs-card-body">
                            <h3>Home Loan Products & Schemes</h3>
                            <p>We combine intelligence with expertise to offer customized APF and financial schemes from India's preferred banks.</p>
                            <div class="hs-feature-list">
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Customised Loan Schemes</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Home Loan Experts</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Milestone Disbursements</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Preferred Bank Tie-ups</div>
                            </div>
                            <a href="#showw" class="hs-btn-primary" style="padding:12px 30px; font-size:0.9rem;">Partner With Us</a>
                        </div>
                    </div>

                    <div class="hs-detail-card" id="ops">
                        <img src="rkimg/Smarter_Operationss.jpg" class="hs-card-img" alt="Operations">
                        <div class="hs-card-body">
                            <h3>Smarter Operations</h3>
                            <p>Patented lead management solutions designed to streamline developer workflows and ensure no lead is left behind.</p>
                            <div class="hs-feature-list">
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Patented Lead Management</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Single Click Dashboard</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Real-time Analytics</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Automated Follow-ups</div>
                            </div>
                            <a href="#showw" class="hs-btn-primary" style="padding:12px 30px; font-size:0.9rem;">View Solution</a>
                        </div>
                    </div>

                    <div class="hs-detail-card" id="furnished">
                        <img src="rkimg/Furnished_Homess.jpg" class="hs-card-img" alt="Furnished">
                        <div class="hs-card-body">
                            <h3>Furnished & Smart Homes</h3>
                            <p>Deliver move-in ready homes with tailored interiors by global leaders and integrated smart home technology.</p>
                            <div class="hs-feature-list">
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Possession Events</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Global Interior Leaders</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Smart Home Tech</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Turnkey Execution</div>
                            </div>
                            <a href="#showw" class="hs-btn-primary" style="padding:12px 30px; font-size:0.9rem;">See Showroom</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PANEL: PARTNERS -->
            <div class="hs-panel" id="panel-partners">
                <aside class="hs-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px; font-size:1.2rem;">Channel Partners</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Helping partners expand their service offerings and revenue.</p>
                    <div class="hs-nav-links">
                        <a href="javascript:void(0)" class="hs-nav-link active" onclick="switchDetailCard('referral', this)">
                            <i class="fa fa-trophy"></i> Referral Programme
                        </a>
                        <a href="javascript:void(0)" class="hs-nav-link" onclick="switchDetailCard('dashboard', this)">
                            <i class="fa fa-th-large"></i> Tech Dashboard
                        </a>
                    </div>
                </aside>

                <div class="hs-content">
                    <div class="hs-detail-card active" id="referral">
                        <img src="rkimg/Referral_Programmee.jpg" class="hs-card-img" alt="Referral">
                        <div class="hs-card-body">
                            <h3>Referral Programme</h3>
                            <p>Empower your network and create an additional source of revenue through our structured referral mechanism.</p>
                            <div class="hs-feature-list">
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Committed Commissions</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Transparent Payouts</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Track Referrals Live</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Professional Training</div>
                            </div>
                            <a href="#showw" class="hs-btn-primary" style="padding:12px 30px; font-size:0.9rem;">Join Programme</a>
                        </div>
                    </div>

                    <div class="hs-detail-card" id="dashboard">
                        <img src="rkimg/Tech_Dashboardd.jpg" class="hs-card-img" alt="Dashboard">
                        <div class="hs-card-body">
                            <h3>Partner Tech Dashboard</h3>
                            <p>Track every lead and update client status in real-time with our proprietary single-click dashboard.</p>
                            <div class="hs-feature-list">
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Single-Click Tracking</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Real-time Updates</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Client Management</div>
                                <div class="hs-list-item"><i class="fa fa-check-circle"></i> Lead Source Analytics</div>
                            </div>
                            <a href="#showw" class="hs-btn-primary" style="padding:12px 30px; font-size:0.9rem;">Request Access</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="hs-cta">
        <div class="container">
            <div class="hs-cta-box" data-aos="zoom-in">
                <h2>Build Your Future <span>Today</span></h2>
                <p>Whether you're looking for financial assistance or smart home solutions, our experts are just one click away.</p>
                <a href="#showw" class="hs-btn-primary">Let's Connect Now <i class="fa fa-comments"></i></a>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

    <script>
    function switchAudiTab(id, btn) {
        document.querySelectorAll('.hs-pill').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.hs-panel').forEach(el => el.classList.remove('active'));
        
        btn.classList.add('active');
        const panel = document.getElementById('panel-' + id);
        panel.classList.add('active');
        
        // Reset inner tabs to first
        const firstLink = panel.querySelector('.hs-nav-link');
        const firstCard = panel.querySelector('.hs-detail-card');
        panel.querySelectorAll('.hs-nav-link').forEach(l => l.classList.remove('active'));
        panel.querySelectorAll('.hs-detail-card').forEach(c => c.classList.remove('active'));
        if(firstLink) firstLink.classList.add('active');
        if(firstCard) firstCard.classList.add('active');
    }

    function switchDetailCard(id, btn) {
        const panel = btn.closest('.hs-panel');
        panel.querySelectorAll('.hs-nav-link').forEach(el => el.classList.remove('active'));
        panel.querySelectorAll('.hs-detail-card').forEach(el => el.classList.remove('active'));
        
        btn.classList.add('active');
        const card = panel.querySelector('#' + id);
        card.classList.add('active');

        if(window.innerWidth < 992) {
            card.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    </script>

</body>
</html>