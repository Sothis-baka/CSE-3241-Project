<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Inventory</title>
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
        <h1 class="text-center ">Vaccine Inventory</h1>
        <br>
        <table class="table table-hover">
            <tr>
                <th>Manufacturer</th>
                <th>Total</th>
                <th>Available</th>
                <th>Distributed</th>
                <th>Expired</th>
            </tr>
    _HTML_;

    $sql_manuf = "SELECT DISTINCT Manufacturer FROM batch"; //find all manufactures
    $result_manuf = mysqli_query($conn, $sql_manuf);
    if (!$result_manuf) {
        die("Error: " . mysqli_error($conn));
    }
    date_default_timezone_set("America/New_York");
    //$today = date("Y-m-d");
    $today = "2021-03-01";
    // iterate the manufacturer list
    while ($row = mysqli_fetch_array($result_manuf, MYSQLI_ASSOC)) {
        $manufacturer = $row['Manufacturer'];
        $sql_totalDose = "SELECT COUNT(*) AS total FROM dose INNER JOIN batch ON dose.Bid=batch.Id WHERE Manufacturer='$manufacturer'";
        $sql_availableDose = "SELECT COUNT(*) AS available FROM dose AS d INNER JOIN batch AS b ON d.Bid=b.Id WHERE Manufacturer='$manufacturer' AND Expiredate >= '$today' AND Tno NOT IN (SELECT Tno FROM appointment NATURAL JOIN dose)";
        $sql_distributedDose = "SELECT COUNT(*) AS distributed FROM dose INNER JOIN batch ON dose.Bid=batch.Id WHERE Manufacturer='$manufacturer' AND Tno IN (SELECT Tno FROM appointment NATURAL JOIN dose)";
        $sql_expiredDose = "SELECT COUNT(*) AS expired FROM dose INNER JOIN batch ON dose.Bid=batch.Id WHERE Manufacturer='$manufacturer' AND Expiredate < '$today'";

        $result_totalDose = mysqli_query($conn, $sql_totalDose);
        $result_availableDose = mysqli_query($conn, $sql_availableDose);
        $result_distributedDose = mysqli_query($conn, $sql_distributedDose);
        $result_expiredDose = mysqli_query($conn, $sql_expiredDose);

        if (!($result_totalDose && $result_availableDose && $result_distributedDose && $result_expiredDose)) {
            die("Error: " . mysqli_error($conn));
        }

        $totalDose = mysqli_fetch_array($result_totalDose, MYSQLI_ASSOC);
        $availableDose = mysqli_fetch_array($result_availableDose, MYSQLI_ASSOC);
        $distributedDose = mysqli_fetch_array($result_distributedDose, MYSQLI_ASSOC);
        $expiredDose = mysqli_fetch_array($result_expiredDose, MYSQLI_ASSOC);

        $total = $totalDose['total'];
        $available = $availableDose['available'];
        $distributed = $distributedDose['distributed'];
        $expired = $expiredDose['expired'];
        print <<< _HTML_
                            <tr>
                            <td>$manufacturer</td>
                            <td>$total</td>
                            <td>$available</td>
                            <td>$distributed</td>
                            <td>$expired</td>
                            </tr>
        _HTML_;
    }
    print <<< _HTML_
        </table>
    _HTML_;
    mysqli_close($conn);
    ?>

    <a href="adminIndex.php"  class="btn btn-primary form-control">Back</a>

</div>
</body>
</html>




