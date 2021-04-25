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
        <h1 class="text-center ">All Doses</h1>
        <br>
        <table class="table table-hover">
            <tr>
                <th>Tracking#</th>
                <th>Batch#</th>
                <th>Manufacturer</th>
                <th>Expiration Date</th>
                <th>Status</th>
                <th>Patient Name</th>
            </tr>
    _HTML_;

    $sql_doses = "SELECT d.Tno, d.Bid, b.Manufacturer, b.ExpireDate, p.Fname, p.Lname, a.Date As AppDate FROM dose d INNER JOIN batch b on d.Bid = b.Id LEFT JOIN appointment a on d.Tno = a.Tno 
                    LEFT JOIN patient p on p.Id = a.Pid ORDER BY d.Tno ASC "; //find all doses
    $result_doses = mysqli_query($conn, $sql_doses);
    if (!$result_doses) {
        die("Error: " . mysqli_error($conn));
    }

    date_default_timezone_set("America/New_York");
    //$today = date("Y-m-d");
    $today = "2021-03-01";

    while ($row_doses = mysqli_fetch_array($result_doses, MYSQLI_ASSOC)) {
        $tno = $row_doses['Tno'];
        $bid = $row_doses['Bid'];
        $manufacturer = $row_doses['Manufacturer'];
        $eDate = $row_doses['ExpireDate'];
        $fname = $row_doses['Fname'];
        $lname = $row_doses['Lname'];
        $aDate = $row_doses['AppDate'];
        $status = '';
        // if it is not assigned to any appointment: expire or available
        if ($aDate==null) {
            $fname = "No";
            $lname = "Patient";
            if($eDate < $today){ //expired
                $status = "Expired";
            }else{ //available
                $status = "Available";
            }
        }else{
            if($aDate<$today){ //already gotten
                $status = "Used";
            }else{ //not yet gotten
                $status = "Reserved";
            }
        }

        print <<< _HTML_
                            <tr>
                            <td>$tno</td>
                            <td>$bid</td>
                            <td>$manufacturer</td>
                            <td>$eDate</td>
                            <td>$status</td>
                            <td>$fname $lname</td>
                            </tr>
        _HTML_;
    }
    print <<< _HTML_
        </table>
        <a class="btn btn-primary form-control" href="adminIndex.php" role="button">Back</a>
    _HTML_;

    ?>

</div>