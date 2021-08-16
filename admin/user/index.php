<?php
  // Include config file
  require_once "setup.php";
  session_start();

	if(!isset($_SESSION['admin'])){
		header("Location: ../index.php");
	}

	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION);
		header("Location: ../index.php");
	}
?>
<?php if(isset($_SESSION['admin'])){ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
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
<div class="w3-sidebar w3-light-grey w3-bar-block" style="width:15%">
  <h3 class="w3-bar-item">Menu</h3>
  <a href="../user/index.php" class="w3-bar-item w3-button">Người dùng</a>
  <a href="../product/index.php" class="w3-bar-item w3-button">Sản phẩm</a>
  <a href="../card/index.php" class="w3-bar-item w3-button">Thẻ nạp</a>
  <a href="../adm/index.php" class="w3-bar-item w3-button">Admin</a>
  <a href="index.php?logout=true" class="btn btn-danger pull-right" style="margin-right: 100px;margin-top: 30px;"> thoát </a>
</div>
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Quản lý người dùng</h2>
                        <a href="create.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Tạo mới </a>
                    </div>
                    <?php             
                 
                    $sql = "SELECT * FROM user";
                    if($result = mysqli_query($mysqli, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Username</th>";
                                        echo "<th>Mật khẩu</th>";
                                        echo "<th>Email</th>";
                                        echo "<th>Số điện thoại</th>";
                                        echo "<th>Ảnh đại diện</th>";
                                        echo "<th>Số tiền</th>";
                                        echo "<th>Ngày hết hạn Vip</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['username'] . "</td>";
                                        echo "<td>" . $row['password'] . "</td>";
                                        echo "<td>" . $row['email'] . "</td>";
                                        echo "<td>" . $row['phone'] . "</td>";
                                        echo "<td><img src='".AVATAR_PATH. $row['avatar'] . "' width='100' height='100' /></td>";
                                        echo "<td>" . $row['money'] . "</td>";
                                        echo "<td>" . $row['vip'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="asset/index.php?id='. $row['id'] .'" class="mr-3" title="View Asset" data-toggle="tooltip"><span class="fa fa-eye"></span></a>';
                                            echo '<a href="edit.php?id='. $row['id'] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
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
                        echo "Oops! Something went wrong. Please try again later.";
                    }
 
                    
                    mysqli_close($mysqli); 
             
                   
                    ?>
                </div>
            </div>        
        </div>
    </div>


</body>
</html>
<?php } ?>