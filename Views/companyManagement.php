<?php
include_once('header.php');
include_once('nav-admin.php');
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
?>
<div class="wrapper row4">
    <main class="container">
        <!-- main body -->
        <div class="container">
            <div class="scrollable">
                <form action="<?php echo FRONT_ROOT . "Company/Remove" ?>" method="post" class="bg-light-alpha p-5" enctype="multipart/form-data">
                    <table style="text-align:center;">
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

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($allCompanys as $company) {
                            ?>
                            <tr>
                                <td><?php echo $company->getCompanyId() ?></td>
                                <td><?php echo $company->getName() ?></td>
                                <td><?php echo $company->getNacionality() ?></td>
                                <td><?php echo $company->getFoundationDate() ?></td>
                                <td><?php echo $company->getCuit() ?></td>
                                <td><?php echo $company->getAboutUs() ?></td>
                                <td><?php echo $company->getCompanyLink() ?></td>
                                <td><?php echo $company->getEmail() ?></td>
                                <td><?php echo $company->getCountry() ?></td>
                                <td><?php echo $company->getCity() ?></td>
                                <td><?php echo $company->getActive() ?></td>
                                <td><?php echo '<img src="data:image;base64,' . $company->getLogo() . '" height="50" width="50"/>'; ?></td>

                                <td>
                                    <button type="submit" name="id" class="btn"
                                            value="<?php echo $company->getCompanyId() ?>"> Remove
                                    </button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
        <!-- / main body -->
        <div class="clear"></div>
    </main>
</div>

<?php
include('footer.php');
?>
