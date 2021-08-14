<?php
// Include config file
require_once "setup.php";


$error="";
if(isset($_POST['submit']) & !empty($_POST)){
  
    $name = $_POST["name"];
    $cost = $_POST["cost"];
    $content = $_POST["content"];
    $avatar = basename($_FILES["avatar"]["name"]);

    $error = isValidInputProduct($name,$cost,$content);
    if($error == ""){
       // if (inputIsSafe()) {
           if($avatar != "")
           {
            $avatar = encodeName($avatar);
            $path = getcwd().DIRECTORY_SEPARATOR;
            $path .= PICTURE_PATH .$avatar ;
            move_uploaded_file( $_FILES["avatar"][ 'tmp_name' ], $path );
           }
       
           
            $sql = "INSERT INTO product (name, cost, picture, content ) VALUES (?,?,?,?)";
             
            if($PrepareQuery = mysqli_prepare($mysqli, $sql)){            
                mysqli_stmt_bind_param($PrepareQuery, "siss",$name,$cost,$avatar,$content);                    
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
                    <h2 class="mt-5">Create Product</h2>              
                    <form action="create.php" method="post"  enctype="multipart/form-data">
                        <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" >
                        </div>
                        <div class="form-group">
                            <label>Mức giá</label>
                            <input type="text" name="cost" class="form-control" >
                        </div>  
                        <div class="form-group">
                            <label>Picture</label>                                       
                             Chọn ảnh upload:
                            <input type="file" name="avatar" class="form-control" >                
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea name="content" class="form-control "></textarea>
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
