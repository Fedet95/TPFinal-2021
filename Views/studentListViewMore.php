<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>
<div class="ml-auto col-auto">
    <h3 class=" text-center text-muted py-4"> <td><?php echo $searchedStudent->getFirstName()." ".$searchedStudent->getLastName()  ?></td></h3>
    <div class="scrollable container-fluid">
        <table class="table bg bg-light-alpha border" style="text-align:center;">
            <thead>
            <tr>

                <th class="text-muted text-strong" style="width: 15%;">ID</th>
                 <th class="text-muted text-strong" style="width: 20%;">First Name</th>
                <th  class="text-muted text-strong" style="width: 20%;">Last Name</th>
                <th class="text-muted text-strong"  style="width: 20%;">DNI</th>
                <th class="text-muted text-strong" style="width: 15%;">File Number</th>
                <th class="text-muted text-strong"  style="width: 15%;">Birthdate</th>
                <th class="text-muted text-strong" style="width: 15%;">Gender</th>
                <th class="text-muted text-strong" style="width: 15%;">Phone Number</th>
                <th class="text-muted text-strong" style="width: 15%;">Email</th>
                <th class="text-muted text-strong" style="width: 15%;">Active</th>
                <th class="text-muted text-strong"  style="width: 30%;">Career</th>-
                <th class="text-muted text-strong" style="width: 15%;">Back</th>
                ////PALBO VIENDOOOOOOOOOOOOOOOOOOO

            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $searchedStudent->getStudentId() ?></td>
                <td><?php echo $searchedStudent->getFirstName() ?></td>
                <td><?php echo $searchedStudent->getLastName()?></td>
                <td><?php echo $searchedStudent->getDni()?></td>
                <td><?php echo $searchedStudent->getFileNumber()?></td>
                <td><?php echo $searchedStudent->getBirthDate() ?></td>
                <td><?php echo $searchedStudent->getGender() ?></td>
                <td><?php echo $searchedStudent->getPhoneNumber() ?></td>
                <td><?php echo $searchedStudent->getEmail()?></td>
                <td><?php if($searchedStudent->getActive()){echo "Active";}else{echo "Inactive";};?></td>
                <td><?php echo $searchedStudent->getCareer()->getDescription() ?></td>
                <td>
                    <form action="<?php echo FRONT_ROOT . "Student/showStudentListView" ?>" method="post"
                          enctype="multipart/form-data">
                        <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Return</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- / main body -->
<div class="clear"></div>
<br><br><br><br><br><br>
<br><br><br><br><br><br>
<?php
include('footer.php');
?>



