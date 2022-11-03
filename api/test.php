<?php
echo 'php';

if($_POST['username']){
 $res = 'Hi '. $_POST['username'];
 echo json_encode($res);
}


?>


