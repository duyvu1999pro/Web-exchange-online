<?php
// Include config file
require_once "setup.php";


  
$error="";
if(isset($_POST['submit']) & !empty($_POST)){
  
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $avatar = basename($_FILES["avatar"]["name"]);
  
    $money = $_POST["money"];
    $vip = $_POST["vip"];

    $error = isValidInputUser($username,$password,$email,$phone,$money,$vip);
    if($error == ""){
       // if (inputIsSafe()) {
           if($avatar != "")
           {
            $avatar = encodeName($avatar);
            $path = getcwd().DIRECTORY_SEPARATOR;
            $path .= AVATAR_PATH .$avatar ;
            move_uploaded_file( $_FILES["avatar"][ 'tmp_name' ], $path );
           }
       
           
            $sql = "INSERT INTO user (username, `password`, email, phone, avatar, `money`, vip) VALUES (?,?,?,?,?,?,?)";
             
            if($PrepareQuery = mysqli_prepare($mysqli, $sql)){            
                mysqli_stmt_bind_param($PrepareQuery, "sssssis",$username,$password,$email,$phone,$avatar,$money,$vip);                    
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
                    <h2 class="mt-5">Create User</h2>              
                    <form action="create.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control" >                       
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="email" class="form-control" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Avatar</label>                                       
                             Chọn ảnh upload:
                            <input type="file" name="avatar" class="form-control" >                
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Money</label>
                            <input type="text" name="money" class="form-control" value="0" >
                            <span class="invalid-feedback"></span>
                        </div>
                        <div class="form-group">
                            <label>Vip</label>
                            <input type="date" name="vip" class="form-control" value="2003-10-23" >
                            <span class="invalid-feedback"></span>
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
