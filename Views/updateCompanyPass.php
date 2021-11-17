<?php
use Models\SessionHelper;
SessionHelper::checkCompanySession();
include_once('header.php');
include_once('nav.php');
?>

<?php

    if(isset($modifyPass))
    {
    if($modifyPass==1 && $loggedUser->getRol()->getUserRolId() == 3){;?>

    <main class="py-5">
        <section id="listado">
            <div class="container">
                <h2 class="mb-4 text-muted text-center">Confirm Password</h2>
                <div class="row justify-content-center">
                    <form action="<?php echo FRONT_ROOT . "User/showCompanyEditPassView" ?>" method="POST"
                          class="bg-light-alpha p-5 border" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $loggedUser->getUserId() ?>">
                        <div class="col-sm-12  text-center">
                            <strong><?php if (isset($message)) {
                                    echo $message;
                                } ?></strong>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">Enter Password</label>
                                    <input type="password" name="confirmPassword" class="form-control" required>
                                </div>
                            </div>
                            <div>
                                <button type="submit"
                                        class="btn btn-dark  ml-d-block my-3 justify-content-center">Confirm
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            </div>
        </section>
    </main>
<?php }else if($modifyPass==2 && $loggedUser->getRol()->getUserRolId() == 3){?>

    <main class="py-5">
        <section id="listado">
            <div class="container">
                <h2 class="mb-4 text-muted text-center">Update User Company Password </h2>
                <div class="row justify-content-center">
                    <form action="<?php echo FRONT_ROOT . "User/updateUserCompanyPass" ?>" method="POST"
                          class="bg-light-alpha p-5 border" enctype="multipart/form-data">
                        <div class="col-sm-12  text-center">
                            <strong><?php if (isset($message)) {
                                    echo $message;
                                } ?></strong>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">New Password</label>
                                    <input type="password" name="newPassword" class="form-control">
                                </div>
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">Confirm Password</label>
                                    <input type="password" name="confirmPassword" class="form-control">

                                </div>
                                <div>
                                    <button type="submit"
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
}}
?>

<?php
include_once('footer.php');
?>