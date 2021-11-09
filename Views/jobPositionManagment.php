<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<div class="ml-auto col-auto">
        <section class="bg-light-alpha section-gap"  id="join">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <div class="menu-content col-lg-9">
                        <div class="title text-center">
                            <h1 class="mb-10 text-muted">Job Positions</h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <br><br><br>
    <div class="scrollable container-fluid ">
        <table class="table w-auto  bg bg-light-alpha border" style="text-align:center;">
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

