<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>

<main class="py-5">
    <section id="listado">
        <div class="container">
            <h2 class="mb-4 text-muted text-center">Edit Company <?php echo $company->getName() ?></h2>
            <div class="row justify-content-center">
                <form action="<?php echo FRONT_ROOT . "Company/UpdateCompany" ?>" method="POST" class="bg-light-alpha p-5 border" enctype="multipart/form-data">
                        <div class="col-sm-10 offset-sm-1 text-center">
                            <strong><?php if(isset($message)){ echo $message;}?></strong>
                            <div class="form-group">
                                <label for="">Company Name</label>
                                <input type="text" name="name" class="form-control" value = "<?php echo $company->getName() ?>" required
                                       placeholder="Enter company name">
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label>Cuit</label>
                                    <input type="number" name="cuit" id="contactNo" required class="form-control"
                                           placeholder="Enter cuit" value="<?php echo $company->getCuit() ?>" aria-label="contactNo" aria-describedby="basic-addon2"
                                           maxlength="11" data-rule-minlength="11" data-rule-maxlength="11"
                                           oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')  ;">
                                </div>
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">Company Web URL</label>
                                    <input type="url" name="companyLink" class="form-control" value="<?php echo $company->getCompanyLink() ?>" required
                                           placeholder="Enter company web">
                                </div>
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">Email</label>
                                    <input type="email" name="email" class="form-control" value= "<?php echo $company->getEmail() ?>" required
                                           placeholder="Enter company email">
                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="countrylist">Current Location Country</label>
                                    <input list="listcountrys" name="country" id="countrylist" value="<?php echo $company->getCountry()->getName() ?>">
                                    <datalist id="listcountrys" required>
                                        <option selected value="<?php echo $company->getCountry()->getName() ?>"><?php echo $company->getCountry()->getName() ?></option>
                                        <?php
                                        foreach ($allCountrys as $value) {
                                            ?>
                                            <option value="<?php echo $value->getId() ?>"><?php echo $value->getName() ?></option>

                                            <?php

                                        }
                                        ?>
                                    </datalist>

                                </div>
                            </div>



                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">City</label>
                                    <input type="text" name="city" class="form-control" minlength="3" value="<?php echo $company->getCity()->getName()?>" required
                                           placeholder="Enter company City">
                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">Industry Area</label>
                                    <select name="industry" class="form-control" value="<?php echo $company->getIndustry()->getType() ?>"  required>
                                        <option selected><?php echo $company->getIndustry()->getType() ?></option>
                                        <?php
                                        foreach ($allIndustrys as $value)
                                        {
                                            ?>
                                            <option value="<?php echo $value->getType()?>"><?php echo $value->getType()?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <p>Condition</p>
                                    <?php if($company->getActive() == "true"){?>
                                        <label for="active">Active</label>
                                        <input type="radio" name="active" value="true" class="radioSize" required id="active" checked="checked">
                                        <label for="inactive">Inactive</label>
                                        <input type="radio" name="active" value="false" class="radioSize" required id="inactive">
                                    <?php }else
                                    {?>
                                        <label for="active">Active</label>
                                        <input type="radio" name="active" value="true" class="radioSize" required id="active" >
                                        <label for="inactive">Inactive</label>
                                        <input type="radio" name="active" value="false" class="radioSize" required id="inactive" checked="checked">
                                    <?php }?>

                                </div>
                            </div>

                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">Foundation Date</label>
                                    <input type="date" name="foundationDate" class="form-control" value="<?php echo $company->getFoundationDate() ?>"required
                                           placeholder="Enter company foundation date">
                                </div>
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">About Us</label>
                                    <p><textarea name="aboutUs" placeholder="Tell us something about your company..." class="form-control"><?php echo $company->getAboutUs() ?></textarea></p>
                                </div>
                            </div>
                            <div class="col-lg-15">
                                <div class="form-group">
                                    <label for="">Company Logo</label>
                                    <input type="file" name="image" class="form-control" value="<?php $company->getLogo() ?>" required placeholder="Enter a valid image">
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="id" value="<?php echo $company->getCompanyId() ?>">
                            </div>
                        </div>

                    </div>
            <button type="submit" name="button" class="btn btn-dark ml-auto d-block my-3 justify-content-center">Finish Edition</button>
                </form>
           </div>
        </div>
    </section>
</main>


<?php
include_once('footer.php');
?>