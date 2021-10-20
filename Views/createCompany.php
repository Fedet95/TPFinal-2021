<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>

<main class="py-5">
    <section id="listado">
        <div class="container">
            <h2 class="mb-4 text-center text-muted">Create Company</h2>
           <div class="row justify-content-center">
               <form action="<?php echo FRONT_ROOT . "Company/addCompany" ?>" method="POST" class="bg-light-alpha p-5 border"
                     enctype="multipart/form-data">
                       <div class="col-sm-10 offset-sm-1 text-center">
                           <strong><?php if(isset($message)){ echo $message;}?></strong>
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
                                   <label for="">Email</label>
                                   <input type="email" name="email" class="form-control" required
                                          placeholder="Enter company email">
                               </div>
                           </div>

                           <div class="col-lg-15">
                               <div class="form-group">
                                   <label for="">Current Location Country</label>
                                   <select name="country" class="form-control" required>
                                       <option disabled selected>Select country</option>
                                       <?php
                                       foreach ($allCountrys as $value) {
                                           ?>
                                           <option value="<?php echo $value->getId() ?>"><?php echo $value->getName() ?></option>

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
                                   <select name="industry" class="form-control" required>
                                       <option disabled selected>Select industry area</option>
                                       <?php
                                       foreach ($allIndustrys as $value) {
                                           ?>
                                           <option value="<?php echo $value->getId() ?>"><?php echo $value->getType() ?></option>
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
                                   <input type="radio" name="active" value="false" class="radioSize" required
                                          id="inactive">
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
                                   <p><textarea name="aboutUs" placeholder="Tell us something about your company..."
                                                class="form-control"></textarea></p>
                               </div>
                           </div>
                           <div class="col-lg-15">
                               <div class="form-group">
                                   <label for="">Company Logo</label>
                                   <input type="file" name="image" class="form-control" required
                                          placeholder="Enter a valid image">
                               </div>
                           </div>

                       </div>

                   <button type="submit" name="button" class="btn btn-dark ml-auto d-block my-3 justify-content-center">Agregar</button>
               </form>
           </div>
        </div>
    </section>
</main>

<?php
include_once('footer.php');
?>
