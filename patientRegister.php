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
            <label class='ml-1 mt-2'>First name: </label>
            <input type="text" id="fname" name="fname" class="form-control" required>

            <label class='ml-1 mt-2'>Last name: </label>
            <input type="text" name="lname"  class="form-control" required>

            <label class='ml-1 mt-2'>Age: </label>
            <input type="number" name="age" min=1 class="form-control" required/>

            <label class='ml-1 mt-2'>Phone number: </label>
            <input type="text" name="phone" maxlength="10"  class="form-control" required/>

            <label class='ml-1 mt-2'>Priority (1-3): </label>
            <input type="number" name="priority" min=1 max=3 class="form-control" required/>

            <label class='ml-1 mt-2'>Earliest available date: </label>
            <input type="date" name="date" class="form-control" required>
            <br>
            <input type="submit" id="registerBtn" value="Sign up" class="btn btn-primary form-control"/>
        </form>

        <br>
    <a class="btn btn-primary form-control" href="patientIndex.php" role="button">Back</a>


</div>

</body>
</html>


