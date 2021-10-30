<?php
use Models\Administrator;
use Models\Student;

require_once(VIEWS_PATH . "checkLoggedUser.php");
include_once('header.php');
include_once('nav.php');
?>

<?php
if(isset($remove)){?>
    <?php if(($remove != null) && ($loggedUser instanceof Administrator)){
        if(($jobOffer!= null) && ($cant!=null)){  ?>

            <main class="py-3">
                <section id="listado">
                    <h2 class="mb-4 text-muted text-center">Remove Job Offer:  <?php echo $jobOffer->getTitle() ?></h2>
                    <div class="container">
                        <strong class="text-muted text-strong"><?php if (isset($message)) {
                                echo $message;
                            } ?></strong>
                        <div class="row justify-content-center offset-sm-1 text-center bg-light-alpha p-5 border">

                            <div class="form-group col-3">
                                <label for="" class="text-muted text-strong text">Title</label>
                                <input type="text" name="title" class="form-control text-center"
                                       value="<?php echo $jobOffer->getTitle() ?>" readonly>
                            </div>

                            <div class="form-group col-3">
                                <label class="text-muted text-strong text">Company</label>
                                <input type="text" name="company" id="contactNo" readonly class="form-control text-center"  value="<?php echo $company->getName() ?>">
                            </div>


                            <div class="form-group col-3">
                                <label class="text-muted text-strong text" for="">Publish Date</label>
                                <input type="text" name="publishdate" class="form-control text-center" value="<?php echo $jobOffer->getPublishDate() ?>"
                                       readonly>
                            </div>

                            <div class="form-group col-3">
                                <label class="text-muted text-strong text">End Date</label>
                                <input type="text" name="fileNumber" class="form-control text-center"
                                       value="<?php echo $jobOffer->getEndDate() ?>" readonly>
                            </div>


                            <div class="form-group col-3">
                                <label class="text-muted text-strong" for="">Career</label>
                                <input type="text" name="career" class="form-control text-center"
                                       value="<?php echo $jobOffer->getCareer()->getDescription() ?>" readonly>
                            </div>

                            <div class="form-group col-3">
                                <label class="text-muted text-strong text" for="">Active</label>
                                <input type="text" name="active" class="form-control text-center"
                                       value="<?php if($jobOffer->getActive()=='true'){ echo "Active";}else {echo "Inactive";} ?>" readonly>
                            </div>

                            <div class="form-group col-3">
                                <label class="text-muted text-strong text" for="">Appointments</label>
                                <input type="text" name="appointments" class="form-control text-center"
                                       value="<?php echo $cant ?>" readonly>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="container">
                        <form action="<?php echo FRONT_ROOT . "Job/removeJobOffer" ?>" method="POST">
                            <div>
                                <input type="hidden" name="offerId" value="<?php echo $jobOffer->getJobOfferId()?>">
                            </div>
                            <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-3">
                                <p class="text-strong h6">The job offer you want to delete currently has applications, please confirm if you want to continue.</p>
                                <br>
                                <div class="form-group">
                                    <p class="text-muted text-strong text">Confirmation</p>
                                    <label for="active"  class="h5">Accept</label>
                                    <input type="radio" name="accept" value="true" class="radioSize" required id="active">
                                    <br>
                                    <label for="inactive" class="h5">Decline</label>
                                    <input type="radio" name="accept" value="false" class="radioSize" required
                                           id="inactive">
                                </div>

                                <div class="form-group">
                                    <br>
                                    <button type="submit" name="button" class="offset-3 btn btn-dark ml-auto">CONFIRM </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </section>
            </main>
        <?php }else { if($cant==null){ if(isset($finalMessage)) { if($finalMessage=="Empty"){ ?>

            <main class="py-3">
                <section id="">
                    <h2 class="mb-4 text-muted text-center offset-0">Send a Message</h2>
                    <div class="container">
                        <form action="<?php echo FRONT_ROOT . "Job/removeJobOffer" ?>" method="POST">
                            <div>
                                <input type="hidden" name="offerId" value="<?php echo $jobOffer->getJobOfferId()?>">
                                <input type="hidden" name="accept" value="<?php echo "true"?>">
                            </div>
                            <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-5">
                                <p class="text-strong">Send a message to the applicants notifying them of the withdrawal.</p>
                                <br>

                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">Subject</label>
                                    <input type="text" name="sub" class="form-control text-center offset-2" style="width: 675px; height: 30px" placeholder="Enter email subject here..." required>
                                </div>

                                <div class="form-group">
                                    <textarea name="text" class="form-control offset-2" placeholder="Message..."  style="width: 675px; height: 30px" required></textarea>
                                </div>
                                <div class="form-group">
                                    <br>
                                    <button type="submit" name="button" class="offset-2 btn btn-dark ml-auto">SEND</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </section>
            </main>
            <?php
        }else  { ?>

            <main class="py-3">
                <section id="">
                    <h2 class="mb-4 text-muted text-center offset-0">Remove Job Offer</h2>
                    <div class="container">
                        <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>" method="POST">
                            <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-5">
                                <p class="offset-2 text-muted form-control " style="width: 675px; height: 30px"><?php echo $finalMessage?></p>
                                <div class="form-group">
                                    <br>
                                    <button type="submit" name="button" class="offset-2 btn btn-dark ml-auto">BACK</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </section>
            </main>

            <br><br><br><br><br><br><br>


            <?php
        }

        }
        }}
    }
}

?>