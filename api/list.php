<?php
/**
 * Returns the list of cars.
 */
require 'connect.php';

$cars = [];
$sql = "SELECT id, login, name FROM users";

if($result = mysqli_query($con,$sql))
{
  $cr = 0;
  while($row = mysqli_fetch_assoc($result))
  {
    $cars[$cr]['id']    = $row['id'];
    $cars[$cr]['login'] = $row['login'];
    $cars[$cr]['name'] = $row['name'];
    $cr++;
  }

  echo json_encode(['data'=>$cars]);
}
else
{
  http_response_code(404);
}
