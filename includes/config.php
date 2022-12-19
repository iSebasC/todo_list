<?php

/* ====================================================== */
/* Database connection function */
/* ====================================================== */
function dbConnect()
{
  $hostname = "localhost";
  $username = "root";
  $password = "";
  $database = "todo_list_app";

  $conn = mysqli_connect($hostname, $username, $password, $database) or die("Database connection failed.");
  return $conn;
}

$conn = dbConnect();

/* ====================================================== */
/* Check email is valid or not function */
/* ====================================================== */

function emailIsValid($email)
{
  $conn = dbConnect();
  $sql = "SELECT email FROM users WHERE email='$email'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  if ($count > 0) {
    return true;
  } else {
    return false;
  }
}


/* ====================================================== */
/* Check login details is valid or not function */
/* ====================================================== */

function checkLoginDetails($email, $password)
{
  $conn = dbConnect();
  $sql = "SELECT email FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  if ($count > 0) {
    return true;
  } else {
    return false;
  }
}


/* ====================================================== */
/* Create user function */
/* ====================================================== */

function createUser($email, $password)
{
  $conn = dbConnect();
  $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
  $result = mysqli_query($conn, $sql);
  return $result;
}


/* ====================================================== */
/* Get Head function */
/* ====================================================== */

function getHead()
{
  $pageTitle = dynamicTitle();
  $output = '<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- Google Fonts -->
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
      rel="stylesheet"
    />
    <!-- MDB -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.0.1/mdb.min.css"
      rel="stylesheet"
    />

    <!-- ico -->
    <link rel="icon" type="image/x-icon" href="assets/img/icon_s.ico">

    <!-- Style -->
    <link rel="stylesheet" href="assets/style/style.css">

    <!-- Sweatalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>' . $pageTitle . ' - Sebastian C</title>';

  echo $output;
}


/* ====================================================== */
/* Get Header function */
/* ====================================================== */

function getHeader()
{
  $output = '<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <!-- Container wrapper -->
  <div class="container">
    <!-- Navbar brand -->
    <a class="navbar-brand me-2 text-primary fw-bold" href="https://sebastiancabrera.netlify.app/">
      /SC/
    </a>

    <!-- Toggle button -->
    <button
      class="navbar-toggler"
      type="button"
      data-mdb-toggle="collapse"
      data-mdb-target="#navbarButtonsExample"
      aria-controls="navbarButtonsExample"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <i class="fas fa-bars"></i>
    </button>

    <!-- Collapsible wrapper -->
    <div class="collapse navbar-collapse" id="navbarButtonsExample">
      <!-- Left links -->
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="todos.php">Dashboard</a>
        </li>
      </ul>
      <!-- Left links -->

      <div class="d-flex align-items-center">
        <a href="todos.php" class="btn btn-link px-3 me-2">
          Inicio
        </a>
          <a href="add-todo.php" class="btn btn-primary me-3">Agregar Nota</a>
          <a href="logout.php" class="btn btn-danger me-3">Cerrar Sesión</a>
          <a
            class="btn btn-dark px-3"
            href="https://github.com/iSebasC"
            role="button" target="_blank"
            ><i class="fab fa-github"></i
          ></a>
      </div>
    </div>
    <!-- Collapsible wrapper -->
  </div>
  <!-- Container wrapper -->
</nav>';

  echo $output;
}


/* ====================================================== */
/* Text Limit function */
/* ====================================================== */

function textLimit($string, $limit)
{
  if (strlen($string) > $limit) {
    return substr($string, 0, $limit) . "...";
  } else {
    return $string;
  }
}



/* ====================================================== */
/* Get Todo function */
/* ====================================================== */

function getTodo($todo)
{
  $output = '<div class="card">
        <div class="card-body">
            <h4 class="card-title">' . textLimit($todo['title'], 28) . '</h4>
            <p class="card-text">' . textLimit($todo['description'], 75) . '</p>
            <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group btn-group-sm" role="group">
                    <a href="view-todo.php?id=' . $todo['id'] . '" class="btn btn-dark">View</a>
                    <a href="edit-todo.php?id=' . $todo['id'] . '" class="btn btn-dark">Edit</a>
                </div>
                <small class="text-muted">' . $todo['date'] . '</small>
            </div>
        </div>
    </div>';

  echo $output;
}



/* ====================================================== */
/* Dynamic Title function */
/* ====================================================== */

function dynamicTitle()
{
  global $conn;
  $filename = basename($_SERVER["PHP_SELF"]);
  $pageTitle = "";
  switch ($filename) {
    case 'index.php':
      $pageTitle = "Home";
      break;

    case 'todos.php':
      $pageTitle = "Todo List";
      break;

    case 'add-todo.php':
      $pageTitle = "Add Todo";
      break;

    case 'edit-todo.php':
      $pageTitle = "Edit Todo";
      break;

    case 'view-todo.php':
      $todoId = mysqli_real_escape_string($conn, $_GET["id"]);
      $sql1 = "SELECT * FROM todos WHERE id='{$todoId}'";
      $res1 = mysqli_query($conn, $sql1);
      if (mysqli_num_rows($res1) > 0) {
        foreach ($res1 as $todo) {
          $pageTitle = $todo["title"];
        }
      }
      break;

    default:
      $pageTitle = "Todo List";
      break;
  }

  return $pageTitle;
}
