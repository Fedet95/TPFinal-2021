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
                <form action="<?php echo FRONT_ROOT . "Admin/addAdmin" ?>" method="POST" class="bg-light-alpha p-5 border"
                      enctype="multipart/form-data">
                    <div class="col-sm-10 offset-sm-1 text-center">
                        <strong><?php if(isset($message)){ echo $message;}?></strong>
                        <div class="form-group">
                            <label class="text-muted text-strong text" for="">First Name</label>
                            <input type="text" name="firstName" class="form-control" required
                                   placeholder="Enter first name">
                        </div>
                        <div class="form-group">
                            <label class="text-muted text-strong text" for="">Last Name</label>
                            <input type="text" name="lastName" class="form-control" required
                                   placeholder="Enter last name">
                        </div>
                        <div class="form-group">
                            <label class="text-muted text-strong text" for="">Employee Number</label>
                            <input type="text" name="employeeNumber" class="form-control" required
                                   placeholder="Enter employee number">
                        </div>
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
                        <div class="col-lg-15">
                            <div class="form-group">
                                <p class="text-muted text-strong text">Condition</p>
                                <label for="active" >Active</label>
                                <input type="radio" name="active" value="true" class="radioSize" required id="active">
                                <label for="inactive">Inactive</label>
                                <input type="radio" name="active" value="false" class="radioSize" required id="inactive">
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

