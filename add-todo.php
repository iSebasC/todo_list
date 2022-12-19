<?php
include "includes/config.php";
session_start();
if (!isset($_SESSION["user_email"])) {
  header("Location: index.php");
  die();
}

$msg = "";

if (isset($_POST["addTodo"])) {
  $title = mysqli_real_escape_string($conn, $_POST["title"]);
  $desc = mysqli_real_escape_string($conn, $_POST["desc"]);

  // Get User Id based on user email
  $sql = "SELECT id FROM users WHERE email='{$_SESSION["user_email"]}'";
  $res = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($res);
  if ($count > 0) {
    $row = mysqli_fetch_assoc($res);
    $user_id = $row["id"];
  } else {
    $user_id = 0;
  }
  $sql = null;

  // Inserting todo
  $sql = "INSERT INTO todos (title, description, user_id) VALUES ('$title', '$desc', '$user_id')";
  $res = mysqli_query($conn, $sql);
  if ($res) {
    $_POST["title"] = "";
    $_POST["desc"] = "";
    $msg = "
    
    <script>
      Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Se agrego correctamente',
        showConfirmButton: false,
        timer: 1500
      })
    </script>

    ";  
  } else {
    $msg = "
    
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Todo no se crea',
        showConfirmButton: false,
        timer: 1500
      })
    </script>

  ";
  }
}

?>


<!doctype html>
<html lang="en">

<head>

  <?php getHead(); ?>
  
</head>

<body class="bg-light">
  <?php getHeader(); ?>

  <div class="container py-5">
    <div class="row">
      <div class="col-md-5 mx-auto">


        <div class="card">
          <h5 class="card-header info-color white-text text-center py-4">
            <strong>Nueva Nota</strong>
          </h5>

          <div class="card-body px-lg-5 pt-4">
            <?php echo $msg; ?>
            <form action="" method="POST">

              <div class="mb-3">
                <label for="title" class="form-label">Titulo</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="e.g. Create a PHP program" value="<?php if (isset($_POST["addTodo"])) {
                                                                                                                                  echo $_POST["title"];
                                                                                                                                } ?>" required>
              </div>

              <div class="mb-3">
                <label for="desc" class="form-label">Descripción</label>
                <textarea class="form-control" id="desc" name="desc" rows="3" required><?php if (isset($_POST["addTodo"])) {
                                                                                          echo $_POST["title"];
                                                                                        } ?></textarea>
              </div>
              <div>
                <button type="submit" name="addTodo" class="btn btn-primary me-2">Agregar</button>
                <button type="reset" class="btn btn-danger">Resetear</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>

  <!-- JS -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>



</body>

</html>