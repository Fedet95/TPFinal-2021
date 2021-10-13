<?php
//include ('Process/check-LoggedUser.php'); //lo coloco aca porque es donde se necesitara siempre (para no tener que cargarlo en cada nueva pagina php)
?>

<nav class="navbar navbar-expand-lg  navbar-dark bg-dark">
     <span class="navbar-text">
          Welcome <strong> hola  </strong>
     </span>
     <ul class="navbar-nav ml-auto">
         <li class="nav-item">
             <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/showAdministratorControlPanelView"?>">Control Panel</a>
         </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo  FRONT_ROOT."Company/showCreateCompanyView"?>">Add Company</a>
          </li>
         <li class="nav-item">
             <a class="nav-link" href="<?php echo  FRONT_ROOT."Company/showCompanyManagement"?>">Company Management</a>
         </li>
          <li class="nav-item">
               <a class="nav-link" href="<?php echo  FRONT_ROOT."Home/Logout"?>">Logout</a>
          </li>
     </ul>
</nav>
