<?php
$loggedUser=null;
if (isset($_SESSION['loggedstudent']))
{
    $loggedUser = $_SESSION['loggedstudent'];

}else if(isset($_SESSION['loggedadmin']))
{
    $loggedUser= $_SESSION['loggedadmin'];
}
else if(isset($_SESSION['loggedcompany'])){

    $loggedUser= $_SESSION['loggedcompany'];
}
else if($loggedUser==null)
{
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= 'Logout';</script>";

}

