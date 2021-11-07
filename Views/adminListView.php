<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');

?>

<div class="ml-auto col-auto">
    <!-- Start callto-action Area -->
    <section class="bg-light-alpha section-gap"  id="join">
        <div class="container fa-text-width">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-muted">Administrators</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br><br>

    <div class="scrollable container-fluid offset-lg-3">
        <div class="form-group">
            <table>
                <thead>
                <tr>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "User/showAdminCreateView" ?>" method="POST">
                            <button type="submit" name="" class="btn btn-dark m-lg-auto d-block "
                                    value=""> Create New Admin
                            </button>
                        </form>
                    </th>
                </tr>
                </thead>
            </table>

        </div>
        <strong class="offset-lg-2"><?php if (isset($message)) {
                echo $message;
            } ?></strong>
        <table class="table w-auto  bg bg-light-alpha border" style="text-align:center; ">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 16.66%;">ID</th>
                <th class="text-muted text-strong" style="width: 25%;">Email</th>
                <th class="text-muted text-strong" style="width: 16.66%;">Remove</th>
                <th class="text-muted text-strong" style="width: 8.33%;">Edit</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($allAdmins as $value) {
                ?>
                <tr>
                    <td><?php echo $value->getUserId() ?></td>
                    <td><?php echo $value->getEmail() ?></td>
                    <td>
                        <form action="<?php echo FRONT_ROOT . "User/Remove" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark m-lg-auto d-block"
                                    value="<?php echo $value->getUserId() ?>"> Remove
                            </button>
                        </form>
                    </td>


                    <td>
                        <form action="<?php echo FRONT_ROOT . "User/showAdminEditView" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark m-lg-auto d-block"
                                    value="<?php echo $value->getUserId() ?>"> Edit
                            </button>
                        </form>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<br>
<?php
include_once('footer.php');
?>

