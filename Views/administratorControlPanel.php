<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h3 class="mb-3 text-center text-muted">Administrator</h3>

            <div class="bg-light-alpha p-3 border">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <label class="text-muted text-strong" for="">First Name</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getFirstName()?>">
                    </div>

                    <div class="col-lg-4 text-center">
                        <label class="text-muted text-strong" for="">Last Name</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getLastName()?>">
                    </div>

                    <div class="col-lg-4 text-center">
                        <label class="text-muted text-strong"  for="">Employee Number</label>
                        <input type="text" name="" class="form-control form-control-ml text-center" disabled value="<?php echo $loggedUser->getEmployeeNumber()?>">
                    </div>
                </div>
            </div><br>
        </div>
    </section>

    <section id="hero" class=" align-items-center justify-content-center offset-1">
        <div class="container">
            <div class="row justify-content-center align-items-center">

                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                </div>
                <div class=" col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="../Views/img/admini.png" class="img-fluid animated" alt="">

                </div>
            </div>
        </div>
    </section><!-- End Hero -->


</main>


<br><br><br><br><br><br>
<br><br><br><br><br><br>

<?php
include_once('footer.php');
?>
