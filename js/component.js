///////////////////
function NewTab() {
  window.open(
    "property-detail-for.php", "_blank");
}

///////////////////////////////////////

///////////////////////////////////////
function NewTabb() {
  window.open(
    "sky-star.php", "_blank");
}

///////////////////////////////////////


///////////////////////////////////////
function NewTabb1() {
  window.open(
    "rasik.php", "_blank");
}

///////////////////////////////////////

///////////////////////////////////////
function NewTabb2() {
  window.open(
    "arihant.php", "_blank");
}

///////////////////////////////////////



///////////////////////////////////////
//load jquery first
$(document).ready(function () {
  // create showDescription function
  function showDescription() {
    //this will be done on event
    $(this).find('span').slideToggle();
  }
  //mouse event
  $('.gallery').on('mouseenter mouseleave', 'img', showDescription);
});



//////////////////////////////////////////////////////////
function validateForm() {
  const name = document.getElementById('name').value.trim();
  const email = document.getElementById('email').value.trim();
  const mobile = document.getElementById('mobile').value.trim();
  const age = document.getElementById('age').value.trim();
  const experience = document.getElementById('experience').value.trim();
  const file = document.getElementById('file').value;

  // Name validation (required, min 3 characters)
  if (name === '' || name.length < 3) {
    alert('Please enter a valid name (at least 3 characters).');
    return false;
  }

  // Email validation (basic pattern check)
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailPattern.test(email)) {
    alert('Please enter a valid email address.');
    return false;
  }

  // Mobile validation (10-digit numeric)
  const mobilePattern = /^[0-9]{10}$/;
  if (!mobilePattern.test(mobile)) {
    alert('Please enter a valid 10-digit mobile number.');
    return false;
  }

  // Age validation (numeric, 18-100 range)
  const ageNum = parseInt(age, 10);
  if (isNaN(ageNum) || ageNum < 18 || ageNum > 100) {
    alert('Please enter a valid age between 18 and 100.');
    return false;
  }

  // Experience validation (required, numeric, non-negative)
  const expNum = parseInt(experience, 10);
  if (isNaN(expNum) || expNum < 0) {
    alert('Please enter a valid experience (non-negative number).');
    return false;
  }

  // Resume file validation (required, only .pdf, .doc, .docx)
  const allowedExtensions = /\.(pdf|doc|docx)$/i;
  if (!file || !allowedExtensions.test(file)) {
    alert('Please upload a valid resume in PDF, DOC, or DOCX format.');
    return false;
  }

  return true; // Submit the form if all validations pass
}
