<?php

include_once 'connection.php';
session_start();
if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
} else {
    $loggedIn = false;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CarSeller.com</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="index.php">CarSeller</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="lijst.php"><i class="fa fa-car"></i> Cars</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="plaatsen.php"><i class="fa fa-plus-square"></i> List a Car</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php"><i class="fa fa-envelope"></i> Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="login.php"><i class="fa fa-user"></i> Login/Logout</a>
        </li>
      </ul>
    </div>
  </nav>



  <div class="container mt-5 flex-grow-1">
    <h1 class="text-center">CONTACT</h1>
    <p class="text-center lead">Let's get in touch. Send us a message:</p>
    <div class="row justify-content-center">
      <div class="col-md-6">
        <p><i class="fa fa-map-marker fa-fw"></i> Amsterdam, Netherlands</p>
        <p><i class="fa fa-phone fa-fw"></i> Phone: 0684193506</p>
        <p><i class="fa fa-envelope fa-fw"></i> Email: marai@mail.com</p>
      </div>
      <div class="col-md-6">
        <form action="index.php" method="post">
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Name" required name="Name">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Email" required name="Email">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Subject" required name="Subject">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" placeholder="Message" required name="Message">
          </div>
          <button type="submit" class="btn btn-primary btn-block">
            <i class="fa fa-paper-plane"></i> SEND MESSAGE
          </button>
        </form>
      </div>
    </div>
  </div>

  <footer class="bg-dark text-white text-center py-5">
    <a href="contact.php" class="btn btn-secondary mb-3"><i class="fa fa-arrow-up mr-2"></i>To the top</a>
    <div class="h3">
      <a href="https://github.com/Marai01" class="text-white"><i class="fa fa-github mx-3"></i></a>
      <a href="https://www.linkedin.com/in/marai-de-jong/" class="text-white"><i class="fa fa-linkedin mx-3"></i></a>
      <a href="https://www.youtube.com/channel/UCskqxbolcppYOpBfF98ixHw" class="text-white"><i class="fa fa-youtube mx-3"></i></a>
    </div>
    <p class="mt-3">2023 CarSeller.INC ALL RIGHTS RESERVED</p>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>





</body>

</html>
