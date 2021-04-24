<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Patients in the wait list</title>
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
	<h1 class="text-center">Patient Wait List</h1>
	<br>
		<table class="table table-hover">
			<tr>
			    <th>Id</th>
				<th>Name</th>
				<th>Age</th>
				<th>Priority</th>
				<th>Earliest available date</th>
			</tr>
	_HTML_;
    $sql_patient = "SELECT * FROM patient where Id NOT IN (select Pid from appointment) ORDER BY Priority, age DESC";
    $result_patient = mysqli_query($conn, $sql_patient);
    if (!$result_patient) {
        die("Error: " . mysqli_error($conn));
    }
    while ($row_patient = mysqli_fetch_array($result_patient, MYSQLI_ASSOC)) {
        $id = $row_patient['Id'];
        $fname = $row_patient['Fname'];
        $lname = $row_patient['Lname'];
        $age = $row_patient['Age'];
        $priority = $row_patient['Priority'];
        $date = $row_patient['Date'];
        print <<< _HTML_
							<tr>
							<td>$id</td>
							<td>$fname $lname</td>
							<td>$age</td>
							<td>$priority</td>
							<td>$date</td>
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




