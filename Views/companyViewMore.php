<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<?php if(!isset($remove)){?>
<div class="ml-auto col-auto">
    <h3 class=" text-center text-muted py-3"> <td><?php echo $company->getName()?></td></h3>
    <div class="scrollable container-fluid">
        <table class="table bg bg-light-alpha border" style="text-align:center;">
            <thead>
            <tr>
                <th  class="text-muted text-strong" style="width: 15%;">Foundation Date</th>
                <th class="text-muted text-strong" style="width: 15%;">Cuit</th>
                <th class="text-muted text-strong" style="width: 15%;">About Us</th>
                <th class="text-muted text-strong" style="width: 15%;">Company Link</th>
                <th class="text-muted text-strong" style="width: 15%;">Email</th>
                <th class="text-muted text-strong" style="width: 15%;">Country</th>
                <th class="text-muted text-strong" style="width: 15%;">City</th>
                <th class="text-muted text-strong" style="width: 15%;">Active</th>
                <th class="text-muted text-strong" style="width: 15%;">Remove</th>
                <th class="text-muted text-strong" style="width: 15%;">Edit</th>
                <th class="text-muted text-strong" style="width: 15%;">Back</th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <td><?php echo $company->getFoundationDate() ?></td>
                <td><?php echo $company->getCuit() ?></td>
                <td><?php echo $company->getAboutUs() ?></td>
                <td><?php echo $company->getCompanyLink() ?></td>
                <td><?php echo $company->getEmail() ?></td>
                <td><?php echo $company->getCountry()->getName() ?></td>
                <td><?php echo $company->getCity()->getName() ?></td>
                <td><?php echo $company->getActive() ?></td>

                <td>
                    <form action="<?php echo FRONT_ROOT . "Company/Remove" ?>" method="POST">
                        <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                value="<?php echo $company->getCompanyId() ?>"> Remove
                        </button>
                    </form>
                </td>

                <td>
                    <form action="<?php echo FRONT_ROOT . "Company/Edit" ?>" method="POST">
                        <button type="submit" name="id" class="btn btn-dark ml-auto d-block"
                                value="<?php echo $company->getCompanyId() ?>"> Edit
                        </button>
                    </form>
                </td>
                <td>
                    <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"
                          enctype="multipart/form-data">
                        <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Return</button>
                    </form>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- / main body -->
<div class="clear"></div>

<br><br><br><br><br><br><br><br><br><br><br>


<?php }else if(isset($remove) && $remove!=null){?>

    <main class="py-3">
        <section id="listado">
            <h2 class="mb-4 text-muted text-center">Remove Company:  <?php echo $company->getName() ?></h2>
            <div class="container">
                <strong class="text-muted text-strong"><?php if (isset($message)) {
                        echo $message;
                    } ?></strong>
                <div class="row justify-content-center offset-sm-1 text-center bg-light-alpha p-5 border">

                    <div class="form-group col-3">
                        <label for="" class="text-muted text-strong text">Name</label>
                        <input type="text" name="name" class="form-control text-center"
                               value="<?php echo $company->getName() ?>" readonly>
                    </div>

                    <div class="form-group col-3">
                        <label class="text-muted text-strong text">Cuit</label>
                        <input type="text" name="cuit" id="contactNo" readonly class="form-control text-center"  value="<?php echo $company->getCuit() ?>">
                    </div>


                    <div class="form-group col-3">
                        <label class="text-muted text-strong text" for="">Industry</label>
                        <input type="text" name="industry" class="form-control text-center" value="<?php echo $company->getIndustry()->getType() ?>"
                               readonly>
                    </div>

                    <div class="form-group col-3">
                        <label class="text-muted text-strong text">Email</label>
                        <input type="text" name="email" class="form-control text-center"
                               value="<?php echo $company->getEmail() ?>" readonly>
                    </div>


                    <div class="form-group col-3">
                        <label class="text-muted text-strong text" for="">Active</label>
                        <input type="text" name="active" class="form-control text-center"
                               value="<?php if($company->getActive()=='true'){ echo "Active";}else {echo "Inactive";} ?>" readonly>
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
                        <input type="hidden" name="offerId" value="<?php echo $company->getCompanyId()?>">
                    </div>
                    <div class="justify-content-center align-items-center offset-sm-1 text-center bg-light-alpha border py-3">
                        <p class="text-strong h6">The company you want to delete currently has a job offer with applications, please confirm if you want to continue.</p>
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


<?php }?>


<?php
include('footer.php');
?>


