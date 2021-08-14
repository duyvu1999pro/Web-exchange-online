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
    .wrapper{
            width: 400px;
            margin: 0 auto;
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
        <li class="active"><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
        <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng </a></li>
        <li><a href="<?php echo ROOT_PATH; ?>index.php?logout=true"><span class="glyphicon glyphicon-off"></span>Thoát</a></li>
      </ul>
    </div>
  </div>

</nav>

<div class="container-fluid">   
<div class="row">
     
  <div class="col-md-3">                
                    <form action="profile.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <img src='../image/avatar/chinh.PNG' width='300' height='300' style="margin-bottom: 20px;"/>
                            <label>Username: </label> chinhxu123<br>
                            <label>Số tiền hiện có: </label> 1 VNĐ<br>
                            <label>Hiệu lực Vip còn:   </label> 0 ngày<br>
                        </div>         
                    </form>
  </div>

  <div class="col-md-3" style="margin-left: 20px;">   
  <h3 >Thông tin cá nhân</h3>         
                    <form action="profile.php" method="post"  enctype="multipart/form-data">
                      
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Avatar</label>                                       
                            <input type="file" name="avatar" class="form-control" >                
                            <span class="invalid-feedback"></span>
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Cập nhật">      
                        <div class="form-group">
                        <label>Mật khẩu cũ</label>
                            <input type="text" name="username" class="form-control" >
                            <label>Mật khẩu mới</label>
                            <input type="text" name="username" class="form-control" >
                        </div>
                        <input type="submit" class="btn btn-primary" name="submit" value="Đổi mật khẩu">    
                    </form>
  </div>
  
  <div class="container-fluid bg-3 text-center">    
  <h3 >item hiện có</h3>   
  <div class="row">
    <div class="col-sm-3">
      <p>Some text..</p>
      <img src="../image/avatar/chinh.PNG" class="img-responsive"  width='50' height='50'alt="Image">
    </div>
    <div class="col-sm-3"> 
      <p>Some text..</p>
      <img src="../image/avatar/chinh.PNG" class="img-responsive"  width='50' height='50'alt="Image">
    </div>
    <div class="col-sm-3"> 
      <p>Some text..</p>
      <img src="../image/avatar/chinh.PNG" class="img-responsive"  width='50' height='50'alt="Image">
    </div>
    <div class="col-sm-3">
      <p>Some text..</p>
      <img src="../image/avatar/chinh.PNG" class="img-responsive"  width='50' height='50'alt="Image">
    </div>
  </div>
</div><br><br>



</div>
</div><br> 

</body>
</html>