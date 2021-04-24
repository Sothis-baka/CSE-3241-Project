<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Patients have appointment</title>
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
	    <h1 class="text-center">Scheduled Patient</h1>
	    <br>
		<table class="table table-hover">
			<tr>
			    <th>Id</th>
				<th>Name</th>
				<th>Date</th>
				<th>Phone number</th>
			</tr>
	_HTML_;
    date_default_timezone_set("America/New_York");
    $today = date("Y-m-d");
    $sql_patientDate = "SELECT p.Id, p.Fname, p.Lname, p.Phone, a.Date FROM patient p inner join appointment a on p.Id = a.Pid WHERE a.Date >= '$today'";
    $result_patientDate = mysqli_query($conn, $sql_patientDate);
    if (!$result_patientDate) {
        die("Error: " . mysqli_error($conn));
    }

    while ($row_patientDate = mysqli_fetch_array($result_patientDate, MYSQLI_ASSOC)) {
        $id = $row_patientDate['Id'];
        $fname = $row_patientDate['Fname'];
        $lname = $row_patientDate['Lname'];
        $date = $row_patientDate['Date'];
        $phone = $row_patientDate['Phone'];
        print <<< _HTML_
							<tr>
							<td>$id</td>
							<td>$fname $lname</td>
							<td>$date</td>
							<td>$phone</td>
							</tr>
		_HTML_;
    }
    print <<< _HTML_
		</table>
	_HTML_;
    mysqli_close($conn);
    ?>
    <a href="adminIndex.php" class="btn btn-primary form-control">back</a>
</div>
</body>
</html>




