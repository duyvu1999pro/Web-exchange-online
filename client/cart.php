<?php 
require_once('setup.php');
session_start();
	if(!isset($_SESSION['userlogin'])){
		header("Location: ".ROOT_PATH."login.php");
	}

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Store Online</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <style>
    /* Remove the navbar's default rounded borders and increase the bottom margin */ 
    .navbar {
      margin-bottom: 50px;
      border-radius: 0;
    }
    
    /* Remove the jumbotron's default bottom margin */ 
     .jumbotron {
      margin-bottom: 0;
    }
   
    /* Add a gray background color and some padding to the footer */
    footer {
      background-color: #f2f2f2;
      padding: 25px;
    }
  </style>
</head>
<body>

<div class="jumbotron">
  <div class="container text-center">
    <h1>Mua bán, chuyển khoản trực tuyến </h1>      
    <p> An toàn, Nhanh chóng & Hiệu quả </p>
  </div>
</div>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">   
        <li><a href="<?php echo ROOT_PATH; ?>index.php">Trang chủ</a></li>
        <li><a href="transfer.php">Chuyển tiền</a></li>
        <li><a href="rechargeCard.php">Nạp thẻ</a></li>
        <li><a href="UpdateVip.php">Nâng vip</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
        <li class="active"><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng </a></li>
        <li><a href="<?php echo ROOT_PATH; ?>index.php?logout=true"><span class="glyphicon glyphicon-off"></span>Thoát</a></li>
      </ul>
    </div>
  </div>
</nav>


</body>
</html>