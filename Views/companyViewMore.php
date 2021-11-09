<?php
require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<?php if(!isset($remove)){?>
<div class="ml-auto col-auto">
    <section class="bg-light-alpha section-gap"  id="join">
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="menu-content col-lg-9">
                    <div class="title text-center">
                        <h1 class="mb-10 text-muted"><?php echo $company->getName()?></h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
   <br><br>
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
                <td><a href="#" target="_blank" rel="noopener noreferrer"><?php echo $company->getCompanyLink() ?></a></td>
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

<br><br><br><br><br><br>
    <br><br><br><br><br><br>
<?php }?>

<?php
include('footer.php');
?>


