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

<?php
if (isset($_GET['carId'])) {
    $carId = filter_var($_GET['carId'], FILTER_VALIDATE_INT);
    if ($carId === false) {
        echo 'Invalid car ID provided.';
        exit();
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM cars WHERE id = ?");
            $stmt->bindParam(1, $carId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo '<div class="container py-5">';
            echo '<h3 class="text-center">Edit Car</h3>';
            echo '<form action="add_car_login.php" method="post" enctype="multipart/form-data">';
            echo '<input type="hidden" name="carId" value="' . $carId . '">';
            echo '<div class="row">';
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label for="naam">Name:</label>';
            echo '<input type="text" name="naam" class="form-control" value="' . htmlspecialchars($result['naam']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="prijs">Price:</label>';
            echo '<input type="number" name="prijs" class="form-control" value="' . htmlspecialchars($result['prijs']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="merk">Brand:</label>';
            echo '<input type="text" name="merk" class="form-control" value="' . htmlspecialchars($result['merk']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="bouwjaar">Year:</label>';
            echo '<input type="number" name="bouwjaar" class="form-control" value="' . htmlspecialchars($result['bouwjaar']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="model">Model:</label>';   
            echo '<input type="text" name="model" class="form-control" value="' . htmlspecialchars($result['model']) . '" required>';
            echo '</div>';

            echo '</div>';
            echo '<div class="col-md-6">';
            echo '<div class="form-group">';
            echo '<label for="km">Kilometers:</label>';
            echo '<input type="number" name="km" class="form-control" value="' . htmlspecialchars($result['km']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="brandstof">Fuel Type:</label>';
            echo '<input type="text" name="brandstof" class="form-control" value="' . htmlspecialchars($result['brandstof']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="transmissie">Transmission:</label>';
            echo '<input type="text" name="transmissie" class="form-control" value="' . htmlspecialchars($result['transmissie']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="vermogen">Horsepower:</label>';
            echo '<input type="number" name="vermogen" class="form-control" value="' . htmlspecialchars($result['vermogen']) . '" required>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="image">Image:</label>';
            echo '<input type="file" name="image" accept="image/*">';
            echo '</div>';

            echo '</div>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="description">Description:</label>';
            echo '<textarea name="description" class="form-control" rows="4" required>' . htmlspecialchars($result['beschrijving']) . '</textarea>';
            
            echo '<div class="form-group text-center">';
            echo '<button type="submit" class="btn btn-primary" name="update">Update Car</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>'; 
            
            echo '<form action="add_car_login.php" method="post">';
            echo '<input type="hidden" name="carId" value="' . $carId . '">';
            echo '<button type="submit" class="btn btn-danger" name="delete">Verwijder Car</button>';
            echo '</form>';
        } else {
            echo 'Car not found.';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
} else {
echo 'Car ID not provided.';
exit();
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
    <script>var loggedIn = <?php echo ($loggedIn) ? 'true' : 'false'; ?>;
        if (!loggedIn) {
            alert("Je moet eerst inloggen om toegang te krijgen tot deze pagina.");
            window.location.href = "lijst.php";
        }
        </script>


</body>

</html>
