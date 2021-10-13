<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container text-center">
            <h2 class="mb-4">Create Company</h2>
            <?php if(isset($message)){ echo $message;}?>
            <form action="<?php echo FRONT_ROOT . "Company/addCompany" ?>" method="POST" class="bg-light-alpha p-5" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label for="">Company name</label>
                            <input type="text" name="name" class="form-control" required
                                   placeholder="Enter company name">
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label>Cuit</label>
                                <input type="number" name="cuit" id="contactNo" required class="form-control"
                                       placeholder="Enter cuit" aria-label="contactNo" aria-describedby="basic-addon2"
                                       maxlength="11" data-rule-minlength="11" data-rule-maxlength="11"
                                       oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength); this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')  ;">
                            </div>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Company Web URL</label>
                                <input type="url" name="companyLink" class="form-control" required
                                       placeholder="Enter company web">
                            </div>
                        </div>

                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Nacionality</label>
                                <select name="nacionality" class="form-control"  required>
                                    <option disabled selected>Select country of origin</option>
                                    <?php
                                    foreach ($allCountrys as $value)
                                    {
                                        ?>
                                        <option value="<?php echo $value->getName()?>"><?php echo $value->getName()?></option>
                                        <?php
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="email" name="email" class="form-control" required
                                       placeholder="Enter company email">
                            </div>
                        </div>

                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Current Location Country</label>
                                <select name="country" class="form-control"  required>
                                   <option disabled selected>Select country</option>
                                    <?php
                                    foreach ($allCountrys as $value)
                                    {
                                            ?>
                                            <option value="<?php echo $value->getName()?>"><?php echo $value->getName()?></option>

                                            <?php

                                    }
                                    ?>
                                </select>

                            </div>
                        </div>

                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">City</label>
                                <input type="text" name="city" class="form-control" minlength="3" required
                                       placeholder="Enter company City">
                            </div>
                        </div>

                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Industry Area</label>
                                <select name="industry" class="form-control"  required>
                                    <option disabled selected>Select industry area</option>
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
                                <label for="active">Active</label>
                                <input type="radio" name="active" value="true" class="radioSize" required id="active">
                                <label for="inactive">Inactive</label>
                                <input type="radio" name="active" value="false" class="radioSize" required id="inactive">
                            </div>
                        </div>

                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Foundation Date</label>
                                <input type="date" name="foundationDate" class="form-control" required
                                       placeholder="Enter company foundation date">
                            </div>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">About Us</label>
                                <p><textarea name="aboutUs" placeholder="Tell us something about your company..." class="form-control"></textarea></p>
                            </div>
                        </div>
                        <div class="col-lg-15">
                            <div class="form-group">
                                <label for="">Company Logo</label>
                                <input type="file" name="image" class="form-control" required placeholder="Enter a valid image">
                            </div>
                        </div>

                    </div>

                </div>

                <!--
                                              <div class="form-group">
                                                   <label for="">Fecha</label>
                                                   <input type="date" name="date" class="form-control" required>
                                              </div>
                                         </div>
                                         <div class="col-lg-3">
                                              <div class="form-group">
                                                   <p>Tipo</p>
                                                   <input type="radio" name="type" value="A" class="radioSize" required>Factura A
                                                   <input type="radio" name="type" value="B" class="radioSize" required>Factura B
                                              </div>
                                         </div>

                                         <div class="col-lg-3">
                                              <div class="form-group">
                                                   <label for="">Numero</label>
                                                   <input type="number" name="number" class="form-control" min="0"  minlength="4" required>
                                              </div>
                                         </div>
                                    </div>
                                    -->


                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
            </form>
        </div>
    </section>
</main>

// private $companyId; //auto_increment


private $logo;


<?php
include_once('footer.php');
?>
