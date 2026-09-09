<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<body class="home-page">
    
    <!-- Navbar -->
    <?php include 'component/navbar.php'; ?>

    <!-- Premium Career Hero -->
    <header class="about-hero" data-aos="fade-down">
        <div class="container">
            <div class="about-badge mb-3">Careers at I Kan</div>
            <h1 class="story-title">Shape The <span>Future</span> <br>Of Real Estate</h1>
            <p class="text-muted mx-auto" style="max-width: 800px !important;">Join a dynamic team where innovation meets excellence. We're looking for passionate individuals to help us redefine high-end living in Jaipur.</p>
            <div class="mt-4">
                <button onclick="scrollToJobs()" class="btn btn-primary">Explore Openings</button>
            </div>
        </div>
    </header>

    <!-- Culture Section -->
    <section class="section-padding bg-white overflow-hidden">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <?php
                    if (isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger rounded-4 py-3 border-0 shadow-sm' id='alert'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']);
                    }
                    if (isset($_SESSION['success'])) {
                        echo "<div class='alert alert-success rounded-4 py-3 border-0 shadow-sm' id='alert'>" . $_SESSION['success'] . "</div>";
                        unset($_SESSION['success']);
                    }
                    ?>
                    <div class="about-badge mb-3">Our Culture</div>
                    <h2 class="fw-bold text-secondary mb-4" style="font-size: 2.5rem;">Join a Team That Values <span class="text-primary">Growth</span></h2>
                    <p class="text-muted mb-4 lead">At I Kan Housing, we don't just build homes; we foster careers. Our culture is built on transparency, collaboration, and a relentless pursuit of excellence.</p>
                    
                    <div class="row g-4 mt-2">
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="job-icon-box mb-0" style="width: 45px; height: 45px; font-size: 1.1rem;"><i class="fa fa-chart-line"></i></div>
                                <h6 class="fw-bold mb-0">Career Growth</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="job-icon-box mb-0" style="width: 45px; height: 45px; font-size: 1.1rem;"><i class="fa fa-users"></i></div>
                                <h6 class="fw-bold mb-0">Elite Team</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="job-icon-box mb-0" style="width: 45px; height: 45px; font-size: 1.1rem;"><i class="fa fa-lightbulb"></i></div>
                                <h6 class="fw-bold mb-0">Innovation</h6>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex align-items-center gap-3">
                                <div class="job-icon-box mb-0" style="width: 45px; height: 45px; font-size: 1.1rem;"><i class="fa fa-heart"></i></div>
                                <h6 class="fw-bold mb-0">Work-Life Balance</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="culture-grid">
                        <div class="culture-photo-item" data-aos="zoom-in" data-aos-delay="100">
                            <img src="img/bday1.jpeg" alt="Team Celebration">
                        </div>
                        <div class="culture-photo-item" data-aos="zoom-in" data-aos-delay="200">
                            <img src="img/2-bhai.jpg" alt="Collaborative Culture">
                        </div>
                        <div class="culture-photo-item" data-aos="zoom-in" data-aos-delay="300">
                            <img src="img/at-2.jpg" alt="Office Environment">
                        </div>
                        <div class="culture-photo-item" data-aos="zoom-in" data-aos-delay="400">
                            <img src="img/all-team-2.jpg" alt="Annual Meet">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Board Section -->
    <section class="section-padding bg_light" id="job-board">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold text-secondary">Current Openings</h2>
                <p class="text-muted">Find your perfect role and start your journey with us.</p>
            </div>

            <div class="job-board-modern">
                <!-- Job 1 -->
                <div class="job-card-premium" data-aos="fade-up">
                    <div class="job-icon-box"><i class="fa fa-user-tie"></i></div>
                    <div class="job-meta-badge">Sales & Leadership</div>
                    <h3 class="job-title-premium">Sr. Sales Manager</h3>
                    <p class="job-description-short">We're looking for veterans with 3-4 years in Jaipur real estate. Expert in luxury villa sales and deal closing.</p>
                    <button class="btn btn-primary w-100 mt-auto applyNowBtn" data-position="Sr. Sales Manager">Apply Now</button>
                </div>

                <!-- Job 2 -->
                <div class="job-card-premium" data-aos="fade-up" data-aos-delay="100">
                    <div class="job-icon-box"><i class="fa fa-users"></i></div>
                    <div class="job-meta-badge">Sales</div>
                    <h3 class="job-title-premium">Sales Manager</h3>
                    <p class="job-description-short">Drive sales for high-growth projects. Ideal for candidates with 1-2 years experience and strong communication.</p>
                    <button class="btn btn-primary w-100 mt-auto applyNowBtn" data-position="Sales Manager">Apply Now</button>
                </div>

                <!-- Job 3 -->
                <div class="job-card-premium" data-aos="fade-up" data-aos-delay="200">
                    <div class="job-icon-box"><i class="fa fa-briefcase"></i></div>
                    <div class="job-meta-badge">Support</div>
                    <h3 class="job-title-premium">Asst. Sales Manager</h3>
                    <p class="job-description-short">Entry-level leadership role for energetic individuals with 1 year experience in residential sales.</p>
                    <button class="btn btn-primary w-100 mt-auto applyNowBtn" data-position="Asst. Sales Manager">Apply Now</button>
                </div>

                <!-- Job 4 -->
                <div class="job-card-premium" data-aos="fade-up">
                    <div class="job-icon-box"><i class="fa fa-desktop"></i></div>
                    <div class="job-meta-badge">Administration</div>
                    <h3 class="job-title-premium">Backoffice Executive</h3>
                    <p class="job-description-short">Detail-oriented support for sales teams. Proficiency in MS Office and database management required.</p>
                    <button class="btn btn-primary w-100 mt-auto applyNowBtn" data-position="Backoffice Executive">Apply Now</button>
                </div>

                <!-- Job 5 -->
                <div class="job-card-premium" data-aos="fade-up" data-aos-delay="100">
                    <div class="job-icon-box"><i class="fa fa-concierge-bell"></i></div>
                    <div class="job-meta-badge">Front Desk</div>
                    <h3 class="job-title-premium">Receptionist</h3>
                    <p class="job-description-short">The face of our company. Professional, presentable, and well-spoken individuals with admin skills.</p>
                    <button class="btn btn-primary w-100 mt-auto applyNowBtn" data-position="Receptionist">Apply Now</button>
                </div>

                <!-- Job 6 -->
                <div class="job-card-premium" data-aos="fade-up" data-aos-delay="200">
                    <div class="job-icon-box"><i class="fa fa-headset"></i></div>
                    <div class="job-meta-badge">Tele-Marketing</div>
                    <h3 class="job-title-premium">Female Telecallers</h3>
                    <p class="job-description-short">Outbound experts with strong persuasion skills. Help us connect with potential high-net-worth clients.</p>
                    <button class="btn btn-primary w-100 mt-auto applyNowBtn" data-position="Telecaller">Apply Now</button>
                </div>
            </div>
        </div>
    </section>

    <!-- Application Modal -->
    <div class="modal fade modal-glass" id="applicationModal" tabindex="-1" aria-hidden="true" style="display: none; align-items: center; justify-content: center;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content modal-content-premium">
                <div class="modal-header modal-header-premium">
                    <h5 class="modal-title fw-bold">Application Form</h5>
                    <button type="button" class="btn-close btn-close-white" id="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body modal-body-premium bg-white">
                    <form action="api/resume.php" method="post" id="resumeform" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label-premium">Full Name *</label>
                                <input class="form-control form-control-premium" placeholder="Your Name" type="text" name="name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-premium">Email Address *</label>
                                <input class="form-control form-control-premium" placeholder="email@example.com" type="email" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-premium">Mobile *</label>
                                <input maxlength="10" minlength="10" class="form-control form-control-premium" placeholder="10-digit number" type="tel" name="mobile" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label-premium">Age *</label>
                                <input class="form-control form-control-premium" placeholder="Enter age" type="number" name="age" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-premium">Applying For *</label>
                                <select class="form-select form-control-premium" id="targetPosition" name="position" required>
                                    <option value="" disabled selected>Select Position</option>
                                    <option value="Sr. Sales Manager">Sr. Sales Manager</option>
                                    <option value="Sales Manager">Sales Manager</option>
                                    <option value="Asst. Sales Manager">Asst. Sales Manager</option>
                                    <option value="Backoffice Executive">Backoffice Executive</option>
                                    <option value="Receptionist">Receptionist</option>
                                    <option value="Telecaller">Telecaller</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label-premium">Years of Experience *</label>
                                <input class="form-control form-control-premium" placeholder="Ex: 2" type="number" name="experience" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label-premium">Your Resume (PDF/DOC) *</label>
                                <input class="form-control form-control-premium" type="file" name="resume" accept=".pdf,.doc,.docx" required>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100 py-3 fw-bold">Submit Application</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'component/footer.php'; ?>

    <script>
        function scrollToJobs() {
            document.getElementById('job-board').scrollIntoView({ behavior: 'smooth' });
        }

        document.addEventListener("DOMContentLoaded", function () {
            const modal = document.getElementById("applicationModal");
            const closeModalBtn = document.getElementById("closeModal");
            const applyNowButtons = document.querySelectorAll(".applyNowBtn");
            const targetSelect = document.getElementById("targetPosition");

            applyNowButtons.forEach(button => {
                button.addEventListener("click", function (event) {
                    event.preventDefault();
                    const position = this.getAttribute('data-position');
                    if(position) targetSelect.value = position;
                    modal.style.display = "flex";
                });
            });

            closeModalBtn.addEventListener("click", function () {
                modal.style.display = "none";
            });

            window.addEventListener("click", function(e){
                if(e.target === modal){
                    modal.style.display = "none";
                }
            });

            // Fade out alerts
            const alertElement = document.getElementById('alert');
            if (alertElement) {
                setTimeout(function () {
                    alertElement.style.opacity = '0';
                    setTimeout(function () {
                        alertElement.style.display = 'none';
                    }, 500);
                }, 10000);
            }
        });
    </script>
</body>
</html>