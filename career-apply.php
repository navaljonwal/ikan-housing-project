<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<?php include 'component/head.php'; ?>

<body>


    <!--/ Nav Star /-->
    <?php include 'component/navbar.php'; ?>
    <!--/ Nav End /-->


    <section class="section_padding bg_gray2 help_us_section" style="  background-color: cornsilk; margin-top:20px;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-3 photoframe_wrap1 pic-wrap-pk">
                    <div class="photoframe photoframe_1 new-frame">
                        <img src="img/bday1.jpeg" alt="error in loading image">
                        <div class="icon"><img src="img/icon/chat2.webp" alt="error in loading image"></div>
                    </div>
                    <div class="photoframe photoframe_2 new-frame">
                        <img src="img/2-bhai.jpg" alt="error in loading image">
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php


                    if (isset($_SESSION['error'])) {
                        echo "<div class='alert alert-danger' id='alert'>" . $_SESSION['error'] . "</div>";
                        unset($_SESSION['error']);
                    }

                    if (isset($_SESSION['success'])) {
                        echo "<div class='alert alert-success' id='alert'>" . $_SESSION['success'] . "</div>";
                        unset($_SESSION['success']);
                    }
                    ?>
                    <div class="main-title-5">
                        <div class="career-page-1 career-page-rdx">
                            <h1>Help Us Build the Future of Real Estate</h1>
                            <div class="title-border">
                                <div class="title-border-inner"></div>
                                <div class="title-border-inner"></div>
                                <div class="title-border-inner"></div>
                            </div>
                            <p>Join the <strong>Ikan Housing</strong> team, where passion meets purpose. Join a dynamic,
                                growth-driven culture that values innovation, collaboration, and personal development
                                while crafting dream homes for our customers.</p>

                        </div>
                       </div>
                    </div>
                 <div class="col-lg-3 photoframe_wrap2 pic-wrap-pk">
                    <div class="photoframe photoframe_3 new-frame">
                        <img src="img/at-2.jpg" alt="error in loading image">
                        <div class="icon"><img src="img/icon/video-camera.webp" alt="error in loading image"></div>
                    </div>
                    <div class="photoframe photoframe_4 new-frame">
                        <img src="img/all-team-2.jpg" alt="error in loading image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--/ Career Section Start /-->

    <div class="col-md-10 mx-auto" id="myDIVv">
        <div class="col-sm-12 contact-box">

            <div class="modall" id="applicationModa">
                <div class="modal-contentt modal-content-rdx">
                    <div class="modal-header bg-danger border-0">
                        <h5 class="modal-title text-white">Application Form</h5>
                        <button type="button" class="btn btn-link text-white" id="closeModal"><i
                                class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form action="api/resume.php" method="post" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control" placeholder="Enter Your Name" type="text" name="name"
                                    id="name">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" placeholder="Enter Email" type="text" name="email"
                                    id="email">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Mobile</label>
                                <input class="form-control" placeholder="Enter Your Mobile No." type="number"
                                    name="mobile" id="mobile">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="age">Age</label>
                                <input class="form-control" id="age" placeholder="Enter Your Age" type="number"
                                    name="age" id="age">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="position">Position</label>
                                <select class="form-controld" id="position" name="position">
                                    <option>Select Your Possition </option>
                                    <option value="Sales Manager"> Sales Manager</option>
                                    <option value=" Marketing Manager"> Marketing Manager</option>
                                    <option value="HR Manager"> HR Manager</option>
                                    <option value="Telecaller">Telecaller</option>

                                </select>
                            </div>


                            <div class="mb-3">
                                <label class="form-label" for="experience">Experience</label>
                                <input class="form-control" id="experience" placeholder="Enter Your Experience"
                                    type="number" name="experience" id="experience">
                            </div>

                            <div class="mb-3">
                                <label class="form-label" for="file">Resume</label>
                                <input class="form-control" type="file" name="resume" id="file"
                                    accept=".pdf,.doc,.docx">
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-danger rounded-pill">Submit</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <!--/ Career Section End /-->

    <!--/ footer Star /-->
    <?php include 'component/footer.php'; ?>


    <script>
        window.onload = function () {
            // Hide the alert after 10 seconds
            var alertElement = document.getElementById('alert');
            if (alertElement) {
                setTimeout(function () {
                    alertElement.style.opacity = '0'; // Start fading out
                    setTimeout(function () {
                        alertElement.style.display = 'none'; // Hide after fade-out
                    }, 500); // Delay to allow the fade-out transition to complete
                }, 10000); // 10000 milliseconds = 10 seconds
            }
        };
    </script>

</body>

</html>