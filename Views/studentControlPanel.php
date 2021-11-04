<?php
require_once(VIEWS_PATH."checkLoggedStudent.php");
include_once('header.php');
include_once('nav.php');
?>

<main class="py-3">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-3 text-center text-muted">Students</h2>

            <div class="bg-light-alpha p-2 text-center">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-3">
                        <label class="text-muted text-strong" for="">First Name</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getFirstName()?>">
                    </div>

                    <div class="col-lg-3">
                        <label class="text-muted text-strong" for="">Last Name</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getLastName()?>">
                    </div>

                    <div class="col-lg-3">
                        <label class="text-muted text-strong"  for="">DNI</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getDni()?>">
                    </div>

                    <div class="col-lg-3">
                        <label class="text-muted text-strong" for="">Email</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getEmail()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">PhoneNumber</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getPhoneNumber()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">FileNumber</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getFileNumber()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">BirthDate</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getBirthDate()?>">
                    </div>
                </div>
            </div>
    </section>

    <section id="why-us" class="why-us section-bg justify-content-center align-items-center">
        <div class="container-fluid" data-aos="fade-up">

            <div class="row">

                <div class="col-lg-7 d-flex flex-column justify-content-center align-items-stretch">

                    <div class="content">
                        <h3>Don't wait any longer to <strong>find your dream job!</strong></h3>
                        <p>
                            UTN University gives you the best opportunities to launch into the world of work
                        </p>
                    </div>

                    <div class="accordion-list">
                        <ul>
                            <li>
                                <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>"
                                      method="POST">
                                    <button type="submit" name="filename" class="btn buttonPer"><span>01</span><strong>Look at the new Job Offers we have for you!</strong> </button>
                                </form>
                                <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i>
                                <div id="accordion-list-1" class="collapse show" data-bs-parent=".accordion-list">
                                    <p>
                                        You can search for job offers related to your career and apply by entering your curriculum
                                    </p>
                                </div>
                            </li>

                            <li>
                                <form action="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>"
                                      method="POST">
                                    <button type="submit" name="filename" class="btn buttonPer"><span>02</span><strong>Chek out the member companies</strong> </button>
                                </form>
                                <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i>
                               <p> Our member companies offer you the best benefits</p>
                            </li>

                            <li>
                                <form action="<?php echo  FRONT_ROOT."Home/showContactUsView"?>"
                                      method="POST">
                                    <button type="submit" name="filename" class="btn buttonPer"><span>03</span><strong>Do you have any questions? Contact us</strong> </button>
                                </form>
                                <i class="bx bx-chevron-down icon-show"></i><i class="bx bx-chevron-up icon-close"></i>
                                <p> Do not hesitate to ask us your questions, we are here for you</p>
                            </li>

                        </ul>
                    </div>

                </div>
                <div class="col-lg-5 align-items-stretch order-1 order-lg-2 img" style='background-image: url("../Views/img/why-us.png");' data-aos="zoom-in" data-aos-delay="150">&nbsp;</div>
            </div>

        </div>
    </section>

</main>
<br>

<?php
include_once('footer.php');
?>


