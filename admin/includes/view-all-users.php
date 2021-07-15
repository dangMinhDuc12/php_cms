<table class="table table-bordered table-hover">
  <thead>
  <tr>
    <th>ID</th>
    <th>Username</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>Email</th>
    <th>Role</th>
     <th colspan="4" style="text-align: center">Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $users= mysqli_query($connection, "SELECT * FROM users");
  while($row = mysqli_fetch_assoc($users)) {
    $user_id = $row['user_id'];
    $user_name = $row['user_name'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname= $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_image = $row['user_image'];
    $user_role = $row['user_role'];


    echo "
                        <tr>
                            <td>{$user_id  }</td>
                            <td>{$user_name}</td>
                            <td>{$user_firstname}</td>
                            <td>{$user_lastname}</td>
                            <td>{$user_email}</td>
                            <td>{$user_role}</td>
                            <td><a href='users.php?change_admin=$user_id'>Admin</a></td>
                            <td><a href='users.php?change_sub=$user_id'>Subscriber</a></td>
                            <td><a href='users.php?delete=$user_id'>Delete</a></td>
                            <td><a href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>
                        </tr>
                        
                        ";
  }
  ?>
  <?php
  if(isset($_GET['delete'])) {
    $user_id_delete = $_GET['delete'];
    if(!mysqli_query($connection, "DELETE FROM users WHERE user_id = $user_id_delete")) {
      die('Delete comment failed' . mysqli_error($connection));
    }
    header('Location:users.php');
  }

  if(isset($_GET['change_admin'])) {
    $user_id_update = $_GET['change_admin'];
    if(!mysqli_query($connection, "UPDATE users SET user_role = 'admin' WHERE user_id = $user_id_update")) {
      die('Update failed' . mysqli_error($connection));
    }
    header("Location:users.php");
  }
  if(isset($_GET['change_sub'])) {
    $user_id_update = $_GET['change_sub'];
    if(!mysqli_query($connection, "UPDATE users SET user_role = 'subscriber' WHERE user_id = $user_id_update")) {
      die('Update failed' . mysqli_error($connection));
    }
    header("Location:users.php");
  }
  ?>
  </tbody>
</table>


