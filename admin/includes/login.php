<?php
include '../../includes/db.php';

if(isset($_POST['login'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $email = mysqli_real_escape_string($connection, $email);
  $password = mysqli_real_escape_string($connection, $password);

  $loginForUser= mysqli_query($connection, "
    SELECT * FROM users WHERE user_email = '$email' AND user_password = '$password'
  
  ");
  if(!$loginForUser) {
    die("Login Failed" . mysqli_error($connection));
  }

  $checkLogin = mysqli_num_rows($loginForUser);
  if(!$checkLogin) {
    echo "Email Or Password wrong";
  } else {
      while ($row = mysqli_fetch_assoc($loginForUser)) {
        echo $row['user_name'];
  }
  }



}
