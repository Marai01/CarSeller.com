<?php
include_once 'connection.php';


session_start();
if (isset($_SESSION['username'])) {
    $loggedIn = true;
    $username = $_SESSION['username'];
} else {
    $loggedIn = false;
}

if (isset($_POST['opslaan'])) {
    $update = $_POST['name'];
    $update1 = $_POST['prijs'];
    $update2 = $_POST['brand'];
    $update3 = $_POST['year'];
    $update4 = $_POST['model'];
    $update5 = $_POST['mileage'];
    $update6 = $_POST['fuel'];
    $update7 = $_POST['transmission'];
    $update8 = $_POST['power'];
    $update9 = $_POST['description'];

    $image = $_FILES['image'];
    if ($image['error'] === UPLOAD_ERR_OK) {
        $imageData = file_get_contents($image['tmp_name']);
    } else {
        echo "Fout bij het uploaden van de afbeelding.";
        exit();
    }

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $username = $_SESSION['username'];
    } else {
        echo "Niet ingelogd. Kon geen gebruikersinformatie vinden.";
        exit();
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO cars (naam, prijs, merk, bouwjaar, model, km, brandstof, transmissie, vermogen, beschrijving, image, user_id, username) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $update);
        $stmt->bindParam(2, $update1);
        $stmt->bindParam(3, $update2);
        $stmt->bindParam(4, $update3);
        $stmt->bindParam(5, $update4);
        $stmt->bindParam(6, $update5);
        $stmt->bindParam(7, $update6);
        $stmt->bindParam(8, $update7);
        $stmt->bindParam(9, $update8);
        $stmt->bindParam(10, $update9);
        $stmt->bindParam(11, $imageData, PDO::PARAM_LOB);
        $stmt->bindParam(12, $user_id, PDO::PARAM_INT);
        $stmt->bindParam(13, $username);
        
        if ($stmt->execute()) {
            $autoId = $pdo->lastInsertId();

            $filename = $_FILES['image']['name'];
            $sql = "INSERT INTO image (filename, car_id) VALUES (?, ?)";
            $stmtImage = $pdo->prepare($sql);
            $stmtImage->bindParam(1, $filename);
            $stmtImage->bindParam(2, $autoId, PDO::PARAM_INT);

            if ($stmtImage->execute()) {
                $folder = "./image/" . $filename;
                $tempname = $_FILES['image']['tmp_name'];
                if (move_uploaded_file($tempname, $folder)) {
                    echo "<h3>Auto- en afbeeldingsgegevens zijn succesvol opgeslagen!</h3>";
                    header("Location: index.php");
                    exit();
                } else {
                    echo "<h3>Fout bij het uploaden van de afbeelding!</h3>";
                }
            } else {
                echo "Error inserting image data: ";
            }
        } else {
            echo "Error inserting car data: ";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}


if (isset($_POST['register'])) {
    $update = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bindParam(1, $update);
        $stmt->bindParam(2, $password);

        if ($stmt->execute()) {
            header("Location: login.php");
            exit();
        } else {
            echo "Error: Je kan niet 2 dezelfde gebruikersnamen hebben.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bindParam(1, $username, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($password, $result['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $result['id'];
            header("Location: plaatsen.php");
            exit();
        } else {
            echo "<script>alert('Ongeldige inloggegevens');</script>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['update'])) {
    if (isset($_SESSION['user_id'])) {
        $carId = filter_var($_POST['carId'], FILTER_VALIDATE_INT);
        $naam = $_POST['naam'];
        $prijs = $_POST['prijs'];
        $merk = $_POST['merk'];
        $bouwjaar = $_POST['bouwjaar'];
        $model = $_POST['model'];
        $km = $_POST['km'];
        $brandstof = $_POST['brandstof'];
        $transmissie = $_POST['transmissie'];
        $vermogen = $_POST['vermogen'];
        $beschrijving = $_POST['description'];

        if ($carId === false) {
            echo 'Ongeldige auto-ID verstrekt.';
            exit();
        }

        try {
            $stmt = $pdo->prepare("UPDATE cars SET naam = ?, prijs = ?, merk = ?, bouwjaar = ?, model = ?, km = ?, brandstof = ?, transmissie = ?, vermogen = ?, beschrijving = ? WHERE id = ? AND user_id = ?");
            $stmt->bindParam(1, $naam);
            $stmt->bindParam(2, $prijs);
            $stmt->bindParam(3, $merk);
            $stmt->bindParam(4, $bouwjaar);
            $stmt->bindParam(5, $model);
            $stmt->bindParam(6, $km);
            $stmt->bindParam(7, $brandstof);
            $stmt->bindParam(8, $transmissie);
            $stmt->bindParam(9, $vermogen);
            $stmt->bindParam(10, $beschrijving);
            $stmt->bindParam(11, $carId, PDO::PARAM_INT);
            $stmt->bindParam(12, $_SESSION['user_id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: lijst.php");
                exit();
            } else {
                echo 'Error trying to update data: ';
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo 'You must be logged in to edit a car.';
    }
}

 if (isset($_POST['delete'])) {
    $carId = filter_var($_POST['carId'], FILTER_VALIDATE_INT);

    if ($carId === false) {
        echo 'Ongeldige auto-ID verstrekt.';
        exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM cars WHERE id = ?");
        $stmt->bindParam(1, $carId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: lijst.php");
        } else {
            echo 'Error trying to delete data: ';
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// session_unset();
// session_destroy();
// exit();

$pdo = null; 

?>
