<?php $con = mysqli_connect("localhost","root","","library"); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<style type="text/css">
		body
		{
		  margin: 0;
		  padding: 0;
		  background: #232323;
		  color: #cdcdcd;
		  font-family: "Avenir Next", "Avenir", sans-serif;
		  margin: auto;
		 -ms-overflow-style: none; /* for Internet Explorer, Edge */
		  scrollbar-width: none; /* for Firefox */
		  overflow-y: none;
		}
	</style>
</head>
<body>
<form style="margin-left: 8%; margin-right: 8%; margin-top: 15%;" method="POST">
  <div class="form-group">
    <label for="user">Username:</label>
    <input type="text" class="form-control" name = "user" id="user" placeholder="username" style="text-transform: lowercase;">
  </div>
  <div class="form-group">
    <label for="pass">Password:</label>
    <input type="password" class="form-control" name="pass" id="pass" placeholder="Password">
  </div>
  <button type="submit" class="btn btn-primary" name="login">Submit</button> &nbsp;<a href="signup.php">Signup</a>
</form>
</body>
</html>
<?php

if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $q = "SELECT * FROM `login` WHERE user = '$user' AND pass = '$pass';";
    $result = mysqli_query($con,$q);

    if(mysqli_num_rows($result) > 0) {
            header('Location: successful.php');
            session_start();
            $_SESSION['user'] = $user;
        }
    else{
        	echo "Username and Password Not found";
        
    }
}
?>