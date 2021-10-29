<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>
<main class="py-3">
    <section id="listado">
        <div class="container">
            <h2 class="mb-4 text-center text-muted">Create Job Position</h2>
            <div class="row justify-content-center">
                <form action="<?php echo FRONT_ROOT . "Job/addJobPosition" ?>" method="POST">
                    <strong class=" offset-md-5"><?php if (isset($message)) {
                            echo $message;
                        } ?></strong>
                    <div class="row  col-sm-10 offset-sm-1 text-center bg-light-alpha p-5 border">

                        <div class=" offset-3 col-7">
                            <div class="form-group">
                                <label class="text-muted text-strong text" for="">Referring Career</label>
                                <select name="careerId" class="form-control" required>
                                    <option disabled selected value="" class="text-center">Select referring career
                                    </option>
                                    <?php
                                    foreach ($allCareers as $value) {
                                        if ($value->getActive() == 'true') {
                                            ?>
                                            <option value="<?php echo $value->getCareerId() ?>"><?php echo $value->getDescription() ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group offset-3 col-7">
                            <label class="text-muted text-strong text" for="">Job Description</label>
                            <p><textarea name="descriptionJob" placeholder="Describe the Job Position..."
                                         class="form-control" required></textarea></p>
                        </div>
                        <button type="submit" name="button"
                                class="btn btn-dark offset-5 d-block my-3 col-3 justify-content-center">Confirm & Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<?php
include_once('footer.php');
?>
