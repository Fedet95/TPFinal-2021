<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');

?>

<div class="ml-auto col-auto">
    <!-- Start callto-action Area -->
    <section class="bg-light-alpha section-gap"  id="join">
        <div class="container">
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

    <div class="scrollable container-fluid">
        <div class="form-group">
            <table>
                <thead>
                <tr>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Admin/showAdminCreateView" ?>" method="POST">
                            <button type="submit" name="" class="btn btn-dark m-lg-auto d-block"
                                    value=""> Create New Admin
                            </button>
                        </form>
                    </th>
                </tr>
                </thead>
            </table>

        </div>
        <table class="table bg bg-light-alpha border" style="text-align:center; ">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 10%;">First Name</th>
                <th class="text-muted text-strong" style="width: 10%;">Last Name</th>
                <th class="text-muted text-strong" style="width: 10%;">EmployeeNumber</th>
                <th class="text-muted text-strong" style="width: 10%;">Email</th>
                <th class="text-muted text-strong" style="width: 10%;">Password</th>
                <th class="text-muted text-strong" style="width: 5%;">Active</th>
                <th class="text-muted text-strong" style="width: 10%;">Remove</th>
                <th class="text-muted text-strong" style="width: 5%;">Edit</th>
            </tr>
            </thead>
            <tbody>

            <?php foreach ($allAdmins as $value) {
                ?>
                <tr>
                    <td><?php echo $value->getFirstName() ?></td>
                    <td><?php echo $value->getLastName() ?></td>
                    <td><?php echo $value->getEmployeeNumber() ?></td>
                    <td><?php echo $value->getEmail() ?></td>
                    <td><?php echo $value->getPassword() ?></td>
                    <?php if ($value->getActive() == 1) {
                        ?>
                        <td>Active</td>
                    <?php } else { ?>
                        <td>Inactive</td>
                    <?php } ?>

                    <td>
                        <form action="<?php echo FRONT_ROOT . "Admin/Remove" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark m-lg-auto d-block"
                                    value="<?php echo $value->getAdministratorId() ?>"> Remove
                            </button>
                        </form>
                    </td>


                    <td>
                        <form action="<?php echo FRONT_ROOT . "Admin/showAdminEditView" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark m-lg-auto d-block"
                                    value="<?php echo $value->getAdministratorId() ?>"> Edit
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

