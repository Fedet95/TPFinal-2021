<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>

          <div class="ml-auto col-auto">
            <h3 class=" text-center text-muted">Company's List</h3>
            <div class="scrollable container-fluid" >
                <div class="form-group">
                     <table>
                        <thead>
                        <tr>
                            <th>
                                <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"  enctype="multipart/form-data">
                                <input type="text" name="valueToSearch" placeholder="Company To Search">
                                    <input type="submit" class="btn" name="search" value="Filter">
                                </form>
                            </th>
                            <th>
                                <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"  enctype="multipart/form-data">
                                <input type="submit" class="btn" name="all" value="Show all companys" >
                                </form>
                            </th>
                        </tr>
                        </thead>
                     </table>
                </div>
                    <table class="table bg bg-light-alpha" style="text-align:center;">
                        <thead>
                        <tr>
                            <th style="width: 30%;">ID</th>
                            <th style="width: 30%;">Name</th>
                            <th style="width: 30%;">Nacionality</th>
                            <th style="width: 30%;">Foundation Date</th>
                            <th style="width: 30%;">Cuit</th>
                            <th style="width: 50%;">About Us</th>
                            <th style="width: 30%;">Company Link</th>
                            <th style="width: 30%;">Email</th>
                            <th style="width: 30%;">Country</th>
                            <th style="width: 30%;">City</th>
                            <th style="width: 30%;">Active</th>
                            <th style="width: 30%;">Logo</th>
                            <th style="width: 30%;">Remove</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchedCompany as $valueCompany)
                            {
                                ?>
                            <tr>
                                <td><?php echo $valueCompany->getCompanyId() ?></td>
                                <td><?php echo $valueCompany->getName() ?></td>
                                <td><?php echo $valueCompany->getNacionality() ?></td>
                                <td><?php echo $valueCompany->getFoundationDate() ?></td>
                                <td><?php echo $valueCompany->getCuit() ?></td>
                                <td><?php echo $valueCompany->getAboutUs() ?></td>
                                <td><?php echo $valueCompany->getCompanyLink() ?></td>
                                <td><?php echo $valueCompany->getEmail() ?></td>
                                <td><?php echo $valueCompany->getCountry() ?></td>
                                <td><?php echo $valueCompany->getCity() ?></td>
                                <td><?php echo $valueCompany->getActive() ?></td>
                                <td><?php echo '<img src="data:image;base64,' . $valueCompany->getLogo() . '" height="50" width="50"/>'; ?></td>

                                <td>
                                    <form action="<?php echo FRONT_ROOT . "Company/Remove" ?>" method="POST">
                                        <button type="submit" name="id" class="btn"
                                                value="<?php echo $valueCompany->getCompanyId() ?>"> Remove
                                        </button>
                                    </form>
                                </td>

                                <td>
                                    <form action="<?php echo FRONT_ROOT . "Company/Edit" ?>" method="POST">
                                        <button type="submit" name="id" class="btn"
                                                value="<?php echo $valueCompany->getCompanyId() ?>"> Edit
                                        </button>
                                    </form>
                                </td>
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

<?php
include('footer.php');
?>
