<?php
//include ('Process/check-LoggedUser.php'); //lo coloco aca porque es donde se necesitara siempre (para no tener que cargarlo en cada nueva pagina php)
?>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
     <span class="navbar-text">
          Welcome <strong>   </strong> <!-- Esto va dentro del strong <?php echo $client->getUserName()?>-->
     </span>
     <ul class="navbar-nav ml-auto">
          <li class="nav-item">
               <a class="nav-link" href="#">Escribir algo</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="#">Escribir algo</a>
          </li>
          <li class="nav-item">
               <a class="nav-link" href="#">Cerrar sesión</a>
          </li>
     </ul>
</nav>
