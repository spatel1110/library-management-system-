<?php $con = mysqli_connect("localhost","root","","library"); 
session_start();
$user = $_SESSION['user'];
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
    background-color: whitesmoke;
    margin: auto;
    background-size: cover;
    color: auto;
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
    color: skyblue;
}
h1 {
    letter-spacing: 1.5vw;
    font-family: 'system-ui';
    text-transform: uppercase;
    text-align: center;
}
h2 {
    letter-spacing: 0.5vw;
    font-family: 'system-ui';
    text-transform: uppercase;
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
    position: absolute;
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
h2::before {  
  transform: scaleX(0);
  transform-origin: bottom right;
}

h2:hover::before {
  transform: scaleX(1);
  transform-origin: bottom left;
}

h2::before {
  content: " ";
  display: block;
  position: absolute;
  top: 0; right: 0; bottom: 0; left: 0;
  inset: 0 0 0 0;
  background: greenyellow;
  z-index: -1;
  transition: transform 0.5s ease;
}

h2 {
  position: relative;
  font-size: 2rem;
}
table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #ddd;
  padding: 8px;
}

tr:nth-child(even){background-color: #f2f2f2;}

tr:hover {background-color: #ddd;}

th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: royalblue;
  color: white;
}
#Remove{
    border-radius: 0;
    font-weight: 60;
    background: royalblue;
    color: #fff;
    display: inline-block;
    border-radius: 8px;
    padding: 10px 35px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 10px;
    width: 10%;
    line-height: 1.42;
    border: 1px solid #17191d;
    min-height: 44px;
    margin: 0 10px 10px 0;
    transition: color .25s ease-in-out,background .25s ease-in-out,border .25s ease-in-out;
    word-wrap: break-word;
    white-space: normal;
}
#Buy,#Rent{
    border-radius: 0;
    font-weight: 700;
    background: #17191d;
    color: #fff;
    transition: all .1s ease-in-out 0s;
    display: inline-block;
    padding: 10px 35px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 14px;
    width: 40%;
    line-height: 1.42;
    border: 1px solid #17191d;
    min-height: 44px;
    margin: 0 10px 10px 0;
    transition: color .25s ease-in-out,background .25s ease-in-out,border .25s ease-in-out;
    word-wrap: break-word;
    white-space: normal;
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
    <div style="margin:2%;">
        <h2>Rent</h2>
       <?php
            $total = 0;
            echo "<table border = 1>";
            echo "<tr><th>Id</th><th>Book Name</th><th>ISBN13</th><th>Price(USD)</th><th>quantity</th>";
            $query = "SELECT * FROM `rent` WHERE user = '$user';";

            if ($result = $con->query($query)) {

                /* fetch associative array */
                while ($row = $result->fetch_assoc()) {
                    echo "<tr><td>".$row["id"]."</td><td>".$row["bname"]."</td><td>".$row["ISBN13"]."</td><td>".$row["price"]."</td><td>".$row["quantity"]."</td></tr>";
                    $total = $total + $row["price"];
                }
            echo "</table>";
        }
        $result->free();
       ?>
       <br>
       <span>After Returning Books This Table might emptied by Our Staff And Added in Available book.</span>
           </label>
       </form>
    </div>
    </body>
    <footer>
        Created By DE-Team No: 356609(GEC,Patan-GTU)
    </footer>
</html>