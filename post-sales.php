<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
/* ===== POST-SALES PAGE — PREMIUM STYLES ===== */

/* ---- HERO ---- */
.ps-hero {
    position: relative;
    min-height: 100vh;
    display: flex;
    align-items: center;
    overflow: hidden;
    background: #0a0514 url('rkimg/Post_Sales.jpg') center/cover no-repeat;
}


.ps-hero-video {
    position: absolute;
    inset: 0;
    width: 100%; height: 100%;
    object-fit: cover;
    opacity: 0.35;
    z-index: 0;
}

.ps-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,5,20,0.94) 0%, rgba(45,10,28,0.75) 50%, rgba(192,42,124,0.15) 100%);
    z-index: 1;
}

.ps-hero-content {
    position: relative;
    z-index: 2;
    padding-top: 110px;
    padding-bottom: 60px;
}

.ps-hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192,42,124,0.14);
    border: 1px solid rgba(192,42,124,0.35);
    color: #ff85c0;
    padding: 8px 22px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 2.5px;
    text-transform: uppercase;
    margin-bottom: 28px;
}

.ps-hero-badge i {
    font-size: 0.75rem;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.2); opacity: 0.7; }
    100% { transform: scale(1); opacity: 1; }
}

.ps-hero-title {
    font-size: clamp(3rem, 6vw, 5.5rem);
    font-weight: 900;
    color: #fff;
    line-height: 1.05;
    letter-spacing: -2px;
    margin-bottom: 24px;
}

.ps-hero-title span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.ps-hero-desc {
    color: rgba(255,255,255,0.7);
    font-size: 1.15rem;
    line-height: 1.8;
    max-width: 580px;
    margin-bottom: 40px;
}

.ps-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    padding: 16px 38px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1rem;
    text-decoration: none;
    transition: all 0.4s ease;
    box-shadow: 0 12px 30px rgba(192,42,124,0.3);
}

.ps-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 45px rgba(192,42,124,0.45);
    color: #fff;
}

/* ---- STATS BAR ---- */
.ps-stats-bar {
    padding: 60px 0;
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 100%);
    position: relative;
    z-index: 10;
}

.ps-stat-item {
    text-align: center;
    border-right: 1px solid rgba(255,255,255,0.1);
}

.ps-stat-item:last-child { border-right: none; }

.ps-stat-num {
    font-size: 2.8rem;
    font-weight: 900;
    color: #fff;
    line-height: 1;
    margin-bottom: 8px;
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.ps-stat-label {
    color: rgba(255,255,255,0.5);
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ---- SERVICES SECTION ---- */
.ps-services {
    padding: 120px 0;
    background: linear-gradient(180deg, #fff 0%, #fff5f9 100%);
    position: relative;
    overflow: hidden;
}

.ps-services::before {
    content: '';
    position: absolute;
    top: 5%; right: -10%;
    width: 600px; height: 600px;
    background: radial-gradient(circle, rgba(192,42,124,0.04) 0%, transparent 70%);
    z-index: 0;
}

.ps-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192,42,124,0.08);
    color: #c02a7c;
    padding: 8px 20px;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 20px;
    border: 1px solid rgba(192,42,124,0.1);
}

.ps-section-title {
    font-size: clamp(2.2rem, 5vw, 3.5rem);
    font-weight: 900;
    color: #2d0a1c;
    line-height: 1.1;
    margin-bottom: 24px;
    letter-spacing: -1px;
}

.ps-section-title span {
    background: linear-gradient(135deg, #c02a7c, #ff85c0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.ps-section-desc {
    color: #6a4d5b;
    font-size: 1.1rem;
    line-height: 1.8;
    max-width: 700px;
    margin-bottom: 60px;
}

/* Sticky layout for services */
.ps-services-grid {
    display: grid;
    grid-template-columns: 340px 1fr;
    gap: 50px;
    align-items: start;
}

.ps-sidebar {
    position: sticky;
    top: 120px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(15px);
    border: 1px solid rgba(192, 42, 124, 0.1);
    border-radius: 30px;
    padding: 35px 25px;
    box-shadow: 0 20px 50px rgba(45, 10, 28, 0.05);
    z-index: 10;
}

.ps-nav-link {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 16px 20px;
    border-radius: 18px;
    color: #2d0a1c;
    font-weight: 700;
    font-size: 0.92rem;
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    margin-bottom: 10px;
    border: 1px solid transparent;
}

.ps-nav-link i {
    width: 38px; height: 38px;
    background: #fff;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    color: #c02a7c;
    font-size: 1rem;
    box-shadow: 0 5px 15px rgba(192, 42, 124, 0.1);
    transition: all 0.3s ease;
}

.ps-nav-link:hover {
    background: rgba(192, 42, 124, 0.05);
    color: #c02a7c;
    transform: translateX(8px);
}

.ps-nav-link.active {
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    box-shadow: 0 15px 30px rgba(192, 42, 124, 0.3);
    border-color: rgba(192, 42, 124, 0.2);
}

.ps-nav-link.active i {
    background: rgba(255, 255, 255, 0.2);
    color: #fff;
    box-shadow: none;
}

/* Content Area */
.ps-content {
    display: flex;
    flex-direction: column;
    gap: 40px;
    /* Removed max-height and overflow to allow natural page scroll for AOS */
    padding-right: 0;
}


.ps-content::-webkit-scrollbar { width: 4px; }
.ps-content::-webkit-scrollbar-track { background: transparent; }
.ps-content::-webkit-scrollbar-thumb { 
    background: linear-gradient(to bottom, #c02a7c, #ff85c0); 
    border-radius: 10px; 
}

.ps-service-card {
    display: none;
    background: #fff;
    border-radius: 35px;
    overflow: hidden;
    border: 1px solid rgba(192, 42, 124, 0.08);
    transition: all 0.5s ease;
    box-shadow: 0 10px 40px rgba(45, 10, 28, 0.03);
    position: relative;
    animation: psFadeIn 0.5s ease-out forwards;
}

.ps-service-card.active {
    display: block;
}

@keyframes psFadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

.ps-service-card:hover {
    box-shadow: 0 40px 80px rgba(192, 42, 124, 0.15);
    border-color: rgba(192, 42, 124, 0.2);
    transform: translateY(-8px);
}


.ps-card-img-wrap {
    height: 320px;
    overflow: hidden;
    position: relative;
}

.ps-card-img-wrap img {
    width: 100%; height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.2, 1, 0.3, 1);
}

.ps-card-img-wrap::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 60%, rgba(45, 10, 28, 0.5));
}

.ps-service-card:hover .ps-card-img-wrap img {
    transform: scale(1.1);
}

.ps-service-card img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}


.ps-card-body {
    padding: 45px;
}

.ps-card-body h3 {
    font-size: 1.8rem;
    font-weight: 900;
    color: #2d0a1c;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}

.ps-card-body p {
    color: #6a4d5b;
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 30px;
}

.ps-feature-list {
    list-style: none;
    padding: 0;
    margin: 0 0 40px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 15px;
}

@media (max-width: 1200px) {
    .ps-feature-list { grid-template-columns: 1fr; }
}

.ps-feature-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.95rem;
    color: #4a343f;
    font-weight: 700;
    background: #fff5f9;
    padding: 14px 20px;
    border-radius: 15px;
    border: 1px solid rgba(192, 42, 124, 0.05);
    transition: all 0.3s ease;
}

.ps-feature-list li:hover {
    background: #fff;
    border-color: #c02a7c;
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(192, 42, 124, 0.1);
}

.ps-feature-list li i {
    color: #c02a7c;
    font-size: 1.1rem;
    flex-shrink: 0;
}

/* ---- CTA SECTION ---- */
.ps-cta {
    padding: 80px 0;
    background: linear-gradient(160deg, #fff 0%, #fff5f9 100%);
}

.ps-cta-box {
    background: linear-gradient(135deg, #2d0a1c 0%, #1a0511 100%);
    border-radius: 32px;
    padding: 70px 60px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.ps-cta-box::before {
    content: '';
    position: absolute;
    top: -100px; right: -100px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(192,42,124,0.2), transparent 70%);
}

.ps-cta-box h2 {
    font-size: clamp(1.8rem, 3.5vw, 2.8rem);
    font-weight: 800;
    color: #fff;
    margin-bottom: 15px;
}

.ps-cta-box h2 span {
    background: linear-gradient(135deg, #ff85c0, #c02a7c);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.ps-cta-box p {
    color: rgba(255,255,255,0.6);
    font-size: 1.1rem;
    max-width: 600px;
    margin: 0 auto 30px;
}

.ps-step-badge {
    position: absolute;
    top: 20px; left: 20px;
    background: rgba(192, 42, 124, 0.9);
    backdrop-filter: blur(5px);
    color: #fff;
    padding: 6px 15px;
    border-radius: 10px;
    font-size: 0.75rem;
    font-weight: 800;
    letter-spacing: 1px;
    text-transform: uppercase;
    z-index: 2;
    box-shadow: 0 5px 15px rgba(192, 42, 124, 0.3);
}

/* Responsive */
@media (max-width: 991px) {
    .ps-services-grid { grid-template-columns: 1fr; }
    .ps-sidebar { position: static; margin-bottom: 30px; }
    .ps-content { max-height: none; overflow-y: visible; padding-right: 0; }
    .ps-stat-item { border-right: none; margin-bottom: 30px; }
    .ps-stat-item:last-child { margin-bottom: 0; }
}
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- ===== CINEMATIC HERO ===== -->
    <section class="ps-hero">
        <video autoplay muted loop playsinline class="ps-hero-video">
            <source src="rkimg/Post_Saless.webm" type="video/webm">
        </video>
        <div class="ps-hero-overlay"></div>

        <div class="container ps-hero-content">
            <div class="row">
                <div class="col-lg-7" data-aos="fade-right" data-aos-duration="1000">
                    <div class="ps-hero-badge">
                        <i class="fa fa-heart"></i> Relationship Management
                    </div>
                    <h1 class="ps-hero-title">
                        Excellence Beyond<br>the <span>Final Sale.</span>
                    </h1>
                    <p class="ps-hero-desc">
                        Maximizing customer retention by fostering long-term, trust-based relationships. Our experienced team ensures an enriching and seamless home-buying journey at every touchpoint.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="#showw" class="ps-btn-primary">
                            <i class="fa fa-handshake-o"></i> Let's Connect
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS BAR ===== -->
    <section class="ps-stats-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="ps-stat-item">
                        <div class="ps-stat-num">3,000+</div>
                        <div class="ps-stat-label">Registrations Executed</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="ps-stat-item">
                        <div class="ps-stat-num">88%</div>
                        <div class="ps-stat-label">Avg. Recovery Rate</div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="ps-stat-item">
                        <div class="ps-stat-num">Pan India</div>
                        <div class="ps-stat-label">Service Presence</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== SERVICES SECTION ===== -->
    <section class="ps-services">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-12" data-aos="fade-up">
                    <div class="ps-badge">What We Do</div>
                    <h2 class="ps-section-title">One-stop Solution for <span>Developers</span></h2>
                    <p class="ps-section-desc">
                        Our experienced and reliable team serves as a strategic partner, offering a blend of structured collections framework and customer-centric lead management.
                    </p>
                </div>
            </div>

            <div class="ps-services-grid">
                <!-- Sidebar -->
                <aside class="ps-sidebar" data-aos="fade-right">
                    <nav class="ps-nav">
                        <a href="javascript:void(0)" class="ps-nav-link active" onclick="switchService('onboarding', this)">
                            <i class="fa fa-user-plus"></i> Customer Onboarding
                        </a>
                        <a href="javascript:void(0)" class="ps-nav-link" onclick="switchService('collections', this)">
                            <i class="fa fa-money"></i> Collections & Revenue
                        </a>
                        <a href="javascript:void(0)" class="ps-nav-link" onclick="switchService('lifecycle', this)">
                            <i class="fa fa-refresh"></i> Lifecycle Management
                        </a>
                        <a href="javascript:void(0)" class="ps-nav-link" onclick="switchService('homeloan', this)">
                            <i class="fa fa-bank"></i> Home Loan Assistance
                        </a>
                        <a href="javascript:void(0)" class="ps-nav-link" onclick="switchService('possession', this)">
                            <i class="fa fa-key"></i> Possession Strategy
                        </a>
                        <a href="javascript:void(0)" class="ps-nav-link" onclick="switchService('loyalty', this)">
                            <i class="fa fa-star"></i> Loyalty Management
                        </a>
                    </nav>
                </aside>

                <!-- Content Area -->
                <div class="ps-content" id="services-content">
                    <!-- Onboarding -->
                    <div class="ps-service-card active" id="onboarding">

                        <div class="ps-card-img-wrap">
                            <img src="rkimg/Customer-Onbordingg.jpg" alt="Customer Onboarding">
                            <div class="ps-step-badge">Phase 01</div>
                        </div>
                        <div class="ps-card-body">
                            <h3>Customer Onboarding</h3>
                            <p>We ensure a smooth transition from buyer to community member with a structured onboarding process that sets the stage for a positive long-term relationship.</p>
                            <ul class="ps-feature-list">
                                <li><i class="fa fa-handshake-o"></i> Seamless welcome experience</li>
                                <li><i class="fa fa-file-text-o"></i> Documentation & KYC support</li>
                                <li><i class="fa fa-info-circle"></i> Project feature orientation</li>
                                <li><i class="fa fa-comments-o"></i> Transparent comms setup</li>
                            </ul>
                            <a href="#showw" class="ps-btn-primary" style="padding: 10px 25px; font-size: 0.85rem;">Get Started <i class="fa fa-arrow-right" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Collections -->
                    <div class="ps-service-card" id="collections">
                        <div class="ps-card-img-wrap">
                            <img src="rkimg/Collections_and_Revenue_Management11.jpg" alt="Collections & Revenue Management">
                            <div class="ps-step-badge">Phase 02</div>
                        </div>
                        <div class="ps-card-body">
                            <h3>Collections & Revenue Management</h3>
                            <p>Our structured collections framework ensures consistent revenue flow for developers while maintaining professional empathy and customer trust.</p>
                            <ul class="ps-feature-list">
                                <li><i class="fa fa-line-chart"></i> Milestone-based tracking</li>
                                <li><i class="fa fa-calendar-check-o"></i> Automated reminders</li>
                                <li><i class="fa fa-pie-chart"></i> Revenue forecasting</li>
                                <li><i class="fa fa-check-square-o"></i> Payment reconciliations</li>
                            </ul>
                            <a href="#showw" class="ps-btn-primary" style="padding: 10px 25px; font-size: 0.85rem;">Learn More <i class="fa fa-arrow-right" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Lifecycle -->
                    <div class="ps-service-card" id="lifecycle">
                        <div class="ps-card-img-wrap">
                            <img src="rkimg/Customer_Lifecycle_Management1.jpg" alt="Customer Lifecycle Management">
                            <div class="ps-step-badge">Phase 03</div>
                        </div>
                        <div class="ps-card-body">
                            <h3>Customer Lifecycle Management</h3>
                            <p>We manage the entire spectrum of customer touchpoints throughout the construction phase, ensuring buyers feel valued and informed at every stage.</p>
                            <ul class="ps-feature-list">
                                <li><i class="fa fa-bullhorn"></i> Regular project updates</li>
                                <li><i class="fa fa-user-circle"></i> Dedicated RM support</li>
                                <li><i class="fa fa-life-ring"></i> Prompt issue resolution</li>
                                <li><i class="fa fa-users"></i> Community initiatives</li>
                            </ul>
                            <a href="#showw" class="ps-btn-primary" style="padding: 10px 25px; font-size: 0.85rem;">Let's Connect <i class="fa fa-arrow-right" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Home Loan -->
                    <div class="ps-service-card" id="homeloan">
                        <div class="ps-card-img-wrap">
                            <img src="rkimg/Home_loan.jpg" alt="Home Loan Assistance">
                            <div class="ps-step-badge">Phase 04</div>
                        </div>
                        <div class="ps-card-body">
                            <h3>Home Loan Assistance</h3>
                            <p>Facilitating the financial journey of the homebuyer with tie-ups across leading financial institutions for quick and hassle-free loan processing.</p>
                            <ul class="ps-feature-list">
                                <li><i class="fa fa-university"></i> Top bank tie-ups</li>
                                <li><i class="fa fa-folder-open-o"></i> Document appraising</li>
                                <li><i class="fa fa-check-circle-o"></i> Disbursement support</li>
                                <li><i class="fa fa-calculator"></i> Customized EMI plans</li>
                            </ul>
                            <a href="#showw" class="ps-btn-primary" style="padding: 10px 25px; font-size: 0.85rem;">Check Eligibility <i class="fa fa-arrow-right" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Possession -->
                    <div class="ps-service-card" id="possession">
                        <div class="ps-card-img-wrap">
                            <img src="rkimg/Possession_Strategy_and_Residence_Delivery_Executionn.jpg" alt="Possession Strategy">
                            <div class="ps-step-badge">Phase 05</div>
                        </div>
                        <div class="ps-card-body">
                            <h3>Possession Strategy & Delivery</h3>
                            <p>The most critical phase. We manage final handovers with precision, ensuring the delivery experience is celebratory and error-free.</p>
                            <ul class="ps-feature-list">
                                <li><i class="fa fa-search-plus"></i> Unit inspection/Snagging</li>
                                <li><i class="fa fa-pencil-square-o"></i> Registration support</li>
                                <li><i class="fa fa-gift"></i> Handover kit delivery</li>
                                <li><i class="fa fa-wrench"></i> Maintenance orientation</li>
                            </ul>
                            <a href="#showw" class="ps-btn-primary" style="padding: 10px 25px; font-size: 0.85rem;">View Strategy <i class="fa fa-arrow-right" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                        </div>
                    </div>

                    <!-- Loyalty -->
                    <div class="ps-service-card" id="loyalty">
                        <div class="ps-card-img-wrap">
                            <img src="rkimg/Loyalty_Managementt.jpg" alt="Loyalty Management">
                            <div class="ps-step-badge">Phase 06</div>
                        </div>
                        <div class="ps-card-body">
                            <h3>Loyalty Management</h3>
                            <p>Defining a new sales vertical by turning satisfied customers into brand ambassadors through structured referral and loyalty programs.</p>
                            <ul class="ps-feature-list">
                                <li><i class="fa fa-trophy"></i> Referral rewards program</li>
                                <li><i class="fa fa-certificate"></i> Repeat-purchase benefits</li>
                                <li><i class="fa fa-diamond"></i> Brand partner perks</li>
                                <li><i class="fa fa-calendar"></i> Exclusive launch access</li>
                            </ul>
                            <a href="#showw" class="ps-btn-primary" style="padding: 10px 25px; font-size: 0.85rem;">Join Loyalty <i class="fa fa-arrow-right" style="font-size: 0.7rem; margin-left: 5px;"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ===== CTA SECTION ===== -->
    <section class="ps-cta">
        <div class="container">
            <div class="ps-cta-box" data-aos="zoom-in">
                <h2>Build Long-term <span>Trust</span> with Customers</h2>
                <p>Ready to enhance your post-sales experience? Our experts are here to help you foster relationships that fuel future growth.</p>
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="#showw" class="ps-btn-primary">Connect With Us Now</a>
                    <a href="contact" class="ps-btn-primary" style="background: transparent; border: 2px solid rgba(255,255,255,0.2); box-shadow: none;">View Contact Details</a>
                </div>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>
    <?php include 'component/formk.php'; ?>
    <?php include 'component/footer.php'; ?>

    <script>
        function switchService(id, element) {
            // Remove active class from all links
            document.querySelectorAll('.ps-nav-link').forEach(link => link.classList.remove('active'));
            
            // Add active class to clicked link
            element.classList.add('active');
            
            // Hide all cards
            document.querySelectorAll('.ps-service-card').forEach(card => card.classList.remove('active'));
            
            // Show specifically targeted card
            const target = document.getElementById(id);
            if (target) {
                target.classList.add('active');
            }
        }
    </script>



</body>

</html>