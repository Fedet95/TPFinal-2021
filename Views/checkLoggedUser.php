<?php
$loggedUser=null;

if (isset($_SESSION['loggedstudent']))
{
    $loggedUser = $_SESSION['loggedstudent'];
    var_dump($loggedUser);

}else if(isset($_SESSION['loggedadmin']))
{
    $loggedUser= $_SESSION['loggedadmin'];
    var_dump($loggedUser);
}
else if(isset($_SESSION['loggedcompany'])){

    $loggedUser= $_SESSION['loggedcompany'];
    var_dump($loggedUser);
}
else if($loggedUser==null)
{
    var_dump($loggedUser);
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= '../Home/Logout';</script>";



}

