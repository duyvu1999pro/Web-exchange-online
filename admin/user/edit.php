<?php

require_once "setup.php";
session_start();
	if(!isset($_SESSION['admin'])){
		header("Location: ../index.php");
    }    
$id = $username = $password = $email = $phone = $avatar = $money = $vip = "";
 
if(isset($_POST['submit']) & !empty($_POST)){
    $id = $_POST["id"];
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $avatar = basename($_FILES["avatar"]["name"]);
  
    $money = $_POST["money"];
    $vip = $_POST["vip"];
    $error = isValidInputUser($username,$password,$email,$phone,$money,$vip);

    if($error == ""){
        if(basename($_FILES["avatar"]["name"]) != "")
        {
         $avatar = encodeName($avatar);
         $path = getcwd().DIRECTORY_SEPARATOR;
         $path .= AVATAR_PATH .$avatar ;
         move_uploaded_file( $_FILES["avatar"][ 'tmp_name' ], $path );
         $sql = "UPDATE user SET avatar=? WHERE user.id=?";
         if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "si",$avatar,$id);

            if(mysqli_stmt_execute($PrepareQuery)){
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
          }
        }
        $sql = "UPDATE user SET username=?, password=?, email=?, phone=?, money=?, vip=? WHERE user.id=?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
           
            mysqli_stmt_bind_param($PrepareQuery, "ssssisi",$username,$password,$email,$phone,$money,$vip,$id);

            if(mysqli_stmt_execute($PrepareQuery)){
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }

        mysqli_stmt_close($PrepareQuery);
    }
    mysqli_close($mysqli);
} 
else
{

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){  
        $id =  trim($_GET["id"]);
        $sql = "SELECT * FROM user WHERE id = ?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "i", $param_id);
            $param_id = $id;
            if(mysqli_stmt_execute($PrepareQuery)){
                $result = mysqli_stmt_get_result($PrepareQuery);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $username = $row['username'];
                    $password = $row['password'];
                    $email = $row['email'];
                    $phone = $row['phone'];
                    $avatar = $row['avatar']; 
                    $money = $row['money'];
                    $vip =$row['vip'];
                 
                } else{
                    header("location: ../error.php");
                    exit();
                }    
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($PrepareQuery);
        mysqli_close($mysqli);
    }  else{
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
                    <h2 class="mt-5">Update User</h2>              
                    <form action="edit.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" value="<?php echo $password; ?>">                       
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" value="<?php echo $phone; ?>" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label> Avatar :</label>    
                            <img src='<?php echo AVATAR_PATH.$row['avatar']; ?>' width='100' height='100' />
                            <label><?php echo $avatar; ?></label>                               
                            <label> Chọn ảnh upload:</label>     
                            <input type="file" name="avatar" class="form-control" >                
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Money</label>
                            <input type="text" name="money" class="form-control" value="<?php echo $money; ?>" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Vip</label>
                            <input type="date" name="vip" class="form-control" value="<?php echo $vip; ?>" >
                            <span class="invalid-feedback"></span>
                        </div>
                       
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" name="submit" value="Sửa">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<?php } ?>
