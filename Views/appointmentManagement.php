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




<!-- Start callto-action Area -->
<section class="callto-action-area section-gap"  id="join">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="menu-content col-lg-9">
                <div class="title text-center">
                    <h1 class="mb-10 text-white">Appoiment Management</h1>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End calto-action Area -->


          <?php if(isset($allOffers) && $allOffers!=null){?>



<!-----------------------CARDD----------------------------->


    <div class="container">
        <br><br><br>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-blue">
                    <div class="inner">


                        <?php
                        $carreras = array();

                        foreach ($allOffers as $value) {
                            $flag = 0;
                            foreach ($carreras as $carre) {
                                if ($carre == $value->getCareer()->getDescription()) {
                                    $flag = 1;
                                }
                            }

                            if ($flag == 0) {
                                array_push($carreras, $value->getCareer()->getDescription());
                            }

                        }
                        $cant=count($carreras);

                        ?>

                        <h3> <?php echo $cant ?> </h3>
                        <h5> Careers with Appointments </h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-green">
                    <div class="inner">

                        <?php
                        $companies= array();
                        foreach ($allOffers as $value) {
                            $flag = 0;
                            foreach ($companies as $com) {
                                if ($com == $value->getCompany()->getName()) {
                                    $flag = 1;
                                }
                            }

                            if ($flag == 0) {
                                array_push($companies, $value->getCompany()->getName());
                            }

                        }
                        $cant=count($companies);

                        ?>


                        <h3>  <?php echo $cant ?> </h3>
                        <h5>Selected Companies </h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-orange">
                    <div class="inner">

                  <?php
                  $titles= array();
                  foreach ($allOffers as $value) {
                      $flag = 0;
                      foreach ($titles as $title) {
                          if ($title == $value->getTitle()) {
                              $flag = 1;
                          }
                      }

                      if ($flag == 0) {
                          array_push($titles, $value->getTitle());
                      }

                  }
                  $cant=count($titles);?>

                        <h3>  <?php echo $cant ?></h3>
                        <h5>Selected offers </h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-red">
                    <div class="inner">

                        <?php

                        $cantidad = 0;
                        $total=0;
                        foreach ($allOffers as $value) {

                               $cantidad=count($value->getAppointment());
                               $total=$total+$cantidad;

                        } ?>


                        <h3><?php echo $total ?>  </h3>
                        <h5> Total Appointments </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!-------------------------CARD--------------------------------->



<?php   if(is_object($allOffers))
{ $offer= $allOffers;
    $allOffers= array();
    array_push($allOffers, $offer);
}?>


<!--...........................ESTADISTICA..........................................................................-->


<?php  if(isset($finalArray) && !empty($finalArray)){

    $carreras= $finalArray['carreras'];
    $numeros= $finalArray['numeros'];
    ?>


<?php if(isset($version) && $version==1){?>
    <div class="offset-lg-5" style="width:20%;hieght:10%;text-align:center">
        <br><br><br>
        <h2 class="page-header" >Analytics Reports </h2>
        <div><h6>Job Offers per Career</h6> </div>
        <br>
        <canvas  id="chartjs_bar"></canvas>
    </div>
    <?php }?>


    <?php if(isset($version) && $version==2){?>
        <div class="offset-lg-5" style="width:20%;hieght:10%;text-align:center">
            <br><br><br>
            <h2 class="page-header" >Analytics Reports </h2>
            <div><h6>Job Offers per Company</h6> </div>
            <br>
            <canvas  id="chartjs_bar"></canvas>
        </div>
    <?php }?>


    <?php if(isset($version) && $version==3){?>
        <div class="offset-lg-5" style="width:20%;hieght:10%;text-align:center">
            <br><br><br>
            <h3 class="page-header" >Analytics Reports </h3>
            <div><h6></h6> </div>
            <br>
            <canvas  id="chartjs_bar"></canvas>
        </div>
    <?php }?>

    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript">
        var ctx = document.getElementById("chartjs_bar").getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels:<?php echo json_encode($carreras); ?>,
                datasets: [{
                    backgroundColor: [
                        "#a3abf8",
                        "#e8aefa",
                        "#90e0f3",
                        "#efd99e",
                        "#99f6a8",
                        "#7040fa",
                        "#ff004e"
                    ],
                    data:<?php echo json_encode($numeros); ?>,
                }]
            },
            options: {
                legend: {
                    display: true,
                    position: 'bottom',

                    labels: {
                        fontColor: '#71748d',
                        fontFamily: 'Circular Std Book',
                        fontSize: 14,
                    }
                },


            }
        });
    </script>

<?php }?>
<!--.....................................................................................................................-->



    <section class="post-area section-gap">
        <div class="container">
            <div class="row justify-content-center d-flex bg-light-alpha p-5 border">
                <div class="col-md-9 post-list">
                    <ul class="cat-list">

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

                                                                <option value="<?php echo $value->getJobOfferId()?>"><?php echo $value->getCompany()->getName()?></option>
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

                                if ($company->getActive()=='true')  { //una job offer que finalizo se establece como inactive, pero sus postulaciones son validas.
                                                                      //si una empresa inactivada (al quererse eliminar o manualmente) cuando posee postulaciones en alguna job offer, esas offers NO son validas salvo que sea active nuevamente
                                                                       //en la tabla de appointment estan todas las appointment actuales validas, salvo las de una job offer de una company inactiva (si se elimina una job offer tambien sus postulaciones, por lo que no estarian en la tabla de appointment)
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
                                                    <td>
                                                        <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentList" ?>"
                                                              method="POST">
                                                            <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>">
                                                                Appoinments
                                                            </button>
                                                        </form>
                                                    </td>
                                                    <br>
                                                    <td>
                                                        <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentList" ?>"
                                                              method="POST">
                                                            <input type="hidden" name="back" value="1">
                                                            <button type="submit" name="id" class="btn buttonPer m-lg-auto d-block"
                                                                    value="<?php echo $value->getJobOfferId() ?>">Generate PDF
                                                            </button>
                                                            <br>
                                                        </form>
                                                    </td>
                                            </ul>
                                        </div>
                                    </div>
                                    <?php
                                }
                                else{ //COMPANY INACTIVA (APPOINTMENTS "NO" VALIDAS HASTA QUE SE VUELVA A ACTIVAR LA COMPANY)

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
                                                            <form action="<?php echo FRONT_ROOT . "Appointment/showAppointmentList" ?>"
                                                                  method="POST">
                                                                <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                        value="<?php echo $value->getJobOfferId() ?>">
                                                                    Appoinments
                                                                </button>
                                                                <br>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <form action="<?php echo FRONT_ROOT . "Job/showJobOfferViewMore" ?>"
                                                                  method="POST">
                                                                <button type="submit" name="id" class="btn buttonPer ml-auto d-block"
                                                                        value="<?php echo $value->getJobOfferId() ?>"> View More
                                                                </button>
                                                            </form>
                                                            <br>
                                                        </td>
                                                    </ul>
                                                </div>
                                            </div>

                                            <?php
                                        }}
                                }
                            }
                        }
                     ?>

                </div>

                <?php } ?>
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
