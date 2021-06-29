<?php include './includes/admin-header.php';?>

<div id="wrapper">

  <?php  include './includes/admin-navigation.php';?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Welcome to posts page
                <small>Author</small>
            </h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Category ID</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Comment Count</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $posts = mysqli_query($connection, "SELECT * FROM posts");
                    while($row = mysqli_fetch_assoc($posts)) {
                        $postId = $row['id'];
                        $postAuthor = $row['author'];
                        $postTitle = $row['title'];
                        $postCatId = $row['category_id'];
                        $postStatus = $row['status'];
                        $postImage = $row['image'];
                        $postTag = $row['tags'];
                        $postCommentCount = $row['comment_count'];
                        $postDate = $row['date'];
                        echo "
                        <tr>
                            <td>{$postId}</td>
                            <td>{$postAuthor}</td>
                            <td>{$postTitle}</td>
                            <td>{$postCatId}</td>
                            <td>{$postStatus}</td>
                            <td>
                                <img src='{$postImage}' alt='image' width='100'>
                            </td>
                            <td>{$postTag}</td>
                            <td>{$postCommentCount}</td>
                            <td>{$postDate}</td>
                        </tr>
                        
                        ";
                    }
                ?>
                </tbody>
            </table>
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


