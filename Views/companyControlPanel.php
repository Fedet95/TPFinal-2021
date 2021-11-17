<?php
use Models\SessionHelper;
SessionHelper::checkCompanySession();
include_once('header.php');
include_once('nav.php');
?>

<main class="py-3">
    <section id="listado" class="mb-5">
        <div class="container">

            <h1 class="mb-3 text-center text-muted">Welcome!</h1>
            <br>
            <strong class="offset-lg-4"><?php if (isset($message)) {
                    echo $message;
                } ?></strong>
            <div class="bg-light-alpha p-2 text-center">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-3">

                        <label class="text-muted text-strong" for="">Company Name</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getName()?>">
                    </div>

                    <div class="col-lg-3">
                        <label class="text-muted text-strong" for="">Cuit</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getCuit()?>">
                    </div>

                    <div class="col-lg-3">
                        <label class="text-muted text-strong"  for="">Company Web URL</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getCompanyLink()?>">
                    </div>

                    <div class="col-lg-3">
                        <label class="text-muted text-strong" for="">Email</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getEmail()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">Location Country</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getCountry()->getName()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">Location City</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getCity()->getName()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">Industry Area</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getIndustry()->getType()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">Condition</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $company->getActive()?>">
                    </div>
                    <div class="col-lg-4">
                        <br>
                        <label class="text-muted text-strong" for="">Logo</label>
                        <img><?php echo '<img src="../uploads/' . $company->getLogo()->getFile() . '" height="150" width="180"/>'; ?>
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


    <!-- Start callto-action Area -->
    <section class="callto-action-area section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10">Our selection of offers is updated every day!</h1>
                        <p>We offer you a wide variety of job offers from the best companies</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End calto-action Area -->

    <br><br>
    <iframe  class="offset-lg-3" width="900" height="500" src="https://www.youtube.com/embed/pJo_fojED70" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

</main>
<br>

<?php
include_once('footer.php');
?>


