<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<div class="ml-auto col-auto">
    <h3 class=" text-center text-muted py-3"><?php echo $careerToShow ?>'s Job Positions</h3>
    <div class="scrollable container-fluid">
        <form action="<?php echo FRONT_ROOT . "job/showJobPositionManagement" ?>" method="post"
              enctype="multipart/form-data">
            <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Return</button>
        </form>
        <br>
        <table class="table bg bg-light-alpha border" style="text-align:center;">
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

<br><br><br><br><br><br><br><br><br><br><br>
<?php
include('footer.php');
?>
