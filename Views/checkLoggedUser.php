<?php
$loggedUser=null;
if (isset($_SESSION['loggedstudent']))
{
    $loggedUser = $_SESSION['loggedstudent'];

}else if(isset($_SESSION['loggedadmin']))
{
    $loggedUser= $_SESSION['loggedadmin'];
}
else if($loggedUser==null)
{
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= 'home.php';</script>";

}

