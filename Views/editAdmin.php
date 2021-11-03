<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<main class="py-5">
    <section id="listado">
        <div class="container">
            <h2 class="mb-4 text-muted text-center">Edit Admin <?php echo $admin->getFirstName() ?></h2>
            <div class="row justify-content-center">
                <form action="<?php echo FRONT_ROOT . "Admin/UpdateAdmin" ?>" method="POST"
                      class="bg-light-alpha p-5 border" enctype="multipart/form-data">
                    <div class="col-sm-12  text-center">
                        <strong><?php if (isset($message)) {
                                echo $message;
                            } ?></strong>
                        <div class="form-group">
                            <label for="" class="text-muted text-strong text">First Name</label>
                            <input type="text" name="firstName" class="form-control"
                                   value="<?php echo $admin->getFirstName() ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="text-muted text-strong text">Last Name</label>
                            <input type="text" name="lastName" class="form-control"
                                   value="<?php echo $admin->getLastName() ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="" class="text-muted text-strong text">Employee Number</label>
                            <input type="text" name="employeeNumber" class="form-control"
                                   value="<?php echo $admin->getEmployeeNumber() ?>" required>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label class="text-muted text-strong text" for="">Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="<?php echo $admin->getEmail() ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label class="text-muted text-strong text" for="">Password</label>
                                <input type="password" name="password" class="form-control"
                                       value="<?php echo $admin->getPassword() ?>" required>
                            </div>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <p class="text-muted text-strong text">Condition</p>
                                <?php if ($admin->getActive() == "1") { ?>
                                    <label for="active">Active</label>
                                    <input type="radio" name="active" value="true" class="radioSize" required
                                           id="active" checked="checked">
                                    <label for="inactive">Inactive</label>
                                    <input type="radio" name="active" value="false" class="radioSize" required
                                           id="inactive">
                                <?php } else {
                                    ?>
                                    <label for="active">Active</label>
                                    <input type="radio" name="active" value="true" class="radioSize" required
                                           id="active">
                                    <label for="inactive">Inactive</label>
                                    <input type="radio" name="active" value="false" class="radioSize" required
                                           id="inactive" checked="checked">
                                <?php } ?>

                            </div>
                        </div>
                        <div>
                            <input type="hidden" name="id" value="<?php echo $admin->getAdministratorId() ?>">
                        </div>
                        <div>
                            <button type="submit" name="button"
                                    class="btn btn-dark  ml-d-block my-3 justify-content-center">Finish Edition
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </section>
</main>


<?php
include_once('footer.php');
?>
