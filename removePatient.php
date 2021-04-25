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
    $sql_appointment = "SELECT * FROM patient p INNER JOIN appointment a on p.Id = a.Pid";
    $result_appointment = mysqli_query($conn, $sql_appointment);
    if (!$result_appointment) {
        die("Error: " . mysqli_error($conn));
    }

    $sql_removePatient = "DELETE FROM patient WHERE Id=$id";

    if (mysqli_num_rows($result_appointment) != 0) {
        $row_appointment = mysqli_fetch_array($result_appointment, MYSQLI_ASSOC);
        $tno = $row_appointment['Tno'];
        $result_removePatient = mysqli_query($conn, $sql_removePatient);
        if ($result_removePatient) {
            echo "You have successfully remove your information.";
        } else {
            die("Error: " . mysqli_error($conn));
        }

        // find if there is a match dose for patient on the wait list
        date_default_timezone_set("America/New_York");
        //$today = date("Y-m-d");
        $today = "2021-03-01";
        $sql_waitList = "SELECT * FROM patient WHERE Id NOT IN (SELECT Pid FROM appointment) ORDER BY Priority, Age DESC";
        $result_waitList = mysqli_query($conn, $sql_waitList);
        if (!$result_waitList) {
            die("Error: " . mysqli_error($conn));
        }

        // iterating wait list
        while ($row_waitList = mysqli_fetch_array($result_waitList, MYSQLI_ASSOC)) {
            $id = $row_waitList['Id'];
            $date = $row_waitList['Date'];

            // if today is later then the earliest available date
            if ($date < $today) {
                $date = $today;
            }

            //find the available dose that expire after the date
            $sql_dose = "SELECT * FROM (SELECT Tno, Bid FROM dose where Tno NOT IN (SELECT Tno FROM appointment NATURAL JOIN dose)) d INNER JOIN batch b 
                        on d.Bid = b.Id WHERE b.ExpireDate >= '$date' ORDER BY b.ExpireDate ASC, d.Tno ASC LIMIT 1";
            $result_dose = mysqli_query($conn, $sql_dose);
            if (!$result_dose) {
                die("Error: " . mysqli_error($conn));
            }

            //if there is a dose for patient
            if (mysqli_num_rows($result_dose) != 0) {
                $row_dose = mysqli_fetch_array($result_dose, MYSQLI_ASSOC);
                $tno = $row_dose['Tno'];
                $sql_makeAppointment = "INSERT INTO appointment values ('$id','$date','$tno')";
                $result_makeAppointment = mysqli_query($conn, $sql_makeAppointment);
                if (!$result_makeAppointment) {
                    die("Error: " . mysqli_error($conn));
                }
            }
        }

    }else{
        $result_removePatient = mysqli_query($conn, $sql_removePatient);
        if ($result_removePatient) {
            echo "You have successfully remove your information.";
        } else {
            die("Error: " . mysqli_error($conn));
        }
    }
    mysqli_close($conn);
    ?>

    <a href="patientIndex.php" class="btn btn-primary form-control">Back</a>
</div>
</body>
</html>




