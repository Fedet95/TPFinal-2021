<?php
require_once(VIEWS_PATH."checkLoggedStudent.php");
include_once('header.php');
include_once('nav.php');
?>

<div class="ml-auto col-auto">
            <h3 class="text-center text-muted py-3">Companies List</h3>
            <div class="scrollable container-fluid">
                <div class="form-group">
                     <table>
                        <thead>
                        <tr>
                            <th>
                                <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"  enctype="multipart/form-data">
                                <input type="text" name="valueToSearch" placeholder="Company name to search" class="bg-light" required>
                                    <input type="submit" class="btn btn-dark ml-auto" name="search" value="Filter">
                                </form>
                            </th>
                            <th>
                                <form action="<?php echo FRONT_ROOT . "Company/showCompanyManagement" ?>" method="post"  enctype="multipart/form-data">
                                <input type="submit" class="btn btn-dark ml-auto" name="all" value="Show all companies" >
                                </form>
                            </th>
                        </tr>
                        </thead>
                     </table>
                </div>
                    <table class="table bg-light-alpha" style="text-align:center; ">
                        <thead>
                        <tr>
                            <th class="text-muted text-strong" style="width: 25%;">Name</th>
                            <th class="text-muted text-strong" style="width: 25%;">Industry</th>
                            <th class="text-muted text-strong" style="width: 30%;">Logo</th>
                            <th class="text-muted text-strong" style="width: 30%;">View More</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($searchedCompany as $valueCompany)
                            {
                                ?>
                            <tr>
                                <td><?php echo $valueCompany->getName() ?></td>
                                <td><?php echo $valueCompany->getIndustry()->getType() ?></td>
                                <td><?php echo '<img src="data:image;base64,' . $valueCompany->getLogo() . '" height="50" width="50"/>'; ?></td>
                                <td>
                                    <form action="<?php echo FRONT_ROOT . "Company/showCompanyViewMore" ?>" method="POST">
                                        <button type="submit" name="id" class="btn btn-dark ml-auto"
                                                value="<?php echo $valueCompany->getCompanyId() ?>"> View More
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

<br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include_once('footer.php');
?>
