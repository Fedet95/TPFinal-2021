<?php

use Models\Administrator;
use Models\User;
use Models\SessionHelper;

SessionHelper::checkStudentSession();
//require_once(VIEWS_PATH . "checkLoggedStudent.php");
include_once('header.php');
include_once('nav.php');
?>


<link rel="stylesheet" href="../Views/css/estilos.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<h6 class="py-3 text-muted text-center text-strong"><?php if (isset($message)) {echo $message;} ?></h6>
<div class="container register">
    <div class="row">
        <div class="col-md-3 register-left">
            <img src="https://image.ibb.co/n7oTvU/logo_white.png" alt=""/>
            <h3>Welcome</h3>
            <p>You are 30 seconds away from getting your dream job!</p>
        </div>
        <div class="col-md-9 register-right">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                       aria-controls="home" aria-selected="true">Good Luck</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <h3 class="register-heading">Apply as a Employee</h3>
                    <div class="row register-form">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input readonly type="text" class="form-control" placeholder="First Name *"
                                       value="<?php echo $loggedUser->getFirstName() ?>"/>
                            </div>
                            <div class="form-group">
                                <input type="dni" class="form-control" readonly
                                       value="<?php echo $loggedUser->getDni() ?>"/>
                            </div>
                            <div class="form-group">

                                <input type="text" readonly class="form-control"
                                       value="<?php echo $loggedUser->getPhoneNumber() ?>"/>
                            </div>

                            <form action="<?php echo FRONT_ROOT . "Appointment/addAppointment" ?>" method="POST"
                                  enctype="multipart/form-data">

                                <div class="form-group">
                                    <label class="text-muted">Add your Curriculum (only PDF)</label>
                                    <input type="file" name="cv" class="form-control" required>
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" class="form-control" readonly
                                       value="<?php echo $loggedUser->getLastName() ?>"/>
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" readonly
                                       value="<?php echo $loggedUser->getEmail() ?>"/>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" readonly
                                       value="<?php echo (new \DateTime())->format('Y-m-d'); ?>"/>
                            </div>
                            <div class="form-group">
                                <label class="text-muted">Message</label>
                                <textarea name="text" placeholder="Enter a message... " class="form-control"
                                          required></textarea>
                            </div>

                            <input type="hidden" name="studentId" value="<?php echo $loggedUser->getUserId() ?>">

                            <input type="hidden" name="jobOfferId" value="<?php echo $jobOfferId?>">
                            <input type="submit" class="btnRegister buttonPer text-strong font-weight-bold" value="Apply"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


<?php
include_once('footer.php');
?>




