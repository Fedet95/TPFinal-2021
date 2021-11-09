<?php
use Models\SessionHelper;
//require_once(VIEWS_PATH . "checkLoggedAdmin.php");
SessionHelper::checkAdminSession();
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
    <br><br>

<div class="ml-auto col-auto">

    <div class="scrollable container-fluid">
        <table class="table bg-light-alpha border" style="text-align:center; ">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 15%;">File Number</th>
                <th class="text-muted text-strong" style="width: 15%;">BirthDate</th>
                <th class="text-muted text-strong" style="width: 15%;">Gender</th>
                <th class="text-muted text-strong" style="width: 15%;">PhoneNumber</th>
                <th class="text-muted text-strong" style="width: 15%;">Email</th>
                <th class="text-muted text-strong" style="width: 20%;">Active</th>
                <th class="text-muted text-strong" style="width: 25%;">Back</th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo $studentMore->getFileNumber() ?></td>
                    <td><?php echo $studentMore->getBirthDate() ?></td>
                    <td><?php echo $studentMore->getGender() ?></td>
                    <td><?php echo $studentMore->getPhoneNumber() ?></td>
                    <td><?php echo $studentMore->getEmail() ?></td>
                    <?php if ($studentMore->getActive() == true) {?>
                        <td><?php echo "Active";  ?> </td>
                    <?php } else {?>
                        <td><?php echo "Inactive";?></td>
                    <?php }; ?>
                    <td>
                        <form action="<?php echo FRONT_ROOT . "User/showStudentListView" ?>" method="post"
                              enctype="multipart/form-data">
                            <button type="submit" name="button" class="btn btn-dark m-lg-auto d-block">Return</button>
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



