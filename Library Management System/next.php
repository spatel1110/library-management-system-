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
		<!-- navigation -->
		<nav role="navigation">
		  <div id="menuToggle">
		   <input type="checkbox"/>
		    
		    <span></span>
		    <span></span>
		    <span></span>
		    
		    <ul id="menu">
		      <a href="index.php"><li>Home</li></a>
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
		<!--Retrive information from database -->
				<?php
			  		$id = $_GET['id'];
		            $query = "SELECT * FROM bigbook WHERE id = $id";
		            $result = mysqli_query($con,$query);
		            if(mysqli_num_rows($result) > 0) {
		            $row = mysqli_fetch_array($result);
		        }
		         ?>
		<!-- Displaying content-->
		<div style="position: relative; top: -300px; margin: 5%;">
			<h2><?php echo $row["bname"]; ?>
				<aside style="font-size: 15px; margin-left: 20%;">By <?php echo $row["Author"]?></aside>
			</h2>	
			<table border="0">
				<tr>
					<td rowspan="6"><img src="image/<?php echo $row["image"]; ?>"/><br>
						Price : $<?php echo $row["price"];?>
						<input type="submit" value="Add to Cart">
					</td>
				</tr>
				<tr><th>Product details<br></th>
					<td style="color: #ededed;"></td>
				</tr>
				<tr><td>ASIN: <?php echo $row["ASIN"];?></td></tr>
				<tr><td>Publisher: <?php echo $row["Publisher"];?></td></tr>
				<tr><td>Language: <?php echo $row["Lan"];?></td></tr>
				<tr><td>ISBN-13: <?php echo $row["ISBN13"];?></td></tr>
			</table>
			<h4>About Book</h4>
			<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["aboutbook"]; ?>.</p>
			<br>
			<br>
		</div>
		</body>
		</html>
		<?php
    }
    else{
    	header('Location: index.php');
    }
?>