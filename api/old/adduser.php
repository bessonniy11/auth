<?php
require 'connect.php';

// Get the posted data.
$postdata = file_get_contents("php://input");

if (isset($postdata) && !empty($postdata)) {
  // Extract the data.
  $request = json_decode($postdata);

  // Validate.
  if (trim($request->data->email) === '' || trim($request->data->password === '')) {
    $response = [
      'status'  => false,
      'message' => 'registration failed',
    ];
    echo json_encode(['data' => $response]);
    return http_response_code(400);
  }

  // Sanitize.
  $username = mysqli_real_escape_string($con, trim($request->data->username));
  $email = mysqli_real_escape_string($con, trim($request->data->email));
  $password = mysqli_real_escape_string($con, trim($request->data->password));


  // Store.
  $sql = "INSERT INTO `users`(`id`,`username`,`email`,`password`) VALUES (null,'{$username}','{$email}','{$password}')";

  if (mysqli_query($con, $sql)) {
    http_response_code(201);
    $response = [
      'status' => true,
      'result' => [
        'username' => $username,
        'email'    => $email,
        'password' => $password,
        'id'       => mysqli_insert_id($con),
      ]
    ];
    echo json_encode(['data' => $response]);
  } else {
    http_response_code(422);
  }
}
