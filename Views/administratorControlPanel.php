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

    <iframe  class="offset-lg-3" width="900" height="500" src="https://www.youtube.com/embed/pJo_fojED70" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>




</main>


<br><br><br><br><br><br>
<br><br><br><br><br><br>

<?php
include_once('footer.php');
?>
