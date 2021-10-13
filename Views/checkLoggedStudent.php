<?php

if (isset($_SESSION['loggedstudent'])) {
    $loggedstudent = $_SESSION['loggedstudent'];
} else {
    echo "<script>alert('Error, su sesion ha expirado, ingrese nuevamente');";
    echo "window.location= 'home.php';</script>";
}
?>
