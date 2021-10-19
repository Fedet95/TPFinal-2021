<?php
include_once('header.php');
include_once('nav-student.php');
require_once(VIEWS_PATH . "checkLoggedStudent.php");

?>

    <div class="ml-auto col-auto">
        <h3 class="text-center text-muted py-3"><?php echo $company->getName() ?></h3>
        <div class="scrollable container-fluid">
            <table class="table bg-light-alpha " style="text-align:center; ">
                <thead>
                <tr>
                    <th style="width: 30%;">Name</th>
                    <th style="width: 30%;">Industry</th>
                    <th style="width: 30%;">Foundation Date</th>
                    <th style="width: 50% ;">About Us</th>
                    <th style="width: 30%;">Company Link</th>
                    <th style="width: 30%;">Email</th>
                    <th style="width: 30%;">Country</th>
                    <th style="width: 30%;">City</th>
                    <th style="width: 30%;">Logo</th>
                    <th style="width: 30%;">Back</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?php echo $company->getName() ?></td>
                    <td><?php echo $company->getIndustry()->getType() ?></td>
                    <td><?php echo $company->getFoundationDate() ?></td>
                    <td><?php echo $company->getAboutUs() ?></td>
                    <td><?php echo $company->getCompanyLink() ?></td>
                    <td><?php echo $company->getEmail() ?></td>
                    <td><?php echo $company->getCountry()->getName() ?></td>
                    <td><?php echo $company->getCity()->getName() ?></td>
                    <td><?php echo '<img src="data:image;base64,' . $company->getLogo() . '" height="50" width="50"/>'; ?></td>
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

<?php
include_once('footer.php');
?>