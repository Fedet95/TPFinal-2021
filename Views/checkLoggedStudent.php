<?php

if (isset($_SESSION['loggedstudent'])) {
    $loggedUser = $_SESSION['loggedstudent'];
} else {
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= 'Logout';</script>";
}
?>
