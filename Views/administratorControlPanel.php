<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h3 class="mb-3 text-center text-muted">Administrator</h3>

            <div class="bg-light-alpha p-3 border">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <label class="text-muted text-strong" for="">First Name</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getFirstName()?>">
                    </div>

                    <div class="col-lg-4 text-center">
                        <label class="text-muted text-strong" for="">Last Name</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getLastName()?>">
                    </div>

                    <div class="col-lg-4 text-center">
                        <label class="text-muted text-strong"  for="">Employee Number</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getEmployeeNumber()?>">
                    </div>
                </div>
            </div><br>
        </div>
    </section>
</main>


<br><br>

<?php
include_once('footer.php');
?>
