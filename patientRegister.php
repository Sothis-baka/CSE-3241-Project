<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Appointment Register</title>
</head>
<body>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Home</a>
    </nav>
</header>

<div class="container">
    <h1 class="text-center">Enter Your Information Here</h1>
    <hr>
        <form method= "POST" action="insertPatient.php">

            <input type="text" id="fname" name="fname"  placeholder="First name" class="form-control" required>
            <br>
            <input type="text" name="lname"  placeholder="Last name" class="form-control" required>
            <br>
            <input type="text" name="age" placeholder="Age" class="form-control" required/>
            <br>
            <input type="text" name="phone" placeholder="Phone number" maxlength="10"  class="form-control" required/>
            <br>
            <input type="text" name="priority" placeholder="Priority" class="form-control" required/>
            <br>
            <input type="date" name="date" class="form-control" required>
            <br>
            <input type="submit" id="registerBtn" value="Sign up" class="btn btn-primary form-control"/>
        </form>

        <br>
    <a class="btn btn-primary form-control" href="patientIndex.php" role="button">Back</a>


</div>

</body>
</html>


