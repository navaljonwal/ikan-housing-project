<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== RETAIL — PREMIUM PINK & PLUM DESIGN ===== */

/* ---- HERO SECTION ---- */
.ret-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514;
}

.ret-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.35;
    z-index: 0;
}

.ret-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,5,20,0.92) 0%, rgba(45,10,28,0.7) 50%, rgba(192,42,124,0.15) 100%);
    z-index: 1;
}

.ret-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 120px;
    padding-bottom: 80px;
}

.ret-hero-badge {
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

.ret-hero-title {
    font-size: clamp(3rem, 7vw, 6.5rem);
    font-weight: 900;
    color: #fff;
    line-height: 1;
    letter-spacing: -3px;
    margin-bottom: 25px;
}

.ret-hero-title span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ret-hero-desc {
    color: rgba(255,255,255,0.7);
    font-size: 1.2rem;
    line-height: 1.8;
    max-width: 600px;
    margin-bottom: 40px;
}

/* ---- COMPETITIVE EDGE ---- */
.ret-edge {
    padding: 100px 0;
    background: #fff;
}

.ret-edge-card {
    background: #fff;
    border-radius: 35px;
    padding: 50px;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 20px 50px rgba(45,10,28,0.03);
    transition: all 0.4s ease;
}

.ret-edge-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 40px 80px rgba(192,42,124,0.12);
    border-color: rgba(192,42,124,0.15);
}

.ret-stat-box {
    margin-bottom: 35px;
}

.ret-stat-num {
    font-size: 3.8rem;
    font-weight: 900;
    color: #2d0a1c;
    line-height: 1;
    margin-bottom: 5px;
}

.ret-stat-num span { color: #c02a7c; }

.ret-stat-label {
    font-size: 1.05rem;
    color: #8e6f7e;
    font-weight: 700;
}

.ret-feature-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    align-items: center;
}

.ret-feature-icon {
    width: 55px; height: 55px;
    background: #fff5f9;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 1.4rem;
    flex-shrink: 0;
}

.ret-feature-text {
    font-size: 0.95rem;
    color: #3a1d2e;
    line-height: 1.6;
    font-weight: 600;
}

/* ---- AUDIENCE SECTION ---- */
.ret-audience {
    padding: 100px 0;
    background: #fdf6fb;
}

.ret-badge {
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

.ret-section-title {
    font-size: clamp(2rem, 4vw, 3rem);
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 50px;
}

.ret-section-title span { color: #c02a7c; }

.ret-pill-tabs {
    display: flex;
    gap: 12px;
    margin-bottom: 50px;
}

.ret-pill {
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

.ret-pill.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    border-color: #c02a7c;
    box-shadow: 0 10px 25px rgba(192,42,124,0.25);
}

/* PANELS */
.ret-panel {
    display: none;
}

.ret-panel.active {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 50px;
    animation: retFadeUp 0.6s ease-out;
}

@keyframes retFadeUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
}

.ret-sidebar {
    background: #fff;
    border-radius: 30px;
    padding: 35px;
    border: 1px solid rgba(45,10,28,0.05);
}

.ret-nav-link {
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

.ret-nav-link i {
    width: 35px; height: 35px;
    background: #fff5f9;
    border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 0.9rem;
}

.ret-nav-link.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    box-shadow: 0 12px 24px rgba(192,42,124,0.2);
}

.ret-nav-link.active i {
    background: rgba(255,255,255,0.2);
    color: #fff;
}

/* Detail Card */
.ret-detail-card {
    display: none;
    background: #fff;
    border-radius: 40px;
    overflow: hidden;
    border: 1px solid rgba(45,10,28,0.05);
    box-shadow: 0 20px 50px rgba(45,10,28,0.04);
}

.ret-detail-card.active {
    display: block;
    animation: retSlideIn 0.5s ease-out;
}

@keyframes retSlideIn {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

.ret-card-img {
    width: 100%; height: 380px;
    object-fit: cover;
}

.ret-card-body {
    padding: 50px;
}

.ret-card-body h3 {
    font-size: 2rem;
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 20px;
}

.ret-card-body p {
    color: #8e6f7e;
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 30px;
}

.ret-feature-list {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
    margin-bottom: 35px;
}

.ret-list-item {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 700;
    color: #3f2032;
    font-size: 0.9rem;
}

.ret-list-item i { color: #c02a7c; }

/* ---- CTA ---- */
.ret-cta {
    padding: 100px 0;
    background: #fff;
}

.ret-cta-box {
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 60%, #0a0514 100%);
    border-radius: 50px;
    padding: 100px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.ret-cta-box h2 {
    font-size: clamp(2rem, 5.5vw, 3.8rem);
    font-weight: 950;
    color: #fff;
    margin-bottom: 25px;
    letter-spacing: -1px;
}

.ret-cta-box h2 span { color: #ff85c0; }

.ret-btn-primary {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 20px 55px;
    border-radius: 60px;
    font-weight: 800;
    font-size: 1.2rem;
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 12px;
    transition: all 0.4s ease;
    box-shadow: 0 15px 35px rgba(192,42,124,0.3);
}

.ret-btn-primary:hover {
    transform: translateY(-8px);
    box-shadow: 0 30px 60px rgba(192,42,124,0.5);
    color: #fff;
}

@media (max-width: 991px) {
    .ret-panel.active { grid-template-columns: 1fr; }
    .ret-sidebar { position: static; }
    .ret-feature-list { grid-template-columns: 1fr; }
}
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <style>
        .intro-content { padding-top: 120px !important; }
        @media (max-width: 991px) { .intro-content { padding-top: 90px !important; } }
    </style>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="ret-hero">
        <video autoplay muted loop playsinline class="ret-hero-video">
            <source src="rkimg/Retails.webm" type="video/webm">
        </video>
        <div class="ret-hero-overlay"></div>
        <div class="container ret-hero-content">
            <div class="row">
                <div class="col-lg-9" data-aos="fade-up">
                    <div class="ret-hero-badge">Experience Architecture</div>
                    <h1 class="ret-hero-title">Beyond Brick <span>& Mortar</span></h1>
                    <p class="ret-hero-desc">Transforming retail challenges into competitive advantages. We build communities and create memorable experiences through customized real estate solutions.</p>
                    <div class="d-flex gap-3">
                        <a href="#showw" class="ret-btn-primary">Connect With Us <i class="fa fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== COMPETITIVE EDGE ===== -->
    <section class="ret-edge">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="ret-edge-card">
                        <div class="ret-stat-box">
                            <div class="ret-stat-num"><span>6000</span>+</div>
                            <div class="ret-stat-label">Transactions across 55+ cities pan-India</div>
                        </div>
                        <div class="d-flex flex-column gap-4">
                            <div class="ret-feature-item">
                                <div class="ret-feature-icon"><i class="fa fa-shopping-bag"></i></div>
                                <div class="ret-feature-text">Over 22 million sq. ft. of shopping centres exclusively transacted.</div>
                            </div>
                            <div class="ret-feature-item">
                                <div class="ret-feature-icon"><i class="fa fa-trophy"></i></div>
                                <div class="ret-feature-text">15+ Years of collective leadership experience in the retail domain.</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="ps-lg-5">
                        <div class="ret-badge">The Retail Edge</div>
                        <h2 class="ret-section-title" style="margin-bottom:30px;">Creating <span>Memorable Experiences</span></h2>
                        <p class="res-section-desc" style="font-size:1.1rem; line-height:1.8; color:#8e6f7e; margin-bottom:35px;">
                            The fast-paced nature of the retail market requires dynamic strategies. We collaborate closely with developers, occupiers, and investors to deliver solutions that adapt to ever-changing dynamics.
                        </p>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <div class="d-flex gap-3 align-items-start">
                                    <div class="ret-feature-icon" style="background:#fff;"><i class="fa fa-rocket"></i></div>
                                    <div>
                                        <h5 style="font-weight:900; color:#2d0a1c; margin-bottom:5px;">Community Building</h5>
                                        <p style="color:#8e6f7e; font-size:0.9rem;">Turning structures into vibrant hubs of commerce and social interaction.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== AUDIENCE SECTION ===== -->
    <section class="ret-audience" id="services">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8" data-aos="fade-right">
                    <div class="ret-badge">Solutions Portfolio</div>
                    <h2 class="ret-section-title">What We Can Do <span>For You</span></h2>
                </div>
            </div>

            <div class="ret-pill-tabs" data-aos="fade-up">
                <div class="ret-pill active" onclick="switchRetailTab('developers', this)">
                    <i class="fa fa-building"></i> Developers
                </div>
                <div class="ret-pill" onclick="switchRetailTab('partners', this)">
                    <i class="fa fa-handshake-o"></i> Channel Partners
                </div>
                <div class="ret-pill" onclick="switchRetailTab('corporates', this)">
                    <i class="fa fa-id-card"></i> Corporates
                </div>
            </div>

            <!-- PANEL: DEVELOPERS -->
            <div class="ret-panel active" id="panel-developers">
                <aside class="ret-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px;">For Developers</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Customized solutions aligned with the latest market trends.</p>
                    <div class="ret-nav-links">
                        <a href="javascript:void(0)" class="ret-nav-link active" onclick="switchDetailCard('management', this)">
                            <i class="fa fa-tasks"></i> Transaction Mgmt
                        </a>
                        <a href="javascript:void(0)" class="ret-nav-link" onclick="switchDetailCard('advisory', this)">
                            <i class="fa fa-lightbulb-o"></i> Retail Advisory
                        </a>
                        <a href="javascript:void(0)" class="ret-nav-link" onclick="switchDetailCard('leasing', this)">
                            <i class="fa fa-key"></i> Retail Leasing
                        </a>
                        <a href="javascript:void(0)" class="ret-nav-link" onclick="switchDetailCard('alternatives', this)">
                            <i class="fa fa-puzzle-piece"></i> Alternatives
                        </a>
                    </div>
                </aside>

                <div class="ret-content">
                    <div class="ret-detail-card active" id="management">
                        <img src="rkimg/Transaction_Managementtt.jpg" class="ret-card-img" alt="Management">
                        <div class="ret-card-body">
                            <h3>Transaction Management</h3>
                            <p>End-to-end management for Sale and Leasing, ensuring strategic property sourcing and relocations.</p>
                            <div class="ret-feature-list">
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Market Entry Strategy</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Location Advisory</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Property Sourcing</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Transaction Execution</div>
                            </div>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Start Strategy</a>
                        </div>
                    </div>

                    <div class="ret-detail-card" id="advisory">
                        <img src="rkimg/Retail_Advisory_&_Consultancyy.jpg" class="ret-card-img" alt="Advisory">
                        <div class="ret-card-body">
                            <h3>Retail Advisory & Consultancy</h3>
                            <p>Aligning concept, positioning, and sizing strategies to maximize the potential of retail structures.</p>
                            <div class="ret-feature-list">
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Feasibility Study</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Concept positioning</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Tenant Mix Planning</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Financial Modelling</div>
                            </div>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Consult Experts</a>
                        </div>
                    </div>

                    <div class="ret-detail-card" id="leasing">
                        <img src="rkimg/Retail_Leasingg.jpg" class="ret-card-img" alt="Leasing">
                        <div class="ret-card-body">
                            <h3>Retail Leasing</h3>
                            <p>Negotiating trustworthy and affordable lease deals with planned expansion strategies.</p>
                            <div class="ret-feature-list">
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Affordable Lease deals</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Deal Negotiations</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Expansion Planning</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> space recommendations</div>
                            </div>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Manage Leasing</a>
                        </div>
                    </div>

                    <div class="ret-detail-card" id="alternatives">
                        <img src="rkimg/Alternativesss.jpg" class="ret-card-img" alt="Alternatives">
                        <div class="ret-card-body">
                            <h3>Alternatives Advisory</h3>
                            <p>Catering to specialized asset classes including Co-Living, Co-Working, and Educational entities.</p>
                            <div class="ret-feature-list">
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Co-Living Assets</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Co-Working Spaces</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Educational Entities</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Portfolio Diversification</div>
                            </div>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Explore Assets</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- THE PANELS FOR PARTNERS & CORPORATES WILL USE THE SAME STRUCTURE VIA JS RESET -->
            <div class="ret-panel" id="panel-partners">
                 <aside class="ret-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px;">Channel Partners</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Empowering partners to scale business and expand operations.</p>
                    <div class="ret-nav-links">
                        <a href="javascript:void(0)" class="ret-nav-link active" onclick="switchDetailCard('management-p', this)">
                            <i class="fa fa-tasks"></i> Transaction Mgmt
                        </a>
                        <a href="javascript:void(0)" class="ret-nav-link" onclick="switchDetailCard('advisory-p', this)">
                            <i class="fa fa-lightbulb-o"></i> Retail Advisory
                        </a>
                    </div>
                </aside>
                <div class="ret-content">
                    <div class="ret-detail-card active" id="management-p">
                        <img src="rkimg/Transaction_Managementtt.jpg" class="ret-card-img" alt="Management">
                        <div class="ret-card-body">
                            <h3>Partner Transaction Desk</h3>
                            <p>Providing cutting-edge tools to help partners connect effectively with developers and occupiers.</p>
                             <div class="ret-feature-list">
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Sourcing Assistance</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Lead Management</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Negotiation Support</div>
                                <div class="ret-list-item"><i class="fa fa-check-circle"></i> Ops Scaling</div>
                            </div>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Join Network</a>
                        </div>
                    </div>
                     <div class="ret-detail-card" id="advisory-p">
                        <img src="rkimg/Retail_Advisory_&_Consultancyy.jpg" class="ret-card-img" alt="Advisory">
                        <div class="ret-card-body">
                            <h3>Consultancy Support</h3>
                            <p>Empowering you with well-informed market consultancy to serve your retail clients better.</p>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Talk to Expert</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="ret-panel" id="panel-corporates">
                 <aside class="ret-sidebar">
                    <h4 style="font-weight:850; color:#2d0a1c; margin-bottom:15px;">For Corporates</h4>
                    <p style="font-size:0.85rem; color:#8e6f7e; margin-bottom:25px;">Structuring transactions and monetizing retail assets.</p>
                    <div class="ret-nav-links">
                        <a href="javascript:void(0)" class="ret-nav-link active" onclick="switchDetailCard('monetize', this)">
                            <i class="fa fa-diamond"></i> Monetization
                        </a>
                        <a href="javascript:void(0)" class="ret-nav-link" onclick="switchDetailCard('expand', this)">
                            <i class="fa fa-globe"></i> Global Expansion
                        </a>
                    </div>
                </aside>
                <div class="ret-content">
                    <div class="ret-detail-card active" id="monetize">
                        <img src="rkimg/Transaction_Managementtt.jpg" class="ret-card-img" alt="Monetization">
                        <div class="ret-card-body">
                            <h3>Asset Monetization</h3>
                            <p>Bespoke strategies to monetize retail assets and optimize your existing property portfolio.</p>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Monetize Now</a>
                        </div>
                    </div>
                     <div class="ret-detail-card" id="expand">
                        <img src="rkimg/Retail_Leasingg.jpg" class="ret-card-img" alt="Expansion">
                        <div class="ret-card-body">
                            <h3>Geographic expansion</h3>
                            <p>Assistance in expanding your geographic footprint through strategic retail entries.</p>
                            <a href="#showw" class="ret-btn-primary" style="padding:15px 35px; font-size:1rem;">Plan Expansion</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- ===== CTA ===== -->
    <section class="ret-cta">
        <div class="container">
            <div class="ret-cta-box" data-aos="zoom-in">
                <h2>Build the <span>Future of Retail</span></h2>
                <p>Allow our specialized team to identify emerging opportunities and factual evaluations for your real estate assets.</p>
                <a href="#showw" class="ret-btn-primary">Connect With Us Now <i class="fa fa-comments"></i></a>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

    <script>
    function switchRetailTab(id, btn) {
        document.querySelectorAll('.ret-pill').forEach(el => el.classList.remove('active'));
        document.querySelectorAll('.ret-panel').forEach(el => el.classList.remove('active'));
        
        btn.classList.add('active');
        const panel = document.getElementById('panel-' + id);
        panel.classList.add('active');
        
        // Reset sub-tabs
        const firstLink = panel.querySelector('.ret-nav-link');
        const firstCard = panel.querySelector('.ret-detail-card');
        panel.querySelectorAll('.ret-nav-link').forEach(l => l.classList.remove('active'));
        panel.querySelectorAll('.ret-detail-card').forEach(c => c.classList.remove('active'));
        if(firstLink) firstLink.classList.add('active');
        if(firstCard) firstCard.classList.add('active');
    }

    function switchDetailCard(id, btn) {
        const panel = btn.closest('.ret-panel');
        panel.querySelectorAll('.ret-nav-link').forEach(el => el.classList.remove('active'));
        panel.querySelectorAll('.ret-detail-card').forEach(el => el.classList.remove('active'));
        
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