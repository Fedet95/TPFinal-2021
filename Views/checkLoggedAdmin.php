<?php

if (isset($_SESSION['loggedadmin']))
{
    $loggedadmin = $_SESSION['loggedadmin'];
} else
{
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= 'home.php';</script>";
}
?>
