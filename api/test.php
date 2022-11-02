<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');



if($_POST['username']){
 $res = 'Hi '. $_POST['username'];
 echo json_encode($res);
}


?>


