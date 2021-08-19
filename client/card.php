<?php 
require_once('setup.php');
session_start();
	if(!isset($_SESSION['userlogin'])){
		header("Location: ".ROOT_PATH."login.php");
	}
  if(isset($_POST["submit"]) && !empty($_POST["submit"]) ){
    $money= $code = $id_card = "";
    $check = 0;
    $sql = "SELECT * FROM card WHERE code = ? ";
    if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
        mysqli_stmt_bind_param($PrepareQuery, "s", $code);
        $code = $_POST["card"];
        if(mysqli_stmt_execute($PrepareQuery)){
            $result = mysqli_stmt_get_result($PrepareQuery); 
            if(mysqli_num_rows($result) == 1){
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $money = $row['money']; 
                $id_card = $row['id'];      
                $check = 1;  		
            }
            else
            echo "mã thẻ không đúng";
         }
    }
    if ($check == 1) { 
      $sql = "call recharge(?,?,?) ";
      if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
          mysqli_stmt_bind_param($PrepareQuery, "iii",$card_id, $user_id,$money);
          $card_id = $id_card ;
          $user_id = $_SESSION['userlogin'];
         mysqli_stmt_execute($PrepareQuery);
      } 
         
      echo "nạp thẻ thành công";
    }
   
  }

?>

<?php if(isset($_SESSION['userlogin'])){ ?>
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
            width: 600px;
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
        <li class="active"><a href="card.php">Nạp thẻ</a></li>
        <li><a href="UpdateVip.php">Nâng vip</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
        <!-- <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng </a></li> -->
        <li><a href="<?php echo ROOT_PATH; ?>index.php?logout=true"><span class="glyphicon glyphicon-off"></span>Thoát</a></li>
      </ul>
    </div>
  </div>

</nav>
<?php
  $username="";
  $money="";
	$sql = "SELECT * FROM user WHERE id = ? ";
  if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
      mysqli_stmt_bind_param($PrepareQuery, "i", $param_id);
      $param_id = $_SESSION['userlogin'];
      if(mysqli_stmt_execute($PrepareQuery)){
          $result = mysqli_stmt_get_result($PrepareQuery); 
          if(mysqli_num_rows($result) == 1){
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $username = $row['username'];  
              $money =    $row['money'];  
          }
        }
      }
       mysqli_stmt_close($PrepareQuery);
          mysqli_close($mysqli);
 ?>
<div class="form-group">
<p><b>Username : </b><?php echo $username; ?></p>
<p><b>Số tiền hiện có : </b><?php echo $money; ?> VNĐ</p>
                    </div>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <form action="card.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">  
                            <label>Nhập mã thẻ</label>
                            <input type="text" name="card" class="form-control" size="30" >
                            <span class="invalid-feedback"></span>
                            
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" name="submit" value="Xác nhận"> 
                            </div>  
                        
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php } ?>