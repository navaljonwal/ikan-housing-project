<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    header("Content-Type: application/json"); // ✅ ADD THIS

    $name    = mysqli_real_escape_string($con, $_POST['name']);
    $email   = mysqli_real_escape_string($con, $_POST['email']);
    $phone   = mysqli_real_escape_string($con, $_POST['phone']);
    $message = mysqli_real_escape_string($con, $_POST['message']);
    $business_service_name = mysqli_real_escape_string($con, $_POST['business_service_name']);

    $sql = "INSERT INTO contact (name, email, phone, message, business_service_name) 
            VALUES ('$name', '$email', '$phone', '$message', '$business_service_name')";

    if ($con->query($sql) === TRUE) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "msg" => $con->error]);
    }

    $con->close();
    exit; // ✅ VERY IMPORTANT (stop HTML output)
}
?>

<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<style>
    :root {
        --cnt-plum: #2d0a1c;
        --cnt-pink: #c02a7c;
        --cnt-pink-light: #fff5f9;
        --cnt-glass: rgba(255, 255, 255, 0.95);
    }

    body {
        font-family: 'Outfit', sans-serif;
        background-color: #fff;
        color: var(--cnt-plum);
    }

    /* 🎬 Cinematic Hero Section */
    .cnt-hero-section {
        position: relative;
        padding: 120px 0 80px;
        background: linear-gradient(135deg, #2d0a1ca0 0%, #c02a7c20 100%), 
                    url('rkimg/contact-bg.jpg') center/cover no-repeat;
        color: white;
        text-align: center;
        overflow: hidden;
    }

    .cnt-hero-section::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: radial-gradient(circle at top right, #c02a7c15, transparent);
        z-index: 1;
    }

    .cnt-hero-badge {
        display: inline-block;
        padding: 8px 16px;
        background: rgba(192, 42, 124, 0.1);
        border: 1px solid rgba(192, 42, 124, 0.3);
        backdrop-filter: blur(10px);
        color: var(--cnt-pink);
        border-radius: 100px;
        font-size: 0.85rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }

    .cnt-hero-title {
        font-size: clamp(2.5rem, 6vw, 4.5rem);
        font-weight: 800;
        line-height: 1.1;
        margin-bottom: 1.5rem;
        position: relative;
        z-index: 2;
    }

    .cnt-hero-title span {
        color: var(--cnt-pink);
        background: -webkit-linear-gradient(var(--cnt-pink), #e04696);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .cnt-hero-subtitle {
        font-size: 1.1rem;
        color: rgba(255, 255, 255, 0.8);
        max-width: 700px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
    }

    /* 💎 Contact Info Cards */
    .cnt-info-card {
        background: #fff;
        border: 1px solid #eee;
        border-radius: 24px;
        padding: 35px;
        height: 100%;
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        position: relative;
        overflow: hidden;
    }

    .cnt-info-card:hover {
        transform: translateY(-10px);
        border-color: var(--cnt-pink);
        box-shadow: 0 20px 40px rgba(45, 10, 28, 0.05);
    }

    .cnt-info-icon-box {
        width: 60px;
        height: 60px;
        background: var(--cnt-pink-light);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 25px;
        transition: all 0.4s ease;
    }

    .cnt-info-card:hover .cnt-info-icon-box {
        background: var(--cnt-pink);
    }

    .cnt-info-icon-box i {
        font-size: 24px;
        color: var(--cnt-pink);
        transition: all 0.4s ease;
    }

    .cnt-info-card:hover .cnt-info-icon-box i {
        color: white;
    }

    .cnt-info-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--cnt-plum);
        margin-bottom: 10px;
    }

    .cnt-info-text {
        font-size: 0.95rem;
        color: #6c757d;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .cnt-info-link {
        color: var(--cnt-pink);
        text-decoration: none;
        font-weight: 700;
        font-size: 1rem;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: gap 0.3s ease;
    }

    .cnt-info-link:hover {
        gap: 12px;
        color: var(--cnt-plum);
    }

    /* 📝 Glass Form Section */
    .cnt-form-container {
        margin-top: -60px;
        position: relative;
        z-index: 10;
        margin-bottom: 100px;
    }

    .cnt-glass-card {
        background: var(--cnt-glass);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 40px;
        padding: 60px;
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.1);
    }

    .cnt-form-label {
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--cnt-plum);
        margin-bottom: 10px;
        display: block;
    }

    .cnt-form-control {
        background: #fdfdfd;
        border: 2px solid #f1f3f5;
        border-radius: 16px;
        padding: 18px 20px;
        font-size: 1rem;
        color: var(--cnt-plum);
        transition: all 0.3s ease;
    }

    .cnt-form-control:focus {
        background: #fff;
        border-color: var(--cnt-pink);
        box-shadow: 0 0 0 4px rgba(192, 42, 124, 0.05);
        outline: none;
    }

    .cnt-submit-btn {
        background: var(--cnt-pink);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 20px;
        font-size: 1.1rem;
        font-weight: 700;
        width: 100%;
        transition: all 0.4s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 20px;
    }

    .cnt-submit-btn:hover {
        background: var(--cnt-plum);
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(45, 10, 28, 0.2);
    }

    /* 🗺️ Premium Map Shell */
    .cnt-map-shell {
        height: 600px;
        border-radius: 40px;
        overflow: hidden;
        border: 1px solid #eee;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.05);
    }

    .cnt-whatsapp-float {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 60px;
        height: 60px;
        background: #25d366;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        box-shadow: 0 10px 25px rgba(37, 211, 102, 0.3);
        z-index: 999;
        transition: all 0.3s ease;
    }

    .cnt-whatsapp-float:hover {
        transform: scale(1.1) rotate(10deg);
        color: white;
    }

    @media (max-width: 991px) {
        .cnt-glass-card { padding: 40px 25px; border-radius: 30px; }
        .cnt-hero-section { padding: 100px 0 140px; }
        .cnt-form-container { margin-top: -100px; }
    }
</style>

<body class="home-page">
    <!-- Navbar -->
    <?php include 'component/navbar.php'; ?>

    <!-- Cinematic Hero -->
    <header class="cnt-hero-section">
        <div class="container">
            <div class="cnt-hero-badge" data-aos="fade-down">Connect With I Kan Housing</div>
            <h1 class="cnt-hero-title" data-aos="fade-up" data-aos-delay="100">Let’s Start A <br><span>New Chapter</span> Together</h1>
            <p class="cnt-hero-subtitle" data-aos="fade-up" data-aos-delay="200">Whether you're looking for your dream home or a strategic commercial asset, our team of experts is ready to navigate the path with you.</p>
        </div>
    </header>

    <!-- Main Content Section -->
    <main class="cnt-form-container">
        <div class="container">
            <div class="row g-5">
                <!-- Left: Contact Details -->
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="cnt-info-card">
                                <div class="cnt-info-icon-box"><i class="fa fa-map-marked-alt"></i></div>
                                <h3 class="cnt-info-title">Corporate HQ</h3>
                                <p class="cnt-info-text">B-128, Sanganer, Vidhyadhar Nagar, Shiksha Vihar, Jagatpura, Jaipur, Rajasthan 302017</p>
                                <a href="https://www.google.com/maps/place/I+Kan+Housing+Pvt+Ltd/@26.8288277,75.8526915,17z" target="_blank" class="cnt-info-link">Get Pro Directions <i class="fa fa-arrow-right"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12">
                            <div class="cnt-info-card">
                                <div class="cnt-info-icon-box"><i class="fa fa-phone-volume"></i></div>
                                <h3 class="cnt-info-title">Speak to Experts</h3>
                                <p class="cnt-info-text">Direct line to our senior consultants available 10AM - 7PM.</p>
                                <a href="tel:+918955331454" class="cnt-info-link">+91 89553 31454 <i class="fa fa-phone"></i></a>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12">
                            <div class="cnt-info-card">
                                <div class="cnt-info-icon-box"><i class="fa fa-envelope-open-text"></i></div>
                                <h3 class="cnt-info-title">Official Inquiries</h3>
                                <p class="cnt-info-text">Drop us a line and we’ll ensure it reaches the right department.</p>
                                <a href="mailto:info@ikanhousing.com" class="cnt-info-link">info@ikanhousing.com <i class="fa fa-paper-plane"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Glass Form -->
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="cnt-glass-card">
                        <h2 class="fw-bold mb-2">Send an Inquiry</h2>
                        <p class="text-muted mb-5">Our specialist will reach out to you within 24 hours.</p>

                        <form id="contactPageForm" class="row g-4">
                            <div class="col-12">
                                <span class="cnt-form-label">Service Type</span>
                                <select class="cnt-form-control w-100" name="business_service_name" required>
                                    <option value="" selected disabled>Select Service Category</option>
                                    <option value="Residential">Residential High-Rises</option>
                                    <option value="Commercial">Commercial Leasing</option>
                                    <option value="Investment">Strategic Investment</option>
                                    <option value="Consultancy">Project Marketing</option>
                                    <option value="HomeSolutions">Interior & Home Solutions</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <span class="cnt-form-label">Full Name</span>
                                <input type="text" class="cnt-form-control w-100" name="name" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <span class="cnt-form-label">Phone Number</span>
                                <input type="tel" class="cnt-form-control w-100" name="phone" placeholder="+91 00000 00000" pattern="[6-9][0-9]{9}" required>
                            </div>
                            <div class="col-12">
                                <span class="cnt-form-label">Email Address</span>
                                <input type="email" class="cnt-form-control w-100" name="email" placeholder="john@example.com" required>
                            </div>
                            <div class="col-12">
                                <span class="cnt-form-label">Your Message</span>
                                <textarea class="cnt-form-control w-100" name="message" rows="4" placeholder="Briefly describe your property requirements..."></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="cnt-submit-btn" id="submitBtn">
                                    Finalize Inquiry <i class="fa fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Map View -->
            <div class="mt-5" data-aos="zoom-in" data-aos-duration="1000">
                <div class="cnt-map-shell">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3560.3496929622447!2d75.8526914745018!3d26.828827763692143!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396dc9df0b288def%3A0x127963e9826fc367!2sI%20Kan%20Housing%20Pvt%20Ltd!5e0!3m2!1sen!2sin!4v1736338699030!5m2!1sen!2sin"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
        </div>
    </main>

    <!-- Floating WhatsApp -->
    <a href="https://wa.me/918955331454" class="cnt-whatsapp-float" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>

    <?php include 'component/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    $(document).ready(function() {
        // Initialize AOS
        AOS.init({
            duration: 900,
            once: true,
            offset: 100
        });

        // AJAX Form Submission
        $("#contactPageForm").on("submit", function(e) {
            e.preventDefault();
            
            const $btn = $("#submitBtn");
            const originalHTML = $btn.html();
            
            $btn.prop("disabled", true).html('<i class="fa fa-spinner fa-spin"></i> Finalizing...');

            $.ajax({
                url: "contact.php",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        swal.fire({
                            title: "Success! ✨",
                            text: "Your inquiry has been finalized. Our specialist will contact you shortly.",
                            icon: "success",
                            confirmButtonColor: "#c02a7c"
                        });
                        $("#contactPageForm")[0].reset();
                    } else {
                        swal.fire({
                            title: "Error!",
                            text: res.msg || "Something went wrong. Please check your details.",
                            icon: "error"
                        });
                    }
                },
                error: function() {
                    swal.fire({
                        title: "Connection Failed",
                        text: "We couldn't reach our server. Please try again later.",
                        icon: "error"
                    });
                },
                complete: function() {
                    $btn.prop("disabled", false).html(originalHTML);
                }
            });
        });
    });
    </script>
</body>
</html>