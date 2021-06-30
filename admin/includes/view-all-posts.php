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
    <th>Action</th>
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
                            <td><a href='posts.php?delete={$postId}'>Delete</a></td>
                        </tr>
                        
                        ";
  }
  ?>

  <?php
    if(isset($_GET['delete'])) {
        if(!mysqli_query($connection, "DELETE FROM posts WHERE id = {$_GET['delete']}")) {
            die('Delete Failed' . mysqli_error($connection));
        }
        header('Location: posts.php');
    }
  ?>
  </tbody>
</table>
