<?php

use Models\Administrator;
use Models\User;

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



<?php if ($edit==null && $remove==null) { ?>
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


    <?php if(isset($allOffers) && $allOffers!=null){?>
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
                <div class="row">
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <br>
                        <div class="single-fcat">
                            <img src="../Views/img/o1.png" alt="">
                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                            <?php

                            foreach ($allCareers as $car) {

                                if($car->getActive()=='true' && $car->getDescription()=="University technician in textile production")
                                {
                                    ?>
                                    <input type="hidden" name="valueToSearch" value="<?php echo $car->getDescription()?>">
                                    <input type="submit" class=" btn btn-light-1 c-filter  ml-auto" name="button" value="Textile Production">
                                    <?php
                                }} ?>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <br>
                        <div class="single-fcat">
                            <img src="../Views/img/o2.png" alt="">
                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                            <?php

                            foreach ($allCareers as $car) {

                                if($car->getActive()=='true' && $car->getDescription()=="University technician in computer systems")
                                {
                                    ?>
                                    <input type="hidden" name="valueToSearch" value="<?php echo $car->getDescription()?>">
                                    <input type="submit" class=" btn btn-light-1 c-filter ml-auto" name="button" value=" Ing Comp systems">
                                    <?php
                                }} ?>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <br>
                        <div class="single-fcat">
                            <img src="../Views/img/o3.png" alt="">
                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                            <?php

                            foreach ($allCareers as $car) {

                                if($car->getActive()=='true' && $car->getDescription()=="University technician in programming")
                                {
                                    ?>
                                    <input type="hidden" name="valueToSearch" value="<?php echo $car->getDescription()?>">
                                    <input type="submit" class=" btn btn-light-1 c-filter ml-auto" name="button" value="Tech programming">
                                    <?php
                                }} ?>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <br>
                        <div class="single-fcat">
                            <img src="../Views/img/o4.png" alt="">
                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                            <?php

                            foreach ($allCareers as $car) {

                                if($car->getActive()=='true' && $car->getDescription()=="Naval engineering")
                                {
                                    ?>
                                    <input type="hidden" name="valueToSearch" value="<?php echo $car->getDescription()?>">
                                    <input type="submit" class=" btn btn-light-1 c-filter ml-auto" name="button" value="Naval">
                                    <?php
                                }} ?>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <br>
                        <div class="single-fcat">
                            <img src="../Views/img/o5.png" alt="">
                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                            <?php

                            foreach ($allCareers as $car) {

                                if($car->getActive()=='true' && $car->getDescription()=="University technician in administration")
                                {
                                    ?>
                                    <input type="hidden" name="valueToSearch" value="<?php echo $car->getDescription()?>">
                                    <input type="submit" class=" btn btn-light-1 c-filter ml-auto" name="button" value="Administration">
                                    <?php
                                }} ?>
                            </form>

                        </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-6">
                        <br>
                        <div class="single-fcat">
                            <img src="../Views/img/o6.png" alt="">
                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                            <?php

                            foreach ($allCareers as $car) {

                                if($car->getActive()=='true' && $car->getDescription()=="University technician in environmental procedures and technologies")
                                {
                                    ?>
                                    <input type="hidden" name="valueToSearch" value="<?php echo $car->getDescription()?>">
                                    <input type="submit" class=" btn btn-light-1 c-filter ml-auto" name="button" value="Environmental">
                                    <?php
                                }} ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <?php   if(is_object($allOffers))
        { $offer= $allOffers;
            $allOffers= array();
            array_push($allOffers, $offer);
        }?>

        <section class="post-area section-gap">
            <div class="container">
                <div class="row justify-content-center d-flex bg-light-alpha p-5 border">
                    <div class="col-md-9 post-list">
                        <ul class="cat-list">

                            <?php if(isset($searchedValue)) {
                                if(!empty($searchedValue))
                                {
                                    $allOffers=$searchedValue;

                                }
                                else if(empty($searchedValue) && $back==1)
                                {
                                    $message= "Job offer successfully added";
                                }
                                else if(empty($searchedValue) && $back==2)
                                {
                                    $message= "Job offer successfully updated";
                                }
                                else if(empty($searchedValue) && $back==3)
                                {
                                    $message="Remove operation aborted";
                                }
                                else
                                {
                                    $message= "No job offers with these characteristics were found";
                                }
                            }?>




                            <div class="form-group offset-7">  <!--JOB POSITION FILTER-->
                                <table>
                                    <thead>
                                    <tr>
                                        <th>
                                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                                            <div>
                                                <div class="form-group">
                                                    <br>
                                                    <select name="valueToSearch"  class="form-control"  required="required">
                                                        <option value="" selected disabled class="text-center">Select Position</option>
                                                        <?php
                                                        $positionIds= array();
                                                        foreach ($allOffers as $value)
                                                        {
                                                            $flag=0;
                                                            if($loggedUser->getRol()->getUserRolId()==1)
                                                            {

                                                              foreach ($value->getJobPosition() as $pos){

                                                                  foreach($positionIds as $ids)
                                                                  {
                                                                      if($ids==$pos->getJobPositionId())
                                                                      {
                                                                          $flag=1;
                                                                      }
                                                                  }

                                                                  if($flag==0)
                                                                  {
                                                                      array_push($positionIds, $pos->getJobPositionId());
                                                                      ?>
                                                                      <option value="<?php echo $pos->getJobPositionId()?>"><?php echo $pos->getDescription()?></option>
                                                                      <?php
                                                                  }

                                                        }}else if($loggedUser->getRol()->getUserRolId()==2)
                                                        {

                                                                if($value->getActive()=='true'){

                                                                foreach ($value->getJobPosition() as $pos){

                                                                    foreach($positionIds as $ids)
                                                                    {
                                                                        if($ids==$pos->getJobPositionId())
                                                                        {
                                                                            $flag=1;
                                                                        }
                                                                    }

                                                                    if($flag==0)
                                                                    {
                                                                        array_push($positionIds, $pos->getJobPositionId());
                                                                        ?>
                                                                        <option value="<?php echo $pos->getJobPositionId()?>"><?php echo $pos->getDescription()?></option>
                                                                        <?php
                                                                    }
                                                            }
                                                        }}}
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <input type="submit" class="btn btn-light ml-auto filtre-button" name="search" value="Filter">
                                        </th>
                                        </form>
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>

                            <!--
                        <div class="form-group offset-7">   //FILTER CAREERS EQUAL TO JOB POSITIONS FILTER
                            <table>
                                <thead>
                                <tr>
                                    <th>
                                        <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post"">
                                        <div>
                                            <div class="form-group">
                                                <br>
                                                <select name="valueToSearch"  class="form-control"  required="required">
                                                    <option value="" selected disabled class="text-center">Select Career</option>
                                                    <?php
                                                        foreach ($allCareers as $car) {
                                                         if($car->getActive()=='true')
                                                          {
                                                              ?>
                                                                    <option value="<?php echo $car->getDescription()?>"><?php echo $car->getDescription()?></option>
                                                                    <?php
                                                                   }}
                                                           ?>
                                                </select>
                                            </div>
                                        </div>
                                    <th>
                                        <input type="submit" class="btn btn-light ml-auto" name="search" value="Filter">
                                    </th>

                                    </form>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                -->

                            <div class="form-group offset-lg-10">

                                <table>
                                    <thead>
                                    <tr>
                                        <th>
                                        <th>
                                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="post" ">
                                            <input type="submit" name="all" class="btn btn-close-white ml-auto" value="Show all Offers">
                                            </form>
                                        </th>
                                        </th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </ul>



                        <h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>

                     <?php

                     if(is_object($allOffers))
                     { $offer= $allOffers;
                         $allOffers= array();
                         array_push($allOffers, $offer);
                     }?>



                        <?php
                        //var_dump($allOffers);
                        foreach ($allOffers as $value) {

                            foreach ($allCompanies as $company) {
                                if ($value->getCompany()->getCompanyId() == $company->getCompanyId()) {

                                    if ($value->getActive() == "true" && $company->getActive()=='true' && strtotime($value->getEndDate()) >= strtotime(date("Y-m-d")) ) {
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
                                                        <h4><?php echo $value->getTitle() ?></h4>
                                                        <!--TITLE-->
                                                        <h5><?php echo $company->getName() ?></h5> <!--COMPANY NAME-->
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row offset-3">
                                                    <h5 class=""> <!--CAREER-->
                                                        <I> <?php echo $value->getCareer()->getDescription() ?></I>
                                                    </h5>
                                                    <I><h5>Job Nature: <?php echo $value->getDedication(); ?></h5></I>
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
                                                            <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>"> View More
                                                            </button>
                                                        </form>
                                                        <br>
                                                    </td>
                                                    <?php if ($loggedUser->getRol()->getUserRolId()==2) { ?>
                                                        <td>
                                                        <?php if ($value->getCareer()->getCareerId() == $loggedUser->getCareer()->getCareerId()) { ?>
                                                            <form action="<?php echo FRONT_ROOT ."Appointment/showApplyView" ?>"
                                                                  method="POST">
                                                                <input type="hidden" name="studentId" value="<?php echo $loggedUser->getUserId() ?>">
                                                                <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                        value="<?php echo $value->getJobOfferId() ?>">Apply
                                                                </button>
                                                            </form>
                                                            <br>
                                                            </td>
                                                        <?php }
                                                    } ?>

                                                    <?php if ($loggedUser->getRol()->getUserRolId()==1) { ?>
                                                        <td>
                                                            <form action="<?php echo FRONT_ROOT . "Job/removeJobOffer" ?>"
                                                                  method="POST">
                                                                <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                        value="<?php echo $value->getJobOfferId() ?>">
                                                                    Remove
                                                                </button>
                                                            </form>
                                                        </td>
                                                        <br>
                                                        <td>
                                                            <form action="<?php echo FRONT_ROOT . "Job/editJobOffer" ?>"
                                                                  method="POST">
                                                                <button type="submit" name="id"
                                                                        class="btn buttonPer ml-auto d-block"
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
                                    else
                                    {
                                        if($loggedUser->getRol()->getUserRolId()==1)
                                        {
                                            if(strtotime($value->getEndDate()) < strtotime(date("Y-m-d")) ||  $value->getActive() == "false" || $company->getActive()=='false'){
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
                                                            <h5><?php echo $company->getName() ?></h5> <!--COMPANY NAME-->
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row offset-3">
                                                        <p class="text-strong text-muted ">Inactive</p>
                                                        <h5 class=""> <!--CAREER-->
                                                            <I> <?php echo $value->getCareer()->getDescription() ?></I>
                                                        </h5>
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
                                                                <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                        value="<?php echo $value->getJobOfferId() ?>"> View More
                                                                </button>
                                                            </form>
                                                            <br>
                                                        </td>
                                                        <?php if ($loggedUser->getRol()->getUserRolId()==1) { ?>
                                                            <td>
                                                                <form action="<?php echo FRONT_ROOT . "Job/removeJobOffer" ?>"
                                                                      method="POST">
                                                                    <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                            value="<?php echo $value->getJobOfferId() ?>">
                                                                        Remove
                                                                    </button>
                                                                </form>
                                                            </td>
                                                            <br>
                                                            <td>
                                                                <form action="<?php echo FRONT_ROOT . "Job/editJobOffer" ?>"
                                                                      method="POST">
                                                                    <button type="submit" name="id"
                                                                            class="btn ml-auto buttonPer d-block"
                                                                            value="<?php echo $value->getJobOfferId() ?>"> Edit
                                                                    </button>
                                                                </form>
                                                            </td>

                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>

                                            <?php
                                        }}
                                    }
                                }
                            }
                        } ?>

                    </div>

                </div>
            </div>
        </section>
<?php }else{?>
        <h6 class="py-3 text-muted text-center text-strong mb-100"><?php echo "No Job Offers  currently available" ?></h6>
        <br><br><br>
        <?php }?>

        <!-- End post Area -->


    <!-- Start callto-action Area -->
    <section class="callto-action-area section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-white">Our selection of offers is updated every day!</h1>
                        <p class="text-white">We offer you a wide variety of job offers from the best companies</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End calto-action Area -->


<?php } ?>


    <!--EDIT JOB OFFER AREA-->
<?php
if(($edit != null) && ($loggedUser->getRol()->getUserRolId()==1) && ($jobOfferEdit->getJobOfferId() != null))
{
 if(($careerId == null))
 { ?>
    <main class="py-3">
        <section id="listado">
            <section id="listado">
                <div class="container">
                    <h2 class="mb-4 text-center text-muted">Edit Job Offer</h2>
                    <div class="row justify-content-center">
                        <form action="<?php echo FRONT_ROOT . "Job/editJobOfferFirstPart" ?>" method="POST">
                            <strong class="h5 offset-md-5"><?php if (isset($message)) {
                                    echo $message;
                                } ?></strong>
                            <div class="row  col-sm-10 offset-sm-1 text-center bg-light-alpha p-5 border">

                                <div class=" offset-3 col-7">
                                    <div class="form-group">
                                        <label class="text-muted text-strong text" for="">Offering Company</label>
                                        <select name="company" class="form-control" required>
                                            <?php foreach ($allCompanies as $valueC) {
                                                if ($valueC->getCompanyId() == $jobOfferEdit->getCompany()->getCompanyId()) {
                                                    ?>
                                                    <option selected value="<?php echo $jobOfferEdit->getCompany()->getCompanyId() ?>"><?php echo $valueC->getName() ?></option>
                                                <?php }
                                            }
                                            foreach ($allCompanies as $value) {
                                                if ($value->getActive() == 'true') {
                                                    if($value->getCompanyId()!=$jobOfferEdit->getCompany()->getCompanyId()){
                                                    ?>
                                                    <option value="<?php echo $value->getCompanyId() ?>"><?php echo $value->getName() ?></option>
                                                    <?php
                                                }}
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group offset-3 col-7">
                                    <label class="text-muted text-strong text" for="">Referring Career</label>
                                    <select name="career" class="form-control" required>
                                        <option value="" disabled selected class="text-center">Select referring career
                                        </option>
                                        <?php foreach ($allCareers as $valueC) {
                                            if ($valueC->getCareerId() == $jobOfferEdit->getCareer()->getCareerId()) {
                                                ?>

                                                <option selected
                                                        value="<?php echo $jobOfferEdit->getCareer()->getCareerId() ?>"><?php echo $valueC->getDescription() ?></option>

                                            <?php }
                                        }
                                        foreach ($allCareers as $value) {
                                            if ($value->getActive() == 'true') {
                                                if($value->getCareerId()!=$jobOfferEdit->getCareer()->getCareerId()){
                                                ?>
                                                <option value="<?php echo $value->getCareerId() ?>"><?php echo $value->getDescription() ?></option>
                                                <?php
                                            }}
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div>
                                    <div class="form-group  offset-lg-11 col-lg-12">
                                        <label class="text-muted text-strong text">Publish Date</label>
                                        <input type="date" name="publishDate"
                                               value="<?php echo $jobOfferEdit->getPublishDate()?>" required
                                               class="form-control">
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group offset-md-11 col-lg-12">
                                        <label for="" class="text-muted text-strong text">End Date</label>
                                        <input type="date" value="<?php echo $jobOfferEdit->getEndDate() ?>"
                                               name="endDate" class="form-control" required>
                                    </div>
                                </div>
                                <div>
                                    <input type="hidden" name="jobOfferId"
                                           value="<?php echo $jobOfferEdit->getJobOfferId() ?>">
                                </div>
                                <button type="submit" name="button"
                                        class="btn btn-dark offset-5 d-block my-3 col-3 justify-content-center">Continue
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>
    </main>
<?php } else
{
    if (($careerId != null)) {
        ?>
        <!--PARTE 2-->
        <main class="py-3">
        <section id="listado">
        <div class="container">
        <h2 class="mb-4 text-center text-muted">Edit Job Offer</h2>
        <div class="row justify-content-center">
        <form action="<?php echo FRONT_ROOT . "Job/editJobOfferSecondPart" ?>" method="POST" class="bg-light-alpha p-5 border" >
        <div class="col-sm-10 offset-sm-1 text-center">
        <strong><?php if (isset($message)) {
                echo $message;
            } ?></strong>
        <div class="form-group">
            <label class="text-muted text-strong text" for="">Title</label>
            <input type="text" value="<?php echo $jobOfferEdit->getTitle()?>" name="title" class="form-control" required
                   placeholder="Enter Job Offer Title">
        </div>
        <div class="col-lg-15">
        <div class="form-group">
        <label class="text-muted text-strong text" for="">Job Position</label>
        <select name="position[]" multiple class="form-control"  required="required">
        <option value="" disabled class="text-center">Select Job Position</option>
        <?php

        $actualPositions=array();
        foreach ($jobOfferEdit->getJobPosition() as $valueJ)
        {
            if($valueJ->getCareer()->getCareerId()==$careerId){
            ?>
            <option selected value="<?php echo $valueJ->getJobPositionId() ?>"><?php echo $valueJ->getDescription() ?></option>
            <?php
            array_push($actualPositions,$valueJ->getJobPositionId());
        }}

        foreach ($allPositions as $value)
        {
        if ($value->getCareer()->getCareerId() == $careerId)
        {
            $flag=0;
            foreach ($actualPositions as $actualP)
                {
                    if($actualP == $value->getJobPositionId())
                        {
                            $flag=1;
                        }
                }
            if($flag == 0)
            {

            ?>
            <option value="<?php echo $value->getJobPositionId() ?>"><?php echo $value->getDescription() ?></option>
            <?php
            }
        }
        }
    ?>

    </select>
    </div>
    </div>

    <div class="form-group col-lg-15">
        <label class="text-muted text-strong text" for="">Work Type</label>
        <select name="remote" class="form-control" required>
            <option selected value="<?php echo $jobOfferEdit->getRemote()?>" class="text-center"><?php echo $jobOfferEdit->getRemote()?></option>
            <option value="Remote Working">Remote Working</option>
            <option value="Office Working">Office Working</option>
            <option value="Office and Remote Working">Office and Remote Working</option>
            <option value="Not defined">Not defined</option>
            <?php }?>
        </select>
    </div>

    <div class="form-group col-lg-15">
        <label class="text-muted text-strong text" for="">Dedication</label>
        <select name="dedication" class="form-control" required>
            <option selected value="<?php echo $jobOfferEdit->getDedication()?>" class="text-center"><?php echo $jobOfferEdit->getDedication()?></option>
            <option value="Full Time">Full Time</option>
            <option value="Part Time">Part Time</option>
            <option value="Temporary">Temporary</option>
            <option value="Not defined">Not defined</option>
        </select>
    </div>

    <div class="col-lg-15">
        <div class="form-group">
            <label class="text-muted text-strong" for="">Description</label>
            <p><textarea  name="description" placeholder="" class=" wide form-control" required> <?php echo htmlspecialchars($jobOfferEdit->getDescription());?></textarea></p>
        </div>
    </div>

    <div class="col-lg-15">
        <div class="form-group">
            <label class="text-muted text-strong" for="">Salary</label>
            <input required type="number" name="salary" value="<?php echo $jobOfferEdit->getSalary()?>" min="0.00" step="0.01"
        </div>
    </div>

    <div class="col-lg-15">
        <div class="form-group">
            <p class="text-muted text-strong text">Condition</p>
             <?php if($jobOfferEdit->getActive() == "true"){?>
                 <label  for="active">Active</label>
                 <input type="radio" name="active" value="true" class="radioSize" required id="active" checked="checked">
                 <label for="inactive">Inactive</label>
                 <input type="radio" name="active" value="false" class="radioSize" required id="inactive">
             <?php }else
             {?>
                 <label for="active">Active</label>
                 <input type="radio" name="active" value="true" class="radioSize" required id="active" >
                 <label for="inactive">Inactive</label>
                 <input type="radio" name="active" value="false" class="radioSize" required id="inactive" checked="checked">
             <?php }?>
        </div>
    </div>
    <div>
        <?php if (isset($values)) {
            $postValues = base64_encode(serialize($values));
            ?>
            <input type="hidden" name="values" value="<?php echo $postValues; ?>">

        <?php } ?>

    </div>
    <div>
        <button type="submit" name="button"
                class="btn btn-dark ml-auto my-3 col-6 align-items-center justify-content-center">Update
        </button>

    </div>
    </form>
    </div>
    </div>
    </section>
    </main>

<?php }}?>



<!--REMOVE JOB OFFER AREA -->
<?php if(isset($remove)){?>
<?php if(($remove != null) && ($loggedUser->getRol()->getUserRolId()==1)){
    if(($jobOffer!= null) && ($cant!=null)){  ?>

        <main class="py-3">
            <section id="listado">
                <h2 class="mb-4 text-muted text-center">Remove Job Offer:  <?php echo $jobOffer->getTitle() ?></h2>
                <div class="container">
                    <strong class="text-muted text-strong"><?php if (isset($message)) {
                            echo $message;
                        } ?></strong>
                    <div class="row justify-content-center offset-sm-1 text-center bg-light-alpha p-5 border">

                        <div class="form-group col-3">
                            <label for="" class="text-muted text-strong text">Title</label>
                            <input type="text" name="title" class="form-control text-center"
                                   value="<?php echo $jobOffer->getTitle() ?>" readonly>
                        </div>

                        <div class="form-group col-3">
                            <label class="text-muted text-strong text">Company</label>
                            <input type="text" name="company" id="contactNo" readonly class="form-control text-center"  value="<?php echo $company->getName() ?>">
                        </div>


                        <div class="form-group col-3">
                            <label class="text-muted text-strong text" for="">Publish Date</label>
                            <input type="text" name="publishdate" class="form-control text-center" value="<?php echo $jobOffer->getPublishDate() ?>"
                                   readonly>
                        </div>

                        <div class="form-group col-3">
                            <label class="text-muted text-strong text">End Date</label>
                            <input type="text" name="fileNumber" class="form-control text-center"
                                   value="<?php echo $jobOffer->getEndDate() ?>" readonly>
                        </div>


                        <div class="form-group col-3">
                            <label class="text-muted text-strong" for="">Career</label>
                            <input type="text" name="career" class="form-control text-center"
                                   value="<?php echo $jobOffer->getCareer()->getDescription() ?>" readonly>
                        </div>

                        <div class="form-group col-3">
                            <label class="text-muted text-strong text" for="">Active</label>
                            <input type="text" name="active" class="form-control text-center"
                                   value="<?php if($jobOffer->getActive()=='true'){ echo "Active";}else {echo "Inactive";} ?>" readonly>
                        </div>

                        <div class="form-group col-3">
                            <label class="text-muted text-strong text" for="">Appointments</label>
                            <input type="text" name="appointments" class="form-control text-center"
                                   value="<?php echo $cant ?>" readonly>
                        </div>
                    </div>
                </div>
                <br>
                <div class="container">
                    <form action="<?php echo FRONT_ROOT . "Job/removeJobOffer" ?>" method="POST">
                        <div>
                            <input type="hidden" name="offerId" value="<?php echo $jobOffer->getJobOfferId()?>">
                        </div>
                        <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-3">
                            <p class="text-strong h6">The job offer you want to delete currently has applications, please confirm if you want to continue.</p>
                            <br>
                            <div class="form-group">
                                <p class="text-muted text-strong text">Confirmation</p>
                                <label for="active"  class="h5">Accept</label>
                                <input type="radio" name="accept" value="true" class="radioSize" required id="active">
                                <br>
                                <label for="inactive" class="h5">Decline</label>
                                <input type="radio" name="accept" value="false" class="radioSize" required
                                       id="inactive">
                            </div>

                            <div class="form-group">
                                <br>
                                <button type="submit" name="button" class="offset-3 btn btn-dark ml-auto">CONFIRM </button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </main>
    <?php }else { if($cant==null){ if(isset($finalMessage)) { if($finalMessage=="Empty"){ ?>

        <main class="py-3">
            <section id="">
                <h2 class="mb-4 text-muted text-center offset-0">Send a Message</h2>
                <div class="container">
                    <form action="<?php echo FRONT_ROOT . "Job/removeJobOffer" ?>" method="POST">
                        <div>
                            <input type="hidden" name="offerId" value="<?php echo $jobOffer->getJobOfferId()?>">
                            <input type="hidden" name="accept" value="<?php echo "true"?>">
                        </div>
                        <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-5">
                            <p class="text-strong">Send a message to the applicants notifying them of the withdrawal.</p>
                            <br>

                            <div class="form-group">
                                <label class="text-muted text-strong text" for="">Subject</label>
                                <input type="text" name="sub" class="form-control text-center offset-2" style="width: 675px; height: 30px" placeholder="Enter email subject here..." required>
                            </div>

                            <div class="form-group">
                                <textarea name="text" class="form-control offset-2" placeholder="Message..."  style="width: 675px; height: 30px" required></textarea>
                            </div>
                            <div class="form-group">
                                <br>
                                <button type="submit" name="button" class="offset-2 btn btn-dark ml-auto">SEND</button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </main>
        <?php
    }else  { ?>

        <main class="py-3">
            <section id="">
                <h2 class="mb-4 text-muted text-center offset-0">Remove Job Offer</h2>
                <div class="container">
                    <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="POST">
                        <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-5">
                             <p class="offset-2 text-muted form-control " style="width: 675px; height: 30px"><?php echo $finalMessage?></p>
                            <div class="form-group">
                                <br>
                                <button type="submit" name="button" class="offset-2 btn btn-dark ml-auto">BACK</button>
                            </div>
                        </div>
                    </form>

                </div>
            </section>
        </main>

        <br><br><br><br><br><br><br>


<?php
    }

    }
    }}
}
}

?>

<?php
include_once('footer.php');
?>

