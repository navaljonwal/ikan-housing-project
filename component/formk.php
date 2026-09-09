<!-- ===== HOW CAN WE HELP YOU — PREMIUM FORM SECTION ===== -->
<style>
.help-section {
    padding: 90px 0 100px;
    background: linear-gradient(160deg, #fff5f9 0%, #fff 40%, #fce7f3 100%);
    position: relative;
    overflow: hidden;
}

.help-section::before {
    content: '';
    position: absolute;
    top: -80px; right: -80px;
    width: 400px; height: 400px;
    background: radial-gradient(circle, rgba(192,42,124,0.07), transparent 65%);
    pointer-events: none;
}

.help-section::after {
    content: '';
    position: absolute;
    bottom: -60px; left: -60px;
    width: 300px; height: 300px;
    background: radial-gradient(circle, rgba(192,42,124,0.05), transparent 65%);
    pointer-events: none;
}

/* ===== HEADER ===== */
.help-header {
    text-align: center;
    margin-bottom: 60px;
}

.help-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: rgba(192,42,124,0.08);
    border: 1px solid rgba(192,42,124,0.2);
    color: #c02a7c;
    padding: 7px 20px;
    border-radius: 50px;
    font-size: 0.72rem;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 20px;
}

.help-badge i {
    font-size: 0.75rem;
    animation: spin-slow 4s linear infinite;
}

@keyframes spin-slow {
    from { transform: rotate(0deg); }
    to   { transform: rotate(360deg); }
}

.help-title {
    font-size: clamp(2rem, 4vw, 3.2rem);
    font-weight: 900;
    color: #2d0a1c;
    line-height: 1.15;
    margin-bottom: 14px;
    letter-spacing: -1px;
}

.help-title span {
    background: linear-gradient(135deg, #c02a7c, #ff85c0);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.help-subtitle {
    color: #8e6f7e;
    font-size: 1rem;
    line-height: 1.7;
    max-width: 480px;
    margin: 0 auto;
}

/* ===== CONTACT CARD WRAPPER ===== */
.help-card-wrap {
    background: #fff;
    border-radius: 28px;
    box-shadow: 0 30px 80px rgba(45,10,28,0.1), 0 0 0 1px rgba(192,42,124,0.06);
    overflow: hidden;
    display: flex;
    min-height: 480px;
}

/* Left panel */
.help-left-panel {
    background: linear-gradient(160deg, #2d0a1c 0%, #1a0511 60%, #3d0d28 100%);
    padding: 52px 44px;
    width: 38%;
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

.help-left-panel::before {
    content: '';
    position: absolute;
    top: -60px; right: -60px;
    width: 220px; height: 220px;
    background: radial-gradient(circle, rgba(192,42,124,0.25), transparent 65%);
}

.help-left-panel::after {
    content: '';
    position: absolute;
    bottom: -40px; left: -40px;
    width: 180px; height: 180px;
    background: radial-gradient(circle, rgba(255,133,192,0.12), transparent 65%);
}

.help-panel-title {
    font-size: 1.5rem;
    font-weight: 800;
    color: #fff;
    margin-bottom: 10px;
    position: relative; z-index: 1;
}

.help-panel-desc {
    color: rgba(255,255,255,0.6);
    font-size: 0.9rem;
    line-height: 1.7;
    position: relative; z-index: 1;
    margin-bottom: 36px;
}

.help-contact-info {
    list-style: none;
    padding: 0;
    margin: 0;
    position: relative; z-index: 1;
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.help-contact-info li {
    display: flex;
    align-items: center;
    gap: 14px;
}

.help-info-icon {
    width: 38px; height: 38px;
    background: rgba(192,42,124,0.2);
    border: 1px solid rgba(192,42,124,0.3);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    color: #ff85c0;
    flex-shrink: 0;
}

.help-info-text {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.75);
    font-weight: 500;
    line-height: 1.4;
}

.help-info-text strong {
    color: #fff;
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    color: rgba(255,133,192,0.8);
    text-transform: uppercase;
    margin-bottom: 2px;
}

.help-social-row {
    display: flex;
    gap: 10px;
    position: relative; z-index: 1;
    margin-top: 36px;
}

.help-social-btn {
    width: 36px; height: 36px;
    background: rgba(255,255,255,0.08);
    border: 1px solid rgba(255,255,255,0.12);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: rgba(255,255,255,0.7);
    font-size: 0.85rem;
    text-decoration: none;
    transition: all 0.3s ease;
}

.help-social-btn:hover {
    background: #c02a7c;
    border-color: #c02a7c;
    color: #fff;
    transform: translateY(-3px);
}

/* Right panel — Form */
.help-right-panel {
    flex: 1;
    padding: 52px 48px;
}

/* Enquire toggle button */
.help-enquire-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    border: none;
    padding: 16px 38px;
    border-radius: 50px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    box-shadow: 0 12px 30px rgba(192,42,124,0.3);
    letter-spacing: 0.3px;
}

.help-enquire-btn i {
    width: 32px; height: 32px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.9rem;
    transition: transform 0.3s ease;
}

.help-enquire-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 20px 45px rgba(192,42,124,0.45);
}

.help-enquire-btn:hover i {
    transform: rotate(45deg);
}

.help-toggle-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    flex-direction: column;
    gap: 16px;
    text-align: center;
}

.help-toggle-wrap p {
    color: #8e6f7e;
    font-size: 0.92rem;
    margin: 0;
}

/* ===== FORM STYLES ===== */
.help-form {
    display: none;
}

.help-form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}

.help-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.help-field.full {
    grid-column: 1 / -1;
}

.help-field label {
    font-size: 0.78rem;
    font-weight: 700;
    color: #2d0a1c;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.help-field label span {
    color: #c02a7c;
}

.help-input {
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

.help-input::placeholder {
    color: #c4aab8;
    font-size: 0.9rem;
}

.help-input:focus {
    border-color: #c02a7c;
    background: #fff;
    box-shadow: 0 0 0 4px rgba(192,42,124,0.08);
}

textarea.help-input {
    resize: none;
    height: 100px;
}

.help-submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: linear-gradient(135deg, #c02a7c, #8b1d57);
    color: #fff;
    border: none;
    padding: 15px 36px;
    border-radius: 50px;
    font-size: 0.98rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.4s ease;
    box-shadow: 0 10px 25px rgba(192,42,124,0.28);
    font-family: 'Outfit', sans-serif;
    width: 100%;
    justify-content: center;
    margin-top: 8px;
}

.help-submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 18px 40px rgba(192,42,124,0.4);
}

.help-submit-btn .btn-spinner {
    display: none;
    width: 18px; height: 18px;
    border: 2px solid rgba(255,255,255,0.4);
    border-top-color: #fff;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Success / error popup */
#popup-messages {
    display: none;
    padding: 14px 20px;
    border-radius: 12px;
    font-size: 0.9rem;
    font-weight: 600;
    margin-top: 16px;
    text-align: center;
    color: #fff;
    animation: fadeInUp 0.4s ease;
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* Responsive */
@media (max-width: 900px) {
    .help-card-wrap { flex-direction: column; }
    .help-left-panel { width: 100%; padding: 36px 28px; }
    .help-right-panel { padding: 36px 28px; }
    .help-form-grid { grid-template-columns: 1fr; }
}

@media (max-width: 576px) {
    .help-section { padding: 60px 0 70px; }
    .help-title { font-size: 1.9rem; }
}
</style>

<section class="help-section" id="help-section">
    <div class="container">

        <!-- Section Header -->
        <div class="help-header" data-aos="fade-down" data-aos-duration="800">
            <div class="help-badge">
                <i class="fa fa-star"></i> Get In Touch
            </div>
            <h2 class="help-title">How Can We <span>Help You?</span></h2>
            <p class="help-subtitle">Our team of experts is ready to guide you through every step of your real estate journey. Reach out today.</p>
        </div>

        <!-- Main Card -->
        <div class="help-card-wrap" data-aos="fade-up" data-aos-duration="900">

            <!-- Left: Info Panel -->
            <div class="help-left-panel">
                <div>
                    <h3 class="help-panel-title">Contact Information</h3>
                    <p class="help-panel-desc">Fill out the form and our team will get back to you within 24 hours.</p>

                    <ul class="help-contact-info">
                        <li>
                            <div class="help-info-icon"><i class="fa fa-phone"></i></div>
                            <div class="help-info-text">
                                <strong>Call Us</strong>
                                +91 89553 31454
                            </div>
                        </li>
                        <li>
                            <div class="help-info-icon"><i class="fa fa-envelope"></i></div>
                            <div class="help-info-text">
                                <strong>Email Us</strong>
                                info@ikanhousing.com
                            </div>
                        </li>
                        <li>
                            <div class="help-info-icon"><i class="fa fa-map-marker"></i></div>
                            <div class="help-info-text">
                                <strong>Visit Us</strong>
                                Jaipur, Rajasthan, India
                            </div>
                        </li>
                    </ul>
                </div>

                <div>
                    <div class="help-social-row">
                        <a href="https://www.facebook.com/IkanHousing" target="_blank" class="help-social-btn"><i class="fa fa-facebook"></i></a>
                        <a href="https://www.instagram.com/ikanhousing" target="_blank" class="help-social-btn"><i class="fa fa-instagram"></i></a>
                        <a href="https://www.linkedin.com/company/ikan-housing" target="_blank" class="help-social-btn"><i class="fa fa-linkedin"></i></a>
                        <a href="https://wa.me/918955331454" target="_blank" class="help-social-btn"><i class="fa fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <!-- Right: Form Panel -->
            <div class="help-right-panel">

                <!-- Enquire Toggle -->
                <div class="help-toggle-wrap" id="hidee-wrap">
                    <button class="help-enquire-btn" id="hidee" onclick="showHelpForm()">
                        <i class="fa fa-plus"></i>
                        Enquire Now
                    </button>
                    <p>Click to open the enquiry form and connect with our team</p>
                </div>

                <!-- Form (hidden by default) -->
                <form class="help-form" id="showw" action="contact.php" method="post" id="myForm">
                    <input type="hidden" name="business_service_name" id="business_service_name" value="Contact from Service">

                    <div class="help-form-grid">
                        <div class="help-field">
                            <label for="fname">Your Name <span>*</span></label>
                            <input type="text" class="help-input" id="fname" name="name" placeholder="e.g. Rahul Sharma" required>
                        </div>
                        <div class="help-field">
                            <label for="email">Email Address <span>*</span></label>
                            <input type="email" class="help-input" id="email" name="email" placeholder="you@example.com" required>
                        </div>
                        <div class="help-field full">
                            <label for="number">Mobile Number <span>*</span></label>
                            <input type="tel" class="help-input" id="number" name="phone" placeholder="Your 10-digit mobile number" required maxlength="10">
                        </div>
                        <div class="help-field full">
                            <label for="message">Your Message <span>*</span></label>
                            <textarea class="help-input" id="message" name="message" placeholder="Tell us how we can help you..." required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="help-submit-btn" id="submitBtn">
                        <span class="btn-spinner" id="btnSpinner"></span>
                        <i class="fa fa-paper-plane" id="btnIcon"></i>
                        Send Message
                    </button>

                    <div id="popup-messages"></div>
                </form>

            </div>
        </div><!-- /card-wrap -->

    </div>
</section>

<script>
function showHelpForm() {
    document.getElementById('hidee-wrap').style.display = 'none';
    var form = document.getElementById('showw');
    form.style.display = 'block';
    form.style.animation = 'fadeInUp 0.5s ease';
}

document.getElementById('business_service_name').value = "Contact from Service";

$(document).ready(function () {
    $("#myForm, #showw").on('submit', function (e) {
        e.preventDefault();
        var formData = $(this).serialize();
        var btn = $('#submitBtn');
        var spinner = $('#btnSpinner');
        var icon = $('#btnIcon');

        btn.prop('disabled', true);
        spinner.show();
        icon.hide();

        $.ajax({
            url: "contact.php",
            type: "POST",
            data: formData,
            success: function (response) {
                showPopup("✅ Message sent! We'll reach out within 24 hours.");
                $('#showw')[0].reset();
            },
            error: function () {
                showPopup("❌ Something went wrong. Please try again.", true);
            },
            complete: function () {
                btn.prop('disabled', false);
                spinner.hide();
                icon.show();
            }
        });
    });

    function showPopup(message, isError = false) {
        const popup = $("#popup-messages");
        popup.text(message);
        popup.css("background-color", isError ? "#e74c3c" : "#c02a7c");
        popup.fadeIn(300);
        setTimeout(function () { popup.fadeOut(400); }, 5000);
    }
});
</script>
