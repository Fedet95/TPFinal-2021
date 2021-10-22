<?php
include('header.php');
?>

<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h1 class="text-muted">Welcome</h1>
        </header>

        <div class="container bg-light-alpha border py-lg-4">
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
                      </div>
                      <button class="btn btn-dark btn-block btn-lg" type="submit">LOGIN</button>
                  </form>
                  <form class=" text-center">
                      <input type="button" value="BACK" class="btn btn-dark " onclick="history.back()">
                  </form>
                  <!--
                  <form action="<?php echo FRONT_ROOT."Home/Index" ?>" method="post" class=" text-center">
                      <button type="submit" class="btn btn-dark ">BACK</button>
                  </form>
                  -->
              </th>
          </tbody>
      </table>
    </div>
    </div>
</main>

<?php
include('footer.php')
?>