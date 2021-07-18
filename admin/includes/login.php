<?php
include '../../includes/db.php';
session_start();

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
    echo "Email or Password wrong";
  } else {
      while ($row = mysqli_fetch_assoc($loginForUser)) {
        $login_user_id = $row['user_id'];
        $login_user_name = $row['user_name'];
        $login_user_password = $row['user_password'];
        $login_user_firstname = $row['user_firstname'];
        $login_user_lastname= $row['user_lastname'];
        $login_user_email = $row['user_email'];
        $login_user_image = $row['user_image'];
        $login_user_role = $row['user_role'];
  }
  $_SESSION['login_user_name'] = $login_user_name;
  $_SESSION['login_user_firstname'] = $login_user_firstname;
  $_SESSION['login_user_lastname'] = $login_user_lastname;
  $_SESSION['login_user_role'] = $login_user_role;
  $_SESSION['login_user_email'] = $login_user_email;
  $_SESSION['login_user_password'] = $login_user_password;
  $_SESSION['login_user_id'] = $login_user_id;
  header("Location: ../../admin/index.php");
  }



}
