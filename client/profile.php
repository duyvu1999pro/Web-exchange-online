<?php 
require_once('setup.php');
session_start();
	if(!isset($_SESSION['userlogin'])){
		header("Location: ".ROOT_PATH."login.php");
	}
  $username = $password = $email =  $phone = $avatar = $money = $vip = "";
  $sql = "SELECT * FROM user WHERE id = ? ";
  if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
      mysqli_stmt_bind_param($PrepareQuery, "i", $user_id);
      $user_id = $_SESSION['userlogin'];
      if(mysqli_stmt_execute($PrepareQuery)){
          $result = mysqli_stmt_get_result($PrepareQuery); 
          if(mysqli_num_rows($result) == 1){
              $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
              $username = $row['username'];    
              $password = $row['password'];    
              $email =  $row['email'];    
              $phone = $row['phone'];    
              $avatar = $row['avatar'];    
              $money = $row['money'];    
              $vip =   $row['vip'];      		
          }
        }
        mysqli_stmt_close($PrepareQuery);
        //mysqli_close($mysqli);
  }
  if(isset($_POST['update']) & !empty($_POST)){
    
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    if(isValidEmail($email) && isValidPhone($phone))
    {
      if(basename($_FILES["avatar"]["name"]) != "")
      {
        $avatar = basename($_FILES["avatar"]["name"]);
       $avatar = encodeName($avatar);
       $path = getcwd().DIRECTORY_SEPARATOR;
       $path .= AVATAR_PATH .$avatar ;
       move_uploaded_file( $_FILES["avatar"][ 'tmp_name' ], $path );
       $sql = "UPDATE user SET avatar=? WHERE user.id=?";
       if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
          mysqli_stmt_bind_param($PrepareQuery, "si",$avatar,$id);
          $id = $_SESSION['userlogin'];
          mysqli_stmt_execute($PrepareQuery);
        }
      }
      $sql = "UPDATE user SET email=?, phone=? WHERE user.id=?";
      if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
          mysqli_stmt_bind_param($PrepareQuery, "ssi",$email,$phone,$id);
          $id = $_SESSION['userlogin'];
          mysqli_stmt_execute($PrepareQuery);
      }
      echo "cập nhật thông tin cá nhân thành công";
    }
    else
      echo "email hoặc sđt không đúng";
  }

  if(isset($_POST['ch-pass']) & !empty($_POST)){
    //$temp_pass = $_POST["newpass"];
      if($_POST["oldpass"] != $password)
      {
        echo "pass cũ không đúng";
      }
      else if ($_POST["newpass"] == "")
      {
        echo "chưa nhập pass";
      }
      else
      {
        $sql = "UPDATE user SET password=? WHERE id=?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "si",$password,$id);
            $id = $_SESSION['userlogin'];
            $password = $_POST["newpass"];
            mysqli_stmt_execute($PrepareQuery);
            echo "đổi pass thành công";
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
        <li><a href="card.php">Nạp thẻ</a></li>
        <li><a href="UpdateVip.php">Nâng vip</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="profile.php"><span class="glyphicon glyphicon-user"></span> Thông tin cá nhân</a></li>
        <!-- <li><a href="cart.php"><span class="glyphicon glyphicon-shopping-cart"></span> Giỏ hàng </a></li> -->
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
                            <img src='<?php echo AVATAR_PATH.$avatar; ?>' width='300' height='300' style="margin-bottom: 20px;"/>
                            <label>Username: </label> <?php echo $username; ?><br>
                            <label>Số tiền hiện có: </label> <?php echo $money; ?> VNĐ<br>
                            <label>Thời hạn Vip :   </label> <?php echo vipLeft($vip); ?> ngày<br>
                        </div>         
                    </form>
  </div>

  <div class="col-md-3" style="margin-left: 20px;">   
  <h3 >Thông tin cá nhân</h3>         
                    <form action="profile.php" method="post"  enctype="multipart/form-data">
                      
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>" >
                        </div>
                        <div class="form-group">
                            <label>Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>">
                        </div>
                        <div class="form-group">
                            <label>Avatar</label>                                       
                            <input type="file" name="avatar" class="form-control" >                
                        </div>
                        <input type="submit" class="btn btn-primary" name="update" value="Cập nhật">      
                        <div class="form-group">
                        <label>Mật khẩu cũ</label>
                            <input type="password" name="oldpass" class="form-control" >
                            <label>Mật khẩu mới</label>
                            <input type="password" name="newpass" class="form-control" >
                        </div>
                        <input type="submit" class="btn btn-primary" name="ch-pass" value="Đổi mật khẩu">    
                    </form>
  </div>
  
  <div class="container-fluid bg-3 text-center">    
  <h3 >item hiện có</h3>   
  <?php 
  $i = 1;
  $sql = "SELECT * FROM product,owned where owned.product_id=product.id and owned.user_id=".$_SESSION['userlogin'];
  if($result = mysqli_query($mysqli, $sql)){
    if(mysqli_num_rows($result) > 0){
      while($row = mysqli_fetch_array($result)){
        if ($i%3==1) {
          echo '<div class="container"  style="margin-right: -15px;>';
          echo '<div class="row" >';
        }
        echo '<div class="col-sm-2">';
        echo '<div class="panel panel-success">';
        echo '<div class="panel-heading">'.$row['name'].'</div>';
        echo '<div class="panel-body"><img src="'.PICTURE_PATH.$row['picture'].'" class="img-responsive" width="50" height="50" alt="Image" style="margin-left: 30px;"></div>';
        echo '<div class="panel-footer">Số lượng: '.$row['quantity'].'</div>';
        //echo '<p >'.$row['name'].'</p>';
      // cho '<img src="'.PICTURE_PATH.$row['picture'].'" class="img-responsive" width="50" height="50" alt="Image" style="margin-left: 100px;">';
        echo '</div>';
        echo '</div>';
        $i++;
      }
      if ($i%3 != 0 ) {
        echo '</div>';
        echo ' </div><br>';
      }
    }
  }
  mysqli_close($mysqli);
  ?>

</div>
<br><br>



</div>
</div><br> 

</body>
</html>
<?php } ?>