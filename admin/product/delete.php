<?php
  require_once "setup.php";
  session_start();
  if(!isset($_SESSION['admin'])){
      header("Location: ../index.php");
  } 
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $sql = "DELETE FROM product WHERE id = ?";  
    if($PrepareQuery = mysqli_prepare($mysqli, $sql)){    
        mysqli_stmt_bind_param($PrepareQuery, "i", $param_id); 
        $param_id = trim($_POST["id"]);
        if(mysqli_stmt_execute($PrepareQuery)){
            header("location: index.php");
            exit();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
    mysqli_stmt_close($PrepareQuery);  
    mysqli_close($mysqli);
} else{

    if(empty(trim($_GET["id"]))){
        header("location: ../error.php");
        exit();
    }
}
?>

<?php if(isset($_SESSION['admin'])){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Record</title>
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
                    <h2 class="mt-5 mb-3">Xóa Product</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>Bạn chắc chắn muốn xóa ?</p>
                            <p>
                                <input type="submit" value="Yes" class="btn btn-danger">
                                <a href="index.php" class="btn btn-secondary">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php } ?>