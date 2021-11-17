<?php

if (isset($_SESSION['loggedcompany'])) {
    $loggedUser = $_SESSION['loggedcompany'];
} else {
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= 'Logout';</script>";
}
?>
