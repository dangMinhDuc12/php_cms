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

    <title>Blog Home - Start Bootstrap Template</title>

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
            <a class="navbar-brand" href="index.php">Football Blog</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
              <?php
              $category = mysqli_query($connection, "SELECT * FROM category");
              while($row = mysqli_fetch_assoc($category)) {
                $title = $row['title'];
                $categoryId = $row['id'];
                echo "
                        <li>
                            <a href='category.php?category=$categoryId'>{$title}</a>
                        </li>
                        ";
              }

              ?>

              <?php

              if (isset($_SESSION['login_user_id']) && $_SESSION['login_user_role'] === 'admin') {
                echo "<li>
                                    <a href='./admin'>Admin</a>
                            </li>";
                if(isset($_GET['p_id'])) {
                    $postIdEdit = $_GET['p_id'];
                    echo "
                        <li>
                                    <a href='./admin/posts.php?source=edit_post&p_id=$postIdEdit'>Edit</a>
                            </li>

                    ";
                }
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

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
          <?php
          if(isset($_GET['p_id'])) {
              $thePostId = $_GET['p_id'];
          if(!mysqli_query($connection, "
            UPDATE posts SET view_count = view_count + 1 WHERE id = $thePostId
          
          ")) {
              die('Update failed' . mysqli_error($connection));
          }
          $posts = mysqli_query($connection, "SELECT * FROM posts WHERE id = $thePostId");
          while($row = mysqli_fetch_assoc($posts)) {
            $postsTitle = $row['title'];
            $postsAuthor = $row['author'];
            $postsDate = $row['date'];
            $postsContent = $row['content'];
            $postsTags = $row['tags'];
            $image = $row['image'];
            $imageShow = null;
            if(str_contains($image, 'http')) {
              $imageShow = $image;
            } else {
              $imageShow = "images/$image";
            }
            ?>
              <h1 class="page-header">
                  Page Heading
                  <small>Secondary Text</small>
              </h1>

              <!-- First Blog Post -->
              <h2>
                  <a href="#"><?php echo  $postsTitle; ?></a>
              </h2>
              <p class="lead">
                  by <a href="index.php"><?php echo $postsAuthor?></a>
              </p>
              <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $postsDate?></p>
              <hr>
              <img class="img-responsive" src="<?php echo $imageShow   ?>" alt="">
              <hr>
              <p><?php echo $postsContent?></p>


              <hr>
            <?php

          }
          } else {
              header("Location:index.php");
          }
          ?>
            <!-- Blog Comments -->
          <?php
            if(isset($_POST['create_comment'])) {
                $comment_author = $_POST['comment_author'];
                $comment_email = $_POST['comment_email'];
                $comment_content = $_POST['comment_content'];
                $comment_date = date('Y-m-d');
                if(!empty($comment_author && !empty($comment_content) && !empty($comment_email))) {
                  $create_comment = mysqli_query($connection, "
                INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date)
                VALUES ($thePostId, '$comment_author', '$comment_email', '$comment_content', 'unapproved', '$comment_date')
                ");
                  if(!$create_comment) {
                    die('Comment failed'. mysqli_error($connection));
                  }
                  if(!mysqli_query($connection, "
                 UPDATE posts SET comment_count = comment_count + 1
                WHERE id = $thePostId
                ")) {
                    die('Update comment count failed' . mysqli_error($connection));
                  }
                } else {
                    echo "
                    <script>alert('Please fill all field')</script>";
                }

            }
          ?>
            <!-- Comments Form -->
            <div class="well">
                <h4>Leave a Comment:</h4>
                <form role="form" method="post">
                    <div class="form-group">
                        <label for="author">Author</label>
                        <input type="text" name="comment_author" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="comment_email" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="comment">Your comment</label>
                        <textarea class="form-control" rows="3" name="comment_content"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                </form>
            </div>

            <hr>

            <!-- Posted Comments -->

            <!-- Comment -->
            <?php

                $all_comment_approved = mysqli_query($connection, "
                SELECT * FROM comments 
                WHERE comment_post_id = $thePostId AND comment_status = 'approved'
                ORDER BY id DESC
                ");
                while ($row = mysqli_fetch_assoc($all_comment_approved)) {
                    $comment_date_show = $row['comment_date'];
                    $comment_content_show = $row['comment_content'];
                    $comment_author_show = $row['comment_author'];

                    ?>

                    <div class="media">
                        <a class="pull-left" href="#">
                            <img class="media-object" src="http://placehold.it/64x64" alt="">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php  echo $comment_author_show;  ?>
                                <small><?php  echo $comment_date_show; ?></small>
                            </h4>
                          <?php  echo $comment_content_show; ?>
                        </div>
                    </div>

            <?php

                }

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

            <!-- Blog Categories Well -->
            <div class="well">
                <h4>Blog Categories</h4>
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                          <?php
                          $categorySidebar = mysqli_query($connection, "SELECT * FROM category");
                          while($row = mysqli_fetch_assoc($categorySidebar)) {
                            $titleSidebar = $row['title'];
                            echo "
                                    <li>
                                        <a href='#'>{$titleSidebar}</a>
                                    </li>
                                    ";
                          }
                          ?>
                        </ul>
                    </div>
                    <!-- /.col-lg-6 -->
                    <div class="col-lg-6">
                        <ul class="list-unstyled">
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                            <li><a href="#">Category Name</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.col-lg-6 -->
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
