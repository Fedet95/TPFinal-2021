<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');

?>

<div class="ml-auto col-auto">
    <h3 class="text-center text-muted py-3">Student List</h3>
    <div class="scrollable container-fluid">
        <div class="form-group">
            <table>
                <thead>
                <tr>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Admin/showAdminListView" ?>" method="post"
                        ">
                        <input type="number" name="valueToSearch" placeholder="Enter the student DNI" class="bg-light"
                               required>
                        <input type="submit" class="btn btn-dark ml-auto" name="search" value="Filter">
                        </form>
                    </th>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Admin/showAdminListView" ?>" method="post"
                        ">
                        <input type="submit" class="btn btn-dark ml-auto" name="all" value="Show all students">
                        </form>
                    </th>
                </tr>
                </thead>
            </table>

        </div>
        <table class="table bg-light-alpha border" style="text-align:center; ">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 25%;">First Name</th>
                <th class="text-muted text-strong" style="width: 25%;">Last Name</th>
                <th class="text-muted text-strong" style="width: 30%;">EmployeeNumber</th>
                <th class="text-muted text-strong" style="width: 30%;">Email</th>
                <th class="text-muted text-strong" style="width: 30%;">Password</th>
                <th class="text-muted text-strong" style="width: 30%;">Active</th>
                <th class="text-muted text-strong" style="width: 30%;">Remove</th>
                <th class="text-muted text-strong" style="width: 30%;">Edit</th>
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
                            <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                    value="<?php echo $allAdmins->getAdministratorId() ?>"> Remove
                            </button>
                        </form>
                    </td>

                    <td>
                        <form action="<?php echo FRONT_ROOT . "Admin/Edit" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                    value="<?php echo $allAdmins->getAdministratorId() ?>"> Edit
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
<br><br><br>
<?php
include_once('footer.php');
?>
