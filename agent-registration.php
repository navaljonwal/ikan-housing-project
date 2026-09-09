<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);
include('config.php'); // Make sure it defines $con

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_type = $_POST['form_type'] ?? '';

    if ($form_type == 'individual') {
        $first_name = mysqli_real_escape_string($con, $_POST['first_name'] ?? '');
        $last_name = mysqli_real_escape_string($con, $_POST['last_name'] ?? '');
        $name = $first_name . ' ' . $last_name;
        $email = mysqli_real_escape_string($con, $_POST['email'] ?? '');
        $mobile_code = mysqli_real_escape_string($con, $_POST['mobile_code'] ?? '');
        $mobile = mysqli_real_escape_string($con, $_POST['mobile'] ?? '');
        $country = mysqli_real_escape_string($con, $_POST['country'] ?? '');
        $nationality = mysqli_real_escape_string($con, $_POST['nationality'] ?? '');

        // You can hash a dummy password or skip it if not used
        $password = ''; // Set blank if not collected

        if ($name && $email && $mobile && $country && $nationality) {
            $query = "INSERT INTO agent_registration (form_type, name, email, mobile_code, mobile, country, nationality, password)
                      VALUES ('individual', '$name', '$email', '$mobile_code', '$mobile', '$country', '$nationality', '$password')";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo "<script>window.location.href='agentt';</script>";
                exit();
            } else {
                echo "<script>alert('Error saving individual data.'); window.location.href='agent-registration.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('All required fields for individual must be filled.'); window.location.href='agent-registration.php';</script>";
            exit();
        }
    }

    elseif ($form_type == 'company') {
        $company_name = mysqli_real_escape_string($con, $_POST['company_name'] ?? '');
        $contact_person = mysqli_real_escape_string($con, $_POST['agency_type'] ?? '');
        $email = mysqli_real_escape_string($con, $_POST['company_email'] ?? '');
        $mobile_code = mysqli_real_escape_string($con, $_POST['company_mobile_code'] ?? '');
        $mobile = mysqli_real_escape_string($con, $_POST['company_mobile'] ?? '');
        $country = mysqli_real_escape_string($con, $_POST['company_country'] ?? '');

        if ($company_name && $contact_person && $email && $mobile && $country) {
            $query = "INSERT INTO agent_registration (form_type, company_name, contact_person, email, mobile_code, mobile, country)
                      VALUES ('company', '$company_name', '$contact_person', '$email', '$mobile_code', '$mobile', '$country')";
            $result = mysqli_query($con, $query);

            if ($result) {
                echo "<script> window.location.href='company-reg';</script>";
                exit();
            } else {
                echo "<script>alert('Error saving company data.'); window.location.href='agent-registration.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('All required fields for company must be filled.'); window.location.href='agent-registration.php';</script>";
            exit();
        }
    }

    else {
        echo "<script>alert('Invalid form type submitted.'); window.location.href='agent-registration.php';</script>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

  <?php include 'component/head.php'; ?>

<body class="body-Rdxx">
<?php include 'component/navbar.php'; ?>

<!-- Hero Banner -->
<h1 class="h1h" data-aos="fade-down" data-aos-duration="1000">Agent Registration</h1>  

<!-- Image -->
<section class="banners" data-aos="fade-up" data-aos-duration="1000">
  <img style="width: 90%; max-width: 100%;" src="rkimg/ass.jpg" alt="error in loading image">
</section>

<!-- Content -->
<div class="container container-y my-2">
  <section class="banner">
    <h1 data-aos="fade-down" data-aos-duration="1000">Become Our Exclusive Partner</h1>
  </section>

  <h4 class="rdx-h-h" data-aos="fade-right" data-aos-duration="1000">India Brokers & Associates</h4>
  <ul class="ul-rdx" data-aos="fade-right" data-aos-duration="1000">
    <li>Application Form (with complete office address, signed by the Owner with company stamp)</li>
    <li>Commercial License/ Certificate of Incorporation translated into English (Authenticated /Attested /Issued by the Local Government)</li>
    <li>Memorandum of Association or Articles of Incorporation</li>
    <li>Clear / Properly Scanned Passport copy with signature page, National ID (Front and Back side) of the Owner/s, Partner/s, Shareholder/s, and authorized Signatory</li>
    <li>Complete company bank account details in English printed on company letterhead, signed by an authorized signatory with a company stamp</li>
    <li>Indemnity Letter printed on company letterhead, signed by the Owner with company stamp</li>
  </ul>

  <h4 class="rdx-h-h" data-aos="fade-right" data-aos-duration="1000">Referral Agent</h4>
  <ul class="ul-rdx" data-aos="fade-right" data-aos-duration="1000">
    <li>Application Form</li>
    <li>Clear / Properly Scanned Passport copy and signature page.</li>
    <li>Complete Bank Account Details</li>
    <li>Signed Indemnity Letter</li>
  </ul>

  <div class="container my-5 text-center" data-aos="fade-right" data-aos-duration="1000">
    <button class="btn btn-primary px-4" onclick="showRegistration()">Register</button>
  </div>
</div>

<!-- Registration Section -->
<div class="container container-rdP" id="registrationSection" style="display: none;">
  <div class="text-center">
    <h3 class="mb-4">Agent Registration</h3>
    <div class="mb-3">
      <select class="form-select w-50 mx-auto" id="formSelect" onchange="toggleForms()" required>
        <option selected disabled>Select Registration Type</option>
        <option value="individual">Individual / Personal Registration</option>
        <option value="company">Company Registration</option>
      </select>
    </div>
  </div>

  <!-- Individual Registration Form -->

<!-- HTML Part -->
<form id="individualForm" class="form-section" action="agent-registration.php" method="POST">
  <input type="hidden" name="form_type" value="individual">
  <h5>Individual Registration Form</h5>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">First Name (*)</label>
      <input type="text" class="form-control" name="first_name" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Last Name (*)</label>
      <input type="text" class="form-control" name="last_name" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Country (*)</label>
      <select class="form-select" name="country" required>
        <option selected disabled>Select</option>
        <option value="India">India</option>
      </select>
    </div>
    <div class="col-md-6">
      <label class="form-label">Nationality (*)</label>
      <select class="form-select" name="nationality" required>
        <option selected disabled>Select</option>
        <option value="Indian">Indian</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Mobile Country Code (*)</label>
      <select class="form-select" name="mobile_code" required>
        <option selected disabled>Select</option>
        <option value="+91">+91</option>
      </select>
    </div>
    <div class="col-md-9">
      <label class="form-label">Mobile Number (*)</label>
      <input type="tel" name="mobile" class="form-control" required>
    </div>
    <div class="col-12">
      <label class="form-label">User Email ID (*)</label>
      <input type="email" name="email" class="form-control" required>
    </div>
  </div>
  <div class="text-end mt-3">
    <button type="submit" class="btn btn-success">Submit Individual Form</button>
  </div>
</form>


  <!-- Company Registration Form -->
  <form id="companyForm" style="display: none;" class="form-section" action="agent-registration.php" method="POST">
  <input type="hidden" name="form_type" value="company">
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Company Name As per Trade License (*)</label>
      <input type="text" name="company_name" class="form-control" placeholder="Enter Company Name" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Country (*)</label>
      <select class="form-select" name="company_country" required>
        <option selected disabled>Select</option>
        <option value="India">India</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Mobile Country Code (*)</label>
      <select class="form-select" name="company_mobile_code" required>
        <option selected disabled>Select</option>
        <option value="+91">+91</option>
      </select>
    </div>
    <div class="col-md-9">
      <label class="form-label">Mobile Number (*)</label>
      <input type="tel" name="company_mobile" class="form-control" required>
    </div>
    <div class="col-12">
      <label class="form-label">User Email ID (*)</label>
      <input type="email" name="company_email" class="form-control" required>
    </div>
    <div class="col-12 note">
      Important Note: The email ID entered in this field will be used in creating a User Name and Password for accessing the portal.
    </div>
  </div>
  <div class="text-end mt-3">
    <button type="submit" class="btn btn-success">Submit Company Form</button>
  </div>
</form>

</div>

<?php include 'component/footer.php'; ?>  

<script>
  function showRegistration() {
    document.getElementById('registrationSection').style.display = 'block';
    window.scrollTo({ top: document.getElementById('registrationSection').offsetTop, behavior: 'smooth' });
  }

    function toggleForms() {
    const selected = document.getElementById('formSelect').value;
    document.getElementById('individualForm').style.display = selected === 'individual' ? 'block' : 'none';
    document.getElementById('companyForm').style.display = selected === 'company' ? 'block' : 'none';
  }

  function validateForm(form) {
    if (!form.checkValidity()) {
      form.reportValidity();
      return false;
    }
    return false; // Prevent actual submission for demo purposes
  }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
