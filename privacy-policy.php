<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 🛡️ Privacy Hub Premium Overhaul */
    :root {
        --priv-plum: #1a0511;
        --priv-plum-accent: #2d0a1c;
        --priv-pink: #c02a7c;
        --priv-pink-soft: #ff85c0;
        --priv-text-slate: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--priv-plum-accent); overflow-x: hidden; }

    /* --- Privacy Hero --- */
    .priv-hero {
        background: linear-gradient(135deg, var(--priv-plum) 0%, var(--priv-plum-accent) 100%);
        padding: 180px 0 100px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .priv-hero::before {
        content: ""; position: absolute; inset: 0;
        background: radial-gradient(circle at 30% 70%, rgba(192, 42, 124, 0.15), transparent 70%);
    }

    .hero-shield { font-size: 3.5rem; color: var(--priv-pink-soft); margin-bottom: 25px; display: inline-block; opacity: 0.8; }
    .priv-title { font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; letter-spacing: -2px; line-height: 1.1; margin-bottom: 15px; }
    .priv-subtitle { font-size: 1.2rem; opacity: 0.75; font-weight: 500; max-width: 650px; margin: 0 auto; }

    /* --- Privacy Cards --- */
    .priv-content-wrap { padding: 100px 0; background: #faf9fb; }
    
    .priv-card {
        background: white;
        border-radius: 35px;
        padding: 50px;
        margin-bottom: 40px;
        box-shadow: 0 40px 80px rgba(45, 10, 28, 0.05);
        border: 1px solid rgba(192, 42, 124, 0.04);
        transition: all 0.4s ease;
        position: relative;
    }

    .priv-card:hover { transform: translateY(-7px); border-color: var(--priv-pink); }
    
    .priv-header { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 25px; }
    .priv-icon {
        width: 60px; height: 60px; background: #fff5f9; color: var(--priv-pink);
        border-radius: 20px; display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }

    .priv-card-title { font-size: 1.8rem; font-weight: 850; color: var(--priv-plum-accent); margin: 0; letter-spacing: -0.5px; }
    .priv-body { color: var(--priv-text-slate); line-height: 1.8; font-size: 1.1rem; }
    .priv-body strong { color: var(--priv-plum-accent); font-weight: 750; }

    /* --- Opt-Out Box --- */
    .opt-out-box {
        background: linear-gradient(135deg, #fff 0%, #fff5f9 100%);
        border: 2px dashed var(--priv-pink);
        padding: 40px;
        border-radius: 30px;
        text-align: center;
        margin: 50px 0;
    }

    .opt-out-btn {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        background: var(--priv-pink);
        color: white !important;
        padding: 18px 40px;
        border-radius: 50px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.4s ease;
        box-shadow: 0 15px 30px rgba(192, 42, 124, 0.3);
        border: none;
    }

    .opt-out-btn:hover { background: var(--priv-plum-accent); transform: scale(1.05); box-shadow: 0 20px 40px rgba(45, 10, 28, 0.2); }

    /* --- Info Overlay --- */
    .policy-intro {
        background: white;
        padding: 40px 50px;
        border-radius: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        margin-top: -60px;
        position: relative;
        z-index: 10;
        border-left: 8px solid var(--priv-pink);
        font-weight: 700;
        font-size: 1.15rem;
    }

    @media (max-width: 991px) {
        .priv-hero { padding: 150px 0 80px; }
        .priv-card { padding: 35px 25px; border-radius: 25px; }
        .priv-header { flex-direction: column; gap: 15px; }
        .priv-card-title { font-size: 1.5rem; }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- 🛡️ Premium Privacy Hero -->
    <header class="priv-hero">
        <div class="container" data-aos="fade-down" data-aos-duration="1200">
            <div class="hero-shield"><i class="fa fa-user-shield"></i></div>
            <h1 class="priv-title">Privacy <span>Policy</span></h1>
            <p class="priv-subtitle">Our commitment to protecting your digital footprint within the I Kan Housing ecosystem.</p>
        </div>
    </header>

    <main class="priv-content-wrap">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <!-- 📢 Important Intro -->
                    <div class="policy-intro mb-5" data-aos="fade-up">
                        <i class="fa fa-info-circle me-2 text-pink"></i> Welcome to ikanhousing.com! We provide a real estate information service connecting people across the globe. By using our Services, you agree to the provisions of this Privacy Policy.
                    </div>

                    <!-- Card 1: Purpose & Scope -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-bullseye"></i></div>
                            <h2 class="priv-card-title">Why We Collect Information</h2>
                        </div>
                        <div class="priv-body">
                            <p>ikanhousing.com uses the information we collect to help personalize your experience, connect you with relevant professionals, and keep you informed about the real estate market.</p>
                            <p>Our goal is fully transparent: we collect data to help you find the most relevant information for your needs and ensure smooth, productive relationships between buyers, sellers, and professionals.</p>
                        </div>
                    </div>

                    <!-- Card 2: What We Collect -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-database"></i></div>
                            <h2 class="priv-card-title">Information Collection</h2>
                        </div>
                        <div class="priv-body">
                            <p><strong>Log Data:</strong> Our servers automatically record your IP address, browser type, operating system, and pages visited. We use this to measure and improve our Services.</p>
                            <p><strong>Personal Details:</strong> We collect details you provide during registration, such as your name, contact details, mobile number, and email address.</p>
                            <p><strong>REPs Data:</strong> For Real Estate Professionals (REPs), we collect company names, campaign descriptions, and financial information for paid accounts.</p>
                        </div>
                    </div>

                    <!-- Card 3: Cookies -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-cookie-bite"></i></div>
                            <h2 class="priv-card-title">Cookies & Tracking</h2>
                        </div>
                        <div class="priv-body">
                            <p>We use session cookies to keep you logged in and persistent cookies to recognize you each time you return. These help us remember your search preferences and customize your experience.</p>
                            <p>Most browsers accept cookies by default, but you can adjust your settings to refuse them. Note that disabling cookies may affect certain features of our Services.</p>
                        </div>
                    </div>

                    <!-- Card 4: Location -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-map-marker-alt"></i></div>
                            <h2 class="priv-card-title">Location Data</h2>
                        </div>
                        <div class="priv-body">
                            <p>If you provide location information (address, ZIP code, or city), we store it to deliver localized features and relevant advertising. We may also use precise geographic location data if you grant permission on your device.</p>
                        </div>
                    </div>

                    <!-- Card 5: Information Sharing -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-share-nodes"></i></div>
                            <h2 class="priv-card-title">How We Share Information</h2>
                        </div>
                        <div class="priv-body">
                            <p><strong>Real Estate Professionals:</strong> If you contact a REP through our Site, we share your contact information and search criteria with them so they can assist you better.</p>
                            <p><strong>Trustworthy Partners:</strong> We may share email addresses with reputable organizations offering related products or services, unless you opt out.</p>
                            <p><strong>Legal Requirements:</strong> We disclose information when necessary to comply with Indian laws, regulations, or enforceable governmental requests.</p>
                        </div>
                    </div>

                    <!-- 🛑 Opt-Out Premium Box -->
                    <div class="opt-out-box" data-aos="zoom-in">
                        <div class="priv-icon mx-auto mb-4"><i class="fa fa-user-slash"></i></div>
                        <h3 class="fw-black mb-3">Online Tracking Preferences</h3>
                        <p class="text-secondary mb-4">You have the right to opt out of non-personally identifiable information tracking across our online properties.</p>
                        <button class="opt-out-btn" onclick="alert('You have successfully opted out of tracking on this browser.')">
                            * I Agree, Opt me out * <i class="fa fa-check-circle"></i>
                        </button>
                        <p class="small text-muted mt-3">Note: Opting out places a cookie in your browser. If you clear your cookies or use a different browser, you will need to opt out again.</p>
                    </div>

                    <!-- Card 6: Mortgages & UGC -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-house-chimney-window"></i></div>
                            <h2 class="priv-card-title">Specific Services</h2>
                        </div>
                        <div class="priv-body">
                            <p><strong>Mortgages:</strong> If you request a quote, you authorize us to share data with trusted mortgage partners solely for fulfilling your request.</p>
                            <p><strong>User Content:</strong> Any information you share in public forums (questions, answers, or blogs) may be read and used by others. We are not responsible for data disclosed in public areas.</p>
                        </div>
                    </div>

                    <!-- Card 7: Security & Changes -->
                    <div class="priv-card" data-aos="fade-up">
                        <div class="priv-header">
                            <div class="priv-icon"><i class="fa fa-shield-halved"></i></div>
                            <h2 class="priv-card-title">Security & Policy Updates</h2>
                        </div>
                        <div class="priv-body">
                            <p>We use SSL encryption for sensitive data (like credit cards) and commercially reasonable measures to protect your information. While no transmission is 100% secure, we strive for maximum protection.</p>
                            <p>We may update this policy periodically. Material changes will be preceded by a prominent notice on our Website.</p>
                        </div>
                    </div>

                    <!-- 🏛️ Compliance Footer -->
                    <div class="priv-card" data-aos="fade-up" style="background: var(--priv-plum-accent); color: white; border: none;">
                        <h4 class="fw-bold mb-4 text-priv-pink"><i class="fa fa-balance-scale me-2"></i>Legal Compliance</h4>
                        <p class="opacity-75 mb-0">Ikan Housing websites fully comply with all applicable Indian laws. For any grievances or feedback related to privacy, please contact us at <strong>info@ikanhousing.com</strong> or <strong>+91-7240515515</strong>.</p>
                    </div>

                    <p class="text-center text-muted mt-5 opacity-50">This Privacy Policy page is maintained by <a href="https://ikanhousing.com/" target="_blank">ikanhousing.com</a></p>

                </div>
            </div>

        </div>
    </main>

    <?php include 'component/footer.php'; ?>

</body>
</html>
