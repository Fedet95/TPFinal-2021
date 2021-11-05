<?php
include('header.php');
?>


    <table class=" offset-5 align-items-center justify-content-center">
        <tr>
            <td>
                <section id="hero" class="d-flex align-items-center">
                    <div class="container">
                        <div class="row">
                            <div class="hero-img" data-aos="zoom-in" data-aos-delay="190">
                                <img src="../Views/img/rsz_1login.png"   width="280" height="180" class="img-fluid animated" alt="">
                            </div>
                        </div>
                    </div>
                </section><!-- End Hero -->
            </td>
        </tr>
        <tr>
            <td>
                <main class="d-flex align-items-center justify-content-center height-100">
                    <div class="content">
                        <header class="text-center">
                            <h1 class="text-muted">Welcome</h1>
                        </header>
                        <div class="container bg-light-alpha border py-4 my-5">
                            <table>
                                <tbody class="flex">
                                <tr>
                                    <th>
                                        <form action="<?php echo FRONT_ROOT."Home/login"?>" method="POST" class="py-3 text-center">
                                            <?php if(isset($message)){ echo $message;}?>
                                            <div class="form-group">
                                                <label for="" >Username</label>
                                                <br>
                                                <input type="email" name="email" class="form-control-lg " placeholder="Enter your email" required>
                                                <br><br>
                                                <label for="" >Password</label>
                                                <br>
                                                <input type="password" name="password" class="form-control-lg " placeholder="Enter your password" required>
                                            </div>
                                            <button class="btn btn-dark btn-block btn-lg" type="submit">LOGIN</button>
                                        </form>
                                        <form action="<?php echo FRONT_ROOT."Home/showSignUpView"?>" method="POST" class="py-3 text-center">
                                            <button class="btn btn-dark btn-block btn-lg" type="submit">SIGN UP</button>
                                        </form>
                                        <br>
                                        <form action="<?php echo FRONT_ROOT."Home/Index" ?>" method="POST"
                                              class="py-3 text-center">
                                            <input type="submit" value="BACK" class="btn btn-dark ">
                                        </form>
                                        <!--
                                        <form class=" text-center">
                                            <input type="button" value="BACK" class="btn btn-dark " onclick="history.back()">
                                        </form>
                                        -->

                                    </th>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </main>
            </td>
        </tr>
    </table>




<?php
include('footer.php')
?>