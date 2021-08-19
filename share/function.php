<?php 
  function inputIsSafe()
  {
    return true;
  }

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
  function isValidPhone($input) { 
    if (is_numeric($input))
      return true;
    return false;
  } 
 
  function isValidMoney($input) {  
    if (is_numeric($input))
    return true;
  return false;
  } 
  function isValidVip($input) { 
      return true;
  } 
  function isValidImage($target_file,$file_tmp)
  {  
    $check = getimagesize($file_tmp);
    if($check == false) {
      echo "File is not an image.";
      return false;
    } 
    if (file_exists($target_file)) {   // Check if file already exists
     echo "Sorry, file already exists.";
     return false;
    }
    if ($_FILES[$id_name]["size"] > 500000) {   // Check file size
      echo "Sorry, your file is too large.";
      return false;
    }
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {  //  formats
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    return false;
    }
    return true;
  }
  function isValidInputUser($username,$password,$email,$phone,$money,$vip)
  {   
      $error = "";
      if(empty($username) || empty($password) || empty($email) 
      || empty($phone))
      {
          $error = "Không được bỏ trống";
          return $error;
      }
      if (!isValidUsername($username)) {
          $error = "Username không được chứa kí tự đặc biệt và phải dài hơn 6 kí tự.";
          return $error;
        }
        if (!isValidEmail($email)) {
          $error = "Email không đúng định dạng.";
          return $error;
        }
        if (!isValidphone($phone)) {
          $error = "SĐT không đúng định dạng.";
          return $error;
        }
      //  /// if (!isValidImage($avatar_tmp)) {
      //     if (false) {
      //     $error = "Hình ảnh không đúng định dạng.";
      //     return $error;
      //   }
        if (!isValidMoney($money)) {
          $error = "Money không đúng định dạng.";
          return $error;
        }   
        if (!isValidVip($vip)) {
          $error = "Thời gian không đúng định dạng";
          return $error;
        }    
      return $error;
  }
  function isValidInputProduct($name,$cost,$content)
  {   
      $error = "";
      if(empty($name) || empty($cost) || empty($content) )
      {
          $error = "Không được bỏ trống";
          return $error;
      }
     
        if (!isValidMoney($cost)) {
          $error = "Cost không đúng định dạng.";
          return $error;
        }   
     
      return $error;
  }
 
  function UserHasExist($user_name, $mysqli) { 
    $query = 'SELECT COUNT(*) FROM user WHERE username = ? '; 
    $PrepareQuery  = $mysqli->prepare($query);
    $PrepareQuery->bind_param('s', $user_name);
    $result= $PrepareQuery->execute();
    $PrepareQuery->bind_result($num_rows);
		$PrepareQuery->fetch();			
    if ($num_rows >0) 
        return true;  
    return false;
  } 
  function encodeName($name) { 
   	$uploaded_ext  = substr( $name, strrpos( $name, '.' ) + 1);
    $string = md5( uniqid() . $name ) . '.' . $uploaded_ext;
    return $string;
  } 

  function vipLeft($vip)
  {
    $today = date("Y-m-d");
    $output = 0;
    if ($today > $vip) {
      return $output;
    }

      $datetime1 = strtotime($today);
      $datetime2 = strtotime($vip);

      $secs = $datetime2 - $datetime1;
      $days = $secs / 86400;
      $output = $days+1;
      return $output;

  }
  function addDate( $dayNums, $beginDate )
  {
    $result ="";
    $secs = $dayNums * 86400;
    $datetime = strtotime($beginDate);
    $datetime = $datetime + $secs;
    $result = date('Y-m-d', $datetime);
    return $result;
  }
?>