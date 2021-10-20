<?php
include('header.php');
?>

<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h2>UTN's Job Search</h2>
        </header>

        <form action="<?php echo FRONT_ROOT."Home/login"?>" method="POST" class="login-form bg-light-alpha p-5 text-center">
            <?php if(isset($message)){ echo $message;}?>
            <div class="form-group">
                <label for="" >Username</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
            </div>
            <button class="btn btn-dark btn-block btn-lg" type="submit">LOGIN</button>
        </form>
    </div>
</main>


<?php
include('footer.php')
?>
