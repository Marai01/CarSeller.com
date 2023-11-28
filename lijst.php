<?php
include_once 'connection.php';

try {
    $query = "SELECT c.id, c.naam, c.beschrijving, c.prijs, c.merk, c.bouwjaar, c.model, c.km, c.brandstof, c.transmissie, c.vermogen, i.filename, u.username
              FROM cars c
              LEFT JOIN image i ON c.id = i.car_id
              LEFT JOIN users u ON c.user_id = u.id";
    
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



    <div class="container py-5">
    <div class="row">
        <div class="col-lg-3">
            <div class="career-search mb-60">
                <form method="POST" action="lijst.php" class="career-form mb-60">
                    <div class="row">
                        <div class="col-md-6 col-lg-12 my-3">
                            <div class="input-group position-relative">
                                <input type="text" name="nameFilter" class="form-control" placeholder="Name">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 my-3">
                            <div class="input-group position-relative">
                                <input type="text" name="priceFilter" class="form-control" placeholder="Price">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 my-3">
                            <div class="input-group position-relative">
                                <input type="text" name="brandFilter" class="form-control" placeholder="Brand">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 my-3">
                            <div class="input-group position-relative">
                                <input type="text" name="yearFilter" class="form-control" placeholder="Year">
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-12 my-3">
                            <input type="submit" class="btn btn-primary btn-block" value="Search">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-9">
            <ul class="list-group shadow">
                <?php
                $baseQuery = "SELECT c.*, i.filename 
                            FROM cars c
                            LEFT JOIN image i ON c.id = i.car_id";
                $filters = array();
                $types = "";
                $params = array();

                if (isset($_POST['brandFilter'])) {
                    $selectedBrand = $_POST['brandFilter'];
                    if (!empty($selectedBrand)) {
                        $filters[] = "c.merk LIKE ?";
                        $types .= "s";
                        $params[] = "%" . $selectedBrand . "%";
                    }
                }
                if (isset($_POST['nameFilter'])) {
                    $selectedName = $_POST['nameFilter'];
                    if (!empty($selectedName)) {
                        $filters[] = "c.naam LIKE ?";
                        $types .= "s";
                        $params[] = "%" . $selectedName . "%";
                    }
                }
                if (isset($_POST['priceFilter'])) {
                    $selectedPrice = $_POST['priceFilter'];
                    if (!empty($selectedPrice)) {
                        $filters[] = "c.prijs LIKE ?";
                        $types .= "s";
                        $params[] = "%" . $selectedPrice . "%";
                    }
                }
                if (isset($_POST['yearFilter'])) {
                    $selectedYear = $_POST['yearFilter'];
                    if (!empty($selectedYear)) {
                        $filters[] = "c.bouwjaar LIKE ?";
                        $types .= "s";
                        $params[] = "%" . $selectedYear . "%";
                    }
                }

                $filterQuery = $baseQuery;

try {
    if (!empty($filters)) {
        $filterQuery .= " WHERE " . implode(" AND ", $filters);
        $stmt = $pdo->prepare($filterQuery);

        if ($stmt) {
            foreach ($params as $key => $value) {
                $stmt->bindParam($key + 1, $value);
            }

            $stmt->execute();
            $filterResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    } else {
        $filterResult = $pdo->query($baseQuery)->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}


foreach ($filterResult as $row) {
    echo '<li class="list-group-item">
        <div class="media align-items-lg-center flex-column flex-lg-row p-3">
            <div class="media-body order-2 order-lg-1">
                <h5 class="mt-0 font-weight-bold mb-2">' . htmlspecialchars($row["naam"]) . '</h5>
                <p class="mb-0">' . htmlspecialchars($row["beschrijving"]) . '</p>
                <div class="d-flex align-items-center justify-content-between mt-1">
                    <h6 class="font-weight-bold my-2">Price: ' . htmlspecialchars($row["prijs"]) . '</h6>
                    <h6 class="font-weight-bold my-2">Brand: ' . htmlspecialchars($row["merk"]) . '</h6>
                    <h6 class="font-weight-bold my-2">Year of Manufacture: ' . htmlspecialchars($row["bouwjaar"]) . '</h6>
                    <a href="car_details.php?carId=' . $row["id"] . '">Details</a>
                    <a href="edit_car.php?carId=' . $row["id"] . '">Edit</a>
                </div>
            </div>';

    if ($row['filename']) {
        echo '<img src="./image/' . htmlspecialchars($row['filename']) . '" alt="Car Image" width="200" class="ml-lg-5 order-1 order-lg-2">';
    } else {
        echo '<img src="default_image.png" alt="Default Car Image" width="200" class="ml-lg-5 order-1 order-lg-2">';
    }

    echo '</div>
        </li>';
}

                ?>
            </ul>
        </div>
    </div>
</div>

<footer class="bg-dark text-white text-center py-5">
        <a href="login.php" class="btn btn-secondary mb-3"><i class="fa fa-arrow-up mr-2"></i>To the top</a>
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