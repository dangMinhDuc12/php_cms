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

    echo "
                        <tr>
                            <td>{$comment_id }</td>
                            <td>{$comment_author}</td>
                            <td>{$comment_content}</td>
                            <td>{$comment_email}</td>
                            <td>{$comment_status}</td>
                            <td>In respon to</td>
                            <td>{$comment_date}</td>
                            <td><a>Approve</a></td>
                            <td><a>Unapprove</a></td>
                            <td><a>Delete</a></td>
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

