<?php
require 'connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if(isset($postdata) && !empty($postdata))
{
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if(trim($request->data->login) === '' || trim($request->data->password === ''))
  {
    $car = [
          'username' => $username,
          'login' => $login,
          'password' => $password,
          'id'    => mysqli_insert_id($con),
          'status' => true
        ];
    return http_response_code(400);

  }

  // Sanitize.
  $username = mysqli_real_escape_string($con, trim($request->data->username));
  $login = mysqli_real_escape_string($con, trim($request->data->login));
  $password = mysqli_real_escape_string($con, trim($request->data->password));


  // Store.
  $sql = "INSERT INTO `users`(`id`,`username`,`login`,`password`) VALUES (null,'{$username}','{$login}','{$password}')";

  if(mysqli_query($con,$sql))
  {
    http_response_code(201);
    $car = [
      'status' => true,
      'result' => [
         'username' => $username,
          'login' => $login,
          'password' => $password,
          'id'    => mysqli_insert_id($con),
      ]
    ];
    echo json_encode(['data'=>$car]);
  }
  else
  {
    http_response_code(422);
  }
}

