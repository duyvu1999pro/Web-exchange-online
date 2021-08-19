<?php 
require_once('setup.php');

session_start();

	if(!isset($_SESSION['userlogin'])){
		header("Location: login.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("Location: login.php");
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
        <li class="active"><a href="#">Trang chủ</a></li>
        <li><a href="<?php echo CLIENT_PATH; ?>transfer.php">Chuyển tiền</a></li>
        <li><a href="<?php echo CLIENT_PATH; ?>card.php">Nạp thẻ</a></li>
        <li><a href="<?php echo CLIENT_PATH; ?>UpdateVip.php">Nâng vip</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="<?php echo CLIENT_PATH; ?>profile.php"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
        <!-- <li><a href="<?php //echo CLIENT_PATH; ?>cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng </a></li> -->
        <li><a href="index.php?logout=true"><span class="glyphicon glyphicon-off"></span>Thoát</a></li>
      </ul>
    </div>
  </div>

</nav>
<?php
  $username="";
  $money="";
  $vip="";
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
 ?>
<div class="form-group">
<p><b>Username : </b><?php echo $username; ?></p>
<p><b>Số tiền hiện có : </b><?php echo $money; ?> VNĐ</p>
<p><b>Account : </b><?php 
  $isVip = 0;
  if(vipLeft($vip) > 0 )
  {
    echo "Vip";
    $isVip = 1;
  }
  else 
  echo "Thường";
?> </p>
</div>



<?php 
$i = 1;
$sql = "SELECT * FROM product";
if($result = mysqli_query($mysqli, $sql)){
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
      if ($i%4==1) {
        echo '<div class="container">';
        echo '<div class="row">';
      }
      echo '<div class="col-sm-3">';
      echo '<div class="panel panel-success">';
      echo '<div class="panel-heading">'.$row['name'].'</div>';
      echo '<div class="panel-body"><img src="'.PICTURE_PATH.$row['picture'].'" class="img-responsive" width="100" height="100" alt="Image">'. $row['content'].'</div>';
      echo '<div class="panel-footer">';
      if ($isVip == 1) {
        echo ($row['cost']*7)/10;
      }
      else
      {
        echo $row['cost'];
      }
      echo ' VNĐ ';
      if ($isVip == 1) {
        echo "/  (30% discount) ";
      }
      echo '<br><a href="'.CLIENT_PATH.'buy.php?id='.$row['id'].'" title="Mua đồ" data-toggle="tooltip">
      <button type="button" class="btn btn-danger">Mua</button></a>
      </div>';
      echo '</div>';
      echo '</div>';
      if ($i%4 == 0 ) {
        echo '</div>';
        echo ' </div><br>';
      } 
      $i++;
    }
    if ($i%4 != 0 ) {
      echo '</div>';
      echo ' </div><br>';
    }
    mysqli_free_result($result);
  }
  else{
    echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
}
} else{
echo "Oops! Something went wrong. Please try again later.";
}
mysqli_close($mysqli);

?>  
<!-- 
<div class="container">   
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-primary">
        <div class="panel-heading">BLACK FRIDAY DEAL</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer"><button type="button" class="btn btn-danger">Add</button></div>   
      </div>
    </div>

    <div class="col-sm-4"> 
      <div class="panel panel-danger">
        <div class="panel-heading">BLACK FRIDAY DEAL</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">Buy 50 mobiles and get a gift card</div>
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-success">
        <div class="panel-heading">BLACK FRIDAY DEAL</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">Buy 50 mobiles and get a gift card</div>
      </div>
    </div>
  </div>
</div><br>

<div class="container">    
  <div class="row">
    <div class="col-sm-4">
      <div class="panel panel-primary">
        <div class="panel-heading">BLACK FRIDAY DEAL</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">Buy 50 mobiles and get a gift card</div>
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">BLACK FRIDAY DEAL</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">Buy 50 mobiles and get a gift card</div>
      </div>
    </div>
    <div class="col-sm-4"> 
      <div class="panel panel-primary">
        <div class="panel-heading">BLACK FRIDAY DEAL</div>
        <div class="panel-body"><img src="https://placehold.it/150x80?text=IMAGE" class="img-responsive" style="width:100%" alt="Image"></div>
        <div class="panel-footer">Buy 50 mobiles and get a gift card</div>
      </div>
    </div>
  </div>
</div><br> -->




</body>
</html>
<?php } ?>