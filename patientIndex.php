<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Patient Interface</title>
</head>
<body>
<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Home</a>
    </nav>
</header>

<div class="container">
    <h1 class="text-center">Patient Interface</h1>
    <hr>
    <form method="POST" action="patientInfo.php">
        <div class="form-group">
        <select name="id" class="form-control">
            <?php
            $conn = new mysqli('localhost', 'root', 'mysql', 'BUR');
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sql = "SELECT * FROM PATIENT ORDER BY Fname";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $id = $row['Id'];
                    $fname = $row['Fname'];
                    $lname = $row['Lname'];
                    print <<< _HTML_
                        <option value='$id'>$id $fname $lname</option>
                    _HTML_;
                }
            } else {
                echo("Error description: " . mysqli_error($conn));
            }
            mysqli_close($conn);
            ?>
        </select>
        <br>
        <input class="btn btn-primary form-control" type="submit" value="Check Your Appointment" role="button">
        </div>
    </form>
    <div class="form-group">
    <a class="btn btn-primary form-control" href="patientRegister.php" role="button">Register Your Appointment</a>
    </div>
    <div class="form-group">
    <a class="btn btn-primary form-control" href="home.php" role="button">Back</a>
    </div>

</div>

</body>
</html>


