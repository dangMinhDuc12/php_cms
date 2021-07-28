<?php
if(isset($_POST['create_user'])) {
  /*
   * Hàm move_uploaded_file sẽ check xem tệp tin tải lên liệu có được valid qua phương thức POST HTTP của form hay ko
   * nếu đúng sẽ trả về true và chuyển form đến địa chỉ file ở params số 2
   * (params thứ 1 là tên của nơi mà file được tải lên tạm thời là server của xampp làm trung gian)
   * */
  $user_firstname = $_POST['user_firstname'];
  $user_lastname = $_POST['user_lastname'];
  $user_role = $_POST['user_role'];
  $user_email= $_POST['user_email'];
  $user_password = $_POST['user_password'];
  $username = $_POST['username'];
//  $postImage = $_FILES['image']['name'];
//  $postDate = date('Y-m-d');

//  move_uploaded_file($_FILES['image']['tmp_name'], "../images/$postImage");

  $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
  $createUser = mysqli_query($connection, "
        INSERT INTO users (user_name, user_password, user_firstname, user_lastname, user_email, user_role)
        VALUES ('$username', '$user_password', '$user_firstname', '$user_lastname', '$user_email', '$user_role')
    ");
  if(!$createUser) {
    die('Insert Failed' . mysqli_error($connection));
  } else {
      echo "User Created <a href='users.php'>View All Users</a>";
  }
}

?>



<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">First name</label>
    <input type="text" class="form-control" name="user_firstname">
  </div>

  <div class="form-group">
    <label for="user_lastname">Last name</label>
    <input type="text" class="form-control" name="user_lastname">
  </div>
    <div class="form-group">
        <label for="post_category_id">User Role</label>
        <select name="user_role" id="" class="form-control">
            <option value="subscriber">Select options</option>
            <option value="admin">Admin</option>
            <option value="subscriber">Subscriber</option>
        </select>
    </div>
  <div class="form-group">
    <label for="post_status">Username</label>
    <input type="text" class="form-control" name="username">
  </div>

  <div class="form-group">
    <label for="post_tags">Email</label>
    <input type="email" class="form-control" name="user_email">
  </div>
  <div class="form-group">
    <label for="post_content">Password</label>
      <input type="password" class="form-control" name="user_password">
  </div>
  <div class="form-group">
    <input type="submit" name="create_user" class="btn btn-primary" value="Add user">
  </div>

</form>
