



<?php
    if(isset($_GET['edit_user'])) {
        $userToEdit = $_GET['edit_user'];
    }
    $users= mysqli_query($connection, "SELECT * FROM users WHERE user_id = $userToEdit");
    while($row = mysqli_fetch_assoc($users)) {
      $user_id = $row['user_id'];
      $user_name = $row['user_name'];
      $user_password = $row['user_password'];
      $user_firstname = $row['user_firstname'];
      $user_lastname= $row['user_lastname'];
      $user_email = $row['user_email'];
      $user_image = $row['user_image'];
      $user_role = $row['user_role'];
    }
?>

<?php
if(isset($_POST['edit_user'])) {

  $user_firstname = $_POST['user_firstname'];
  $user_lastname = $_POST['user_lastname'];
  $user_role = $_POST['user_role'];
  $user_email= $_POST['user_email'];
  $user_password = $_POST['user_password'];
  $username = $_POST['username'];


  $editUser = mysqli_query($connection, "
        UPDATE users SET 
        user_name = '$username' , user_password = '$user_password', user_firstname = '$user_firstname', user_lastname = '$user_lastname', user_email = '$user_email', user_role = '$user_role'
        WHERE user_id = $userToEdit
    ");
  if(!$editUser) {
    die('Insert Failed' . mysqli_error($connection));
  }
  header("Location:users.php");
}

?>


<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">First name</label>
        <input type="text" value="<?php echo $user_firstname?>" class="form-control" name="user_firstname">
    </div>

    <div class="form-group">
        <label for="user_lastname">Last name</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php echo $user_lastname?>">
    </div>
    <div class="form-group">
        <label for="post_category_id">User Role</label>
        <select name="user_role" id="" class="form-control">
            <?php
                if($user_role === 'admin') {
                    echo "<option value='admin' selected>Admin</option>
                            <option value='subscriber'>Subscriber</option>";
                } else {
                  echo "<option value='admin' >Admin</option>
                        <option value='subscriber' selected>Subscriber</option>";
                }

            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_status">Username</label>
        <input type="text" class="form-control" name="username" value="<?php echo $user_name?>">
    </div>
    <!--  <div class="form-group">-->
    <!--    <label for="post_image">Post Image</label>-->
    <!--    <input type="file"  name="image">-->
    <!--  </div>-->
    <div class="form-group">
        <label for="post_tags">Email</label>
        <input type="email" class="form-control" name="user_email" value="<?php echo $user_email?>">
    </div>
    <div class="form-group">
        <label for="post_content">Password</label>
        <input type="password" class="form-control" name="user_password" value="<?php echo $user_password?>">
    </div>
    <div class="form-group">
        <input type="submit" name="edit_user" class="btn btn-primary" value="Edit user">
    </div>

</form>
