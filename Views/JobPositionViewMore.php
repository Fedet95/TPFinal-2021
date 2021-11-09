<?php
use Models\SessionHelper;
SessionHelper::checkAdminSession();
//require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<div class="ml-auto col-auto">
    <section class="bg-light-alpha section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-muted"><?php echo $careerToShow ?>'s Job Positions</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <br><br>
    <div class="scrollable container-fluid offset-lg-4">
        <br>
        <table class="table  w-auto bg bg-light-alpha border" style="text-align:center;">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 25%;">ID</th>
                <th class="text-muted text-strong" style="width: 25%;">Job Position</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allPositions as $valuePosition) {

                if (strcasecmp($valuePosition->getCareer()->getDescription(), $careerToShow) == 0) {
                    ?>
                    <tr>
                    <td><?php echo $valuePosition->getJobPositionId() ?></td>
                    <td><?php echo $valuePosition->getDescription() ?></td>
                    <?php
                }
                ?>

                </tr>

                <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>

<!-- / main body -->
<div class="clear"></div>
<form action="<?php echo FRONT_ROOT . "job/showJobPositionManagement" ?>" method="post">
    <button type="submit" name="button" class="btn btn-dark offset-lg-6">Return</button>
</form>

<br><br><br><br><br><br><br><br><br><br><br>
<?php
include('footer.php');
?>
