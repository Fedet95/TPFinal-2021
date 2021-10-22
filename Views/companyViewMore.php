<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>
<div class="ml-auto col-auto">
    <h3 class=" text-center text-muted py-3"> <td><?php echo $company->getName()?></td></h3>
    <div class="scrollable container-fluid">
        <table class="table bg bg-light-alpha border" style="text-align:center;">
            <thead>
            <tr>
                <!--<th class="text-muted text-strong" style="width: 30%;">ID</th>-->
                <!-- <th class="text-muted text-strong" style="width: 30%;">Name</th>-->
                <!--<th class="text-muted text-strong" style="width: 30%;">Industry</th>-->
                <th  class="text-muted text-strong" style="width: 15%;">Foundation Date</th>
                <th class="text-muted text-strong" style="width: 15%;">Cuit</th>
                <th class="text-muted text-strong" style="width: 15%;">About Us</th>
                <th class="text-muted text-strong" style="width: 15%;">Company Link</th>
                <th class="text-muted text-strong" style="width: 15%;">Email</th>
                <th class="text-muted text-strong" style="width: 15%;">Country</th>
                <th class="text-muted text-strong" style="width: 15%;">City</th>
                <th class="text-muted text-strong" style="width: 15%;">Active</th>
              <!--  <th class="text-muted text-strong" style="width: 30%;">Logo</th>-->
                <th class="text-muted text-strong" style="width: 15%;">Remove</th>
                <th class="text-muted text-strong" style="width: 15%;">Edit</th>
                <th class="text-muted text-strong" style="width: 15%;">Back</th>

            </tr>
            </thead>
            <tbody>
            <tr>
                <!-- <td><?php echo $company->getCompanyId() ?></td>-->
               <!-- <td><?php echo $company->getName() ?></td>-->
                <!--<td><?php echo $company->getIndustry()->getType() ?></td>-->
                <td><?php echo $company->getFoundationDate() ?></td>
                <td><?php echo $company->getCuit() ?></td>
                <td><?php echo $company->getAboutUs() ?></td>
                <td><?php echo $company->getCompanyLink() ?></td>
                <td><?php echo $company->getEmail() ?></td>
                <td><?php echo $company->getCountry()->getName() ?></td>
                <td><?php echo $company->getCity()->getName() ?></td>
                <td><?php echo $company->getActive() ?></td>
                <!--<td><?php echo '<img src="data:image;base64,' . $company->getLogo() . '" height="50" width="50"/>'; ?></td>-->

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
<?php
include('footer.php');
?>



