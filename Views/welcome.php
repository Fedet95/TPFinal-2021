<?php
include('header.php');
?>
<main class="py-lg-5">
    <section id="hero" class="d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h1>UTN's Job Search</h1>
                    <h2 class="text-muted">Find your dream job here</h2>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="Views/img/hero-img.png" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>
    </section><!-- End Hero -->

<br>
    <div class="container align-items-center justify-content-center">
        <div class="row">
            <div class="col-lg-12 d-flex justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                <form action="<?php echo FRONT_ROOT."Home/welcome"?>" method="POST" class="login-form bg-light-alpha p-5 text-white border">
                    <button class="btn btn-dark btn-block btn-lg" type="submit">ENTER</button>
                </form>
            </div>
        </div>
    </div>

</main>
<br><br><br><br><br>

<?php
include('footer.php')
?>

