<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Patient Info</title>
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

    $sql_patient = "SELECT * FROM patient WHERE Id = $id";
    $result_patient = mysqli_query($conn, $sql_patient);
    if (!$result_patient) {
        die("Error: " . mysqli_error($conn));
    }
    $row_patient = mysqli_fetch_array($result_patient, MYSQLI_ASSOC);
    $fname = $row_patient['Fname'];
    $lname = $row_patient['Lname'];
    $phone = $row_patient['Phone'];
    $age = $row_patient['Age'];
    $id = $row_patient['Id'];
    $date = $row_patient['Date'];
    $priority = $row_patient['Priority'];

    print <<< _HTML_
        <h1 class="text-center ">Information of $fname $lname</h1>
        <br>
        <table class="table table-hover">
            <tr>
                <td>Id</td>
                <td>$id</td>
            </tr>
            <tr>
                <td>Name</td>
                <td>$fname $lname</td>
            </tr>
            <tr>
                <td>Phone Number</td>
                <td>$phone</td>
            </tr>
            <tr>
                <td>Age</td>
                <td>$age</td>
            </tr>
            <tr>
                <td>Earliest Avaiable Date</td>
                <td>$date</td>
            </tr>
            <tr>
                <td>Priority</td>
                <td>$priority</td>
            </tr>
    _HTML_;
    $sql_appointment = "SELECT * FROM appointment WHERE Pid = $id";
    $result_appointment = mysqli_query($conn, $sql_appointment);
    if (!$result_appointment) {
        die("Error: " . mysqli_error($conn));
    }
    if (mysqli_num_rows($result_appointment) != 0) {
        $row_appointment = mysqli_fetch_array($result_appointment, MYSQLI_ASSOC);
        $appDate = $row_appointment['Date'];
        print <<< _HTML_
        <tr>
            <td>Scheduled date</td>
            <td>$appDate</td>
        </tr>
        </table>
        _HTML_;
    } else {
        print <<< _HTML_
        <tr>
            <td>Scheduled date</td>
            <td>No schedule yet</td>
        </tr>
        </table>
        _HTML_;
    }
    // the patient can only remove their information if they have got vaccine
    $today = date("Y-m-d");
    if(mysqli_num_rows($result_appointment) == 0 || $appDate >= $today){
        print <<< _HTML_
            <form action="removePatient.php" method="POST">
                <button name="id" class="btn btn-danger float-right" type="submit" value="$id">Remove profile</button>
            </form>
        _HTML_;
    }
    mysqli_close($conn);
    ?>
    <a href="patientIndex.php" class="btn btn-primary">back</a>
</div>
</body>
</html>




