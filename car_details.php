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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha256-3sPp8BkKUE7QyP">
    <link rel="stylesheet" href="style.css">
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

  <a class="btn btn-primary btn-block" href="lijst.php">Go Back</a>

  <?php
if (isset($_GET['carId'])) {
    $carId = filter_var($_GET['carId'], FILTER_VALIDATE_INT);

    if ($carId === false) {
        echo 'Invalid car ID provided.';
    } else {
        $query = "SELECT c.*, i.filename, u.username 
                FROM cars c 
                LEFT JOIN image i ON c.id = i.car_id 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $carId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            $row = $result[0];
            echo '<div class="car-details">';
            echo '<p><strong>Name: </strong>' . htmlspecialchars($row['naam']) . '</p>';
            echo '<p><strong>Price: </strong>€' . htmlspecialchars($row['prijs']) . '</p>';
            echo '<p><strong>Brand: </strong> ' . htmlspecialchars($row['merk']) . '</p>';
            echo '<p><strong>Year of Manufacture: </strong> ' . htmlspecialchars($row['bouwjaar']) . '</p>';
            echo '<p><strong>Model: </strong> ' . htmlspecialchars($row['model']) . '</p>';
            echo '<p><strong>Kilometers: </strong> ' . htmlspecialchars($row['km']) . 'km</p>';
            echo '<p><strong>Fuel Type: </strong> ' . htmlspecialchars($row['brandstof']) . '</p>';
            echo '<p><strong>Transmission: </strong> ' . htmlspecialchars($row['transmissie']) . '</p>';
            echo '<p><strong>Power: </strong> ' . htmlspecialchars($row['vermogen']) . 'pk</p>';
            echo '<p><strong>Description: </strong> ' . htmlspecialchars($row['beschrijving']) . '</p>';
            echo '<p><strong>Posted by: </strong> ' . htmlspecialchars($row['username']) . '</p>';
            if ($row['filename']) {
                echo '<img src="./image/' . htmlspecialchars($row['filename']) . '" alt="Car Image">';
            }
            echo '</div>';
        } else {
            echo 'Car not found.';
        }
    }
} else {
    echo 'Car ID not provided.';
}

?>


  <footer class="bg-dark text-white text-center py-5 mt-auto">
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
