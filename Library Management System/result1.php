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
</head>
<body>
    <body>
    <header>
        <h1><a href="page1.php" class="header1">Library</a></h1>
        <style type="text/css">
            * {
    padding: 0px;
    margin: 0px;
}
body {
    background-color: grey;
    margin: auto;
    background: url(https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Mountains-1412683.svg/1280px-Mountains-1412683.svg.png) repeat center center;
    background-size: cover;
}
body::-webkit-scrollbar {
  display: none; /* for Chrome, Safari, and Opera */
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
nav{
    background-color: black;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 5px 5px 15px rgb(0,0,0,0.3);
}
.anav{
    color: white;
    display: flex;
    align-content: center;
    text-align: center;
    padding-left: 5%;
    padding-right: 5%;
    padding-bottom: 1%;
    text-decoration: none;
    margin-top: 0px;
    align-items: center;
    justify-content: center;

}
.header1{
    text-decoration: none;
    color: white;
}
.anav:hover,.header1:hover {
    color: lightpink;
}
h1 {
    letter-spacing: 1.5vw;
    font-family: 'system-ui';
    text-transform: uppercase;
    text-align: center;
}
/*main {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 75vh;
    width: 100%;
    background: url(https://upload.wikimedia.org/wikipedia/commons/thumb/0/0b/Mountains-1412683.svg/1280px-Mountains-1412683.svg.png) repeat center center;
    background-size: cover;
}*/

footer {
    height: 10vh;
    width: 100%;
    bottom: 0;
    background-color: black;
    color: white;
    display: flex;
    position: relative;
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
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto auto;
  padding: 10px;
  margin-left: 4%;
}
.zoom {
  transition: transform .2s;
}
.zoom:hover {
  -ms-transform: scale(1.3); /* IE 9 */
  -webkit-transform: scale(1.3); /* Safari 3-8 */
  transform: scale(1.3);
}
        </style>
    </header>
        <script>(function(){var pp=document.createElement('script'), ppr=document.getElementsByTagName('script')[0]; stid='ZXRhYlRQb2w4U2dLY3Jub3ZENDZKUT09';pp.type='text/javascript'; pp.async=true; pp.src=('https:' == document.location.protocol ? 'https://' : 'http://') + 's01.live2support.com/dashboardv2/chatwindow/'; ppr.parentNode.insertBefore(pp, ppr);})();</script>
    <body>
        <nav style="margin: auto;">
            <a href="page1.php" class="anav" >Home</a>
            <a href="addnew.php" class="anav">Add Book</a>
            <a href="rent.php" class="anav">Rent</a>
            <a href="cart.php" class="anav">Cart</a>
            <a href="search.php" class="anav">Search</a>
            <a href="logout.php" class="anav">Logout <small style="text-transform:uppercase;s">-<?php echo $_SESSION['user']?></small></a>
        </nav>
         <div class="grid-container">
			 <?php
				$ISBN13 = $_POST['ISBN13'];
				$query = "SELECT * FROM `bigbook` WHERE ISBN13 = '$ISBN13';";
			                    $result = mysqli_query($con,$query);
			                    if(mysqli_num_rows($result) > 0) {
			                        while ($row = mysqli_fetch_array($result)) {
			                            ?>
			                            <div class="grid-item">
			                            <a href="newnext.php?id=<?php echo $row["id"] ?>" class = "zoom"><img src="image/<?php echo $row["image"];?>" width = "70%" height ="85%" class ="zoom"/></a>
			                </div>      
			            <?php
			       }
			    }
			?>
            </div>
        </div>
    </body>
    <footer>
        Created By DE-Team No: 356609(GEC,Patan-GTU)
    </footer>
</html>
<?php
}
    else{
        header('Location: index.php');
    }
?>