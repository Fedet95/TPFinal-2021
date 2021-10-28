<?php

use Models\Administrator;
use Models\Student;

require_once(VIEWS_PATH . "checkLoggedUser.php");
include_once('header.php');
include_once('nav.php');
?>

<?php if(!isset($edit)){?>
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

    <strong class="offset-10"><?php if(isset($message)){ echo $message;}?></strong>
    <section class="post-area section-gap">
        <div class="container">
            <div class="row justify-content-center d-flex bg-light-alpha p-5 border">
                <div class="col-md-9 post-list">
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
                                        <div class="thumb ">
                                            <img><?php echo '<img src="../uploads/' . $company->getLogo()->getFile() . '" height="150" width="180"/>'; ?>
                                            <!--  <img src="../Views/img/post.png" alt=""> --LOGO-->
                                            <div class="">
                                                <ul class="tags offset-1 ">
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
                                        </div>
                                        <div class="details">
                                            <div class="offset-3 title d-flex flex justify-content-between">
                                                <div class="titles">
                                                    <a href="single.html"><h4><?php echo $value->getTitle() ?></h4></a>
                                                    <!--TITLE-->
                                                    <h6><?php echo $company->getName() ?></h6> <!--COMPANY NAME-->
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row offset-3">
                                                <p class=""> <!--CAREER-->
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
                                                        <?php if($value->getCareer()->getCareerId()==$loggedUser->getCareer()->getCareerId()){?>
                                                        <form action="<?php echo FRONT_ROOT . " PONER EL ROOT CORRESPONDIENTE  " ?>"
                                                              method="POST">
                                                            <!--********PONER EL ROOT CORRESPONDIENTE *****/ -->
                                                            <button type="submit" name="id" class="btn ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>">Apply
                                                            </button>
                                                        </form>
                                                        <br>
                                                    </td>
                                                <?php }} ?>

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
                                                        <form action="<?php echo FRONT_ROOT . "Job/editJobOffer" ?>"
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
                    <a class="text-uppercase loadmore-btn mx-auto d-block" href="category.html">Load More job Posts</a>

                </div>
            </div>
    </section>
    <!-- End post Area -->

<?php }?>

<!--EDIT JOB OFFER AREA-->
<?php if (($loggedUser instanceof Administrator) && ($edit!=null)  &&  ($jobOfferEdit->getJobOfferId()!=null)){?>
    <main class="py-3">
        <section id="listado">
        <section id="listado">
            <div class="container">
                <h2 class="mb-4 text-center text-muted">Edit Job Offer</h2>
                <div class="row justify-content-center">
                    <form action="<?php echo FRONT_ROOT . "Job/editJobOfferFirstPart" ?>" method="POST" >
                        <strong class=" offset-md-5"><?php if(isset($message)){ echo $message;}?></strong>
                        <div class="row  col-sm-10 offset-sm-1 text-center bg-light-alpha p-5 border">

                            <div class=" offset-3 col-7">
                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">Offering Company</label>
                                    <select name="company" class="form-control" required >
                                        <?php foreach ($allCompanies as $valueC) {
                                            if($valueC->getCompanyId()==$jobOfferEdit->getCompany()->getCompanyId()){?>

                                        <option selected value="<?php echo $jobOfferEdit->getCompany()->getCompanyId()?>"><?php echo $valueC->getName() ?></option>

                                        <?php }}
                                        foreach ($allCompanies as $value)
                                        {
                                            if($value->getActive()=='true')
                                            {
                                                ?>
                                                <option value="<?php echo $value->getCompanyId()?>"><?php echo $value->getName()?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group offset-3 col-7">
                                <label class="text-muted text-strong text" for="">Referring Career</label>
                                <select name="career"  class="form-control" required>
                                    <option value="" disabled selected class="text-center">Select referring career</option>
                                    <?php foreach ($allCareers as $valueC) {
                                            if($valueC->getCareerId()==$jobOfferEdit->getCareer()->getCareerId()){?>

                                        <option selected value="<?php echo $jobOfferEdit->getCareer()->getCareerId()?>"><?php echo $valueC->getDescription() ?></option>

                                    <?php }}
                                    foreach ($allCareers as $value)
                                    {
                                        if($value->getActive()=='true')
                                        {
                                            ?>
                                            <option value="<?php echo $value->getCareerId()?>"><?php echo $value->getDescription()?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div>
                                <div class="form-group  offset-lg-11 col-lg-12">
                                    <label class="text-muted text-strong text">Publish Date</label>
                                    <input type="date" name="publishDate" value="<?php echo (new \DateTime())->format('Y-m-d');?>" readonly class="form-control">
                                </div>
                            </div>
                            <div>
                                <div class="form-group offset-md-11 col-lg-12">
                                    <label for="" class="text-muted text-strong text">End Date</label>
                                    <input type="date" value="<?php echo $jobOfferEdit->getEndDate()?>" name="endDate" class="form-control" required>
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="jobOfferId" value="<?php echo $jobOfferEdit->getJobOfferId()?>">
                            </div>
                            <button type="submit" name="button" class="btn btn-dark offset-5 d-block my-3 col-3 justify-content-center">Continue</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
<?php }
else { if(($loggedUser instanceof Administrator) && ($edit!=null)  &&  ($jobOfferEdit->getJobOfferId()!=null)){
    ?>
    <!--PARTE 2-->
    <main class="py-3">
        <section id="listado">
            <div class="container">
                <h2 class="mb-4 text-center text-muted">Create Job Offer PARTE 2</h2>
                <div class="row justify-content-center">
                    <form action="<?php echo FRONT_ROOT . "Job/addJobOfferSecondPart" ?>" method="POST" class="bg-light-alpha p-5 border" >
                        <div class="col-sm-10 offset-sm-1 text-center">
                            <strong><?php if(isset($message)){ echo $message;}?></strong>
                            <div class="form-group">
                                <label class="text-muted text-strong text" for="">Title</label>
                                <input type="text" name="title" class="form-control" required
                                       placeholder="Enter Job Offer Title">
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">Job Position</label>
                                    <select name="position[]" multiple class="form-control"  required="required">
                                        <option value="" disabled class="text-center">Select Job Position</option>
                                        <?php
                                        foreach ($allPositions as $value)
                                        {
                                            if($value->getCareer()->getCareerId()==$careerId)
                                            {
                                                ?>
                                                <option value="<?php echo $value->getJobPositionId()?>"><?php echo $value->getDescription()?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-15">
                                <label class="text-muted text-strong text" for="">Work Type</label>
                                <select name="remote"  class="form-control"  required>
                                    <option value="" disabled selected class="text-center">Select Work Type</option>
                                    <option value="Remote Working">Remote Working</option>
                                    <option value="Office Working">Office Working</option>
                                    <option value="Office and Remote Working">Office and Remote Working</option>
                                    <option value="Not defined">Not defined</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-15">
                                <label class="text-muted text-strong text" for="">Dedication</label>
                                <select name="dedication"  class="form-control"  required>
                                    <option value="" disabled selected class="text-center">Select Dedication</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Temporary">Temporary</option>
                                    <option value="Not defined">Not defined</option>
                                </select>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong" for="">Description</label>
                                    <p><textarea name="description" placeholder="" class="form-control" required></textarea></p>
                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong" for="">Salary</label>
                                    <input required type="number" name="salary" min="0.00" step="0.01"
                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <p class="text-muted text-strong text">Condition</p>
                                    <label for="active" >Active</label>
                                    <input type="radio" name="active" value="true" class="radioSize" required id="active">
                                    <label for="inactive">Inactive</label>
                                    <input type="radio" name="active" value="false" class="radioSize" required
                                           id="inactive">
                                </div>
                            </div>
                            <div>
                                <?php if(isset($values))
                                {
                                    $postValues= base64_encode(serialize($values));
                                    ?>
                                    <input type="hidden" name="values" value="<?php echo $postValues;?>">

                                <?php } ?>

                            </div>
                            <div>
                                <button type="submit" name="button" class="btn btn-dark ml-auto my-3 col-6 align-items-center justify-content-center">Agregar</button>

                            </div>
                    </form>
                </div>
            </div>
        </section>
    </main>




    <?php
}}
include_once('footer.php');
?>

<?php
include_once('footer.php');
?>