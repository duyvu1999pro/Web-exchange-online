<?php
// Include config file
require_once "setup.php";
session_start();
	if(!isset($_SESSION['admin'])){
		header("Location: ../index.php");
	} 

$error="";
if(isset($_POST['submit']) & !empty($_POST)){
  
    $username = $_POST["username"];
    $password = $_POST["password"];

    if($error == ""){     
            $sql = "INSERT INTO admin (username,password) VALUES (?,?)";
             
            if($PrepareQuery = mysqli_prepare($mysqli, $sql)){            
                mysqli_stmt_bind_param($PrepareQuery, "ss",$username,$password);                    
                if(mysqli_stmt_execute($PrepareQuery)){                 
                    header("location: index.php");
                    exit();
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
            mysqli_stmt_close($PrepareQuery);

       // }      
    }
    mysqli_close($mysqli);
 }
?>
 <?php if(isset($_SESSION['admin'])){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Trang thêm mới</title>
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
                    <h2 class="mt-5">Create Admin</h2>              
                    <form action="create.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu</label>
                            <input type="text" name="password" class="form-control" >
                        </div>  
                    
                      
                        <?php echo $error; ?>

                        <input type="submit" class="btn btn-primary" name="submit" value="Tạo">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php } ?>