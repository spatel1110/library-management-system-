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
    color: lightpink;
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

h3::before {  
  transform: scaleX(0);
  transform-origin: top right;
}

h3:hover::before {
  transform: scaleX(1);
  transform-origin: top left;
}

h3::before {
  content: " ";
  display: block;
  position: absolute;
  top: 0; right: 0; bottom: 0; left: 0;
  inset: 0 0 0 0;
  background: gold;
  z-index: -1;
  transition: transform 0.6s ease;
}

h3 {
  position: relative;
  font-size: 2rem;
}
span{
    font-family: 'system-ui';
    width: auto;
    height: auto;
    background: transparent;
    font-size: 1.2rem;
}
aside{
    font-family: 'system-ui';
    width: auto;
    height: auto;
    background: transparent;
    text-decoration: none;
    color: black;
    display: block;
    transition: 0.25s ease;
}
aside:hover{
    transform: translate(-10px, -20px);
    border-color: cyan;
    border-style: solid;
    color: floralwhite;
    box-shadow: 10px 20px;
}
#AddToCart{
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
    width: 100%;
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
        <?php
       $id = $_GET['id'];
       $query = "SELECT * FROM bigbook WHERE id = $id";
       $result = mysqli_query($con,$query);
       if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        }
        ?>
        <h2><?php echo $row['bname'];?>
            <small style="font-size: 15px;">By <?php echo $row['Author']; ?></small>
        </h2><br>
        <div align="left" style="position:relative;"><img src="image/<?php echo $row["image"]; ?>"/>
        <div style="position:absolute; margin-left: 400px; bottom: 15%; padding-right: 10px;">
            <h3>About Book</h3>
            <br>
            <br>
            <aside>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row["aboutbook"]; ?>.</aside>
        </div>
    </div>
        <div style="position:relative; margin:1%; padding: 10px;">
           <h3> Product details</h3>
           <span>
                ASIN: <?php echo $row["ASIN"];?><br/>
                Publisher: <?php echo $row["Publisher"];?><br/>
                Language: <?php echo $row["Lan"];?><br/>
                ISBN-13: <?php echo $row["ISBN13"];?><br/>
                available book : <?php echo $row["stock"];?><br>
                <form method="POST">
                    <input type="hidden" name="id" id="id" value="<?php echo $row['id'];?>">
                    <input type="hidden" name="bname" value="<?php echo $row['bname'];?>">
                    <input type="hidden" name="ISBN13" value="<?php echo $row['ISBN13'];?>">
                    <input type="hidden" name="price" value="<?php echo $row['price'];?>">
                    <button type="submit" name="addtocart" id="AddToCart" class="btn btn--full" style="font-family: din-2014,sans-serif !important;">
                    <span id="AddToCartText">Add to Cart</span> <span class="hc-money-btn">-$<?php echo $row["price"]; ?></span>
                  </button>
                </form>
            </span>
        </div>
    </div>
    </body>
    <footer>
        Created By DE-Team No: 356609(GEC,Patan-GTU)
    </footer>
</html>
<?php
    $id = $_GET['id'];
    $user1 = $_SESSION['user'];
    $q = "SELECT * FROM `cart` WHERE user = '$user1' AND id = '$id';";
    $result = mysqli_query($con,$q);
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
    }
    else{
        echo "failed to connect to cart";
    }

if (isset($_POST['addtocart'])) {
    if ($row['quantity'] == 0) {
        $id = $_POST['id'];
        $bname = $_POST['bname'];
        $ISBN13 = $_POST['ISBN13'];
        $price = $_POST['price'];
        $user = $_SESSION['user'];
        $q = "INSERT INTO `cart`(`id`, `bname`, `ISBN13`, `price`, `quantity`, `user`) VALUES ('$id','$bname','$ISBN13','$price','1','$user');";
        if (mysqli_query($con,$q)) {
            $q1 = "SELECT * FROM `bigbook` WHERE id = '$id';";
            $result1 = mysqli_query($con,$q1);
            if(mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_array($result1);
            }
            $newquantity1 = $row1['stock']-1;
            $q2 = "UPDATE `bigbook` SET `stock`='$newquantity1' WHERE id = '$id';";
            $result2 = mysqli_query($con,$q2);
            echo '<script>alert("Book Added Successfully")</script>';
        }
        else{
            echo "SQL ERROR :-" .mysqli_error($con);;
            
        }
    }
    else{
        $price = $_POST['price'];
        $newquantity = $row['quantity']+1;
        $price1 = $row['price']+$price;
        $id = $_POST['id'];
        $bname = $_POST['bname'];
        $ISBN13 = $_POST['ISBN13'];
        $price = $_POST['price'];
        $user = $_SESSION['user'];
        $q = "UPDATE `cart` SET `quantity`='$newquantity',`price`='$price1' WHERE id = '$id'";
        if (mysqli_query($con,$q)) {
            $q1 = "SELECT * FROM `bigbook` WHERE id = '$id';";
            $result1 = mysqli_query($con,$q1);
            if(mysqli_num_rows($result1) > 0) {
                $row1 = mysqli_fetch_array($result1);
            }
            $newquantity1 = $row1['stock']-1;
            $q2 = "UPDATE `bigbook` SET `stock`='$newquantity1' WHERE id = '$id'";
            $result2 = mysqli_query($con,$q2);
            echo '<script>alert("Book Added Successfully")</script>';
            }
        else{
            echo "SQL ERROR :-" .mysqli_error($con);
            
        }
    }
    ?>
   <script>location.href = "http://localhost/DE/newnext.php?id=<?php echo $id?>";</script>';
    <?php
}
?>
<?php
}
    else{
        header('Location: index.php');
    }
?>