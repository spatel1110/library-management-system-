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
.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto auto;
  padding: 10px;
  margin-left: 4%;
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
.form-inline {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: horizontal;
    -webkit-box-direction: normal;
    -ms-flex-flow: row wrap;
    flex-flow: row wrap;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
}
.form-control {
    display: block;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
[type=search] {
    outline-offset: -2px;
    -webkit-appearance: none;
}
button, input {
    overflow: visible;
}
.btn {
    display: inline-block;
    font-weight: 400;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    border: 1px solid transparent;
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    line-height: 1.5;
    border-radius: 0.25rem;
    transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
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
    </div>
        <div style="position:relative; margin:1%; padding: 10px;">
        <form class="form-inline" action="result.php" method="POST">
            <input class="form-control mr-sm-2" type="text" placeholder="Search With book name" aria-label="Search" name="bookname">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
        <div style="position:relative; margin:1%; padding: 10px;">
        <form class="form-inline" action="result1.php" method="POST">
            <input class="form-control mr-sm-2" type="text" placeholder="Search With ISBN13" aria-label="Search" name="ISBN13">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        </div>
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