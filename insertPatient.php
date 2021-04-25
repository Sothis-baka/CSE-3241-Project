<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Register Result</title>

</head>

<body>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Home</a>
    </nav>
</header>

<div class="center">
    <?php
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $phone = $_POST['phone'];
    $age = $_POST['age'];
    $date = $_POST['date'];
    $priority = $_POST['priority'];

    $conn = new mysqli('localhost', 'root', 'mysql', 'BUR');
    if (!$conn) {
        die("Error: " . mysqli_connect_error());
    }

    // 1. insert patient into database
    $sql_insertPatient = "INSERT INTO patient values (NULL,'$fname','$lname', '$age', '$date', '$phone', '$priority')";
    $result_insertPatient = mysqli_query($conn, $sql_insertPatient);
    if (!$result_insertPatient) {
        die("Error: " . mysqli_error($conn));
    }

    // 2. Since patient id is automatically incremented, we need to find the id of the patient we just inserted
    $sql_patientId = "SELECT Id FROM patient order by Id DESC LIMIT 1";
    $result_patientId = mysqli_query($conn, $sql_patientId);
    if (!$result_patientId) {
        die("Error: " . mysqli_error($conn));
    }
    $row_patientId = mysqli_fetch_array($result_patientId, MYSQLI_ASSOC);
    $id = $row_patientId['Id'];

    // 3. Check if there is a match dose for the new patient, the first part is doses that are not distributed
    $sql_dose = "SELECT * FROM (SELECT Tno, Bid FROM dose where Tno NOT IN (SELECT Tno FROM appointment NATURAL JOIN dose)) d INNER JOIN batch b 
    on d.Bid = b.Id WHERE b.ExpireDate>= '$date' ORDER BY b.ExpireDate ASC, d.Tno ASC LIMIT 1";
    $result_dose = mysqli_query($conn, $sql_dose);
    if (!$result_dose) {
        die("Error: " . mysqli_error($conn));
    }
    //if there is a match
    if (mysqli_num_rows($result_dose) != 0) {
        $row = mysqli_fetch_array($result_dose, MYSQLI_ASSOC);
        $tno = $row['Tno'];
        date_default_timezone_set("America/New_York");
        //$today = date("Y-m-d");
        $today = "2021-03-01";
        //if today is later than earliest available date, assign the appointment today
        if ($date < $today) {
            $date = $today;
        }
        $sql_setAppointment = "INSERT INTO appointment values ('$id', '$date', '$tno')";
        $result_setAppointment = mysqli_query($conn, $sql_setAppointment);
        if (!$result_setAppointment) {
            die("Error: " . mysqli_error($conn));
        }
        echo "Your id is $id. There is available dose for you, your appointment is on $date.";
    } else {
        echo "Your id is $id. There is no available dose for you, you are on the wait list.";
    }

    print <<< _HTML_
        <a class="btn btn-primary" href="home.php" role="button">Home</a>
    _HTML_;

    mysqli_close($conn);
    ?>
</div>
</body>
</html>




