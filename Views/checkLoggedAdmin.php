<?php

if (isset($_SESSION['loggedadmin']))
{
    $loggedadmin = $_SESSION['loggedadmin'];
} else
{
    echo "<script>alert('Error, su sesion ha expirado, ingrese nuevamente');";
    echo "window.location= 'home.php';</script>";
}
?>
