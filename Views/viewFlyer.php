<?php
use Models\SessionHelper;
SessionHelper::checkUserSession();

//$file = 'uploads/'.$flyer;
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container align-items-center justify-content-center offset-4">


               <?php
                    if(isset($flyer))
                    {
                        ?>
                        <img><?php echo '<img src="../uploads/' . $flyer . '" height="858" width="658"/>'; ?>
                        <?php
                    }
               ?>
          </div>

         <div class="post-details2  mb-50">
             <ul>
                 <form action="<?php echo FRONT_ROOT . "Job/showJobOfferManagementView" ?>"
                       method="POST">
                     <br><br>
                     <button type="submit" name="id" class="btn buttonPer  d-block offset-6">Return
                     </button>
                 </form>
             </ul>

         </div>
     </section>
</main>