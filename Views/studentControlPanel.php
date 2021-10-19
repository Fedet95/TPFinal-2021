<?php
require_once(VIEWS_PATH."checkLoggedStudent.php");
include_once('header.php');
include_once('nav-student.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h3 class="mb-3 text-center text-muted">Student</h3>

            <div class="bg-light-alpha p-2 text-center">
                <div class="row">
                    <div class="col-lg-4">
                        <label for="">First Name</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getFirstName()?>">
                    </div>

                    <div class="col-lg-3">
                        <label for="">Last Name</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getLastName()?>">
                    </div>

                    <div class="col-lg-2">
                        <label for="">DNI</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getDni()?>">
                    </div>

                    <div class="col-lg-3">
                        <label for="">Email</label>
                        <input type="text" name="" class="form-control form-control-ml" disabled value="<?php echo $loggedUser->getEmail()?>">
                    </div>
                </div>
            </div>
    </section>
</main>
<br>


<?php
include_once('footer.php');
?>


