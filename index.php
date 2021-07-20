<?php

include "./includes/db.php";

//mở thẻ php chèn đoạn mã HTML giống như ejs. Ví dụ
/*
 * <?php
 *  for($i = 0; i < 10; i++) {
 *
 *  ?>
 *      <h1><?php echo $i;?></h1>
 * <?php
 * }
 * ?>
 *
 * */
session_start();

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
                        $title = $row['title'];
                        echo "
                        <li>
                            <a href='#'>{$title}</a>
                        </li>
                        ";
                    }

                  ?>
                    <li>
                        <a href="./admin">Admin</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
              <?php
                $posts = mysqli_query($connection, "SELECT * FROM posts");
                while($row = mysqli_fetch_assoc($posts)) {
                    $postsId = $row['id'];
                    $postsTitle = $row['title'];
                    $postsAuthor = $row['author'];
                    $postsDate = $row['date'];
                    $postsContent = $row['content'];
                    $postsTags = $row['tags'];
                    $image = $row['image'];
                    $imageShow = null;
                    $postStatus = $row['status'];
                    if(str_contains($image, 'http')) {
                        $imageShow = $image;
                    } else {
                        $imageShow = "images/$image";
                    }
                    if($postStatus === 'publish') {

                    ?>

                    <h1 class="page-header">
                        Page Heading
                        <small>Secondary Text</small>
                    </h1>

                    <!-- First Blog Post -->
                    <h2>
                        <a href="post.php?p_id=<?php echo $postsId?>"><?php echo  $postsTitle; ?></a>
                    </h2>
                    <p class="lead">
                        by <a href="index.php"><?php echo $postsAuthor?></a>
                    </p>
                    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $postsDate?></p>
                    <hr>
                    <img class="img-responsive" src="<?php echo $imageShow   ?>" alt="">
                    <hr>
                    <p><?php echo $postsContent?></p>
                    <a class="btn btn-primary" href="post.php?p_id=<?php echo $postsId?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

                    <hr>
                <?php

                }}
              ?>

                <!-- Pager -->
                <ul class="pager">
                    <li class="previous">
                        <a href="#">&larr; Older</a>
                    </li>
                    <li class="next">
                        <a href="#">Newer &rarr;</a>
                    </li>
                </ul>

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">

              <?php
                if(isset($_POST['submit'])) {
                    $search = $_POST['search'];
                    $searchQuery = mysqli_query($connection, "SELECT * FROM posts WHERE tags LIKE '%$search%'");
                    if(!$searchQuery) {
                        die('Query Failed' . mysqli_error($connection));
                    }
                    //mysqli_num_rows: lấy về số hàng query ra được
                    $count = mysqli_num_rows($searchQuery);
                    if($count === 0) {
                        echo "<h1>No Result</h1>";
                    } else {
                        echo "Some Result";
                    }
                }
              ?>

                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form method="post" action="search.php">
                        <div class="input-group">
                            <input type="text" class="form-control" name="search">
                            <span class="input-group-btn">
                            <button class="btn btn-default" type="submit" name="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>


                <!-- Login -->
              <?php
                if(empty($_SESSION['login_user_id'])) {
                    echo '
                         <div class="well">
                    <h4>Login</h4>
                    <form method="post" action="./admin/includes/login.php">
                        <div class="form-group">
                            <input type="text" class="form-control" name="email" placeholder="Enter your email">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Enter your password">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" name="login">Login</button>
                        </div>
                    </form>
                    <!-- /.input-group -->
                </div>
                    
                    ';
                } else {
                    echo '';
                }
              ?>



                <!-- Blog Categories Well -->
                <div class="well">
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                            <ul class="list-unstyled">
                                <?php
                                $categorySidebar = mysqli_query($connection, "SELECT * FROM category");
                                while($row = mysqli_fetch_assoc($categorySidebar)) {
                                  $categoryId = $row['id'];
                                  $titleSidebar = $row['title'];
                                  echo "
                                    <li>
                                        <a href='category.php?category=$categoryId'>{$titleSidebar}</a>
                                    </li>
                                    ";
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <!-- /.row -->
                </div>

                <!-- Side Widget Well -->
                <div class="well">
                    <h4>Side Widget Well</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Inventore, perspiciatis adipisci accusamus laudantium odit aliquam repellat tempore quos aspernatur vero.</p>
                </div>

            </div>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
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
