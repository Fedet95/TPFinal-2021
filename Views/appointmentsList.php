<?php

use Models\SessionHelper;
SessionHelper::checkUserSession();
use Models\User;

//require_once(VIEWS_PATH . "checkLoggedUser.php");
include_once('header.php');
include_once('nav.php');;


?>

    <link rel="stylesheet" href="../Views/css/main.css">
    <link rel="stylesheet" href="../Views/css/linearicons.css">



<?php if($loggedUser->getRol()->getUserRolId()==2){?>


    <!-- Start callto-action Area -->
    <section class="callto-action-area section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-white">Active Appointment</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End calto-action Area -->

    <br><br>
    <h6 class="py-3  text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>
    <?php
    if (is_object($historyAppointments)) {
        $history = $historyAppointments;
        $historyAppointments = array();
        array_push($historyAppointments, $history);
    }
    ?>
    <!-- Start actual appointment-->



    <?php if(isset($actualAppointment) && $actualAppointment!=null){?>

        <section class="post-area section-gap">
            <div class="container">
                <div class="row justify-content-center d-flex ">
                    <div class="col-lg-9 post-list bg-light-alpha p-5 border">
                        <div class="single-post d-flex flex-row">
                            <div class="details">
                                <div class="offset-1 title d-flex flex justify-content-between">
                                    <div class="titles">
                                        <a href="single.html"><h4><img src="../Views/img/radio%20-%20copia.png"
                                                                       alt=""> <?php echo $actualAppointment->getJobOffer()->getTitle() ?></h4></a>
                                        <!--TITLE-->
                                        <h5><img src="../Views/img/radio%20-%20copia.png"
                                                 alt=""> <?php echo $actualAppointment->getJobOffer()->getCompany()->getName() ?></h5>
                                    </div>
                                </div>
                                <br>
                                <div class="row offset-1">
                                    <p class="address"><span class="lnr lnr-database"></span>
                                        Application Date: <?php echo $actualAppointment->getDate() ?>  </p>
                                    <p class="address"><span class="lnr lnr-database"></span>
                                        Career:  <?php echo $searchCareer->getDescription() ?> </p>

                                    <p class="address"><span class="lnr lnr-database"></span>
                                        Job Nature: <?php echo $actualAppointment->getJobOffer()->getDedication()?> </p>

                                    <!--DEDICATION-->
                                    <p class="address"><span class="lnr lnr-database"></span>
                                        Work Type: <?php echo $actualAppointment->getJobOffer()->getRemote() ?>  </p>

                                    <!--CITY-->
                                    <p class="address"><span class="lnr lnr-database"></span>
                                        Publish Date: <?php echo $actualAppointment->getJobOffer()->getPublishDate() ?>  </p>
                                    <!--PUBLISHDATE-->
                                    <p class="address"><span class="lnr lnr-database"></span>
                                        End Date:  <?php echo $actualAppointment->getJobOffer()->getEndDate() ?>  </p>
                                    <!--END DATE-->

                                    <p class="address"><span class="lnr lnr-database"></span>
                                        Company Email: <?php echo $actualAppointment->getJobOffer()->getCompany()->getEmail() ?>  </p>

                                    <p class="address"><span class="lnr lnr-database"></span>

                                        Company web:  <a href="#" target="_blank" rel="noopener noreferrer"><?php echo $actualAppointment->getJobOffer()->getCompany()->getCompanyLink() ?></a> </p>


                                </div>
                            </div>
                            <div class="row offset-3">
                                <ul class="btns">
                                    <td>
                                        <?php if(strtotime($actualAppointment->getJobOffer()->getEndDate()) > strtotime(date("Y-m-d")))?>
                                        <form action="<?php echo FRONT_ROOT . "Appointment/Remove" ?>"
                                              method="POST">
                                            <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                    value="<?php echo $loggedUser->getUserId() ?>"><strong>Drop out Appointment</strong>
                                            </button>
                                        </form>
                                        <br>
                                    </td>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
        </section>


    <?php }else { ?>
        <div class="title text-center my-5">
            <h4 class="mb-3">You do not have any active application, look at the job offers!</h4>
        </div>

        <div class="title text-center my-5">
        <form  action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>"
              method="POST">
            <button type="submit" name="id" class="btn buttonPer "
                    value=""><strong>Search Job Offers Now! </strong>
            </button>
        </form>
        </div>

        <section id="hero" class=" align-items-center justify-content-center">
            <div class="container">
                <div class="row justify-content-center align-items-center">

                    <div class=" d-flex justify-content-center " data-aos="fade-up" data-aos-delay="200">
                    </div>
                    <div class=" hero-img" data-aos="zoom-in" data-aos-delay="200">
                        <img src="../Views/img/admini.png" width="450" height="350" class="img-fluid animated" alt="">

                    </div>
                </div>
            </div>
        </section><!-- End Hero -->


    <?php } ?>



    <!-- Start callto-action Area -->
    <section class="callto-action-area section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-white">Appointment History</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End calto-action Area -->



    <?php if(isset($historyAppointments) && $historyAppointments!=null){?>


        <!--Start appointment history area-->

        <section class="post-area section-gap">
            <div class="container">
                <div class="row justify-content-center d-flex">
                    <div class="col-lg-4 post-list bg-light-alpha p-5 border">
                        <?php foreach ($historyAppointments as $value) { ?>
                            <div class="single-post d-flex flex-row">
                                <div class="details">
                                    <div class="title d-flex flex-row justify-content-between">
                                        <div class="titles">

                                            <h4><img src="../Views/img/radio%20-%20copia.png"
                                                     alt=""> <?php echo $value->getJobOffer()->getTitle() ?></h4>
                                            <h5><img src="../Views/img/radio%20-%20copia.png"
                                                     alt=""> <?php echo $value->getCompany()->getName() ?></h5>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <p class="address"><span class="lnr lnr-database"></span>
                                            Career: <I> <?php echo $value->getCareer()->getDescription() ?></I>
                                        <p class="address"><span class="lnr lnr-database"></span>
                                            Application Date: <?php echo $value->getAppointmentDate() ?>  </p>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </div>
                </div>
            </div>
        </section>
        <!--End appointment history area -->
    <?php }else { ?>
        <div class="title text-center my-5">
            <h4 class="mb-3">You do not have any appoitment history</h4>
            <br><br><br><br><br><br><br>
            <br><br><br><br><br><br><br>
        </div>


    <?php } } else if($loggedUser->getRol()->getUserRolId()==1){?>


    <!-- Start callto-action Area -->
    <section class="callto-action-area section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-white">Current Appointments</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End calto-action Area -->

    <section id="hero" class=" align-items-center justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class=" d-flex justify-content-center " data-aos="fade-up" data-aos-delay="200">
                </div>
                <div class=" hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="../Views/img/admini.png" width="400" height="300" class="img-fluid animated" alt="">

                </div>
            </div>
        </div>
    </section><!-- End Hero -->

    <?php if(isset($allAppointments) && $allAppointments!=null){  $offerId=$allAppointments[0]->getJobOffer()->getJobOfferId()?>


    <main class="py-5">
        <section id="listado" class="mb-3">
            <div class="container">
                <h3 class="mb-4 text-center text-muted">Job Offer: <?php echo $searchedJobOffer->getTitle()?></h3>


                <div class="bg-light-alpha p-3 border">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 text-center justify-content-center">
                            <label class="text-muted text-strong" for="">Company</label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo  $searchedJobOffer->getCompany()->getName()?>">
                        </div>

                        <div class="col-lg-4 text-center">
                            <label class="text-muted text-strong" for="">Email</label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo   $searchedJobOffer->getCompany()->getEmail()?>">
                        </div>

                        <div class="col-lg-4 text-center">
                            <label class="text-muted text-strong"  for="">Website</label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo  $searchedJobOffer->getCompany()->getCompanyLink()?>">
                        </div>
                        <div class="col-lg-4 text-center">
                            <br>
                            <label class="text-muted text-strong"  for="">Publish Date</label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo  $searchedJobOffer->getPublishDate()?>">
                        </div>

                        <div class="col-lg-4 text-center">
                            <br>
                            <label class="text-muted text-strong"  for="">End Date</label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo  $searchedJobOffer->getEndDate()?>">
                        </div>

                        <div class="col-lg-4 text-center">
                            <br>
                            <label class="text-muted text-strong"  for="">Career</label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $searchedJobOffer->getCareer()->getDescription()?>">
                        </div>
                        <div class="col-lg-4 text-center">
                            <br>
                            <label class="text-muted text-strong"  for="">Number of Appoiments </label>
                            <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo count($allAppointments)?>">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Start actual appointment-->


            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferViewMore" ?>"
                  method="POST">
                <button type="submit" name="id" class="btn buttonPer m-lg-auto d-block"
                        value="<?php echo $offerId ?>"><strong>Go to Job Offer info</strong>
                </button>
                <br>
            </form>

        <form action=" <?php echo  FRONT_ROOT."Appointment/showAppointmentManagementView"?>"
              method="POST">
            <button type="submit" name="id" class="btn buttonPer m-lg-auto d-block"><strong>Go to Appointment Management View</strong>
            </button>
            <br>
        </form>

        <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentList" ?>"
              method="POST">
            <input type="hidden" name="back" value="1">
            <button type="submit" name="id" class="btn buttonPer m-lg-auto d-block"
                    value="<?php echo $offerId ?>"><strong>Generate PDF</strong>
            </button>
            <br>
        </form>



<?php
        foreach ($allAppointments as $actualAppointment){
        ?>

            <section class="post-area ">
                <div class="container">
                    <div class="row justify-content-center d-flex ">
                        <div class="col-lg-7 post-list bg-light-alpha p-5 border">
                            <div class="single-post d-flex flex-row">
                                <div class="details">
                                    <div class="offset-1 title d-flex flex justify-content-between">
                                        <div class="titles">
                                            <a href="single.html"><h4><img src="../Views/img/radio%20-%20copia.png"
                                                                           alt=""> <?php echo $actualAppointment->getStudent()->getLastName() . " ".$actualAppointment->getStudent()->getFirstName()  ?></h4></a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row offset-1">

                                        <p class="address"><span class="lnr lnr-database"></span>
                                           DNI Number:  <?php echo $actualAppointment->getStudent()->getDni() ?>  </p>

                                        <p class="address"><span class="lnr lnr-database"></span>
                                           Phone Number: <?php echo $actualAppointment->getStudent()->getPhoneNumber() ?>  </p>

                                        <p class="address"><span class="lnr lnr-database"></span>
                                            Email:  <?php echo $actualAppointment->getStudent()->getEmail() ?> </p>

                                        <p class="address"><span class="lnr lnr-database"></span>
                                            Application Date: <?php echo $actualAppointment->getDate() ?>  </p>


                                    </div>
                                </div>
                                <div class="row offset-3">
                                    <ul class="btns">
                                        <td>
                                            <form target="_blank" action="<?php echo FRONT_ROOT . "Appointment/viewCv" ?>"
                                                  method="POST">
                                                <button type="submit" name="filename" class="btn buttonPer ml-auto d-block"
                                                value="<?php echo $actualAppointment->getStudent()->getDni() ?>" ><strong>View CV</strong>

                                                </button>
                                            </form>
                                            <br>
                                        </td>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
            </section>


    <?php }}else { ?>
    <div class="title text-center my-5">
        <h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>
    </div>

    <?php } }?>


<br><br><br>
    <?php include_once("footer.php") ?>