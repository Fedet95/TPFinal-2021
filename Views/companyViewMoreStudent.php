<?php
use Models\SessionHelper;
SessionHelper::checkStudentSession();
//require_once(VIEWS_PATH . "checkLoggedStudent.php");
include_once('header.php');
include_once('nav.php');

?>

    <div class="ml-auto col-auto">
    <div class="ml-auto col-auto">
        <section class="bg-light-alpha section-gap"  id="join">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="menu-content col-lg-9">
                        <div class="title text-center">
                            <h1 class="mb-10 text-muted"><?php echo $company->getName()?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br><br><br>

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
                    <td><a href="#" target="_blank" rel="noopener noreferrer"><?php echo $company->getCompanyLink() ?></a></td>
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