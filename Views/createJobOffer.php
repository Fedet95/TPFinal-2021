<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>
<?php if ($careerId==null){?>
<main class="py-3">
    <section id="listado">
        <div class="container">
            <h2 class="mb-4 text-center text-muted">Create Job Offer</h2>
            <div class="row justify-content-center">
                <form action="<?php echo FRONT_ROOT . "Job/addJobOfferFirstPart" ?>" method="POST" >
                    <strong class=" offset-md-5"><?php if(isset($message)){ echo $message;}?></strong>
                    <div class="row  col-sm-10 offset-sm-1 text-center bg-light-alpha p-5 border">

                        <div class=" offset-3 col-7">
                        <div class="form-group">
                            <label class="text-muted text-strong text" for="">Offering Company</label>
                            <select name="company" class="form-control" required >
                                <option value="" disabled selected class="text-center">Select offering company</option>
                                <?php
                                foreach ($allCompanies as $value)
                                {
                                    if($value->getActive()=='true')
                                    {
                                    ?>
                                    <option value="<?php echo $value->getCompanyId()?>"><?php echo $value->getName()?></option>
                                    <?php
                                }
                                }
                                ?>
                            </select>
                        </div>
                        </div>

                        <div class="form-group offset-3 col-7">
                            <label class="text-muted text-strong text" for="">Referring Career</label>
                            <select name="career"  class="form-control" required>
                                <option value="" disabled selected class="text-center">Select referring career</option>
                                <?php
                                foreach ($allCareers as $value)
                                {
                                    if($value->getActive()=='true')
                                    {
                                        ?>
                                        <option value="<?php echo $value->getCareerId()?>"><?php echo $value->getDescription()?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div>
                            <div class="form-group  offset-lg-11 col-lg-12">
                                <label class="text-muted text-strong text">Publish Date</label>
                                <input type="date" name="publishDate" value="<?php echo (new \DateTime())->format('Y-m-d');?>" readonly class="form-control">
                            </div>
                        </div>
                        <div>
                            <div class="form-group offset-md-11 col-lg-12">
                                <label for="" class="text-muted text-strong text">End Date</label>
                                <input type="date" name="endDate" class="form-control" required>
                            </div>
                        </div>
                        <button type="submit" name="button" class="btn btn-dark offset-5 d-block my-3 col-3 justify-content-center">Continue</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
<?php }
else {
?>
                                                   <!--PARTE 2-->
    <main class="py-3">
        <section id="listado">
            <div class="container">
                <h2 class="mb-4 text-center text-muted">Create Job Offer</h2>
                <div class="row justify-content-center">
                    <form action="<?php echo FRONT_ROOT . "Job/addJobOfferSecondPart" ?>" method="POST" class="bg-light-alpha p-5 border" >
                        <div class="col-sm-10 offset-sm-1 text-center">
                            <strong><?php if(isset($message)){ echo $message;}?></strong>
                            <div class="form-group">
                                <label class="text-muted text-strong text" for="">Title</label>
                                <input type="text" name="title" class="form-control" required
                                       placeholder="Enter Job Offer Title">
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong text" for="">Job Position</label>
                                    <select name="position[]" multiple class="form-control"  required="required">
                                        <option value="" disabled class="text-center">Select Job Position</option>
                                        <?php
                                        foreach ($allPositions as $value)
                                        {
                                            if($value->getCareer()->getCareerId()==$careerId)
                                            {
                                                ?>
                                                <option value="<?php echo $value->getJobPositionId()?>"><?php echo $value->getDescription()?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-lg-15">
                                <label class="text-muted text-strong text" for="">Work Type</label>
                                <select name="remote"  class="form-control"  required>
                                    <option value="" disabled selected class="text-center">Select Work Type</option>
                                    <option value="Remote Working">Remote Working</option>
                                    <option value="Office Working">Office Working</option>
                                    <option value="Office and Remote Working">Office and Remote Working</option>
                                    <option value="Not defined">Not defined</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-15">
                                <label class="text-muted text-strong text" for="">Dedication</label>
                                <select name="dedication"  class="form-control"  required>
                                    <option value="" disabled selected class="text-center">Select Dedication</option>
                                    <option value="Full Time">Full Time</option>
                                    <option value="Part Time">Part Time</option>
                                    <option value="Temporary">Temporary</option>
                                    <option value="Not defined">Not defined</option>
                                </select>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong" for="">Description</label>
                                    <p><textarea name="description" placeholder="" class="form-control" required></textarea></p>
                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label class="text-muted text-strong" for="">Salary</label>
                                    <input required type="number" name="salary" min="0.00" step="0.01"
                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <p class="text-muted text-strong text">Condition</p>
                                    <label for="active" >Active</label>
                                    <input type="radio" name="active" value="true" class="radioSize" required id="active">
                                    <label for="inactive">Inactive</label>
                                    <input type="radio" name="active" value="false" class="radioSize" required
                                           id="inactive">
                                </div>
                            </div>
                             <div>
                                <?php if(isset($values))
                                {
                                    $postValues= base64_encode(serialize($values));
                                 ?>
                                   <input type="hidden" name="values" value="<?php echo $postValues;?>">

                                  <?php } ?>

                            </div>
                            <div>
                                <button type="submit" name="button" class="btn btn-dark ml-auto my-3 col-6 align-items-center justify-content-center">Agregar</button>

                            </div>
                    </form>
                </div>
            </div>
        </section>
    </main>




<?php
}
include_once('footer.php');
?>