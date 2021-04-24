<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Remove Patient</title>
</head>

<body>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Home</a>
    </nav>
</header>

<div class="container">
    <?php
    $id = $_POST["id"];
    $conn = new mysqli('localhost', 'root', 'mysql', 'BUR');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql_removePatient = "DELETE FROM patient WHERE Id=$id";
    $result_removePatient = mysqli_query($conn, $sql_removePatient);
    if ($result_removePatient) {
        echo "You have successfully remove your information.";
    } else {
        die("Error: " . mysqli_error($conn));
    }

    mysqli_close($conn);
    ?>

    <a href="patientIndex.php" class="btn btn-primary form-control">Back</a>
</div>
</body>
</html>




