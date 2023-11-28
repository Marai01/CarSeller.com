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

<body>

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

    <div class="container py-5">
        <h3 class="text-center">Add a New Car</h3>
        <form action="add_car_login.php" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Price:</label>
                        <input type="text" name="prijs" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="brand">Brand:</label>
                        <input type="text" name="brand" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="year">Year:</label>
                        <input type="text" name="year" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="model">Model:</label>
                        <input type="text" name="model" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="mileage">Kilometers:</label>
                        <input type="text" name="mileage" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="fuel">Fuel Type:</label>
                        <input type="text" name="fuel" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="transmission">Transmission:</label>
                        <input type="text" name="transmission" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="power">Horsepower:</label>
                        <input type="text" name="power" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <input type="file" name="image" accept="image/*">
                    </div>

                </div>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <?php if ($loggedIn) { ?>
            <div class="form-group">
                <label for="username">Account logged in with:</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>" disabled>
                <input type="hidden" name="username" value="<?php echo $username; ?>">
            </div>
            <?php } ?>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary" name="opslaan">Add Car</button>
            </div>
        </form>
    </div>


    <footer class="bg-dark text-white text-center py-5">
        <a href="plaatsen.php" class="btn btn-secondary mb-3"><i class="fa fa-arrow-up mr-2"></i>To the top</a>
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
            window.location.href = "login.php";
        }
        </script>


</body>

</html>
