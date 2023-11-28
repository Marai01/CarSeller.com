<?php
include_once 'connection.php';

try {
    $query = "SELECT c.id, c.naam, c.beschrijving, c.prijs, c.merk, c.bouwjaar, c.model, c.km, c.brandstof, c.transmissie, c.vermogen, i.filename FROM cars c LEFT JOIN image i ON c.id = i.car_id";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    session_start();
    
    if (isset($_SESSION['username'])) {
        $loggedIn = true;
        $username = $_SESSION['username'];
    } else {
        $loggedIn = false;
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
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

  <div class="container text-center py-5" id="what-we-do">
    <h3>What We Do:</h3>
    <div class="row mt-4">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>List Your Car</b></h5>
            <p class="card-text">Easily list your car for sale on our platform.</p>
            <a href="plaatsen.php" class="btn btn-primary btn-block">Get Started</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>Find Your Dream Car</b></h5>
            <p class="card-text">Browse our vast selection of cars to find your dream vehicle.</p>
            <a href="lijst.php" class="btn btn-primary btn-block">Search Now</a>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><b>24h Support</b></h5>
            <p class="card-text">Our support team is always available.</p>
            <a href="contact.php" class="btn btn-primary btn-block">Contact</a>
          </div>
        </div>
      </div>
    </div>
  </div>



  <div id="projects" class="container">
    <h1 class="text-center">New Cars:</h1>
    <div class="row justify-content-center mt-4">
    <?php
$displayedCars = 0;

foreach ($result as $row) {
    echo '<div class="col-lg-4 col-md-6 col-sm-6">
        <div id="myCarousel" class="carousel slide card mb-4">
            <div class="carousel-inner">
                <div class="carousel-item active">';
    
    if ($row['filename']) {
        echo '<img src="./image/' . htmlspecialchars($row['filename']) . '" alt="Car Image" width="200" class="ml-lg-5 order-1 order-lg-2">';
    } else {
        echo '<img src="default_image.png" alt="Default Car Image" width="200" class="ml-lg-5 order-1 order-lg-2">';
    }
    
    echo '
                    <div class="card-body">
                        <h5 class="card-title">' . htmlspecialchars($row["naam"]) . '</h5>
                        <p class="card-text">' . htmlspecialchars($row["prijs"]) . '</p>
                        <a class="btn btn-primary" href="car_details.php?carId=' . $row["id"] . '">Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>';
    
    $displayedCars++;
    if ($displayedCars >= 3) {
        break;
    }
}
?>


    </div>
  </div>

  <footer class="bg-dark text-white text-center py-5">
    <a href="index.php" class="btn btn-secondary mb-3"><i class="fa fa-arrow-up mr-2"></i>To the top</a>
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
