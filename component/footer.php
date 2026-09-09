<?php
include('config.php');

// Fetch all properties
$query = "SELECT * FROM properties WHERE status = 1 ORDER BY id DESC  LIMIT 4";
$result = mysqli_query($con, $query);

if (!$result) {
    die("Database query failed: " . mysqli_error($con));
}
?>
<footer class="footer">
    <div class="container" data-aos="fade-up">
        <div class="row gx-lg-5">
            <!-- Brand & Bio -->
            <div class="col-lg-4 col-12 mb-5 mb-lg-0 text-center text-lg-start">
                <img src="img/Ikanhousing-logo2.svg" alt="Ikan Housing Logo" class="footer-logo">
                <p class="mb-4 pe-lg-4">
                    I Kan Housing is your premier partner in Jaipur's real estate market, dedicated to delivering excellence across residential, commercial, and land solutions.
                </p>
                <div class="social-links">
                    <a href="https://www.facebook.com/ikanhousingjpr" class="social-icon" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/IkanHousing" class="social-icon" target="_blank"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/ikanhousing/" class="social-icon" target="_blank"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.linkedin.com/company/i-kan/" class="social-icon" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-6 mb-5 mb-lg-0">
                <h5>Our Company</h5>
                <ul class="footer-links">
                    <li><a href="index">Home</a></li>
                    <li><a href="about-us">About Us</a></li>
                    <li><a href="blog-grid">Latest News</a></li>
                    <li><a href="career">Careers</a></li>
                    <li><a href="contact">Contact</a></li>
                    <li><a href="terms">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-2 col-6 mb-5 mb-lg-0">
                <h5>Our Services</h5>
                <ul class="footer-links">
                    <li><a href="residential">Residential</a></li>
                    <li><a href="land-services">Land Services</a></li>
                    <li><a href="retail">Retail Space</a></li>
                    <li><a href="business-solutions">Business Solutions</a></li>
                    <li><a href="services">Browse All</a></li>
                </ul>
            </div>

            <!-- Newsletter -->
            <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                <h5>Stay Connected</h5>
                <p class="small mb-3">Get the latest property updates and investment opportunities directly in your inbox.</p>
                <form id="emailForm">
                    <div class="newsletter-box">
                        <input type="email" name="email" class="newsletter-input" placeholder="Your email address" required>
                        <button type="submit" id="subscribeBtn" class="newsletter-btn">Join</button>
                    </div>
                    <div id="subscribeMessage" class="mt-2 small" style="display:none;"></div>
                </form>
            </div>
        </div>

        <!-- Copyright section -->
        <div class="footer-bottom">
            <div class="row align-items-center">
                <div class="col-md-7 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">
                        &copy; 2025 <strong>I KAN HOUSING Pvt. Ltd.</strong> All Rights Reserved. 
                        <span class="mx-2 d-none d-sm-inline">|</span>
                        <a href="privacy-policy" class="text-secondary text-decoration-none hover-primary">Privacy Policy</a>
                        <span class="mx-2 d-none d-sm-inline">|</span>
                        <a href="terms" class="text-secondary text-decoration-none hover-primary">Terms & Conditions</a>
                        <span class="mx-2 d-none d-sm-inline">|</span>
                        <a href="sitemap" class="text-secondary text-decoration-none hover-primary">Sitemap</a>
                    </p>
                </div>
                <div class="col-md-5 text-center text-md-end">
                </div>
            </div>
        </div>
    </div>
</footer>
<!--/ Footer End /-->

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- 🎨 Non-Critical CSS (Deferred) -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" media="print" onload="this.media='all'">

<style>
    .whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none !important;
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .whatsapp-icon {
        width: 60px;
        height: 60px;
        background-color: #25D366;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
        position: relative;
        animation: whatsapp-pulse 2s infinite;
    }
    .whatsapp-text {
        background: white;
        color: #0f172a;
        padding: 10px 20px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        border: 1px solid #e2e8f0;
        opacity: 0;
        transform: translateX(20px);
        transition: all 0.3s ease;
        pointer-events: none;
        white-space: nowrap;
    }
    .whatsapp-float:hover .whatsapp-text {
        opacity: 1;
        transform: translateX(0);
    }
    .whatsapp-float:hover {
        transform: scale(1.05);
    }
    @keyframes whatsapp-pulse {
        0% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
        100% { box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
    }
    @media (max-width: 768px) {
        .whatsapp-icon { width: 50px; height: 50px; font-size: 26px; }
        .whatsapp-text { display: none; }
        .whatsapp-float { bottom: 20px; right: 20px; }
    }
</style>

<a href="https://api.whatsapp.com/send?phone=918955331454&text=Hello! I am interested in your properties." class="whatsapp-float" id="whatsappFloat" target="_blank">
    <div class="whatsapp-text">Chat with Expert</div>
    <div class="whatsapp-icon">
        <i class="fa-brands fa-whatsapp"></i>
    </div>
</a>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize AOS Animations
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 800, once: true });
    }

    // 2. Global Navbar Scroll Logic (Sticky Header)
    const navbar = document.getElementById('mainNav');
    window.addEventListener('scroll', () => {
        if (navbar && window.scrollY > 50) {
            navbar.classList.add('sticky');
        } else if (navbar) {
            navbar.classList.remove('sticky');
        }
    });

    // 3. Initialize Swiper (Only if elements exist)
    if (document.querySelector('.mySwiper')) {
        new Swiper('.mySwiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination', clickable: true },
            breakpoints: {
                640: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });
    }

    // 4. WhatsApp Property Context
    const waFloat = document.getElementById('whatsappFloat');
    if (waFloat) {
        const projectName = document.querySelector('.project-title')?.innerText.trim();
        if (projectName) {
            const encodeMsg = encodeURIComponent("Hello! I am interested in " + projectName + ". Please share more details.");
            waFloat.href = "https://api.whatsapp.com/send?phone=918955331454&text=" + encodeMsg;
        }
    }

    // 5. Global Newsletter AJAX
    const emailForm = document.getElementById("emailForm");
    if (emailForm) {
        emailForm.addEventListener("submit", function (e) {
            e.preventDefault(); 
            const subscribeBtn = document.getElementById("subscribeBtn");
            const originalBtnText = subscribeBtn.innerHTML;
            subscribeBtn.innerHTML = "<span class='spinner-border spinner-border-sm'></span>";
            subscribeBtn.disabled = true;

            fetch("email.php", { method: "POST", body: new FormData(emailForm) })
            .then(res => res.json())
            .then(data => {
                const msg = document.getElementById("subscribeMessage");
                msg.textContent = data.message;
                msg.className = "alert " + (data.status === "error" ? "alert-danger" : "alert-success");
                msg.style.display = "block";
                if(data.status === "success") emailForm.reset();
                setTimeout(() => { msg.style.display = "none"; }, 4000);
            })
            .finally(() => {
                subscribeBtn.innerHTML = originalBtnText;
                subscribeBtn.disabled = false;
            });
        });
    }

    // 6. Content Tabs Handler
    const links = document.querySelectorAll('a[data-target]');
    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault(); 
            const targetId = link.getAttribute('data-target');
            document.querySelectorAll('.rdxf').forEach(div => div.style.display = 'none');
            const targetDiv = document.getElementById(targetId);
            if (targetDiv) targetDiv.style.display = 'block';
        });
    });
});
</script>
<!-- Chatbot Integration -->
<?php include 'component/chatbot.php'; ?>
<!-- //////////////////////////////////////////////// -->
