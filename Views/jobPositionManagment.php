<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<div class="ml-auto col-auto">
    <h3 class=" text-center text-muted py-3">Job Positions</h3>
    <div class="scrollable container-fluid">
        <table class="table bg bg-light-alpha border" style="text-align:center;">
            <thead>
            <tr>
                <th class="text-muted text-strong" style="width: 25%;">ID</th>
                <th class="text-muted text-strong" style="width: 25%;">Career</th>
                <th class="text-muted text-strong" style="width: 25%;">Job Description</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($allPositions as $valuePosition) {
                ?>
                <tr>
                    <td><?php echo $valuePosition->getJobPositionId() ?></td>
                    <td><?php echo $valuePosition->getCareer()->getDescription() ?></td>
                    <td><?php echo $valuePosition->getDescription() ?></td>
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

