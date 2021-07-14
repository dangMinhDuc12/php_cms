<table class="table table-bordered table-hover">
  <thead>
  <tr>
    <th>ID</th>
    <th>Author</th>
    <th>Comment</th>
    <th>Email</th>
    <th>Status</th>
    <th>In Response To</th>
    <th>Date</th>
    <th>Approve</th>
    <th>Unapprove</th>
    <th>Delete</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $comments = mysqli_query($connection, "SELECT * FROM comments");
  while($row = mysqli_fetch_assoc($comments)) {
    $comment_id = $row['id'];
    $comment_post_id = $row['comment_post_id'];
    $comment_author = $row['comment_author'];
    $comment_email = $row['comment_email'];
    $comment_content = $row['comment_content'];
    $comment_status = $row['comment_status'];
    $comment_date = $row['comment_date'];
    $posts = mysqli_query($connection, "SELECT * FROM posts WHERE id = $comment_post_id");
    while ($row = mysqli_fetch_assoc($posts)) {
      $post_title = $row['title'];
      $post_id = $row['id'];
    }

    echo "
                        <tr>
                            <td>{$comment_id }</td>
                            <td>{$comment_author}</td>
                            <td>{$comment_content}</td>
                            <td>{$comment_email}</td>
                            <td>{$comment_status}</td>
                            <td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>
                            <td>{$comment_date}</td>
                            <td><a href='comments.php?approved=$comment_id'>Approve</a></td>
                            <td><a href='comments.php?unapproved=$comment_id'>Unapprove</a></td>
                            <td><a href='comments.php?delete=$comment_id'>Delete</a></td>
                        </tr>
                        
                        ";
  }
  ?>
  <?php
  if(isset($_GET['delete'])) {
    $post_id_delete = $_GET['delete'];
    if(!mysqli_query($connection, "DELETE FROM comments WHERE id = $post_id_delete")) {
      die('Delete comment failed' . mysqli_error($connection));
    }
    header('Location:comments.php');
  }

  if(isset($_GET['approved'])) {
    $comment_id_update = $_GET['approved'];
    if(!mysqli_query($connection, "UPDATE comments SET comment_status = 'approved' WHERE id = $comment_id_update")) {
      die('Update failed' . mysqli_error($connection));
    }
    header("Location:comments.php");
  }
  if(isset($_GET['unapproved'])) {
    $comment_id_update = $_GET['unapproved'];
    if(!mysqli_query($connection, "UPDATE comments SET comment_status = 'unapproved' WHERE id = $comment_id_update")) {
      die('Update failed' . mysqli_error($connection));
    }
    header("Location:comments.php");
  }
  ?>
  </tbody>
</table>


