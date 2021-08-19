<?php 
require_once('setup.php');
session_start();
	if(!isset($_SESSION['userlogin'])){
		header("Location: ".ROOT_PATH."login.php");
	}
  $username="";
  $money="";
  $vip ="";
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
              $vip =    $row['vip'];  
          }
        }
      }
  if(isset($_POST["submit"]) && isset($_POST["vip"])){

   
    $check = 0;
    $cost= 0;
    if ($_POST["vip"] == 3 ) {
      $check = 1;
      $cost = 50000;
    }
    if ($_POST["vip"] == 7 ) {
      $check = 1;
      $cost = 100000;
    }
    if ($_POST["vip"] == 30 ) {
      $check = 1;
      $cost = 300000;
    }
    if ($_POST["vip"] == 365 ) {
      $check = 1;
      $cost = 2500000;
    }
    if ($check == 1) {
      if ($money < $cost) {
        echo " không đủ tiền ";
      }
      else
      {
        $money = $money - $cost;
        $date = "";
        if (vipLeft($vip) > 0 ) {

          $date = addDate( $_POST["vip"]-1, $vip );
        }
        else
        {
            $date = addDate( $_POST["vip"]-1, date("Y-m-d") );
        }
        
        $sql = "UPDATE user SET money=?,vip=? WHERE id=?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "isi",$money, $date, $user_id);
            $user_id = $_SESSION['userlogin'];
           mysqli_stmt_execute($PrepareQuery);
           echo "nâng vip thành công";
        } 
      }
    
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
        <li><a href="card.php">Nạp thẻ</a></li>
        <li class="active"><a href="UpdateVip.php">Nâng vip</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
        <!-- <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng </a></li> -->
        <li><a href="<?php echo ROOT_PATH; ?>index.php?logout=true"><span class="glyphicon glyphicon-off"></span>Thoát</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="form-group">
<p><b>Username : </b><?php echo $username; ?></p>
<p><b>Số tiền hiện có : </b><?php echo $money; ?> VNĐ</p>
                    </div>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <p><b>Thời hạn Vip:</b> <?php echo vipLeft($vip); ?> ngày</p>        
                    <form action="UpdateVip.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Mua Vip để được hưởng ưu đãi giảm giá 30% cho tất cả các sản phẩm</label>
                            <select name="vip"  class="btn btn-default" style="width:250px;">
                            <option value="3" class="btn btn-default"  >3 ngày  -  50.000 VNĐ</option>
                            <option value="7" class="btn btn-default"  >7 ngày  -  100.000 VNĐ</option>
                            <option value="30" class="btn btn-default"  >30 ngày  -  300.000 VNĐ</option>
                            <option value="365" class="btn btn-default"  >365 ngày  -  2.500.000 VNĐ</option> 
                            </select>      
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