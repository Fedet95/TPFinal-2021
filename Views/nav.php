<?php
use Models\User;

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
    <img style="max-width:60px; margin-top: -7px;" src="../Views/img/utn-128x128.png">
    <a class="navbar-brand" href="#">Welcome</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <?php
                if($loggedUser->getRol()->getUserRolId()==1)
                {
                    ?>
                    <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showAdministratorControlPanelView"?>">Home</a>
                    <?php
                }
                else if($loggedUser->getRol()->getUserRolId()==2)
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
                    if($loggedUser->getRol()->getUserRolId()==1)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCreateCompanyView"?>">Add Company</a>
                        <?php
                    }
                    else if($loggedUser->getRol()->getUserRolId()==2)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>">Companies</a>
                        <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php
                    if($loggedUser->getRol()->getUserRolId()==1)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>">Company Management</a>
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
                    if($loggedUser->getRol()->getUserRolId()==1)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showCreateJobOfferView"?>">Add Job Offer</a>
                        <?php
                    }
                    else if($loggedUser->getRol()->getUserRolId()==2)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showJobOfferManagementView"?>">Search Job Offers</a>
                        <?php
                    }
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php
                    if($loggedUser->getRol()->getUserRolId()==1)
                    {
                        ?>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showJobOfferManagementView"?>">Job Offers Management</a>
                        <a class="dropdown-item" href="<?php echo  FRONT_ROOT."Job/showJobPositionManagement"?>">Job Position List</a>


                        <?php
                    }
                    else if($loggedUser->getRol()->getUserRolId()==2)
                    {
                        ?>
                        <!--<a class="dropdown-item" href="#">View Our Portfolio</a>-->
                        <?php
                    }
                    ?>
            </li class="nav-item active">
            <?php
            if($loggedUser->getRol()->getUserRolId()==1)
            {
                ?>
                <a class="nav-link" href="<?php echo  FRONT_ROOT."User/showStudentListView"?>">Students</a>
                <a class="nav-link" href="<?php echo  FRONT_ROOT."User/showAdminListView"?>">Administrators</a>

                <?php
            }
            else if($loggedUser->getRol()->getUserRolId()==2)
            {
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showContactUsView"?>">Contact us</a>
                </li>
                <?php
            }
            ?>
            </li class="nav-item active">
            <?php
            if($loggedUser->getRol()->getUserRolId()==2)
            {
                ?>
                <a class="nav-link" href="<?php echo  FRONT_ROOT."Appointment/showAppointmentList"?>">Appointments</a>
                <?php
            }
            else if($loggedUser->getRol()->getUserRolId()==1)
            {
            ?>
                ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo  FRONT_ROOT."Appointment/showAppointmentManagementView"?>">Appointments</a>
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
