<?php  include "includes/db.php"; ?>
<?php
if(isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    if(!empty($username) && !empty($password) && !empty($email)) {
//      define("randSalt", '$2y$10$iusesomecrazystrings22');
      $username = mysqli_real_escape_string($connection, $username);
      $password = mysqli_real_escape_string($connection, $password);
      $email = mysqli_real_escape_string($connection, $email);

      $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
      $create_user_account = mysqli_query($connection, "
    INSERT INTO users (user_name, user_email, user_password, user_role)
    VALUES ('$username', '$email', '$password', 'subscriber')

");
      if(!$create_user_account) {
        die('create user failed' . mysqli_error($connection));
      }
      $message = 'Create account success';
    } else {
        $message = 'This field cannot be empty';
    }


} else {
    $message = '';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Football Blog Home</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/blog-home.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Football Blog </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php
              $category = mysqli_query($connection, "SELECT * FROM category");
              while($row = mysqli_fetch_assoc($category)) {
                $categoryId = $row['id'];
                $title = $row['title'];
                echo "
                        <li>
                            <a href='category.php?category=$categoryId'>{$title}</a>
                        </li>
                        ";
              }

              ?>
              <?php
              if(isset($_SESSION['login_user_id']) && $_SESSION['login_user_role'] === 'admin') {
                echo "<li>
                                    <a href='./admin'>Admin</a>
                            </li>";
              }
              ?>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 class="text-center"><?php echo $message;?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username">
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12 text-center">
                    <p>Copyright &copy; Your Website 2014</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </footer>

    </div>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
