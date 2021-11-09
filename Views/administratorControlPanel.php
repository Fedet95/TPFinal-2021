<?php
use Models\SessionHelper;
SessionHelper::checkAdminSession();
//require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h3 class="mb-3 text-center text-muted">Administrator <?php $loggedUser->getEmail()?></h3>
        </div>
    </section>


    <iframe  class="offset-lg-3" width="900" height="500" src="https://www.youtube.com/embed/pJo_fojED70" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>




</main>


<br><br><br><br><br><br>
<br><br><br><br><br><br>

<?php
include_once('footer.php');
?>
