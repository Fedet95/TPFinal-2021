<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH."checkLoggedAdmin.php");

?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h3 class="mb-3 text-center text-muted">Administrator</h3>

            <div class="bg-light-alpha p-2">
                <div class="row">
                    <div class="col-lg-4 text-center">
                        <label for="">Nombre</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedadmin->getFirstName()?>">
                    </div>

                    <div class="col-lg-4 text-center">
                        <label for="">Apellido</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedadmin->getLastName()?>">
                    </div>

                    <div class="col-lg-4 text-center">
                        <label  for="">Employee Number</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedadmin->getEmployeeNumber()?>">
                    </div>
                </div>
            </div><br>
        </div>
    </section>
</main>




<?php
include_once('footer.php');
?>
