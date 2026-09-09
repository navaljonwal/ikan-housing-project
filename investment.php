<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 🏦 Investment Banking Premium Styles */
    :root {
        --plum-bg: #1a0511;
        --plum-accent: #2d0a1c;
        --pink-prime: #c02a7c;
        --pink-soft: #ff85c0;
        --slate-text: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--plum-accent); overflow-x: hidden; }

    /* --- Cinematic Hero --- */
    .invest-hero {
        position: relative;
        height: 85vh;
        min-height: 650px;
        display: flex;
        align-items: center;
        overflow: hidden;
        background: #000;
        padding-top: 120px;
    }

    .hero-vid-wrap {
        position: absolute;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: 1;
    }

    .vid-bg-premium {
        width: 100%; height: 100%; object-fit: cover; opacity: 0.55;
    }

    .hero-gradient-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to right, rgba(26, 5, 17, 0.95) 0%, rgba(26, 5, 17, 0.3) 100%);
        z-index: 2;
    }

    .invest-hero-content {
        position: relative;
        z-index: 3;
        color: white;
        max-width: 800px;
    }

    .invest-badge {
        display: inline-block;
        background: rgba(192, 42, 124, 0.2);
        border: 1px solid var(--pink-soft);
        color: var(--pink-soft);
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 25px;
        backdrop-filter: blur(10px);
    }

    .invest-title {
        font-size: clamp(2.8rem, 6vw, 4.5rem);
        font-weight: 900;
        line-height: 1.05;
        margin-bottom: 25px;
        letter-spacing: -2px;
    }

    .invest-title span { color: var(--pink-prime); }

    .invest-subtitle {
        font-size: 1.25rem;
        opacity: 0.85;
        margin-bottom: 40px;
        border-left: 4px solid var(--pink-prime);
        padding-left: 20px;
    }

    /* --- Stats & Expertise --- */
    .section-expertise { padding: 120px 0; background: #fdfafd; position: relative; }
    
    .stats-grid-premium {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: -60px;
        position: relative;
        z-index: 10;
    }

    .stat-box-modern {
        background: white;
        padding: 50px 40px;
        border-radius: 35px;
        box-shadow: 0 30px 60px rgba(45, 10, 28, 0.06);
        border: 1px solid rgba(192, 42, 124, 0.05);
        transition: all 0.4s ease;
        text-align: center;
    }

    .stat-box-modern:hover { transform: translateY(-12px); border-color: var(--pink-prime); }

    .stat-val { font-size: 3.8rem; font-weight: 950; color: var(--plum-accent); line-height: 1; margin-bottom: 10px; }
    .stat-val span { color: var(--pink-prime); }
    .stat-lbl { font-size: 1.1rem; font-weight: 700; color: var(--slate-text); text-transform: uppercase; letter-spacing: 1px; }

    /* --- Structured Hub --- */
    .advisory-hub-section { padding: 100px 0; background: white; }

    .pill-tabs-nav {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-bottom: 60px;
    }

    .pill-btn-modern {
        border: 2px solid #f1f5f9;
        background: #f8fafc;
        padding: 12px 35px;
        border-radius: 50px;
        font-weight: 800;
        color: var(--plum-accent);
        transition: all 0.3s ease;
    }

    .pill-btn-modern.active {
        background: var(--pink-prime);
        border-color: var(--pink-prime);
        color: white;
        box-shadow: 0 12px 25px rgba(192, 42, 124, 0.3);
    }

    .service-panel-card {
        background: #fff;
        border-radius: 40px;
        overflow: hidden;
        border: 1px solid #f1f5f9;
        box-shadow: 0 40px 80px rgba(0,0,0,0.06);
    }

    .panel-img-box { height: 550px; overflow: hidden; }
    .panel-img-box img { width: 100%; height: 100%; object-fit: cover; transition: transform 1s ease; }
    .service-panel-card:hover .panel-img-box img { transform: scale(1.08); }

    .panel-body-content { padding: 60px; }
    
    .spec-list {
        list-style: none;
        padding: 0;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-top: 30px;
    }

    .spec-list li {
        display: flex;
        align-items: center;
        gap: 12px;
        font-weight: 600;
        color: var(--slate-text);
        padding: 12px 18px;
        background: #fff5f9;
        border-radius: 12px;
        border-left: 3px solid var(--pink-prime);
    }

    .spec-list li i { color: var(--pink-prime); font-size: 18px; }

    .btn-action-premium {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: var(--plum-accent);
        color: white !important;
        padding: 18px 40px;
        border-radius: 16px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s ease;
        margin-top: 40px;
    }

    .btn-action-premium:hover { background: var(--pink-prime); transform: translateX(8px); }

    @media (max-width: 991px) {
        .panel-img-box { height: 350px; }
        .panel-body-content { padding: 40px 30px; }
        .spec-list { grid-template-columns: 1fr; }
        .invest-hero { height: auto; padding: 180px 0 100px; }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- 🏦 Premium Hero Section -->
    <section class="invest-hero">
        <div class="hero-vid-wrap">
            <video autoplay muted loop playsinline class="vid-bg-premium">
                <source src="rkimg/Investment_Bankingg.webm" type="video/webm">
            </video>
            <div class="hero-gradient-overlay"></div>
        </div>

        <div class="container invest-hero-content">
            <div data-aos="fade-right" data-aos-duration="1000">
                <span class="invest-badge">Capital Markets Mastery</span>
                <h1 class="invest-title">Global Perspective. <span>Local Expertise.</span></h1>
                <p class="invest-subtitle">We create simple solutions for complex real estate transactions by applying the right growth and capitalization strategies across the Indian market.</p>
                <a href="#connect" class="btn-action-premium">Initiate Strategy Session <i class="fa fa-chevron-right"></i></a>
            </div>
        </div>
    </section>

    <!-- 📊 Stats Grid (Overlaying Section) -->
    <section class="section-expertise">
        <div class="container">
            <div class="stats-grid-premium">
                <div class="stat-box-modern" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-val">$<span>10.5</span>B+</div>
                    <div class="stat-lbl">Capital Advised</div>
                </div>
                <div class="stat-box-modern" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-val"><span>450</span>+</div>
                    <div class="stat-lbl">High-Value Transactions</div>
                </div>
                <div class="stat-box-modern" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-val"><span>35</span>+</div>
                    <div class="stat-lbl">Financial Experts</div>
                </div>
            </div>

            <div class="row mt-5 pt-5 align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <img src="rkimg/Tagimg.svg" alt="Quality" class="mb-4" style="height: 60px;">
                    <h2 class="fw-extrabold mb-4" style="font-size: 3rem; line-height: 1.1;">Maximizing Value, <br><span style="color: var(--pink-prime);">Minimizing Cost.</span></h2>
                    <p class="text-secondary fs-5 leading-relaxed">By challenging the status quo and rethinking conventional strategies, we achieves the ideal balance between speed of execution and deal quality.</p>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="p-5 rounded-5" style="background: var(--plum-accent); color: white;">
                        <h4 class="fw-bold mb-3"><i class="fa fa-quote-left text-pink me-3"></i>Our Strategic Edge</h4>
                        <p class="opacity-75 fs-5">"With over 500 years of cumulative team experience, our advisory services are built on deep data metrics and multi-market foresight, shaping the future of real estate investment."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 🧭 Advisory Service Hub -->
    <section class="advisory-hub-section" id="hub">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <span class="invest-badge">Core Verticals</span>
                <h2 class="fw-black mb-3" style="font-size: 3.5rem;">Solutions for <span style="color: var(--pink-prime);">Stakeholders</span></h2>
                <p class="text-secondary mx-auto" style="max-width: 600px;">Bespoke financial strategies tailored to meet the sophisticated objectives of modern developers and corporate entities.</p>
            </div>

            <div class="pill-tabs-nav" data-aos="fade-up">
                <button class="pill-btn-modern active" onclick="switchInvestTab(event, 'panel-developers')">Developers & Landowners</button>
                <button class="pill-btn-modern" onclick="switchInvestTab(event, 'panel-corporates')">Corporates & Institutions</button>
            </div>

            <!-- Developers Content -->
            <div id="panel-developers" class="service-panel-card invest-tab-content" data-aos="zoom-in">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="panel-img-box">
                            <img src="rkimg/Capital_Marketsss.jpg" alt="Capital Markets">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel-body-content">
                            <h3 class="fw-extrabold mb-4">Capital Market Solutions</h3>
                            <p class="text-secondary fs-5 mb-4">Empowering developers to make informed decisions by analyzing market trends, identifying investment opportunities, and evaluating risk-adjusted returns.</p>
                            <ul class="spec-list">
                                <li><i class="fa fa-check-circle"></i> Fund Raising</li>
                                <li><i class="fa fa-check-circle"></i> Private Wealth</li>
                                <li><i class="fa fa-check-circle"></i> REIT Advisory</li>
                                <li><i class="fa fa-check-circle"></i> Equity Placement</li>
                                <li><i class="fa fa-check-circle"></i> Asset Divestment</li>
                                <li><i class="fa fa-check-circle"></i> Portfolio Sales</li>
                            </ul>
                            <a href="#connect" class="btn-action-premium">Consult Financial Expert</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corporates Content -->
            <div id="panel-corporates" class="service-panel-card invest-tab-content" style="display: none;">
                <div class="row g-0">
                    <div class="col-lg-6">
                        <div class="panel-img-box">
                            <img src="rkimg/Corporate_Finance.jpg" alt="Corporate Finance">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="panel-body-content">
                            <h3 class="fw-extrabold mb-4">Institutional Advisory</h3>
                            <p class="text-secondary fs-5 mb-4">Helping clients structure complex transactions, monetize global assets, and expand geographical footprints through data-driven precision.</p>
                            <ul class="spec-list">
                                <li><i class="fa fa-check-circle"></i> Corporate Finance</li>
                                <li><i class="fa fa-check-circle"></i> Debt Raising</li>
                                <li><i class="fa fa-check-circle"></i> Mergers & HQ</li>
                                <li><i class="fa fa-check-circle"></i> Occupier Services</li>
                                <li><i class="fa fa-check-circle"></i> Data Centers</li>
                                <li><i class="fa fa-check-circle"></i> Land Divestment</li>
                            </ul>
                            <a href="#connect" class="btn-action-premium">Review Corporate Strategy</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'component/explore.php'; ?>

    <div id="connect">
        <?php include 'component/formk.php'; ?>
    </div>

    <?php include 'component/footer.php'; ?>

    <script>
        function switchInvestTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("invest-tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("pill-btn-modern");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>
</body>
</html>