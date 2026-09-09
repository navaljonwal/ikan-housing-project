<?php
// speciall file included for index login
include('index-auth.php');
include('../config.php');

// Fetch latest 10 resumes
$resume_query = "SELECT * FROM resume_submissions ORDER BY created_at DESC LIMIT 10";
$resume_result = mysqli_query($con, $resume_query);
if (!$resume_result) {
    die("Resume query failed: " . mysqli_error($con));
}

// Property count
$property_query = "SELECT COUNT(*) as total_properties FROM properties";
$property_result = mysqli_query($con, $property_query);
$property_data = mysqli_fetch_assoc($property_result);
$property_count = $property_data['total_properties'];

// Contact count
$contact_query = "SELECT COUNT(*) as total_contacts FROM contact";
$contact_result = mysqli_query($con, $contact_query);
$contact_data = mysqli_fetch_assoc($contact_result);
$contact_count = $contact_data['total_contacts'];

// Career (resume) count
$resume_count_query = "SELECT COUNT(*) as total_resumes FROM resume_submissions";
$resume_count_result = mysqli_query($con, $resume_count_query);
$resume_count_data = mysqli_fetch_assoc($resume_count_result);
$resume_count = $resume_count_data['total_resumes'];

// Subscribe History
$subscribe_query = "SELECT * FROM subscribe_us ORDER BY id DESC LIMIT 10";
$subscribe_result = mysqli_query($con, $subscribe_query);
if (!$subscribe_result) {
    die("Subscribe query failed: " . mysqli_error($con));
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include('components/indexHead.php'); ?>
<body>
  <div class="wrapper">
    <?php include('components/sidebar.php'); ?>
    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <div class="logo-header" data-background-color="light">
            <a href="index" class="logo">
              <img src="assets/img/kaiadmin/Ikanhousing-logo.svg" alt="navbar brand" class="navbar-brand" height="50" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
              <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
          </div>
        </div>
        <?php include('components/navbar.php'); ?>
      </div>

      <div class="container">
          <div class="page-inner">
          <!-- Premium Welcome Hero -->
          <div class="admin-hero" data-aos="fade-down">
            <div class="row align-items-center">
              <div class="col-md-8">
                <h2 class="mb-2">Welcome back, I Kan Housing! 👋</h2>
                <p class="mb-0 fw-bold" style="color: var(--secondary-color); opacity: 0.7;">Here's a quick look at your property portfolio and recent activities.</p>
              </div>
              <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="../index" target="_blank" class="btn btn-light btn-round px-4">
                  <i class="fas fa-external-link-alt me-2"></i>View Site
                </a>
              </div>
            </div>
          </div>
          <!-- Quick Actions Section -->
          <div class="row mb-4" data-aos="fade-up" data-aos-delay="100">
            <div class="col-12">
              <div class="d-flex flex-wrap gap-2">
                <a href="new-property/new_property" class="btn btn-primary btn-round px-4 shadow-sm">
                  <i class="fas fa-plus me-2"></i>Add Property
                </a>
                <a href="blog/add" class="btn btn-outline-primary btn-round px-4 bg-white">
                  <i class="fas fa-pen me-2"></i>Post Blog
                </a>
                <a href="testimonial/add" class="btn btn-outline-primary btn-round px-4 bg-white">
                  <i class="fas fa-quote-left me-2"></i>Add Testimonial
                </a>
                <a href="sco/add" class="btn btn-outline-primary btn-round px-4 bg-white">
                  <i class="fas fa-search me-2"></i>SEO Update
                </a>
              </div>
            </div>
          </div>

          <!-- Modernized Stats Cards -->
          <div class="row">
            <!-- Property Stats -->
            <div class="col-sm-6 col-md-4">
              <a href="property/list" style="text-decoration: none;">
                <div class="card card-stats-premium" data-aos="zoom-in" data-aos-delay="200">
                  <div class="d-flex align-items-center">
                    <div class="icon-box-premium icon-property mb-0 shadow-sm">
                      <i class="fas fa-building"></i>
                    </div>
                    <div class="ms-3">
                      <p class="stats-label mb-0">Total Properties</p>
                      <h4 class="stats-value"><?php echo $property_count; ?></h4>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Contact Stats -->
            <div class="col-sm-6 col-md-4">
              <a href="contact/contact" style="text-decoration: none;">
                <div class="card card-stats-premium" data-aos="zoom-in" data-aos-delay="300">
                  <div class="d-flex align-items-center">
                    <div class="icon-box-premium icon-contact mb-0 shadow-sm" style="background: rgba(0, 123, 255, 0.1); color: #007bff;">
                      <i class="fas fa-envelope"></i>
                    </div>
                    <div class="ms-3">
                      <p class="stats-label mb-0">Total Inquiries</p>
                      <h4 class="stats-value"><?php echo $contact_count; ?></h4>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Career Stats -->
            <div class="col-sm-6 col-md-4">
              <a href="career/career" style="text-decoration: none;">
                <div class="card card-stats-premium" data-aos="zoom-in" data-aos-delay="400">
                  <div class="d-flex align-items-center">
                    <div class="icon-box-premium icon-career mb-0 shadow-sm" style="background: rgba(40, 167, 69, 0.1); color: #28a745;">
                      <i class="fas fa-file-alt"></i>
                    </div>
                    <div class="ms-3">
                      <p class="stats-label mb-0">Resume Received</p>
                      <h4 class="stats-value"><?php echo $resume_count; ?></h4>
                    </div>
                  </div>
                </div>
              </a>
            </div>
          </div>


          <!-- Resume and Subscribe History Row -->
          <div class="row">
            <!-- Resume Submissions -->
            <div class="col-md-4">
              <div class="card card-round" data-aos="fade-up" data-aos-offset="50">
                <div class="card-body">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title fw-bold">Recent Applications</div>
                  </div>
                  <div class="card-list py-4">
                    <?php if (mysqli_num_rows($resume_result) > 0) { 
                      while ($row = mysqli_fetch_assoc($resume_result)) { ?>
                      <div class="d-flex justify-content-between align-items-center item-list">
                        <div class="info-user ms-2">
                          <div class="username"><?php echo htmlspecialchars($row['name']); ?></div>
                          <div class="text-muted" style="font-size: 0.75rem;"><i class="fas fa-clock me-1"></i><?php echo date('M d, h:i A', strtotime($row['created_at'])); ?></div>
                        </div>
                        <div>
                           <a href="career/career" class="btn btn-icon btn-link btn-secondary"><i class="fa fa-eye"></i></a>
                        </div>
                      </div>
                    <?php } 
                    } else { ?>
                      <div class="text-center py-4 text-muted">No recent applications</div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>

            <!-- Subscribe History -->
            <div class="col-md-8">
              <div class="card card-round" data-aos="fade-up" data-aos-offset="50" data-aos-delay="100">
                <div class="card-header">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title fw-bold">Newsletter Activity</div>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                      <thead>
                        <tr>
                          <th scope="col">Subscriber</th>
                          <th scope="col" class="text-end">Subscription Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($sub = mysqli_fetch_assoc($subscribe_result)) { ?>
                          <tr>
                            <td>
                              <div class="fw-bold text-dark"><?php echo htmlspecialchars($sub['email']); ?></div>
                            </td>
                            <td class="text-end text-muted">
                              <?php echo date('M d, Y, h:i A', strtotime($sub['subscribed_at'])); ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div> <!-- End page-inner -->
      </div> <!-- End container -->

      <?php include('components/footer.php'); ?>
    </div> <!-- End main-panel -->
  </div> <!-- End wrapper -->
</body>
<script>
  AOS.init({
    duration: 800,
    once: true,
    easing: 'ease-out-quad'
  });
</script>
</html>

