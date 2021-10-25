<?php
require_once(VIEWS_PATH . "checkLoggedStudent.php");
include_once('header.php');
include_once('nav-student.php');

?>

    <div class="ml-auto col-auto">
        <h3 class="text-center text-muted py-4"><?php echo $company->getName() ?></h3>
        <div class="scrollable container-fluid">
            <table class="table bg-light-alpha " style="text-align:center; ">
                <thead>
                <tr>
                    <th class="text-muted text-strong" style="width: 15%;">Foundation Date</th>
                    <th class="text-muted text-strong" style="width: 15% ;">About Us</th>
                    <th class="text-muted text-strong" style="width: 15%;">Company Link</th>
                    <th class="text-muted text-strong" style="width: 15%;">Email</th>
                    <th class="text-muted text-strong" style="width: 15%;">Country</th>
                    <th class="text-muted text-strong" style="width: 15%;">City</th>
                    <th class="text-muted text-strong" style="width: 15%;">Back</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $company->getFoundationDate() ?></td>
                    <td><?php echo $company->getAboutUs() ?></td>
                    <td><?php echo $company->getCompanyLink() ?></td>
                    <td><?php echo $company->getEmail() ?></td>
                    <td><?php echo $company->getCountry()->getName() ?></td>
                    <td><?php echo $company->getCity()->getName() ?></td>
                    <th>
                        <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"
                              enctype="multipart/form-data">
                            <input type="submit" class="btn btn-dark ml-auto d-block" name="search" value="Back">
                        </form>
                    </th>
                </tr>
                </tbody>
            </table>
        </div>

    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include_once('footer.php');
?>