<?php
use Models\SessionHelper;
SessionHelper::checkAdminSession();
//require_once(VIEWS_PATH . "checkLoggedAdmin.php");
include_once('header.php');
include_once('nav.php');
?>

<main class="">
    <section id="listado" class="mb-5">
        <div class="container">
            <h1 class=" text-center text-muted">Welcome!</h1>
        </div>
    </section>

    <p id="date"></p>
    <div id="clock">
        <p class="unit" id="hours"></p>
        <p class="unit" id="minutes"></p>
        <p class="unit" id="seconds"></p>
        <p class="unit" id="ampm"></p>
    </div>

    <script>
        var $dOut = $('#date'),
            $hOut = $('#hours'),
            $mOut = $('#minutes'),
            $sOut = $('#seconds'),
            $ampmOut = $('#ampm');
        var months = [
            'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
        ];

        var days = [
            'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'
        ];

        function update(){
            var date = new Date();

            var ampm = date.getHours() < 12
                ? 'AM'
                : 'PM';

            var hours = date.getHours() == 0
                ? 12
                : date.getHours() > 12
                    ? date.getHours() - 12
                    : date.getHours();

            var minutes = date.getMinutes() < 10
                ? '0' + date.getMinutes()
                : date.getMinutes();

            var seconds = date.getSeconds() < 10
                ? '0' + date.getSeconds()
                : date.getSeconds();

            var dayOfWeek = days[date.getDay()];
            var month = months[date.getMonth()];
            var day = date.getDate();
            var year = date.getFullYear();

            var dateString = dayOfWeek + ', ' + month + ' ' + day + ', ' + year;


            $dOut.text(dateString);
            $hOut.text(hours);
            $mOut.text(minutes);
            $sOut.text(seconds);
            $ampmOut.text(ampm);
        }

        update();
        window.setInterval(update, 1000);
    </script>



<br><br><br><br><br><br>



    <!-----------------------CARDD----------------------------->
   <?php if(isset($finalArray) && $finalArray!=null){

       $cantCompany=$finalArray['cantC'];
       $cantStudent=$finalArray['cantS'];
       $cantOffer=$finalArray['cantO'];
       ?>

    <div class="offset-lg-3">
        <br><br><br>
        <div class="row">
            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-blue">
                    <div class="inner">
                        <h3> <?php echo $cantStudent ?> </h3>
                        <h5>Registered Students </h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-green">
                    <div class="inner">
                        <h3>  <?php echo $cantCompany ?> </h3>
                        <h5>Registered Companies </h5>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card-box bg-orange">
                    <div class="inner">
                        <h3>  <?php echo $cantOffer ?></h3>
                        <h5>Registered Offers </h5>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php }?>

    <!-------------------------CARD--------------------------------->










































</main>


<br><br><br><br><br><br>
<br><br><br><br><br><br>

<?php
include_once('footer.php');
?>
