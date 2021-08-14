<?php

require_once "setup.php";

$id = $name = $cost = $content = $avatar = "";
 
if(isset($_POST['submit']) & !empty($_POST)){
    $id = $_POST["id"];
    
    $name = $_POST["name"];
    $cost = $_POST["cost"];
    $content = $_POST["content"];
    $avatar = basename($_FILES["avatar"]["name"]);

  
    
    $error = isValidInputProduct($name,$cost,$content);

    if($error == ""){
        if(basename($_FILES["avatar"]["name"]) != "")
        {
         $avatar = encodeName($avatar);
         $path = getcwd().DIRECTORY_SEPARATOR;
         $path .= PICTURE_PATH .$avatar ;
         move_uploaded_file( $_FILES["avatar"][ 'tmp_name' ], $path );
         $sql = "UPDATE product SET picture=? WHERE id=?";
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
        $sql = "UPDATE product SET name=?, cost=?, content=? WHERE id=?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
           
            mysqli_stmt_bind_param($PrepareQuery, "sisi",$name,$cost,$content,$id);

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
        $sql = "SELECT * FROM product WHERE id = ?";
        if($PrepareQuery = mysqli_prepare($mysqli, $sql)){
            mysqli_stmt_bind_param($PrepareQuery, "i", $param_id);
            $param_id = $id;
            if(mysqli_stmt_execute($PrepareQuery)){
                $result = mysqli_stmt_get_result($PrepareQuery);
    
                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $name = $row['name'];
                    $cost = $row['cost'];      
                    $avatar = $row['picture']; 
                    $content = $row['content']; 
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
                    <form action="edit.php" method="post"  enctype="multipart/form-data" >
                    <div class="form-group">
                            <label>Tên sản phẩm</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                        </div>
                        <div class="form-group">
                            <label>Mức giá</label>
                            <input type="text" name="cost" class="form-control"  value="<?php echo $cost; ?>">
                        </div>  
                        <div class="form-group">
                            <label> Picture :</label>    
                            <img src='<?php echo PICTURE_PATH.$row['picture']; ?>' width='100' height='100' />
                            <label><?php echo $avatar; ?></label>                               
                            <label> Chọn ảnh upload:</label>     
                            <input type="file" name="avatar" class="form-control" >                
                        </div>
                        <div class="form-group">
                            <label>Nội dung</label>
                            <textarea name="content" class="form-control " ><?php echo $content; ?></textarea>
              
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
