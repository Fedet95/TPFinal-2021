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
                <th class="text-muted text-strong" style="width: 25%;">Career</th>
                <th class="text-muted text-strong" style="width: 25%;">View Job Positions</th>
            </tr>
            </thead>
            <tbody>

            <?php
            $careerToShow = null;
            foreach ($allPositions as $valuePosition) { ?>
                <tr>

                    <?php
                    if ($careerToShow == null) { ?>

                        <td><?php echo $valuePosition->getCareer()->getDescription() ?></td>

                        <?php $careerToShow = $valuePosition->getCareer()->getDescription() ?>
                        <td>
                        <form action="<?php echo FRONT_ROOT ."Job/showJobPositionViewMore" ?>"  method="POST">
                            <button type="submit" name="careerDescription" class="btn btn-dark m-lg-auto d-block"
                                    value="<?php echo $valuePosition->getCareer()->getDescription() ?>"> View
                            </button>
                        </form>
                        </td>
                        <?php
                    } else if (strcasecmp($valuePosition->getCareer()->getDescription(), $careerToShow) == 0) {

                    } else { ?>
                        <td><?php echo $valuePosition->getCareer()->getDescription() ?></td>
                        <?php $careerToShow = $valuePosition->getCareer()->getDescription() ?>
                        <td>
                        <form action="<?php echo FRONT_ROOT ."Job/showJobPositionViewMore" ?>" method="POST">
                            <button type="submit" name="careerDescription"  class="btn btn-dark m-lg-auto d-block"
                                    value="<?php echo $valuePosition->getCareer()->getDescription() ?>"> View
                            </button>
                        </form>
                        </td>
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

