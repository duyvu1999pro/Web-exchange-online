<?php

$db_user = 'root';
$db_pass = ''; 
$db_name = 'vu'; 
$db_port = '3308'; 
$mysqli = new mysqli('127.0.0.1', $db_user, $db_pass, $db_name, $db_port);


// if ($mysqli->connect_error) {
//     die('Connect Error (' . $mysqli->connect_errno . ') '
//             . $mysqli->connect_error);
// }
// echo '<p>Connection OK '. $mysqli->host_info.'</p>';
// echo '<p>Server '.$mysqli->server_info.'</p>';
//  $mysqli->close();
?>
