<?php $con = mysqli_connect("localhost","root","","library");
session_start();
if (isset($_SESSION['user'])){
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
          <div>
            <ul id="user">
                <li type="none">Welcome
                <a href="myaccount.php">Yax</a></li>
            </ul>
          </div>
        <div style="position: relative; top: 30px; margin: 5%;">
            <form method="POST">
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
                        <td>Image Name:</td>
                        <td><input type="text" name="iname" placeholder="not space and .jpg" required></td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td><input type="number" name="price" placeholder="USD" required></td>
                    </tr>
                    <tr>
                        <td>About Book:</td>
                        <td><textarea cols="50" rows="10" name="aboutbook"></textarea></td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="add" value="Add"></td>
                    </tr>
                </table>
            </form>
        </div>
        </body>
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

            $q = "INSERT INTO `bigbook`(`bname`, `Author`, `Publisher`, `Lan`, `ISBN13`, `ASIN`, `image`, `price`, `aboutbook`) VALUES ('$bname','$author','$Publisher','$Lan','$ISBN13','$ASIN','$iname','$price','$aboutbook')";
            if (mysqli_query($con,$q)) {
                echo '<script>alert("Student Info Inserted Successfully")</script>';
            }
            else{
                echo mysqli_error($con);
            }
        }
        ?><?php 
    }
    else{
        header('location: index.php');
    }
?>
