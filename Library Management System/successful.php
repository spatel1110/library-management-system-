<?php
    session_start();
    $database_name = "library";
    $con = mysqli_connect("localhost","root","",$database_name);

    if (isset($_SESSION['user'])) {
        ?>
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1">
			<title>Library</title>
			<link rel="stylesheet" type="text/css" href="css/style.css">
		</head>
		<body>
		<nav role="navigation">
		  <div id="menuToggle">
		    <!--
		    A fake / hidden checkbox is used as click reciever,
		    so you can use the :checked selector on it.
		    -->
		    <input type="checkbox"/>
		    
		    <!--
		    Some spans to act as a hamburger.
		    
		    They are acting like a real hamburger,
		    not that McDonalds stuff.
		    -->
		    <span></span>
		    <span></span>
		    <span></span>
		    
		    <ul id="menu">
		      <a href="localhost/DE/"><li>Home</li></a>
		      <a href="#"><li>About</li></a>
		      <a href="#"><li>Info</li></a>
		      <a href="#"><li>Contact</li></a>
		      <a href="https://erikterwan.com/" target="_blank"><li>Show me more</li></a>
		      <a href="logout.php"><li>Logout</li></a>
		    </ul>
		  </div>

		  <div>
		  	<ul id="user">
		  		<li type="none">Welcome
		  		<a href="myaccount.php" style="text-transform:uppercase;"><?php echo $_SESSION['user']?></a></li>
		  	</ul>
		  </div>
		</nav>
		<div class="body" id="navdiv">
			<p>This site is under development phase.</p>
			<br/>
			<div class="grid-container">
		        <?php
		            $query = "SELECT * FROM bigbook ORDER BY id ASC";
		            $result = mysqli_query($con,$query);
		            if(mysqli_num_rows($result) > 0) {

		                while ($row = mysqli_fetch_array($result)) {

		                    ?>
		                            <div class="grid-item">
		                                <a href="next.php?id=<?php echo $row["id"] ?>"><img src="image/<?php echo $row["image"]; ?>" width = "70%" height ="110%"/></a>
		                            </div>
		                    
		                    <?php
		                }
		            }
		        ?>
		    </div>
		</div>
		</body>
		</html>
<?php
}
    else{
    	header('Location: index.php');
    }
?>