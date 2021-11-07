<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<main class="py-3">
    <section id="listado">
        <div class="container">
            <h2 class="mb-4 text-center text-muted">Create New Admin</h2>
            <div class="row justify-content-center">
                <form action="<?php echo FRONT_ROOT . "User/addAdmin" ?>" method="POST" class="bg-light-alpha p-5 border"
                      enctype="multipart/form-data">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <strong><?php if(isset($message)){ echo $message;}?></strong>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="" class="text-muted text-strong text">Email</label>
                                <input type="email" name="email" class="form-control" required
                                       placeholder="Enter email">
                            </div>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="" class="text-muted text-strong text">Password</label>
                                <input type="password" name="password" class="form-control" required
                                       placeholder="Enter password">
                            </div>
                        </div>

                    <button type="submit" name="button" class="btn btn-dark ml-d-block my-3 justify-content-center">Confirm & Create</button>
                </form>
            </div>
        </div>
    </section>
</main>

<?php
include_once('footer.php');
?>

