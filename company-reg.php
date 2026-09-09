<!DOCTYPE html>
<html lang="en">
    <?php include 'component/head.php'; ?>

<style>
      .note {
      font-size: 12px;
      color: #666;
      margin-top: -5px;
      margin-bottom: 10px;
    }
</style>

<body >
<?php include 'component/navbar.php'; ?>
<section class="body-Rdx">

<section class="main-form main-form-R">
  <div class="container">
    <div class="row">
      <div class="col-md-12" data-aos="fade-down" data-aos-duration="1000">
<div class="container form-wrapper">
  <h2 class="text-center mb-2  text-primary">Company Registration Form</h2>

  <form>

    <!-- Company Information -->
    <h4 class="section-title" data-aos="fade-up" data-aos-duration="1000">Company Information</h4>
    <div class="row g-3" data-aos="fade-up" data-aos-duration="1000">
      <!-- Fields as you provided -->
      <div class="col-md-6"><label>Company Name as per the Licence *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Office Number/Unit Number *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Building Name *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Street Name</label><input type="text" class="form-control"></div>
      <div class="col-md-6"><label>Area Name *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Company City *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Country *</label><input type="text" class="form-control" value="INDIA" readonly></div>
      <div class="col-md-6"><label>Postal Code</label><input type="text" class="form-control"></div>
      <div class="col-md-6"><label>Company Mobile Number *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Company Email Address *</label><input type="email" class="form-control" required></div>
      <div class="col-12"><label>Application Form (COMPLETELY FILLED) *</label><input type="file" class="form-control form-control-f" required>
      <a href="uploads/GGB.pdf" class="btn btn-danger mt-2 mb-2" download="">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Automatically Filled Application Form
                    </a>
        <div class="note">Please ensure all mandatory fields are completed before downloading the 'Filled Application Form'. All uploaded documents must be in English.</div>
      </div>
    </div>
    <hr>

    <!-- Certificate of Incorporation -->
    <h4 class="section-title" data-aos="fade-up" data-aos-duration="1000">Certificate of Rera</h4>
    <div class="row g-3" data-aos="fade-up" data-aos-duration="1000">
      <div class="col-md-6"><label>Issuing Authority *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Certificate of Rera Number *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Certificate Upload *</label><input type="file" class="form-control form-control-f" required></div>
   </div>

    <hr>

    <!-- Owner Information -->
    <h4 class="section-title mt-4" data-aos="fade-up" data-aos-duration="1000">Owner Information - 1</h4>
    <div class="row g-3" data-aos="fade-up" data-aos-duration="1000">
      <div class="col-md-6"><label>Owner’s Full Name  *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Owner’s Nationality *</label><select class="form-select" required><option>Select</option><option>Indian</option><option>Other</option></select></div>
    <div class="col-md-6"><label>Owner's Aadhar Number</label><input type="text" class="form-control"></div>
      <div class="col-md-3"><label>Date of Birth</label><input type="date" class="form-control"></div>
      <div class="col-12"><label>Owner's Aadhar Copy (Front and Back)</label><input type="file" class="form-control form-control-f"></div>
    </div>

    <hr>

    <!-- ////////////////////////// -->
    <button class="bhyu"   type="button" id="show-owner2" data-aos="fade-up" data-aos-duration="1000">Owner Information - 2</button>
    <div class="owner-form" id="owner2-form">
    <h4 class="section-title">Owner Information - 2</h4>
    <div  class="row g-3 " >
      <div class="col-md-6"><label>Owner’s Full Name  *</label><input type="text" class="form-control" required></div>
     <div class="col-md-6"><label>Owner’s Nationality *</label><select class="form-select" required><option>Select</option><option>Indian</option><option>Other</option></select></div>
    <div class="col-md-6"><label>Owner's Aadhar Number</label><input type="text" class="form-control"></div>
      <div class="col-md-3"><label>Date of Birth</label><input type="date" class="form-control"></div>
     <div class="col-12"><label>Owner's Aadhar Copy (Front and Back)</label><input type="file" class="form-control form-control-f"></div>
    </div>
</div>
    <hr>

    <!-- /////////////////////////////// -->
    <button class="bhyu"  type="button" id="show-owner3" data-aos="fade-up" data-aos-duration="1000">Owner Information - 3</button>
    <div class="owner-form" id="owner3-form">
    <h4 class="section-title">Owner Information - 3</h4>
    <div class="row g-3 " >
      <div class="col-md-6"><label>Owner’s Full Name *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Owner’s Nationality *</label><select class="form-select" required><option>Select</option><option>Indian</option><option>Other</option></select></div>
      <div class="col-md-6"><label>Owner's Aadhar Number</label><input type="text" class="form-control"></div>
      <div class="col-md-3"><label>Date of Birth</label><input type="date" class="form-control"></div>
      <div class="col-12"><label>Owner's Aadhar Copy (Front and Back)</label><input type="file" class="form-control form-control-f"></div>
    </div>
</div>
    <hr>

    <!-- Staff Member Information -->
    <h4 class="section-title" data-aos="fade-up" data-aos-duration="1000">Staff Member Information</h4>
    <div class="row g-3" data-aos="fade-up" data-aos-duration="1000">
      <div class="col-md-6"><label>Office Admin Full Name</label><input type="text" class="form-control"></div>
      <div class="col-md-6"><label>Office Admin Nationality</label><select class="form-select"><option>Select</option><option>India</option></select></div>
      <div class="col-md-6"><label>Office Admin Email Address</label><input type="email" class="form-control"></div>
      <div class="col-md-6"><label>Office Admin Phone Number</label><input type="text" class="form-control"></div>
      <div class="col-md-6"><label>Is Owner and Manager Same?</label><select class="form-select" onchange="toggleManagerFields(this.value)"><option>Select</option><option value="Yes">Yes</option><option value="No">No</option></select></div>
      <div id="managerFields" class="row g-3" style="padding: 10px 20px;">
    <div class="col-md-6">
      <label>Office Manager Full Name</label>
      <input type="text" class="form-control">
    </div>
    <div class="col-md-6">
      <label>Office Manager Nationality</label>
      <select class="form-select">
        <option>Select</option>
        <option>India</option>
      </select>
    </div>
    <div class="col-md-6">
      <label>Office Manager Email Address</label>
      <input type="email" class="form-control">
    </div>
    <div class="col-md-6">
      <label>Office Manager Phone Number</label>
      <input type="text" class="form-control">
    </div>
  </div>
    </div>
    <hr>

    <!-- POA Information -->
  <h4 class="section-title mt-4" data-aos="fade-up" data-aos-duration="1000">Company related documents</h4>
  <div class="mb-3" data-aos="fade-up" data-aos-duration="1000">
      <div class="col-md-6"><label>Memorandum of Association *</label><input type="file" class="form-control form-control-f" required></div>
      <div class="col-md-6"><label>Article of Association  *</label><input type="file" class="form-control form-control-f" required></div>
       <div class="col-md-6"><label>Incorporation Certificate  *</label><input type="file" class="form-control form-control-f" required></div>
        <div class="col-md-6"><label>GST Certificate *</label><input type="file" class="form-control form-control-f" required></div>
         <div class="col-md-6 mb-4"><label>Board Resolution *</label><input type="file" class="form-control form-control-f" required></div>
   </div>
    <hr>

    <!-- Company Bank Information -->
    <h4 class="section-title" data-aos="fade-up" data-aos-duration="1000">Company Bank Information</h4>
    <div class="note mb-2" data-aos="fade-up" data-aos-duration="1000">*Important Note*: No commission will be released to a third party or personal bank account. Commission release requires a company to provide a company bank account as per the  License.</div>
    <div class="row g-3" data-aos="fade-up" data-aos-duration="1000">
      <div class="col-md-6"><label>Bank Account Status *</label><select class="form-select" required disabled>
         <option >Current</option>
    </select></div>
      <div class="col-md-6"><label>Beneficiary Name *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Account Number *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>IFSC/ Country Bank Code *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Confirm IFSC/ Bank Code *</label><input type="text" class="form-control" required></div>
      <div class="col-md-6"><label>Bank Name *</label><input type="text" class="form-control" required></div>
     <div class="col-md-6"><label>Bank Branch *</label><input type="text" class="form-control" required></div>
    <div class="col-md-6"><label>Currency of Account *</label><select class="form-select" required><option>Select Currency</option><option>INR-Indian Rupee</option></select></div>
      </div>
    <hr>

    <!-- Upload Documents -->
    <h4 class="section-title mt-4" data-aos="fade-up" data-aos-duration="1000">Upload Required Documents</h4>
    <div class="mb-3" data-aos="fade-up" data-aos-duration="1000"><label>Other Related Documents</label><input type="file" class="form-control form-control-f"></div>
    <div class="mb-3" data-aos="fade-up" data-aos-duration="1000"><label>Add Indemnity Letter printed on company letter head with signature and stamp(*)</label><input type="file" class="form-control form-control-f" required>
       <a href="uploads/GGB.pdf" class="btn btn-danger mt-2" download="">
                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Download Automatically Filled Application Form
                    </a>
  </div>

  <div class="text-end my-4" data-aos="fade-up" data-aos-duration="1000">
        <button type="submit" id="submit-btn" class="btn btn-primary px-5">Submit Form</button>
      </div>
  </form>
</div>
  </div>
    </div>
  </div>
</section>
</section>
<?php include 'component/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#show-owner2').click(function() {
      $('#owner2-form').slideToggle();
    });

    $('#show-owner3').click(function() {
      $('#owner3-form').slideToggle();
    });
  });
</script>



<script>
  $(document).ready(function() {
    $('#submit-btn').click(function() {
      Swal.fire({
        icon: 'success',
        title: 'Submitted Successfully!',
        text: 'Your form has been submitted.',
        confirmButtonColor: '#007BFF'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'agent-registration.php';
        }
      });
    });
  });
</script>



<script>
  function toggleManagerFields(value) {
    const managerDiv = document.getElementById("managerFields");
    if (value === "Yes") {
      managerDiv.style.display = "none";
    } else {
      managerDiv.style.display = "flex";
    }
  }
</script>



  <script>
    const poaSelect = document.getElementById('poaSelect');
    const poaForm = document.getElementById('poaForm');

    poaSelect.addEventListener('change', () => {
      if (poaSelect.value === 'yes') {
        poaForm.style.display = 'block';
      } else {
        poaForm.style.display = 'none';
      }
    });
  </script>

</body>
</html>
