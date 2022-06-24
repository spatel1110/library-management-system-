<?php
    session_start();
    $database_name = "library";
    $con = mysqli_connect("localhost","root","",$database_name);
    $user = $_SESSION['user'];
    if (isset($_SESSION['user'])) {
        if ($_SESSION['admin'] == 'YES') {?>
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
#add{
    border-radius: 0;
    font-weight: 60;
    background: black;
    color: whitesmoke;
    display: inline-block;
    border-radius: 8px;
    padding: 10px 35px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-size: 8px;
    width: 10%;
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
        <h2 style="margin-bottom: 1%;">Add Book</h2>
        <form method="POST" style="margin:20px">
                <table align="center">
                    <tr>
                        <td>Book Name:</td>
                        <td><input type="text" name="bname" placeholder="Name" required></td>
                    </tr>
                    <tr>
                        <td>Author:</td>
                        <td><input type="text" name="author" placeholder="author" required></td>
                    </tr>
                    <tr>
                        <td>Publisher:</td>
                        <td><input type="text" name="Publisher" placeholder="Publisher Name" required></td>
                    </tr>
                    <tr>
                        <td>Language:</td>
                        <td><input type="text" name="Lan" placeholder="English" required></td>
                    </tr>
                    <tr>
                        <td>ASIN:</td>
                        <td><input type="text" name="ASIN" placeholder="if not then -" required></td>
                    </tr>
                    <tr>
                        <td>ISBN-13:</td>
                        <td><input type="text" name="ISBN13" placeholder="987-1425365478" required></td>
                    </tr>
                    <tr>
                        <td>Image:</td>
                        <td><input type="text" name="iname" placeholder="Image Name no space" required> <small><a href="upload.html" target="_blank">Upload Image</a></small></td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td><input type="number" name="price" placeholder="USD" step="0.01" required></td>
                    </tr>
                     <tr>
                        <td>Stock:</td>
                        <td><input type="number" name="stock" placeholder="20" required></td>
                    </tr>
                    <tr>
                        <td>About Book:</td>
                        <td><textarea cols="50" rows="10" name="aboutbook"></textarea></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                        <button type="submit" name="add" id="add" class="btn btn--full" style="font-family: din-2014,sans-serif !important;">
                        <span id="AddToCartText">Add Book</span> <span class="hc-money-btn"></span>
                      </button>
                  </td>
                    </tr>
                </table>
            </form>
    </div>
    </body>
    <footer>
        Created By DE-Team No: 356609(GEC,Patan-GTU) 
    </footer>
</html>
<?php

        if (isset($_POST['add'])) {
            $bname = $_POST['bname'];
            $author = $_POST['author'];
            $Publisher = $_POST['Publisher'];
            $Lan = $_POST['Lan'];
            $ASIN = $_POST['ASIN'];
            $ISBN13 = $_POST['ISBN13'];
            $iname = $_POST['iname'];
            $price = $_POST['price'];
            $aboutbook = $_POST['aboutbook'];
            $stock = $_POST['stock'];

            $q = "INSERT INTO `bigbook`(`bname`, `Author`, `Publisher`, `Lan`, `ISBN13`, `ASIN`, `image`, `price`, `aboutbook`, `stock`) VALUES ('$bname','$author','$Publisher','$Lan','$ISBN13','$ASIN','$iname','$price','$aboutbook','$stock')";
            if (mysqli_query($con,$q)) {
                echo '<script>alert("Student Info Inserted Successfully")</script>';
            }
            else{
                echo mysqli_error($con);
            }
        }
        ?><?php
        }
        else{?>
            <script>alert("Your account type is not Librarian");
                location.href = "http://localhost/DE/page1.php";
            </script><?php

        }
        ?>
<?php 
    }
    else{
        header('location: index.php');
    }
?>