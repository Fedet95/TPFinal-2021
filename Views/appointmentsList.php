<?php
use Models\Administrator;
use Models\Student;

require_once(VIEWS_PATH . "checkLoggedUser.php");
include_once('header.php');
include_once('nav.php');
?>


<link rel="stylesheet" href="../Views/css/linearicons.css">
<link rel="stylesheet" href="../Views/css/font-awesome.min.css">
<link rel="stylesheet" href="../Views/css/bootstrap.css">
<link rel="stylesheet" href="../Views/css/magnific-popup.css">
<link rel="stylesheet" href="../Views/css/nice-select.css">
<link rel="stylesheet" href="../Views/css/animate.min.css">
<link rel="stylesheet" href="../Views/css/main.css">


<section class="download-area section-gap" id="app">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 download-left">
                <img class="img-fluid" src="../Views/img/people.png" alt="">
            </div>
            <br><br>
            <div class="col-lg-6 download-right">
                <h1>Find your<br>
                    Dream Job Today!</h1>
                <p class="subs">
                    We offer you a wide variety of job offers from the best companies so that you can find your dream job. Do not wait any longer and expand your work horizons.
                </p>
            </div>
        </div>
    </div>
</section>


<section class="feature-cat-area pt-100" id="category">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content pb-60 col-lg-10">
                <div class="title text-center">
                    <h1 class="mb-10">Get your Job</h1>
                    <p>With a wide variety of offers perfect for you</p>
                </div>
            </div>
        </div>
    </div>
</section>


   <h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>


                    <?php
                    if(is_object($historyAppointments))
                    { $history= $historyAppointments;
                        $historyAppointments= array();
                        array_push($historyAppointments, $history);
                    }
                    ?>



    <!-- Start post Area -->

    <section class="post-area section-gap">
        <div class="container">
            <div class="row justify-content-center d-flex">
                <div class="col-lg-9 post-list">


                    <?php foreach ($historyAppointments as $value){ ?>
                    <div class="single-post d-flex flex-row">
                        <div class="thumb">
                            <!--<img src="img/post.png" alt="">-->
                        </div>
                        <div class="details">
                            <div class="title d-flex flex-row justify-content-between">
                                <div class="titles">


                                    <a href="single.html"><h4><?php echo $value->getJobOfferTittle()->getTitle() ?></h4></a>
                                    <h5><?php echo $value->getCompany()->getName() ?></h5>
                                </div>
                            </div>
                            <br>
                            <div class="row offset-3">
                                <h5 class=""> <!--CAREER-->
                                    <I> <?php echo $value->getCareer()->getDescription() ?></I>
                                </h5>
                                <p class="address"><span class="lnr lnr-database"></span> Application
                                    Date: <?php echo $value->getAppointmentDate() ?>  </p>
                                <!--PUBLISHDATE-->
                            </div>
                            <p>
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                            </p>
                            <h5>Job Nature: Full time</h5>
                            <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                            <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                        </div>
                    </div>

                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
    <!-- End post Area -->










    <?php include_once ("footer.php")?>