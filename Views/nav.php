<?php
//require_once(VIEWS_PATH . "checkLoggedUser.php");
use Models\Administrator;
use Models\Student;

$loggedUser=null;
if (isset($_SESSION['loggedstudent']))
{
    $loggedUser = $_SESSION['loggedstudent'];

}else if(isset($_SESSION['loggedadmin']))
{
    $loggedUser= $_SESSION['loggedadmin'];
}

?>


<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <img style="max-width:30px; margin-top: -7px;" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQXmuQnI6IpPLYNsDQK5TOfvDOK2sTEfFZ1wRdxVQzlhUwkXikpEKfvvdGZ-2gr0RtewYg&usqp=CAU">
    <a class="navbar-brand" href="#">Welcome</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <?php
                if($loggedUser instanceof Administrator)
                {
                    ?>
                    <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showAdministratorControlPanelView"?>">Home</a>
                    <?php
                }
                else if($loggedUser instanceof Student)
                {
                    ?>
                    <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showStudentControlPanelView"?>">Home</a>
                    <?php
                }
                ?>

            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    Company Services
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if($loggedUser instanceof Administrator)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCreateCompanyView"?>">Add Company</a>
                        <?php
                    }
                    else if($loggedUser instanceof Student)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>">Companies</a>
                        <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php
                    if($loggedUser instanceof Administrator)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>">Company Management</a>
                        <?php
                    }
                    else if($loggedUser instanceof Student)
                    {
                        ?>
                        <a class="dropdown-item" href="#">View Our Portfolio</a>
                        <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php
                    if($loggedUser instanceof Administrator)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Student/showStudentListView"?>">Student List</a>
                        <?php
                    }
                        ?>
                </div>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                    Job Offers
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if($loggedUser instanceof Administrator)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showCreateJobOfferView"?>">Add Job Offer</a>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showCreateJobPositionView"?>">Add Job Position</a>
                        <?php
                    }
                    else if($loggedUser instanceof Student)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showJobOfferManagementView"?>">Job Offers Management</a>
                        <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php
                    if($loggedUser instanceof Administrator)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showJobOfferManagementView"?>">Job Offers Management</a>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showJobPositionManagement"?>">Job Position Managment</a>
                        <?php
                    }
                    else if($loggedUser instanceof Student)
                    {
                        ?>
                        <a class="dropdown-item" href="#">View Our Portfolio</a>
                        <?php
                    }
                    ?>
            </li class="nav-item active">
            <?php
            if($loggedUser instanceof Administrator)
            {
                ?>
                <a class="nav-link" href="<?php echo  FRONT_ROOT."Student/showStudentListView"?>">Students</a>
                <a class="nav-link" href="<?php echo  FRONT_ROOT."Admin/showAdminListView"?>">Administrators</a>

                <?php
            }
            else if($loggedUser instanceof Student)
            {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <?php
            }
            ?>
            <li class="nav-item">
                <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/Logout"?>">Logout</a>
            </li>
        </ul>
    </div>
</nav>
