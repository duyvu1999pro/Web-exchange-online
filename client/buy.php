<?php
  require_once "setup.php";
  session_start();
  if(!isset($_SESSION['userlogin'])){
      header("Location: ../index.php");
  } 
  
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $money = $cost = "";
    
  $sql = "SELECT * FROM user WHERE id = ? ";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "i", $user_id);
            $user_id = $_SESSION['userlogin'];
            if(mysqli_stmt_execute($PrepareQuery)){
                $result = mysqli_stmt_get_result($PrepareQuery); 
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $money = $row['money'];          		
                }
			}
		} 
		
    $sql = "SELECT * FROM product WHERE id = ? ";
            if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
                mysqli_stmt_bind_param($PrepareQuery, "i", $product_id);
                $product_id = $_POST["id"];
                if(mysqli_stmt_execute($PrepareQuery)){
                    $result = mysqli_stmt_get_result($PrepareQuery); 
                    if(mysqli_num_rows($result) == 1){
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $cost = $row['cost'];          		
                    }
                }
            } 
              
    if ($money < $cost) {
        echo "không đủ tiền";
    }
    else
    {
        $money=$money-$cost;
       
        $sql = "call buy(?,?,?) ";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "iii",$user_id, $product_id,$money);
            $product_id = $_POST["id"];
            $user_id = $_SESSION['userlogin'];
           mysqli_stmt_execute($PrepareQuery);
        } 
            mysqli_stmt_close($PrepareQuery);
    mysqli_close($mysqli);
        echo "mua thành công";
        //header("location: ../index.php");
    }
} 
else{

    if(empty(trim($_GET["id"]))){
        header("location: ../error.php");
        exit();
    }
}
?>

<?php if(isset($_SESSION['userlogin'])){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Product</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                <?php if(isset($_GET["id"]) && !empty($_GET["id"])){?>
                    <h2 class="mt-5 mb-3">Mua hàng</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">  
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Bạn chắc chắn muốn mua ?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="../index.php" class="btn btn-secondary">No</a>
                            </p>
                            <?php } else {?>
                                <a href="../index.php" class="btn btn-secondary">Back</a>
                                <?php } ?>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php } ?>