<?php

require_once "setup.php";
session_start();
	if(!isset($_SESSION['admin'])){
		header("Location: ../index.php");
	} 
$id = $username = $password = "";
 
if(isset($_POST['submit']) & !empty($_POST)){
    $id = $_POST["id"];
    
    $username = $_POST["username"];
    $password = $_POST["password"];
    $error = "";

    if($error == ""){
        
        $sql = "UPDATE admin SET username=?, password=? WHERE id=?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
           
            mysqli_stmt_bind_param($PrepareQuery, "ssi",$username,$password,$id);

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
        $sql = "SELECT * FROM admin WHERE id = ?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "i", $param_id);
            $param_id = $id;
            if(mysqli_stmt_execute($PrepareQuery)){
                $result = mysqli_stmt_get_result($PrepareQuery);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $username = $row["username"];
                    $password = $row["password"]; 
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
    <title>Trang Edit</title>
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
                    <h2 class="mt-5">Update Admin</h2>              
                    <form action="edit.php" method="post"  enctype="multipart/form-data" >
                    <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="text" name="password" class="form-control"  value="<?php echo $password; ?>">
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
