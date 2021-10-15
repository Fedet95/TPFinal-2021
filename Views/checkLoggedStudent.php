<?php

if (isset($_SESSION['loggedstudent'])) {
    $loggedstudent = $_SESSION['loggedstudent'];
} else {
    echo "<script>alert('Error, your session time has expired, please login again');";
    echo "window.location= 'home.php';</script>";
}
?>
