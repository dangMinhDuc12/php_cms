<?php include './includes/admin-header.php';?>
<!--test comment-->
<div id="wrapper">

  <?php  include './includes/admin-navigation.php';?>

  <?php
  if(isset($_POST['update_user'])) {
    $userToEdit = $_SESSION['login_user_id'];
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
    $_SESSION['login_user_name'] = $username;
    $_SESSION['login_user_firstname'] = $user_firstname;
    $_SESSION['login_user_lastname'] = $user_lastname;
    $_SESSION['login_user_role'] = $user_role;
    $_SESSION['login_user_email'] = $user_email;
    $_SESSION['login_user_password'] = $user_password;
    if(!$editUser) {
      die('Insert Failed' . mysqli_error($connection));
    }
    header("Location:users.php");
  }

  ?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome to profile page
            <small>Author</small>
          </h1>

            <form action="" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">First name</label>
                    <input type="text" class="form-control" name="user_firstname" value="<?php echo $_SESSION['login_user_firstname'] ?>">
                </div>

                <div class="form-group">
                    <label for="user_lastname">Last name</label>
                    <input type="text" class="form-control" name="user_lastname" value="<?php echo $_SESSION['login_user_lastname'] ?>">
                </div>
                <div class="form-group">
                    <label for="post_category_id">User Role</label>
                    <select name="user_role" id="" class="form-control">
                      <?php
                      if($_SESSION['login_user_role'] === 'admin') {
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
                    <input type="text" class="form-control" name="username" value="<?php echo $_SESSION['login_user_name'] ?>">
                </div>

                <div class="form-group">
                    <label for="post_tags">Email</label>
                    <input type="email" class="form-control" name="user_email" value="<?php echo $_SESSION['login_user_email'] ?>">
                </div>
                <div class="form-group">
                    <label for="post_content">Password</label>
                    <input type="password" class="form-control" name="user_password" value="<?php echo $_SESSION['login_user_password'] ?>">
                </div>
                <div class="form-group">
                    <input type="submit" name="update_user" class="btn btn-primary" value="Update user profile">
                </div>

            </form>
        </div>
      </div>
      <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

  </div>
  <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>




