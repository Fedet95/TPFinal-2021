<?php
include('header.php');
?>

<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h2>Welcome</h2>
        </header>
        <form action="<?php echo FRONT_ROOT."Home/login"?>" method="POST" class="login-form bg-dark-alpha p-5 text-white">
            <div class="form-group">
                <label for="">Username</label>
                <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
            </div>
            <button class="btn btn-dark btn-block btn-lg" type="submit">LOGUIN</button>
        </form>
    </div>
</main>


<?php
include('footer.php')
?>
