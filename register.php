<?php 
    require_once('config.php');
    ?>
<!DOCTYPE html>
<html lang="">
    <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Trang đăng ký</title>
    
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>
    <body>
      
<form action="register.php" method="POST">
  <h1>Đăng ký </h1>   
    <table>   
        <tr>
          <td>Username</td> 
          <td><input type="text" name="username" size=30 required></td>
        </tr>   
        <tr>
          <td>Password</td> 
          <td><input type="password" name="password" size=30 required></td>
        </tr>
        <tr>
          <td>Nhập lại Password</td> 
          <td><input type="password" name="repass" size=30 required></td>
        </tr>
        <tr>
          <td>Email</td> 
          <td><input type="text" name="email" size=30 required></td>
        </tr>
        <tr>
          <td>Số điện thoại</td> 
          <td><input type="text" name="phone" size=30 required></td>
        </tr>
        <tr>
						<td colspan="2" align="center"> 
              <input type="submit" name="btn_signup" value="Đăng ký">	            	
							<input type="button" id="back" value="Quay lại" onclick="location.href='login.php';"  />	</td>					
					</tr>	
    </table>  
   
    </body>
</html>

<?php 
  
  function isValidUsername($input) { 
    if(preg_match('/^[a-zA-Z0-9]{6,}$/', $input)) { // no special char, length >= 6
      return true;
    }
    return false;
  } 
  function isValidEmail($input) { 
    if (filter_var($input, FILTER_VALIDATE_EMAIL))
      return true;
    return false;
  } 

  function AccHasExist($input) { 
    global $mysqli;
    $query = 'SELECT COUNT(*) FROM user WHERE username = ? '; 
    $PrepareQuery  = $mysqli->prepare($query);
    $PrepareQuery->bind_param('s', $input);
    $result= $PrepareQuery->execute();
    $PrepareQuery->bind_result($num_rows);
		$PrepareQuery->fetch();			
    if ($num_rows >0) 
        return true;  
    return false;
  } 
  if(isset($_POST['btn_signup']) & !empty($_POST)){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $repass = $_POST['repass'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    if( is_numeric($phone) && isValidUsername($username) && isValidEmail($email) && $password == $repass ){
      if(!AccHasExist($username)){
        $query = 'INSERT INTO user (username, `password`, email, phone) VALUES (?,?,?,?)';    
        $PrepareQuery = $mysqli->prepare($query);
        $PrepareQuery->bind_param('ssss', $username,$password,$email,$phone); 
        $result = $PrepareQuery->execute();
        $mysqli->close();
        if($result){
           echo 'Đăng ký thành công';
        }
           else echo 'Đăng ký thất bại';
      }
      else echo 'Tài khoản đã tồn tại';      
    }
    else   
    echo 'Đầu vào không đúng định dạng (Username không được chứa kí tự đặc biệt và phải dài hơn 6 kí tự)';   
  }  
    
?>  