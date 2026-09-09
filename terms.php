<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    /* 📜 Legal Hub Premium Overhaul */
    :root {
        --legal-plum: #1a0511;
        --legal-plum-accent: #2d0a1c;
        --legal-pink: #c02a7c;
        --legal-pink-soft: #ff85c0;
        --legal-text-slate: #475569;
    }

    body { font-family: 'Outfit', sans-serif; background: #fff; color: var(--legal-plum-accent); overflow-x: hidden; }

    /* --- Policy Hero --- */
    .legal-hero {
        background: linear-gradient(135deg, var(--legal-plum) 0%, var(--legal-plum-accent) 100%);
        padding: 180px 0 100px;
        color: white;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .legal-hero::before {
        content: ""; position: absolute; inset: 0;
        background: radial-gradient(circle at 70% 30%, rgba(192, 42, 124, 0.15), transparent 70%);
    }

    .hero-gavel { font-size: 3.5rem; color: var(--legal-pink-soft); margin-bottom: 25px; display: inline-block; opacity: 0.8; }
    .legal-title { font-size: clamp(2.5rem, 6vw, 4rem); font-weight: 900; letter-spacing: -2px; line-height: 1.1; margin-bottom: 15px; }
    .legal-subtitle { font-size: 1.2rem; opacity: 0.75; font-weight: 500; max-width: 600px; margin: 0 auto; }

    /* --- Clause Cards --- */
    .legal-content-wrap { padding: 100px 0; background: #faf9fb; }
    
    .clause-card {
        background: white;
        border-radius: 35px;
        padding: 50px;
        margin-bottom: 40px;
        box-shadow: 0 40px 80px rgba(45, 10, 28, 0.05);
        border: 1px solid rgba(192, 42, 124, 0.04);
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .clause-card:hover { transform: translateY(-7px); border-color: var(--legal-pink); }
    
    .clause-header { display: flex; align-items: flex-start; gap: 20px; margin-bottom: 25px; }
    .clause-icon {
        width: 60px; height: 60px; background: #fff5f9; color: var(--legal-pink);
        border-radius: 20px; display: flex; align-items: center; justify-content: center;
        font-size: 1.5rem; flex-shrink: 0;
    }

    .clause-title { font-size: 1.8rem; font-weight: 850; color: var(--legal-plum-accent); margin: 0; letter-spacing: -0.5px; }
    .clause-body { color: var(--legal-text-slate); line-height: 1.8; font-size: 1.1rem; }
    .clause-body strong { color: var(--legal-plum-accent); font-weight: 750; }

    /* --- Intro Overlay --- */
    .policy-intro {
        background: white;
        padding: 40px 50px;
        border-radius: 30px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        margin-top: -60px;
        position: relative;
        z-index: 10;
        border-left: 8px solid var(--legal-pink);
        font-weight: 700;
        font-size: 1.15rem;
    }

    @media (max-width: 991px) {
        .legal-hero { padding: 150px 0 80px; }
        .clause-card { padding: 35px 25px; border-radius: 25px; }
        .clause-header { flex-direction: column; gap: 15px; }
        .clause-title { font-size: 1.5rem; }
    }
</style>

<body>

    <?php include 'component/navbar.php'; ?>

    <!-- ⚖️ Premium Policy Hero -->
    <header class="legal-hero">
        <div class="container" data-aos="fade-down" data-aos-duration="1200">
            <div class="hero-gavel"><i class="fa fa-gavel"></i></div>
            <h1 class="legal-title">Terms of <span>Service</span></h1>
            <p class="legal-subtitle">Standard operating procedures and legal frameworks of the I Kan ecosystem.</p>
        </div>
    </header>

    <main class="legal-content-wrap">
        <div class="container">
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    
                    <!-- 📢 Important Intro -->
                    <div class="policy-intro mb-5" data-aos="fade-up">
                        <i class="fa fa-info-circle me-2 text-pink"></i> Please read the following terms of use and disclaimers carefully before using this website.
                    </div>

                    <!-- Card 1: Acceptance -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-handshake"></i></div>
                            <h2 class="clause-title">Acceptance of Terms</h2>
                        </div>
                        <div class="clause-body">
                            <p><strong>I Kan Housing</strong> Property Consultants Private Limited maintains this Website (the "Site") for your personal use. Your access to and use of this Site is subject to the following Terms of Use. <strong>I Kan Housing</strong> reserves the right to update these Terms of Use at any time without prior notice.</p>
                            <p>By choosing to use this Site, you accept and acknowledge these Terms of Use without limitation or qualification. However, if you do not agree to these Terms of Use, please do not use this Site.</p>
                        </div>
                    </div>

                    <!-- Card 2: Accuracy -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-shield"></i></div>
                            <h2 class="clause-title">Accuracy and Completeness</h2>
                        </div>
                        <div class="clause-body">
                            <p>While <strong>I Kan Housing</strong> endeavors to provide updated and reliable information on this Site, the company makes no warranties or representations regarding the accuracy, correctness, reliability, or completeness of such information.</p>
                            <p>We assume no liability or responsibility for any errors or omissions in the content provided on this Site.</p>
                        </div>
                    </div>

                    <!-- Card 3: Modification -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-edit"></i></div>
                            <h2 class="clause-title">Modification of Site</h2>
                        </div>
                        <div class="clause-body">
                            <p><strong>I Kan Housing</strong> retains the right, at its sole discretion, to periodically revise the information, services, and resources provided on this Site. We reserve the right to make further changes without any obligation to notify visitors.</p>
                        </div>
                    </div>

                    <!-- Card 4: Use of Site -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-laptop"></i></div>
                            <h2 class="clause-title">Your Use of the Site</h2>
                        </div>
                        <div class="clause-body">
                            <p>You may download content from this Site exclusively for non-commercial, personal use only, provided that all copyright and proprietary notices remain unchanged. Using our services does not grant you ownership of any intellectual property rights.</p>
                            <p>You agree not to copy, modify, alter, display, distribute, sell, broadcast, or transmit any material from the Site without prior written permission from <strong>I Kan Housing</strong>.</p>
                        </div>
                    </div>

                    <!-- Card 5: Unlawful Use -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-ban"></i></div>
                            <h2 class="clause-title">No Unlawful or Prohibited Use</h2>
                        </div>
                        <div class="clause-body">
                            <p>As a condition of your use of the Site, you agree not to use the Site for any purpose that is unlawful or prohibited by these Terms of Use or by any applicable laws, including the Information Technology Act, 2000 as amended from time to time.</p>
                        </div>
                    </div>

                    <!-- Card 6: Disclaimer -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-info-circle"></i></div>
                            <h2 class="clause-title">Disclaimers</h2>
                        </div>
                        <div class="clause-body">
                            <p>Except as expressly provided in these Terms, the website and its contents are provided on an “as is” basis. <strong>I Kan Housing</strong> disclaims all warranties of any kind, whether express or implied.</p>
                            <p>We disclaim all responsibility for loss, injury, or damage of any kind resulting from:</p>
                            <ul>
                                <li>Technical inaccuracies and typographical errors.</li>
                                <li>Third-party websites or content accessed through links on this website.</li>
                                <li>Unavailability of the website or any portion of it.</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Card 7: Liability -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-balance-scale"></i></div>
                            <h2 class="clause-title">Limitation of Liability</h2>
                        </div>
                        <div class="clause-body">
                            <p>In no event shall <strong>I Kan Housing</strong> be liable for any direct, indirect, special, exemplary, punitive, incidental, or consequential damages arising out of the use of the information contained on this Site.</p>
                        </div>
                    </div>

                    <!-- Card 8: Copyright -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-copyright"></i></div>
                            <h2 class="clause-title">Copyright Notice</h2>
                        </div>
                        <div class="clause-body">
                            <p>Unless otherwise noted, the graphic images, buttons, and text contained in this Site are the exclusive property of <strong>I Kan Housing</strong>. Except for personal use, these items may not be copied, distributed, or transmitted without prior written permission.</p>
                        </div>
                    </div>

                    <!-- Card 9: Jurisdiction -->
                    <div class="clause-card" data-aos="fade-up">
                        <div class="clause-header">
                            <div class="clause-icon"><i class="fa fa-map-marker-alt"></i></div>
                            <h2 class="clause-title">Jurisdiction</h2>
                        </div>
                        <div class="clause-body">
                            <p><strong>I Kan Housing</strong> maintains and operates this Site from its offices in Mumbai, India. These Terms of Use are governed and interpreted under the local laws of Mumbai, India.</p>
                        </div>
                    </div>

                    <p class="text-center text-muted mt-5 opacity-50">This Terms of Use page is maintained by <a href="https://ikanhousing.com/" target="_blank">ikanhousing.com</a></p>

                </div>
            </div>

        </div>
    </main>

    <?php include 'component/footer.php'; ?>

</body>
</html>
