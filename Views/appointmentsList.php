<?php

use Models\Administrator;
use Models\Student;

require_once(VIEWS_PATH . "checkLoggedUser.php");
include_once('header.php');
include_once('nav.php');
?>



    <link rel="stylesheet" href="../Views/css/main.css">
    <link rel="stylesheet" href="../Views/css/linearicons.css">



    <section class="download-area section-gap" id="app">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 download-left">
                    <img class="img-fluid" src="../Views/img/appoint.png" alt="">
                </div>
                <br><br>
                <div class="col-lg-6 download-right">
                    <h1>Find your<br>
                        Dream Job Today!</h1>
                    <p class="subs">
                        We offer you a wide variety of job offers from the best companies so that you can find your
                        dream job. Do not wait any longer and expand your work horizons.
                    </p>
                </div>
            </div>
        </div>
    </section>

<?php if($loggedUser instanceof Student){?>

    <h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>

    <div class="title text-center my-5">
        <h1 class="mb-3">Active Appointment</h1>
    </div>

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
                                        Company web: <?php echo $actualAppointment->getJobOffer()->getCompany()->getCompanyLink() ?>  </p>


                                </div>
                            </div>
                            <div class="row offset-3">
                                <ul class="btns">
                                    <td>
                                        <form action="<?php echo FRONT_ROOT . "Appointment/Remove" ?>"
                                              method="POST">
                                            <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                    value="<?php echo $loggedUser->getStudentId() ?>"><strong>Drop out Appointment</strong>
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
    <?php } ?>

    <?php if(isset($historyAppointments) && $historyAppointments!=null){?>

        <div class="title text-center">
            <h1 class="mb-3">Appointment History</h1>
        </div>

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
        </div>


    <?php } } else if($loggedUser instanceof  Administrator){?>


    <div class="title text-center my-5">
        <h1 class="mb-3">Current Appointments</h1>
    </div>

    <!-- Start actual appointment-->

    <?php if(isset($allAppointments) && $allAppointments!=null){

        foreach ($allAppointments as $actualAppointment){
        ?>

            <section class="post-area section-gap">
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
                                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferViewMore" ?>"
                                                  method="POST">
                                                <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                        value="<?php echo $actualAppointment->getJobOffer()->getJobOfferId() ?>"><strong>Show </strong>
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


    <?php } }else { ?>
    <div class="title text-center my-5">
        <h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>
    </div>


<?php } }?>


    <?php include_once("footer.php") ?>