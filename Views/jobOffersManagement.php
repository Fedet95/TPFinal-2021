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
    <link rel="stylesheet" href="../Views/css/owl.carousel.css">
    <link rel="stylesheet" href="../Views/css/main.css">


    <section class="download-area section-gap" id="app">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 download-left">
                    <img class="img-fluid" src="../Views/img/d1.png" alt="">
                </div>
                <div class="col-lg-6 download-right">
                    <h1>Download the <br>
                        Job Listing App Today!</h1>
                    <p class="subs">
                        It won’t be a bigger problem to find one video game lover in your neighbor. Since the
                        introduction of Virtual Game, it has been achieving great heights so far as its popularity and
                        technological advancement are concerned.
                    </p>
                    <div class="d-flex flex-row">
                        <div class="buttons">
                            <i class="fa fa-apple" aria-hidden="true"></i>
                            <div class="desc">
                                <a href="#">
                                    <p>
                                        <span>Available</span> <br>
                                        on App Store
                                    </p>
                                </a>
                            </div>
                        </div>
                        <div class="buttons">
                            <i class="fa fa-android" aria-hidden="true"></i>
                            <div class="desc">
                                <a href="#">
                                    <p>
                                        <span>Available</span> <br>
                                        on Play Store
                                    </p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="feature-cat-area pt-100" id="category">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content pb-60 col-lg-10">
                    <div class="title text-center">
                        <h1 class="mb-10">Featured Job Categories</h1>
                        <p>Who are in extremely love with eco friendly system.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-fcat">
                        <a href="category.html">
                            <img src="img/o1.png" alt="">
                        </a>
                        <p>Accounting</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-fcat">
                        <a href="category.html">
                            <img src="img/o2.png" alt="">
                        </a>
                        <p>Development</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-fcat">
                        <a href="category.html">
                            <img src="img/o3.png" alt="">
                        </a>
                        <p>Technology</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-fcat">
                        <a href="category.html">
                            <img src="img/o4.png" alt="">
                        </a>
                        <p>Media & News</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-fcat">
                        <a href="category.html">
                            <img src="img/o5.png" alt="">
                        </a>
                        <p>Medical</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="single-fcat">
                        <a href="category.html">
                            <img src="img/o6.png" alt="">
                        </a>
                        <p>Goverment</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="post-area section-gap">
        <div class="container">
            <div class="row justify-content-center d-flex bg-light-alpha p-5 border">
                <div class="col-8 post-list">
                    <ul class="cat-list">
                        <li><a href="#">Recent</a></li>
                        <li><a href="#">Full Time</a></li>
                        <li><a href="#">Intern</a></li>
                        <li><a href="#">part Time</a></li>
                    </ul>

                    <?php foreach ($allOffers as $value) {

                        foreach ($allCompanies as $company) {
                            if ($value->getCompany()->getCompanyId() == $company->getCompanyId()) {

                                if ($value->getActive() == "true") {
                                    ?>

                                    <div class="single-post d-flex flex-row">
                                        <div class="thumb">
                                            <img><?php echo '<img src="../uploads/' . $company->getLogo()->getFile() . '" height="180" width="180"/>'; ?>
                                            <!--  <img src="../Views/img/post.png" alt=""> --LOGO-->
                                            <ul class="tags">
                                                <?php if ($value->getCareer()->getCareerID() == 1 || $value->getCareer()->getCareerID() == 2) { ?>
                                                    <li>
                                                        <?php if ($value->getCareer()->getCareerID() == 3) { ?>
                                                            <a href="#">Naval</a>
                                                        <?php } else { ?>   <a href="#">Fishing</a>  <?php } ?>
                                                    </li>
                                                    <li>
                                                        <a href="#">Engineering</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Harbor</a>
                                                    </li>
                                                <?php } else if ($value->getCareer()->getCareerID() == 3 || $value->getCareer()->getCareerID() == 4) { ?>
                                                    <li>
                                                        <?php if ($value->getCareer()->getCareerID() == 3) { ?>
                                                            <a href="#">Programming</a>
                                                        <?php } else { ?>    <a href="#">Systems</a>  <?php } ?>
                                                    </li>
                                                    <li>
                                                        <a href="#">Development</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Technology</a>
                                                    </li>
                                                <?php } else if ($value->getCareer()->getCareerID() == 5) { ?>
                                                    <li>
                                                        <a href="#">Textile</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Fabrics</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Manufacturing</a>
                                                    </li>
                                                <?php } else if ($value->getCareer()->getCareerID() == 6) { ?>
                                                    <li>
                                                        <a href="#">Administration</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Management</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Organization</a>
                                                    </li>
                                                <?php } else if ($value->getCareer()->getCareerID() == 7 || $value->getCareer()->getCareerID() == 8) { ?>
                                                    <li>
                                                        <a href="#">Ecology</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Enviroment</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Investigation</a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="details">
                                            <div class="offset-3 title d-flex flex-row justify-content-between">
                                                <div class="titles">
                                                    <a href="single.html"><h4><?php echo $value->getTitle() ?></h4></a>
                                                    <!--TITLE-->
                                                    <h6><?php echo $company->getName() ?></h6> <!--COMPANY NAME-->
                                                </div>
                                            </div>
                                            <div class="row offset-3">
                                                <p class="col-lg"> <!--CAREER-->
                                                    <?php echo $value->getCareer()->getDescription() ?>
                                                </p>
                                                <h5>Job Nature: <?php echo $value->getDedication(); ?></h5>
                                                <!--DEDICATION-->
                                                <p class="address"><span class="lnr lnr-map"></span>
                                                    Country: <?php echo $company->getCountry()->getName() ?> </p>
                                                <!--COUNTRY-->
                                                <p class="address"><span class="lnr lnr-map"></span>
                                                    City: <?php echo $company->getCity()->getName() ?> </p>
                                                <!--COUNTRY-->
                                                <p class="address"><span class="lnr lnr-database"></span> Publish
                                                    Date: <?php echo $value->getPublishDate() ?>  </p>
                                                <!--PUBLISHDATE-->
                                            </div>
                                        </div>
                                        <div class="row offset-3">
                                            <ul class="btns">
                                                <td>
                                                    <form action="<?php echo FRONT_ROOT . "Job/showJobOfferViewMore" ?>"
                                                          method="POST">
                                                        <button type="submit" name="id" class="btn ml-auto d-block"
                                                                value="<?php echo $value->getJobOfferId() ?>"> View More
                                                        </button>
                                                    </form>
                                                    <br>
                                                </td>
                                                <?php if ($loggedUser instanceof Student) { ?>
                                                    <td>
                                                        <form action="<?php echo FRONT_ROOT . " PONER EL ROOT CORRESPONDIENTE  " ?>"
                                                              method="POST">
                                                            <!--********PONER EL ROOT CORRESPONDIENTE *****/ -->
                                                            <button type="submit" name="id" class="btn ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>">Apply
                                                            </button>
                                                        </form>
                                                        <br>
                                                    </td>
                                                <?php } ?>

                                                <?php if ($loggedUser instanceof Administrator) { ?>
                                                    <td>
                                                        <form action="<?php echo FRONT_ROOT . " PONER EL ROOT CORRESPONDIENTE  " ?>"
                                                              method="POST">
                                                            <!--********PONER EL ROOT CORRESPONDIENTE *****/ -->
                                                            <button type="submit" name="id" class="btn ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>">
                                                                Remove
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <br>
                                                    <td>
                                                        <form action="<?php echo FRONT_ROOT . " poner el root correspondiente " ?>"
                                                              method="POST">
                                                            <!--********PONER EL ROOT CORRESPONDIENTE *****/ -->
                                                            <button type="submit" name="id"
                                                                    class="btn ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>"> Edit
                                                            </button>
                                                        </form>
                                                    </td>

                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                        }
                    } ?>


                    <!--
                                        <div class="single-post d-flex flex-row">
                                            <div class="thumb">
                                                <img src="../Views/img/post.png" alt="">
                                                <ul class="tags">
                                                    <li>
                                                        <a href="#">Art</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Design</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="details">
                                                <div class="title d-flex flex-row justify-content-between">
                                                    <div class="titles">
                                                        <a href="single.html"><h4>Creative Art Designer</h4></a>
                                                        <h6>Premium Labels Limited</h6>
                                                    </div>
                                                    <ul class="btns">
                                                        <li><a href="#"><span class="lnr lnr-heart"></span></a></li>
                                                        <li><a href="#">Apply</a></li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                                                </p>
                                                <h5>Job Nature: Full time</h5>
                                                <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                                                <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                                            </div>
                                        </div>
                                        <div class="single-post d-flex flex-row">
                                            <div class="thumb">
                                                <img src="../Views/img/post.png" alt="">
                                                <ul class="tags">
                                                    <li>
                                                        <a href="#">Art</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Design</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="details">
                                                <div class="title d-flex flex-row justify-content-between">
                                                    <div class="titles">
                                                        <a href="single.html"><h4>Creative Art Designer</h4></a>
                                                        <h6>Premium Labels Limited</h6>
                                                    </div>
                                                    <ul class="btns">
                                                        <li><a href="#"><span class="lnr lnr-heart"></span></a></li>
                                                        <li><a href="#">Apply</a></li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                                                </p>
                                                <h5>Job Nature: Full time</h5>
                                                <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                                                <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                                            </div>
                                        </div>
                                        <div class="single-post d-flex flex-row">
                                            <div class="thumb">
                                                <img src="../Views/img/post.png" alt="">
                                                <ul class="tags">
                                                    <li>
                                                        <a href="#">Art</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Design</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="details">
                                                <div class="title d-flex flex-row justify-content-between">
                                                    <div class="titles">
                                                        <a href="single.html"><h4>Creative Art Designer</h4></a>
                                                        <h6>Premium Labels Limited</h6>
                                                    </div>
                                                    <ul class="btns">
                                                        <li><a href="#"><span class="lnr lnr-heart"></span></a></li>
                                                        <li><a href="#">Apply</a></li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                                                </p>
                                                <h5>Job Nature: Full time</h5>
                                                <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                                                <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                                            </div>
                                        </div>
                                        <div class="single-post d-flex flex-row">
                                            <div class="thumb">
                                                <img src="../Views/img/post.png" alt="">
                                                <ul class="tags">
                                                    <li>
                                                        <a href="#">Art</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Design</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="details">
                                                <div class="title d-flex flex-row justify-content-between">
                                                    <div class="titles">
                                                        <a href="single.html"><h4>Creative Art Designer</h4></a>
                                                        <h6>Premium Labels Limited</h6>
                                                    </div>
                                                    <ul class="btns">
                                                        <li><a href="#"><span class="lnr lnr-heart"></span></a></li>
                                                        <li><a href="#">Apply</a></li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                                                </p>
                                                <h5>Job Nature: Full time</h5>
                                                <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                                                <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                                            </div>
                                        </div>
                                        <div class="single-post d-flex flex-row">
                                            <div class="thumb">
                                                <img src="../Views/img/post.png" alt="">
                                                <ul class="tags">
                                                    <li>
                                                        <a href="#">Art</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Design</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="details">
                                                <div class="title d-flex flex-row justify-content-between">
                                                    <div class="titles">
                                                        <a href="single.html"><h4>Creative Art Designer</h4></a>
                                                        <h6>Premium Labels Limited</h6>
                                                    </div>
                                                    <ul class="btns">
                                                        <li><a href="#"><span class="lnr lnr-heart"></span></a></li>
                                                        <li><a href="#">Apply</a></li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                                                </p>
                                                <h5>Job Nature: Full time</h5>
                                                <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                                                <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                                            </div>
                                        </div>
                                        <div class="single-post d-flex flex-row">
                                            <div class="thumb">
                                                <img src="../Views/img/post.png" alt="">
                                                <ul class="tags">
                                                    <li>
                                                        <a href="#">Art</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Media</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Design</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="details">
                                                <div class="title d-flex flex-row justify-content-between">
                                                    <div class="titles">
                                                        <a href="single.html"><h4>Creative Art Designer</h4></a>
                                                        <h6>Premium Labels Limited</h6>
                                                    </div>
                                                    <ul class="btns">
                                                        <li><a href="#"><span class="lnr lnr-heart"></span></a></li>
                                                        <li><a href="#">Apply</a></li>
                                                    </ul>
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod temporinc ididunt ut dolore magna aliqua.
                                                </p>
                                                <h5>Job Nature: Full time</h5>
                                                <p class="address"><span class="lnr lnr-map"></span> 56/8, Panthapath Dhanmondi Dhaka</p>
                                                <p class="address"><span class="lnr lnr-database"></span> 15k - 25k</p>
                                            </div>
                                        </div>
                    -->
                    <a class="text-uppercase loadmore-btn mx-auto d-block" href="category.html">Load More job Posts</a>

                </div>
            </div>
    </section>
    <!-- End post Area -->

<?php
include_once('footer.php');
?>