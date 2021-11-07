<?php
require_once(VIEWS_PATH."checkLoggedAdmin.php");
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
                        <h1 class="mb-10 text-muted">Student List</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br><br>

<div class="ml-auto col-auto">
    <div class="scrollable container-fluid">
        <div class="form-group">
            <table>
                <thead>
                <tr>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Student/showStudentListView" ?>" method="post"">
                            <input type="number" name="valueToSearch" placeholder="Enter the student DNI" class="bg-light" required>
                        <button type="submit" class="btn btn-dark ml-auto" name="search"> Filter</button>
                        </form>
                    </th>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Student/showStudentListView" ?>" method="post"">
                            <input type="submit" class="btn btn-dark ml-auto" name="valueToSearch" value="Show all students" >
                        </form>
                    </th>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Student/showStudentListView" ?>" method="post"">
                        <input type="submit" class="btn btn-dark ml-auto" name="valueToSearch" value="Show only registered" >
                        </form>
                    </th>
                </tr>
                </thead>
            </table>

        </div>
        <table class="table bg-light-alpha border" style="text-align:center; ">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 15%;">First Name</th>
                <th class="text-muted text-strong" style="width: 15%;">Last Name</th>
                <th class="text-muted text-strong" style="width: 15%;">DNI</th>
                <th class="text-muted text-strong" style="width: 25%;">Email</th>
                <th class="text-muted text-strong" style="width: 15%;">Career</th>
                <th class="text-muted text-strong" style="width: 5%;">View More</th>
            </tr>
            </thead>
            <tbody>


            <?php

            if(is_object($searchedStudent))
            { $student= $searchedStudent;
                $searchedStudent= array();
                array_push($searchedStudent, $student);
            } ?>

            <?php foreach ($searchedStudent as $value)
            {
                ?>
                <tr>
                    <td><?php echo $value->getFirstName() ?></td>
                    <td><?php echo $value->getLastName() ?></td>
                    <td><?php echo $value->getDni() ?></td>
                    <td><?php echo $value->getEmail()?></td>
                    <td><?php echo $value->getCareer()->getDescription() ?></td>
                    <td>
                        <form action="<?php echo FRONT_ROOT . "Student/showMoreStudentView" ?>" method="POST">
                            <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                    value="<?php echo $value->getUserId() ?>"> View More
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
