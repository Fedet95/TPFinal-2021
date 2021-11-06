<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
<!--
CSS
============================================= -->
<link rel="stylesheet" href="css/linearicons.css">
<link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/magnific-popup.css">
<link rel="stylesheet" href="css/nice-select.css">
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="css/owl.carousel.css">
<link rel="stylesheet" href="css/main.css">




<div class="ml-auto col-auto">
    <!-- Start callto-action Area -->
    <section class="bg-light-alpha section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-muted">Companies List</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br>

<div class="ml-auto col-auto">

    <h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>
    <div class="scrollable container-fluid">
        <div class="form-group">
            <table>
                <thead>
                <tr>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"
                              enctype="multipart/form-data">
                            <input type="text" name="valueToSearch" placeholder="Company name to search" class="bg-light" required>
                            <input type="submit" class="btn btn-dark ml-auto" name="search" value="Filter">
                        </form>
                    </th>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"
                              enctype="multipart/form-data">
                            <input type="submit" class="btn btn-dark ml-auto" name="all" value="Show all companies">
                        </form>
                    </th>
                </tr>
                </thead>
            </table>
        </div>
        <table class="table bg bg-light-alpha border" style="text-align:center;">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 25%;">ID</th>
                <th class="text-muted text-strong" style="width: 25%;">Name</th>
                <th class="text-muted text-strong" style="width: 25%;">Industry</th>
                <th class="text-muted text-strong" style="width: 30%;">Logo</th>
                <th class="text-muted text-strong" style="width: 30%;">View More</th>
            </tr>
            </thead>
            <tbody>


                   <?php if(isset($searchedCompany) && $searchedCompany!=null) {
                       if (is_object($searchedCompany)) {
                           $searched = $searchedCompany;
                           $searchedCompany = array();
                           array_push($searchedCompany, $searched);
                       }
                       foreach ($searchedCompany as $valueCompany) {
                ?>
                <tr>
                    <td><?php echo $valueCompany->getCompanyId() ?></td>
                    <td><?php echo $valueCompany->getName() ?></td>
                    <td><?php echo $valueCompany->getIndustry()->getType() ?></td>
                    <td><?php echo '<img src="../uploads/' .$valueCompany->getLogo()->getFile() . '" height="50" width="70"/>'; ?></td>

                    <td>
                        <form action="<?php echo FRONT_ROOT ."Company/showCompanyViewMore" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                    value="<?php echo $valueCompany->getCompanyId() ?>"> View More
                            </button>
                        </form>
                    </td>
                </tr>
        <?php
            }}else{?> <h6 class="py-3 text-muted text-center text-strong"><?php echo "There are no company loaded in the system"?></h6>  <?php }?>
            </tbody>
        </table>
    </div>
</div>

<!-- / main body -->
<div class="clear"></div>

<br><br><br><br><br><br><br><br><br><br><br>
<?php
include('footer.php');
?>
