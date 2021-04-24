<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


    <title>Batch Register</title>
</head>
<body>

<header>
    <nav class="navbar navbar-dark bg-dark">
        <a class="navbar-brand" href="home.php">Home</a>
    </nav>
</header>

<div class="container">
    <h1 class="text-center">Enter Batch Information</h1>
    <hr>
    <form method="POST" action="insertBatch.php">
            <label class='ml-1 mt-2'>Manufacturer: </label>
            <input type="text" name="manufacturer" class="form-control" required>

        <?php
            date_default_timezone_set("America/New_York");
            //$today = date("Y-m-d");
            $today = "2021-03-01";
            print <<< _HTML_
                <label class='ml-1 mt-2'>Expiration date</label>
                <input type="date" name="expDate" min='$today' class="form-control" required/>
            _HTML_;
        ?>

            <label class='ml-1 mt-2'>Amount of doses:</label>
            <input type="number" name="amount" min=1 class="form-control" required/>
        <br>
            <input type="submit" id="registerBtn" value="Submit" class="btn btn-primary form-control"/>
    </form>
    <br>
    <a class="btn btn-primary form-control" href="adminIndex.php" role="button">Back</a>
</div>
</div>

</body>
</html>


