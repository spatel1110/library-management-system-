<?php $con = mysqli_connect("localhost","root","","library"); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup</title>
</head>
<body>
    <body>
    <header>
        <h1>Signup</h1>
        <style type="text/css">
            * {
    padding: 0px;
    margin: 0px;
}
body {
    background-color: lightgreen;
}
header {
    background-color: black;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 15vh;
    box-shadow: 5px 5px 10px rgb(0,0,0,0.3);
}
h1 {
    letter-spacing: 1.5vw;
    font-family: 'system-ui';
    text-transform: uppercase;
    text-align: center;
}
main {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 75vh;
    width: 100%;
    background: url(https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Mountains-1412683.svg/1280px-Mountains-1412683.svg.png) no-repeat center center;
    background-size: cover;
}
.form_class {
    width: 500px;
    padding: 40px;
    border-radius: 8px;
    background-color: light;
    font-family: 'system-ui';
    box-shadow: 5px 5px 20px rgb(0,0,0,0.3);
}
.form_div {
    text-transform: uppercase;
}
.form_div > label {
    letter-spacing: 3px;
    font-size: 1rem;
}
.info_div {
    text-align: center;
    margin-top: 20px;
}
.info_div {
    letter-spacing: 1px;
}
.field_class {
    width: 100%;
    border-radius: 6px;
    border-style: solid;
    border-width: 1px;
    padding: 5px 0px;
    text-indent: 6px;
    margin-top: 10px;
    margin-bottom: 20px;
    font-family: 'system-ui';
    font-size: 0.9rem;
    letter-spacing: 2px;
}
.submit_class {
    border-style: none;
    border-radius: 5px;
    background-color: #FFE6D4;
    padding: 8px 20px;
    font-family: 'system-ui';
    text-transform: uppercase;
    letter-spacing: .8px;
    display: block;
    margin: auto;
    margin-top: 10px;
    box-shadow: 5px 10px 10px rgb(0,0,0,0.2);
    cursor: pointer;
}
footer {
    height: 10vh;
    background-color: black;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: -5px -5px 10px rgb(0,0,0,0.3);
}
footer > p {
    text-align: center;
    font-family: 'system-ui';
    letter-spacing: 3px;
}
footer > p > a {
    text-decoration: none;
    color: white;
    font-weight: bold;
}
        </style>
    </header>
    <main>
        <form id="login_form" class="form_class" method="POST">
            <div class="form_div">
                <label>Username:</label>
                <input class="field_class" name="user" type="text" placeholder="Username" autofocus required>
                <label>Password:</label>
                <input id="pass" class="field_class" name="pass" type="password" placeholder="Password" required>
                <button class="submit_class" type="submit" form="login_form" name="signup">Signup</button>
                <small style="color:white; font-weight: 400;">Find Login Page <a href="index.php" style="text-decoration: none; color: cyan;">Login Here</a></small>
								<?php

								if (isset($_POST['signup'])) {
								    $user = $_POST['user'];
								    $pass = $_POST['pass'];

								    $q = "INSERT INTO `login`(`user`, `pass`) VALUES ('$user','$pass')";
								    if (mysqli_query($con,$q)) {
								    	header("location: index.php");
								    }
								    else{
								        	echo "Username is already Exist Use Different Username  SQL ERROR :-" .mysqli_error($con);;
								        
								    }
								}
								?>
            </div>

        </form>
    </main>
    <footer>
        Created By DE-Team No: 356609(GEC,Patan-GTU)
    </footer>
</body>
</body>
</html>