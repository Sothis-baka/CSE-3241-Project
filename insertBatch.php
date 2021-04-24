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
    $manufacturer = $_POST['manufacturer'];
    $expDate = $_POST['expDate'];
    $amount = $_POST['amount'];
    $conn = new mysqli('localhost', 'root', 'mysql', 'BUR');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sql_insertBatch = "INSERT INTO batch VALUES (NULL, '$manufacturer', '$expDate')";
    $result_insertBatch = mysqli_query($conn, $sql_insertBatch);

    if (!$result_insertBatch) {
        die("Error: " . mysqli_error($conn));
    }

    // still need to find the batch id of just inserted batch
    $sql_batchId = "SELECT Id FROM batch order by Id DESC LIMIT 1";
    $result_batchId = mysqli_query($conn, $sql_batchId);
    if (!$result_batchId) {
        die("Error: " . mysqli_error($conn));
    }
    $row_batchId = mysqli_fetch_array($result_batchId, MYSQLI_ASSOC);
    $bid = $row_batchId['Id'];

    // insert doses
    for ($i = 0; $i < $amount; $i++) {

        $sql_insertDose = "INSERT INTO dose values (NULL,'$bid')";
        $result_insertDose = mysqli_query($conn, $sql_insertDose);
        if (!$result_insertDose) {
            die("Error: " . mysqli_error($conn));
        }
    }

    // find the last dose tracking number to get the range of new doses
    $sql_lastDose = "SELECT Tno FROM dose ORDER BY Tno DESC";
    $result_lastDose = mysqli_query($conn, $sql_lastDose);
    if (!$result_lastDose) {
        die("Error: " . mysqli_error($conn));
    }
    $row_lastDose = mysqli_fetch_array($result_lastDose, MYSQLI_ASSOC);
    $lastTno = $row_lastDose["Tno"];


    // find if there is a match dose for patient on the wait list
    date_default_timezone_set("America/New_York");
    $today = date("Y-m-d");
    $sql_waitList = "SELECT * FROM patient WHERE Id NOT IN (SELECT Pid FROM appointment) ORDER BY Priority, age DESC";
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
                        on d.Bid = b.Id WHERE b.Expiredate >= '$date' ORDER BY b.Expiredate ASC, d.Tno ASC LIMIT 1";
        $result_dose = mysqli_query($conn, $sql_dose);
        if (!$result_dose) {
            die("Error: " . mysqli_error($conn));
        }

        //if there is a dose for patient
        if (mysqli_num_rows($result_dose) != 0) {
            $row_dose = mysqli_fetch_array($result_dose, MYSQLI_ASSOC);
            $tno = $row_dose['Tno'];
            $sql_makeAppointment = "INSERT INTO appointment values ('$tno','$id','$date','$tno')";
            $result_makeAppointment = mysqli_query($conn, $sql_makeAppointment);
            if (!$result_makeAppointment) {
                die("Error: " . mysqli_error($conn));
            }
        }
    }
    $first_tno = $lastTno-$amount+1;
    print <<< _HTML_
        <h1 class="text-center">Successfully added batch (id=$bid) with $amount dose(s) (id ranges: $first_tno-$lastTno).</h1>
        <a class="btn btn-primary form-control" href="adminIndex.php" role="button">back</a>
    _HTML_;

    mysqli_close($conn);
    ?>
</div>
</body>
</html>




