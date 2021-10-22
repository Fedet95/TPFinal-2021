<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH."checkLoggedAdmin.php");
?>

<div class="ml-auto col-auto">
    <h3 class="text-center text-muted py-4">Student List</h3>
    <div class="scrollable container-fluid">
        <div class="form-group">
            <table>
                <thead>
                <tr>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Student/showStudentListView" ?>" method="post"">
                            <input type="number" name="valueToSearch" placeholder="Enter the student DNI" class="bg-light" required>
                            <input type="submit" class="btn btn-dark ml-auto" name="search" value="Filter">
                        </form>
                    </th>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Student/showStudentListView" ?>" method="post"">
                            <input type="submit" class="btn btn-dark ml-auto" name="all" value="Show all students" >
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
                <th class="text-muted text-strong" style="width: 30%;">DNI</th>
                <th class="text-muted text-strong" style="width: 30%;">Career</th>
                <th class="text-muted text-strong" style="width: 30%;">View More</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($searchedStudent as $value)
            {
                ?>
                <tr>
                    <td><?php echo $value->getFirstName() ?></td>
                    <td><?php echo $value->getLastName() ?></td>
                    <td><?php echo $value->getDni() ?></td>
                    <td><?php echo $value->getCareer()->getDescription() ?></td>
                    <td>
                        <form action="<?php echo FRONT_ROOT . "Student/showMoreStudentView" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                    value="<?php echo $value->getStudentId() ?>"> View More
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
<br><br><br><br><br><br><br><br><br><br>
<?php
include_once('footer.php');
?>
