<?php

require_once "setup.php";

$id = $username = $avatar = $product_id = "";

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
                    $avatar = $row['avatar']; 
                } else{
                    header("location: ../../error.php");
                    exit();
                }    
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        mysqli_stmt_close($PrepareQuery);
      //  mysqli_close($mysqli);
    }  else{
        header("location: ../../error.php");
        exit();
    }


?>
 
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <title>ASSET PAGE</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 850px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Danh sách vật phẩm của <?php echo $username; ?></h2>
                         <img src='<?php echo AVATAR_PATH.$avatar; ?>' width='100' height='100' style="margin-left: 40px;" />
                       <!-- <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Thêm </a> -->
                       
                    </div>
                    <?php             
                   
                    $sql = "SELECT * FROM product,owned where owned.product_id=product.id and owned.user_id=".$id;
                    if($result = mysqli_query($mysqli, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                     //   echo "<th>#</th>";
                                        echo "<th>Tên sản phẩm</th>";
                                        echo "<th>Giá</th>";
                                        echo "<th>Ảnh minh họa</th>";
                                        echo "<th>Nội dung</th>";
                                        echo "<th>Số lượng</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        //echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['cost'] . "</td>";
                                        echo "<td><img src='".PICTURE_PATH. $row['picture'] . "' width='100' height='100' /></td>";
                                        echo "<td>" . $row['content'] . "</td>";
                                        echo "<td>" . $row['quantity'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            
                            mysqli_free_result($result);
                        } else{
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else{
                        echo "Oops! Something went wrong. Please try again later.vu";
                    }
                    mysqli_close($mysqli);
                    ?>
                    <a href="../index.php" class="btn btn-secondary ml-2">Cancel</a>
                </div>
            </div>        
        </div>
    </div>

</body>
</html>
