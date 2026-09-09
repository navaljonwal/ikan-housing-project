<?php
include('config.php');

// Fetch new_property for Ongoing Projects
$property_query = "SELECT id, slug, main_image, project_name, location FROM new_property WHERE status = 1 AND project_type = 0 ORDER BY RAND()";
$property_result = mysqli_query($con, $property_query);

// Trending Properties 
$trending_query = "SELECT id, slug, main_image, project_name, location, min_price, max_price FROM new_property WHERE status = 1 AND trending = 1 ORDER BY RAND()";
$trending_result = mysqli_query($con, $trending_query);

// Fetch blogs for News section
$blog_query = "SELECT id, slug, image, name FROM blog ORDER BY id DESC LIMIT 6";
$blog_result = mysqli_query($con, $blog_query);

if (!$property_result || !$blog_result) {
  die("Database query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include 'component/head.php';
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- AOS CSS -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<body class="home-page">

  <!--/ Nav Star /-->
  <?php include 'component/navbar.php'; ?>
  <!--/ Nav End /-->


  <!--/ Hero Section Modern /-->
  <section class="hero-modern" style="background-image: url('img/I_kan_Housing_Main_Flats.webp');">
    <div class="hero-overlay"></div>
    <div class="container hero-content text-center" data-aos="zoom-out" data-aos-duration="1200">
      <h1 class="hero-title mb-4">
        Find the <span class="text-primary" style="color: #e564b7e0 !important;">Perfect</span> Place to Live <br>
        <span class="fs-2 fw-light">with your Family</span>
      </h1>
      <p class="lead mb-5 text-white-50">Your Partners in Property — Let Us Know How We Can Help.</p>
      
      <div class="mx-auto" style="max-width: 900px;">
        <div class="search-tabs" data-aos="fade-up" data-aos-delay="200">
          <div class="search-tab active" onclick="setSearchType('buy')">Buy</div>
        </div>
        <div class="hero-search-console" data-aos="fade-up" data-aos-delay="300">
          <form action="ongoing-project" method="get" class="d-flex flex-column flex-lg-row w-100 align-items-center">
            <input type="hidden" name="type" id="searchType" value="buy">
            
            <div class="search-field">
              <span class="search-field-label">Location or Project</span>
              <div class="d-flex align-items-center">
                <i class="fa fa-map-marker-alt text-primary me-2"></i>
                <input type="text" name="search" placeholder="Search location or project name..." required>
              </div>
            </div>

            <div class="search-field">
                <span class="search-field-label">Property Type</span>
                <div class="d-flex align-items-center">
                  <i class="fa fa-home text-primary me-2"></i>
                  <select name="category">
                    <option value="">All Types</option>
                    <option value="Residential">Residential</option>
                    <option value="Commercial">Commercial</option>
                    <option value="Industrial">Industrial</option>
                    <option value="Land">Land / Plots</option>
                  </select>
                </div>
            </div>

            <div class="search-field border-0">
                <span class="search-field-label">Budget</span>
                <div class="d-flex align-items-center">
                  <i class="fa fa-tag text-primary me-2"></i>
                  <select name="budget">
                    <option value="">Any Budget</option>
                    <option value="sub-50l">Under 50 Lacs</option>
                    <option value="50l-1cr">50 Lacs - 1 Cr</option>
                    <option value="1cr-plus">Above 1 Cr</option>
                  </select>
                </div>
            </div>

            <button type="submit" class="search-submit-btn ms-lg-3 mt-3 mt-lg-0">
              <i class="fa fa-search"></i>
            </button>
          </form>
        </div>
      </div>
    </div>
  </section>
  <!--/ Ongoing Projects Section /-->
  <section class="section-padding bg-light">
    <div class="container" data-aos="fade-up">
      <div class="row align-items-center mb-5">
        <div class="col-md-8">
          <h2 class="section-title mb-0">Ongoing <span>Projects</span></h2>
          <p class="text-muted mt-2">Discover our latest residential and commercial developments.</p>
        </div>
        <div class="col-md-4 text-md-end mt-3 mt-md-0">
          <a href="ongoing-project" class="btn btn-outline-primary rounded-pill px-4">View All Projects</a>
        </div>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php while ($row = mysqli_fetch_assoc($property_result)) { ?>
            <div class="swiper-slide h-auto pb-4">
              <div class="property-card-minimal" onclick="openPopup('<?= $row['slug'] ?>')">
                <div class="property-img-top">
                  <img src="uploads/<?= htmlspecialchars($row['main_image']) ?>" 
                       alt="<?= htmlspecialchars($row['project_name']) ?>" 
                       loading="lazy">
                  <div class="project-tag-sharp">Ongoing</div>
                </div>
                <div class="property-details-bottom">
                  <div class="project-loc-tag">
                    <i class="fa fa-map-marker-alt me-1"></i><?= htmlspecialchars($row['location']) ?>
                  </div>
                  <h4 class="project-name-sharp"><?= htmlspecialchars($row['project_name']) ?></h4>
                  <div class="project-btn-sharp">
                    View Details <i class="fa fa-chevron-right ms-1"></i>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination mt-4"></div>
      </div>
    </div>
  </section>
  <!--/ Trending Property Section /-->
  <section class="section-padding">
    <div class="container" data-aos="fade-up">
      <div class="row align-items-center mb-5">
        <div class="col-md-12 text-center">
          <h2 class="section-title">Trending <span>Properties</span></h2>
          <p class="text-muted">Explore the most sought-after properties in Jaipur.</p>
        </div>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php while ($row1 = mysqli_fetch_assoc($trending_result)) { ?>
            <div class="swiper-slide h-auto pb-4">
              <div class="property-card-minimal" onclick="openPopup('<?= $row1['slug'] ?>')">
                <div class="property-img-top">
                  <img src="uploads/<?= htmlspecialchars($row1['main_image']) ?>" 
                       alt="<?= htmlspecialchars($row1['project_name']) ?>" 
                       loading="lazy">
                  <div class="project-tag-sharp bg-accent">Trending</div>
                </div>
                <div class="property-details-bottom">
                  <div class="project-loc-tag">
                    <i class="fa fa-map-marker-alt me-1"></i><?= htmlspecialchars($row1['location']) ?>
                  </div>
                  <h4 class="project-name-sharp mb-1"><?= htmlspecialchars($row1['project_name']) ?></h4>
                  <div class="project-price-sharp mb-3"><?= htmlspecialchars($row1['min_price']) ?> - <?= htmlspecialchars($row1['max_price']) ?></div>
                  
                  <div class="project-footer-sharp d-flex justify-content-center align-items-center mt-auto">
                    <div class="project-btn-sharp">
                      Details <i class="fa fa-chevron-right ms-1"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination mt-4"></div>
      </div>
    </div>
  </section>

<!-- Popup Modal -->
<div class="jhyt" id="mobilePopup" style="display:none;position:fixed;top:0;left:0;width:100%;height:100%;background:rgba(0,0,0,0.6);backdrop-filter:blur(5px);z-index:9999;">
  <div class="jhytt" style="background:white;padding:30px;width:90%;max-width:380px;border-radius:15px;text-align:center;box-shadow:0 15px 35px rgba(0,0,0,0.2);position:absolute;top:50%;left:50%;transform:translate(-50%, -50%);">
    <span onclick="closePopup()" style="position:absolute;top:10px;right:18px;font-size:28px;cursor:pointer;color:#999;font-weight:bold;">&times;</span>
    <div style="margin-bottom:20px;">
        <i class="fa fa-phone" style="font-size:36px;color:#c02a7c;background:#fdeaf3;padding:15px 18px;border-radius:50%;"></i>
    </div>
    <h3 style="font-size:22px;font-weight:700;color:#333;margin-bottom:10px;">View Full Details</h3>
    <p style="font-size:14px;color:#666;margin-bottom:20px;">Please enter your mobile number to proceed.</p>
    <form id="mobileForm" action="api/modal_contact.php" method="POST">
        <input type="hidden" name="slug" id="popup-slug">
        <input class="num form-control" type="text" id="mobileNumber" name="phone" placeholder="+91 00000 00000" required pattern="\d{10}" style="padding:12px;width:100%;border-radius:8px;border:1px solid #ddd;font-size:16px;text-align:center;letter-spacing:1px;box-shadow:none;">
        <button class="prk-btn" type="submit" style="width:100%;padding:13px;background:#c02a7c;color:white;border:none;border-radius:8px;font-size:16px;font-weight:600;cursor:pointer;margin-top:15px;transition:0.3s;box-shadow:0 4px 10px rgba(192,42,124,0.3);">Verify & Continue</button>
    </form>
  </div>
</div>
  <!--/ Property End /-->
  <!--/ Why Choose Us Section /-->
  <!--/ Elite Real Estate Services Section /-->
  <section class="section-padding bg-light">
    <div class="container" data-aos="fade-up">
      <div class="text-center mb-5">
        <h2 class="section-title text-center">Elite Real Estate <span>Services</span></h2>
        <p class="text-muted mx-auto" style="max-width: 600px;">Comprehensive solutions tailored to your unique property needs, backed by 15 years of Jaipur's market expertise.</p>
      </div>
      <div class="row g-4 mt-2">
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
          <div class="service-card text-center hover-up">
            <div class="service-icon-box"><i class="fa fa-home"></i></div>
            <h5>Residential Sales</h5>
            <p>From luxury villas to modern apartments, we find the perfect sanctuary for your family in Jaipur's most prime locations.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
          <div class="service-card text-center hover-up">
            <div class="service-icon-box"><i class="fa fa-chart-line"></i></div>
            <h5>Investment Advisory</h5>
            <p>Data-driven investment strategies tailored to maximize your ROI in the fastest-growing residential and commercial corridors.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
          <div class="service-card text-center hover-up">
            <div class="service-icon-box"><i class="fa fa-map-marked-alt"></i></div>
            <h5>Land & Plots</h5>
            <p>Secure, fully verified, and JDA-approved land solutions for long-term growth and customized construction projects.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
          <div class="service-card text-center hover-up">
            <div class="service-icon-box"><i class="fa fa-balance-scale"></i></div>
            <h5>Legal & Vastu</h5>
            <p>Ensuring complete peace of mind with rigorous documentation verification and expert Vastu consultation for every project.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
          <div class="service-card text-center hover-up">
            <div class="service-icon-box"><i class="fa fa-hand-holding-usd"></i></div>
            <h5>Loan Assistance</h5>
            <p>Hassle-free home loan processing through our network of top banking partners, ensuring the best interest rates for you.</p>
          </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
          <div class="service-card text-center hover-up">
            <div class="service-icon-box"><i class="fa fa-tools"></i></div>
            <h5>Post-Sales Care</h5>
            <p>Our commitment doesn't end with a sale. We provide full support for possession, interiors, and property maintenance.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/ Why Invest in Jaipur Section /-->
  <section class="section-padding position-relative overflow-hidden" style="background: linear-gradient(135deg, var(--secondary-color), #1e293b);">
    <div class="container text-white" data-aos="fade-up">
      <div class="row align-items-center mb-5">
        <div class="col-lg-6">
          <h2 class="display-5 fw-bold mb-4">Top Reasons to <br>Invest in <span class="text-primary-glow">Jaipur</span></h2>
          <p class="lead text-white opacity-75">Jaipur is among the fastest-growing Tier II cities in India, offering outstanding connectivity and investment potential.</p>
        </div>
        <div class="col-lg-6">
          <div class="row g-3">
            <div class="col-6">
              <div class="p-4 border border-secondary border-opacity-25 rounded-4 text-center bg-white-5-blur">
                <h4 class="fw-bold mb-0 text-white">11th</h4>
                <small class="text-white opacity-75">Largest city in India</small>
              </div>
            </div>
            <div class="col-6">
              <div class="p-4 border border-secondary border-opacity-25 rounded-4 text-center bg-white-5-blur">
                <h4 class="fw-bold mb-0 text-white">By 2025</h4>
                <small class="text-white opacity-75">Next Mega City</small>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <div class="row g-4">
        <div class="col-md-4">
          <div class="p-4 rounded-4 h-100 bg-white-5-blur border border-white-10">
            <i class="fa fa-plane text-primary fs-3 mb-3"></i>
            <h5 class="fw-bold text-white">Excellent Connectivity</h5>
            <p class="text-white opacity-75 small mb-0">14 national highways and an international airport linking Jaipur to the world.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 rounded-4 h-100 bg-white-5-blur border border-white-10">
            <i class="fa fa-map-marker-alt text-primary fs-3 mb-3"></i>
            <h5 class="fw-bold text-white">Proximity to Delhi/NCR</h5>
            <p class="text-white opacity-75 small mb-0">Strategic location near NCR makes it a preferred destination for property investment.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="p-4 rounded-4 h-100 bg-white-5-blur border border-white-10">
            <i class="fa fa-rocket text-primary fs-3 mb-3"></i>
            <h5 class="fw-bold text-white">Booming IT Sector</h5>
            <p class="text-white opacity-75 small mb-0">Major IT projects and MNCs are establishing a significant presence in the city.</p>
          </div>
        </div>
      </div>
    </div>
  </section>


  <!--/ About Us Section /-->
  <section class="section-padding bg-light">
    <div class="container" data-aos="fade-up">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0">
          <div class="position-relative">
            <img src="img/s222.jpg" alt="About I Kan Housing" class="img-fluid rounded-4 shadow-lg">
            <div class="position-absolute bottom-0 end-0 bg-primary p-4 rounded-4 shadow-lg d-none d-md-block translate-middle-y me-n4">
              <h3 class="text-white fw-bold mb-0">15+</h3>
              <small class="text-white-50">Years of Experience</small>
            </div>
          </div>
        </div>
        <div class="col-lg-6 ps-lg-5">
          <h2 class="section-title">We are <span>I Kan Housing</span></h2>
          <p class="lead mb-4">Established with a mission to provide the best real estate investment opportunities, I Kan Housing is dedicated to helping customers grow their wealth.</p>
          <p class="text-muted mb-4 text-justify">With this commitment, we offer some of the finest investment options by developing state-of-the-art townships and residential flat projects in prime locations across Jaipur.</p>
          <div class="d-flex gap-3">
            <a href="about-us" class="btn btn-primary rounded-pill px-4">Read Our Story</a>
            <a href="ongoing-project" class="btn btn-outline-secondary rounded-pill px-4">Our Projects</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--/ Latest News Section /-->
  <section class="section-padding">
    <div class="container" data-aos="fade-up">
      <div class="text-center mb-5">
        <h2 class="section-title">Our Latest <span>News</span></h2>
        <p class="text-muted">Stay updated with the latest trends and reports in Real Estate.</p>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <?php while ($blog = mysqli_fetch_assoc($blog_result)) { ?>
            <div class="swiper-slide h-auto pb-4">
              <div class="property-card-minimal blog-card-minimal" onclick="location.href='blog-details.php?slug=<?= $blog['slug'] ?>'">
                <div class="property-img-top">
                  <img src="uploads/<?= htmlspecialchars($blog['image']) ?>" 
                       alt="<?= htmlspecialchars($blog['name']) ?>" 
                       loading="lazy">
                  <div class="project-tag-sharp">News</div>
                </div>
                <div class="property-details-bottom">
                  <h5 class="project-name-sharp mb-3">
                    <a href="blog-details?slug=<?= $blog['slug'] ?>" class="text-decoration-none text-dark hover-primary">
                      <?= htmlspecialchars($blog['name']) ?>
                    </a>
                  </h5>
                  <div class="project-footer-sharp d-flex justify-content-center align-items-center mt-auto">
                    <div class="project-btn-sharp">
                      Read More <i class="fa fa-arrow-right ms-2"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
        </div>
        <div class="swiper-pagination mt-4"></div>
      </div>
    </div>
  </section>

  <!--/ Testimonials Section /-->
  <section class="section-padding bg-light">
    <div class="container" data-aos="fade-up">
      <div class="text-center mb-5">
        <h2 class="section-title">Our <span>Testimonials</span></h2>
        <p class="text-muted">What our valued clients say about their experience with us.</p>
      </div>

      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide h-auto pb-4 px-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center">
              <img src="img/pr-shuu.jpeg" alt="Sr. Shubham" class="rounded-circle mx-auto mb-3" width="80" height="80" style="object-fit:cover;">
              <h5 class="fw-bold mb-1">Sr. Shubham</h5>
              <div class="text-warning small mb-3"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
              <p class="text-muted small italic">"ikanvisit.com exceeded my expectations! The professionalism and expertise of their team made my home-buying process stress-free."</p>
            </div>
          </div>
          <div class="swiper-slide h-auto pb-4 px-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center">
              <img src="img/r-clnt.jpeg" alt="Mr. Ashish Jain" class="rounded-circle mx-auto mb-3" width="80" height="80" style="object-fit:cover;">
              <h5 class="fw-bold mb-1">Mr. Ashish Jain</h5>
              <div class="text-warning small mb-3"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
              <p class="text-muted small italic">"Their team is super professional and made the site visit so smooth! The Vastu consultation was spot on! 🙌"</p>
            </div>
          </div>
          <div class="swiper-slide h-auto pb-4 px-2">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100 text-center">
              <img src="img/r-clnt-1.jpeg" alt="Mr. Arnim & Ms. Kriti" class="rounded-circle mx-auto mb-3" width="80" height="80" style="object-fit:cover;">
              <h5 class="fw-bold mb-1">Mr. Arnim & Ms. Kriti</h5>
              <div class="text-warning small mb-3"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
              <p class="text-muted small italic">"Impressed with the knowledgeable team and valuable insights about the property. Their transparency made decision-making easy."</p>
            </div>
          </div>
        </div>
        <div class="swiper-pagination mt-4"></div>
      </div>
    </div>
  </section>

  <!--/ Contact Section /-->
  <section class="section-padding overflow-hidden">
    <div class="container" data-aos="fade-up">
      <div class="row g-5 align-items-center">
        <div class="col-lg-5">
           <h2 class="section-title mb-4">Get in <span>Touch</span></h2>
           <p class="text-muted mb-5">Have questions about a property or investment? Reach out to our expert team today.</p>
           
           <div class="d-flex align-items-center mb-4">
             <div class="bg-primary-light p-3 rounded-circle text-primary me-4"><i class="fa fa-phone fs-4"></i></div>
             <div>
               <h6 class="fw-bold mb-0">Call Us</h6>
               <a href="tel:+918955331454" class="text-muted text-decoration-none">+91 89553 31454</a>
             </div>
           </div>
           
           <div class="d-flex align-items-center mb-4">
             <div class="bg-primary-light p-3 rounded-circle text-primary me-4"><i class="fa fa-envelope fs-4"></i></div>
             <div>
               <h6 class="fw-bold mb-0">Email Us</h6>
               <a href="mailto:info@ikanhousing.com" class="text-muted text-decoration-none">info@ikanvisit.com</a>
             </div>
           </div>
           
           <div class="d-flex align-items-center">
             <div class="bg-primary-light p-3 rounded-circle text-primary me-4"><i class="fa fa-map-marker fs-4"></i></div>
             <div>
               <h6 class="fw-bold mb-0">Visit Us</h6>
               <span class="text-muted">Jaipur, Rajasthan, India</span>
             </div>
           </div>
        </div>
        <div class="col-lg-7">
          <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5">
            <form id="contactHomeForm" action="contact-home.php" method="post" class="row g-3">
              <div class="col-md-6">
                <input type="text" name="name" class="form-control rounded-pill px-4 py-3 bg-light border-0" placeholder="Your Name" required>
              </div>
              <div class="col-md-6">
                <input type="email" name="email" class="form-control rounded-pill px-4 py-3 bg-light border-0" placeholder="Your Email" required>
              </div>
              <div class="col-12">
                <input type="text" name="subject" class="form-control rounded-pill px-4 py-3 bg-light border-0" placeholder="Subject" required>
              </div>
              <div class="col-12">
                <textarea name="message" class="form-control rounded-4 px-4 py-3 bg-light border-0" rows="5" placeholder="Your Message" required></textarea>
              </div>
              <div class="col-12 text-center mt-4">
                <button type="submit" class="btn btn-primary rounded-pill px-5 py-3 fw-bold">Send Message</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!--/ footer /-->
  <?php include 'component/footer.php'; ?>
  
  <!-- Initialization & Custom Logic (Home Page Specific) -->
  <script>
    // Lead Popup Logic
    function openPopup(slug) {
      const isSubmitted = (getCookie('mobile_submitted') === '1' || localStorage.getItem('mobile_submitted') === '1');
      if (isSubmitted) {
        // Sync back to localStorage if found in cookie 
        if (localStorage.getItem('mobile_submitted') !== '1') {
          localStorage.setItem('mobile_submitted', '1');
        }
        window.location.href = 'property-detail-for.php?slug=' + encodeURIComponent(slug);
        return;
      }
      document.getElementById('popup-slug').value = slug;
      const popup = document.getElementById('mobilePopup');
      if (popup) {
        popup.style.display = 'block';
        setTimeout(() => popup.style.opacity = '1', 10);
      }
    }

    function closePopup() {
      const popup = document.getElementById('mobilePopup');
      if (popup) {
        popup.style.opacity = '0';
        setTimeout(() => popup.style.display = 'none', 300);
      }
    }

    function getCookie(name) {
      const value = `; ${document.cookie}`;
      const parts = value.split(`; ${name}=`);
      if (parts.length === 2) return parts.pop().split(';').shift();
    }

    window.addEventListener('load', () => {
      const popup = document.getElementById('mobilePopup');
      if(popup) {
        popup.style.display = 'none';
        popup.style.opacity = '0';
      }
    });

    // Home Page Contact Form AJAX
    $(document).ready(function() {
        $("#contactHomeForm").on("submit", function(e) {
            e.preventDefault();
            const $btn = $(this).find("button[type='submit']");
            const originalText = $btn.text();
            $btn.prop("disabled", true).text("Sending...");

            $.ajax({
                url: "contact-home.php",
                type: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(res) {
                    if (res.status === "success") {
                        Swal.fire({
                            title: 'Success!',
                            text: 'Your message has been received. Our team will contact you soon.',
                            icon: 'success',
                            confirmButtonColor: '#c02a7c',
                            confirmButtonText: 'Great!'
                        });
                        $("#contactHomeForm")[0].reset();
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: (res.msg || "Something went wrong. Please try again."),
                            icon: 'error',
                            confirmButtonColor: '#c02a7c'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Server Error!',
                        text: 'Could not reach the server. Please check your connection.',
                        icon: 'warning',
                        confirmButtonColor: '#c02a7c'
                    });
                },
                complete: function() {
                    $btn.prop("disabled", false).text(originalText);
                }
            });
        });
    });

    // Search Tab Logic
    window.setSearchType = function(type) {
        document.getElementById('searchType').value = type;
        const tabs = document.querySelectorAll('.search-tab');
        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.innerText.toLowerCase() === type) {
                tab.classList.add('active');
            }
        });
    };
  </script>
</body>
</html>