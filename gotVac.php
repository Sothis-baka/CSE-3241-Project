<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Patient got vaccine</title>
</head>

<body>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Home</a>
    </nav>
</header>

<div class="container">
    <?php
    $conn = new mysqli('localhost', 'root', 'mysql', 'BUR');
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    print <<< _HTML_
        <h1 class="text-center ">Patient Gotten Vaccine</h1>
        <br>
        <table class="table table-hover">
            <tr>
                <th>Name</th>
                <th>Date</th>
                <th>Manufacturer of vaccine</th>
                <th>Batch#</th>
                <th>Tracking#</th>
            </tr>
    _HTML_;
    date_default_timezone_set("America/New_York");
    //$today = date("Y-m-d");
    $today = "2021-03-01";
    $sql_patientDateManuf = "SELECT p.Fname, p.Lname , a.Date, b.Manufacturer, a.Tno, d.Bid
        FROM patient AS p INNER JOIN appointment AS a ON p.Id = a.Pid INNER JOIN dose d on a.Tno = d.Tno 
        INNER JOIN batch b on d.Bid = b.Id WHERE a.Date < '$today'";
    $result_patientDateManuf = mysqli_query($conn, $sql_patientDateManuf);
    if (!$result_patientDateManuf) {
        die("Error: " . mysqli_error($conn));
    }

    while ($row_patientDateManuf = mysqli_fetch_array($result_patientDateManuf, MYSQLI_ASSOC)) {
        $fname = $row_patientDateManuf['Fname'];
        $lname = $row_patientDateManuf['Lname'];
        $date = $row_patientDateManuf['Date'];
        $manufacturer = $row_patientDateManuf['Manufacturer'];
        $bid = $row_patientDateManuf['Bid'];
        $tno = $row_patientDateManuf['Tno'];
        print <<< _HTML_
                            <tr>
                            <td>$fname $lname</td>
                            <td>$date</td>
                            <td>$manufacturer</td>
                            <td>$bid</td>
                            <td>$tno</td>
                            </tr>
        _HTML_;
    }
    print <<< _HTML_
        </table>
    _HTML_;
    mysqli_close($conn);
    ?>
    <a href="adminIndex.php" class="btn btn-primary form-control">Back</a>
</div>
</body>
</html>




