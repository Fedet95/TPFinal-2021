<?php
use Models\SessionHelper;
SessionHelper::checkUserSession();
use Models\User;

//require_once(VIEWS_PATH . "checkLoggedUser.php");
include_once('header.php');
include_once('nav.php');
?>


<link rel="stylesheet" href="../Views/css/linearicons.css">
<link rel="stylesheet" href="../Views/css/font-awesome.min.css">
<link rel="stylesheet" href="../Views/css/bootstrap.css">
<link rel="stylesheet" href="../Views/css/nice-select.css">
<link rel="stylesheet" href="../Views/css/main.css">

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script>
    $(function() {
        $( "#show-option" ).tooltip({
            show: {
                effect: "slideDown",
                delay: 300
            }
        });
    });</script>




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
                            <h1 class="mb-10">Get your Job!</h1>
                            <p>With a wide variety of offers perfect for you</p>
                        </div>
                    </div>
                </div>



          <?php if(isset($allOffers) && $allOffers!=null){?>


                <div class="title text-center">
                    <h4 class="mb-2">Trending careers</h4>
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



                        <?php if($careerValidation==null && $companyValidation==null && ($all==1 || $all==null)){?>

                        <div class="form-group offset-7">   <!--FILTER CAREERS EQUAL TO JOB POSITIONS FILTER-->
                            <table>
                                <thead>
                                <tr>
                                    <th>
                                        <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentManagementView" ?>" method="post"">
                                        <div>
                                            <div class="form-group">
                                                <br>
                                                <select name="valueToSearch"  class="form-control"  required="required">
                                                    <option value="" selected disabled class="text-center">Select Career</option>
                                                    <?php
                                                    $careerDescription= array();
                                                    foreach ($allOffers as $value) //offers with appointments
                                                    {
                                                        $flag=0;
                                                        foreach($careerDescription as $career)
                                                        {
                                                            if($career==$value->getCareer()->getDescription())
                                                            {
                                                                $flag=1;
                                                            }
                                                        }

                                                        if($flag==0)
                                                        {
                                                            array_push($careerDescription, $value->getCareer()->getDescription());
                                                            ?>
                                                            <option value="<?php echo $value->getCareer()->getDescription()?>"><?php echo $value->getCareer()->getDescription()?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    <th>
                                        <input type="submit" class="btn btn-light ml-auto filtre-button" name="search" value="Filter">
                                    </th>

                                    </form>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <?php }?>



                        <?php if(isset($careerValidation) && $careerValidation!=null && $companyValidation==null && $all==null){?>

                            <div class="form-group offset-7">  <!--COMPANY JOB OFFERS FILTER-->
                                <table>
                                    <thead>
                                    <tr>
                                        <th>
                                            <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentManagementView" ?>" method="post"">
                                            <div>
                                                <div class="form-group">
                                                    <br>
                                                    <select name="valueToSearch"  class="form-control"  required="required">
                                                        <option value="" selected disabled class="text-center">Select Company</option>
                                                        <?php
                                                        $companies= array();
                                                        foreach ($allOffers as $value)
                                                        {
                                                            $flag=0;

                                                            foreach($companies as $ids)
                                                            {
                                                                if($ids==$value->getCompany()->getCompanyId())
                                                                {
                                                                    $flag=1;
                                                                }
                                                            }

                                                            if($flag==0)
                                                            {
                                                                array_push($companies, $value->getCompany()->getCompanyId());
                                                                ?>
                                                                <option value="<?php echo $value->getCompany()->getCompanyId()?>"><?php echo $value->getCompany()->getName()?></option>
                                                                <?php
                                                            }
                                                        }
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



                        <?php }?>



                        <?php if(isset($companyValidation) && $companyValidation!=null && $finalFilter==null && $all==null){?>

                        <div class="form-group offset-7">  <!--TITLE JOB OFFERS FILTER-->
                            <table>
                                <thead>
                                <tr>
                                    <th>
                                        <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentManagementView" ?>" method="post"">
                                        <div>
                                            <input type="hidden" name="valueToSearch" value="finalValue">
                                            <div class="form-group">
                                                <br>
                                                <select name="titleToSearch"  class="form-control"  required="required">
                                                    <option value="" selected disabled class="text-center">Select Job Offer Title</option>
                                                    <?php
                                                    $titles= array();
                                                    foreach ($allOffers as $value)
                                                    {
                                                        $flag=0;

                                                        foreach($titles as $ids)
                                                        {
                                                            if($ids==$value->getTitle())
                                                            {
                                                                $flag=1;
                                                            }
                                                        }

                                                        if($flag==0)
                                                        {
                                                            array_push($titles,$value->getTitle());
                                                            ?>
                                                            <option value="<?php echo $value->getTitle()?>"><?php echo $value->getTitle()?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <button type="submit" class="btn btn-light ml-auto filtre-button">Filter </button>
                                    </th>
                                    </form>
                                    </th>
                                </tr>
                                </thead>
                            </table>
                        </div>

                        <?php }?>



                        <div class="form-group offset-lg-10">

                            <table>
                                <thead>
                                <tr>
                                    <th>
                                    <th>
                                        <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentManagementView" ?>" method="post" ">
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
                                                            <input type="hidden" name="studentId" value="<?php echo $loggedUser->getEmail() ?>">
                                                            <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>">Apply
                                                            </button>
                                                        </form>
                                                        <br>
                                                        </td>
                                                    <?php }else { ?>
                                                        <td>
                                                            <input type="button" id="show-option" value="Apply" title="This offer does not correspond to your career" class="btn buttonPer disabled ml-auto d-block">
                                                            <br>
                                                        </td>

                                                        <?php
                                                    }} ?>

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

                <?php }?>
            </div>
        </div>
    </section>









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



<?php include_once ('footer.php')?>
