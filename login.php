<?php 
    require_once('setup.php');
	session_start();
	if(isset($_SESSION['userlogin'])){
		header("Location: index.php");
	}
    ?>
<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Trang đăng nhập</title>
	
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	
	</head>
	<body>
		<form method="POST" action="login.php">
	
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
						<td>Captcha</td>
						<td>
							<input type="text" name="captcha" required/><img src="<?php echo CAPTCHA_PATH; ?>" id="cap" />
							<input type="button" id="reload" value="Reload" />
						</td>
					</tr>
					
					<tr>
						<td colspan="2" align="center"> <input type="submit" name="btn_submit" value="Đăng nhập">
							
							<input type="button" id="signup" value="Đăng ký" onclick="location.href='register.php';" />	</td>					
					</tr>	
								
				</table>		
				
				<label>
					<input type="checkbox" name="remember" 
					<?php if(isset($_COOKIE["m_user"]) || isset($_COOKIE["m_pass"])) 
					{ ?> checked <?php } ?> > Remember me
				  </label>			  
	  </form>
		  
	  <script>
		$(function() {
			$('#reload').click(function(){
				var d = new Date();
				$('img').attr('src', '<?php echo CAPTCHA_PATH; ?>?' + d.getTime());
			});
		});
	</script>	
	</body>
</html>
<?php

function remember_me()
{
	if(!empty($_POST["remember"])) {
		setcookie ("m_user",$_POST["username"],time()+ (10 * 365 * 24 * 60 * 60));
		setcookie ("m_pass",$_POST["password"],time()+ (10 * 365 * 24 * 60 * 60));
		} 
	else{
			if( isset($_COOKIE["m_user"]) || isset($_COOKIE["m_pass"]) ) {
				setcookie ("m_user","");
				setcookie ("m_pass","");
				}
		}
}

//session_start();
if(isset($_POST['btn_submit']) & !empty($_POST)){
	//if($_POST['captcha'] == $_SESSION['captcha']){

		$username = $_POST['username'];
		$password = $_POST['password']; 

		
		$query = 'SELECT COUNT(*) FROM `user` WHERE `username` = ? AND `password` = ? '; 
        $PrepareQuery  = $mysqli->prepare($query);
		$PrepareQuery->bind_param('ss', $username,$password);
		$result= $PrepareQuery->execute();

		  
		if($result ){ 
			$PrepareQuery->bind_result($num_rows);
			$PrepareQuery->fetch();
			if($num_rows >0 ){
				echo "đăng nhập thành công";
				$_SESSION['userlogin'] = $username;
				remember_me();
				header("Location: index.php");
			}
			else
         		 echo 'Đăng nhập thất bại';
		}		 
	// }
    // else {
    //     echo "Invalid captcha";
    //     }
	$mysqli->close();
    
}
?>