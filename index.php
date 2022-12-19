<?php
include "includes/config.php";
session_start();

if (isset($_SESSION["user_email"])) {
  header("Location: todos.php");
  die();
}
?>

<!doctype html>
<html lang="en">

<head>
  <?php getHead(); ?>
</head>

<body>



  <!--  -->

  <section class="vh-100">
    <div class="container py-5 h-100">
      <div class="row d-flex align-items-center justify-content-center h-100">
        <div class="col-md-8 col-lg-7 col-xl-6">
          <h1 class="display-4 fw-bold lh-1 mb-3">Regístrese para almacenar sus todos</h1>
          <p class="col-lg-10 fs-4">Crea tu cuenta gratuita para administrar tus tareas.</p>
        </div>
        <div class="col-md-7 col-lg-5 col-xl-5 offset-xl-1">
          <form action="login.php" method="POST">
            <!-- Email input -->
            <div class="form-outline mb-4">
              <input type="email" name="email" id="floatingInput" class="form-control form-control-lg" placeholder="name@example.com" />
              <label class="form-label" for="floatingInput">Correo electrónico</label>
            </div>

            <!-- Password input -->
            <div class="form-outline mb-4">
              <input type="password" name="password" id="floatingPassword" class="form-control form-control-lg" placeholder="Contraseña" />
              <label class="form-label" for="floatingPassword">Contraseña</label>
            </div>

            <!-- Submit button -->
            <button name="submit" type="submit" class="btn btn-primary btn-lg btn-block">Continuar</button>

            <hr class="my-4">

            <small class="text-muted">Al hacer clic en Registrarse, acepta los términos de uso.</small>


          </form>
        </div>
      </div>
    </div>
  </section>

  <!--  -->

  <!-- MDB -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.js"></script>

</body>

</html>