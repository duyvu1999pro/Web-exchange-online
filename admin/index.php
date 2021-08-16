<?php 
    require_once('setup.php');
	session_start();
	if(isset($_SESSION['admin'])){
		header("Location: ".ADMIN_PATH);
	}
    ?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trang Admin</title>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
	</head>
	<body>
		<form method="POST" action="index.php">
	
			<h1>Đăng nhập</h1>
				<table>
					<tr>
						<td>Username</td>
						<td>
							<input type="text" name="username" size="30" 
							value="<?php 
								if(isset($_COOKIE["m_user"])) 
									{ echo $_COOKIE["m_user"]; } ?>" required>
						</td>
					</tr>
					<tr>
						<td>Password</td>
						<td>
							<input type="password" name="password" size="30"
							value="<?php 
								if(isset($_COOKIE["m_pass"])) 
									{ echo $_COOKIE["m_pass"]; } ?>" required>
						</td>
					</tr>
				
					
					<tr>
						<td colspan="2" align="center"> <input type="submit" name="btn_submit" value="Đăng nhập">
							
								</td>					
					</tr>	
								
				</table>		
				
				  
	  </form>
		  
	 	
	</body>
</html>
<?php

if(isset($_POST['btn_submit']) & !empty($_POST)){

		$username = $_POST['username'];
		$password = $_POST['password']; 

		
		$query = 'SELECT COUNT(*) FROM `admin` WHERE `username` = ? AND `password` = ? '; 
        $PrepareQuery  = $mysqli->prepare($query);
		$PrepareQuery->bind_param('ss', $username,$password);
		$result= $PrepareQuery->execute();

		  
		if($result ){ 
			$PrepareQuery->bind_result($num_rows);
			$PrepareQuery->fetch();
			if($num_rows >0 ){
				echo "đăng nhập thành công";
				$_SESSION['admin'] = $username;
				header("Location: ".ADMIN_PATH);
			}
			else
         		 echo 'Đăng nhập thất bại';
		}		 
	$mysqli->close();
    
}
?>