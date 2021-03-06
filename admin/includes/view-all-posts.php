<?php
if(isset($_POST['checkBoxArray'])) {
  //Thêm name có dấu mảng [] thì trong biến $_POST['name mảng'] ta có thể lấy được tất cả các giá trị mà ta check vào ô checkbox
  foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
    $bulk_option = $_POST['bulk_option'];
    switch ($bulk_option) {
      case 'publish':
      {
        $update_to_publish = mysqli_query($connection, "
              
                UPDATE posts SET status = 'publish' WHERE id = $checkBoxValue
              
              ");
        if (!$update_to_publish) {
          die("update failed" . mysqli_error($connection));
        }
        break;
      }
      case 'draft':
      {
        $update_to_draft = mysqli_query($connection, "
              
                UPDATE posts SET status = 'draft' WHERE id = $checkBoxValue
              
              ");
        if (!$update_to_draft) {
          die("update failed" . mysqli_error($connection));
        }
        break;
      }
      case 'delete':
      {
        $delete_select_post = mysqli_query($connection, "
                DELETE FROM posts WHERE id = $checkBoxValue
            ");
        if (!$delete_select_post) {
          die('delete failed' . mysqli_error($connection));
        }
        break;
      }
      case 'clone': {
        $postsClone = mysqli_query($connection, "SELECT * FROM posts WHERE id = $checkBoxValue");
        while($row = mysqli_fetch_assoc($postsClone)) {
          $postIdClone = $row['id'];
          $postAuthorClone = $row['author'];
          $postTitleClone = $row['title'];
          $postCatIdClone = $row['category_id'];
          $postStatusClone = $row['status'];
          $postImageClone = $row['image'];
          $postTagClone = $row['tags'];
          $postContentClone = $row['content'];
          $postCommentCountClone = $row['comment_count'];
          $postDateClone = $row['date'];
          $postImageShowClone = null;

        }
        $createPostClone = mysqli_query($connection, "
        INSERT INTO posts (title, category_id, author, status, tags, content, image, date, comment_count)
        VALUES ('$postTitleClone', $postCatIdClone, '$postAuthorClone', '$postStatusClone', '$postTagClone', '$postContentClone', '$postImageClone', '$postDateClone', '$postCommentCountClone')
    ");
        if(!$createPostClone) {
          die('Insert Failed' . mysqli_error($connection));
        }
        break;
      }
    }
  }
}
?>





<form action="" method="post">

    <div id="bulkOptionsContainer" class="col-xs-4" style="margin-bottom: 10px">
        <select name="bulk_option" id="" class="form-control">
            <option value="">Select Options</option>
            <option value="publish">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>
        </select>
    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="posts.php?source=add_post" class="btn btn-primary">Add new</a>
    </div>
<table class="table table-bordered table-hover">


  <thead>
  <tr>
    <th><input type="checkbox" id="selectAllBoxes"></th>
    <th>ID</th>
    <th>Author</th>
    <th>Title</th>
    <th>Category ID</th>
    <th>Status</th>
    <th>Image</th>
    <th>Tags</th>
    <th>Comment Count</th>
    <th>View Count</th>
    <th>Date</th>
    <th>Action</th>
  </tr>
  </thead>
  <tbody>
  <?php
  $posts = mysqli_query($connection, "SELECT * FROM posts ORDER BY id DESC ");
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
    $postViewCount = $row['view_count'];
    $postImageShow = null;
    //Hàm str_contains check xem chuỗi ở param thứ 2 có tồn tại trong chuỗi ở param 1 ko, nếu có trả về true
    if(str_contains($postImage, 'http')) {
        $postImageShow = $postImage;
    } else {
        $postImageShow = "../images/$postImage";
    }

    $categories = mysqli_query($connection, "SELECT * FROM category WHERE id = $postCatId");
    while ($row = mysqli_fetch_assoc($categories)) {
        $catTitle = $row['title'];
    }
    $countCommentsQuery = mysqli_query($connection, "
        SELECT * FROM comments WHERE comment_post_id = $postId
    ");
    $countComments = mysqli_num_rows($countCommentsQuery);
    echo "
                        <tr>
                            <td><input type='checkbox' class='checkBoxChild' name='checkBoxArray[]' value='$postId'></td>
                            <td>{$postId}</td>
                            <td>{$postAuthor}</td>
                            <td>{$postTitle}</td>
                            <td>{$catTitle}</td>
                            <td>{$postStatus}</td>
                            <td>
                                <img src='{$postImageShow}' alt='image' width='100'>
                            </td>
                            <td>{$postTag}</td>
                            <td>{$countComments}</td>
                            <td><a href='posts.php?reset=$postId'>{$postViewCount}</a></td>
                            <td>{$postDate}</td>
                            <td><a style='margin-right: 10px' href='posts.php?delete={$postId}' class='delete-post' onclick=\"return confirm('Are you sure want to delete')\">Delete</a><a style='margin-right: 10px' href='posts.php?source=edit_post&p_id={$postId}'>Edit</a><a href='../post.php?p_id={$postId}'>Go to post</a></td>
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
  if(isset($_GET['reset'])) {
    if(!mysqli_query($connection, "UPDATE  posts SET view_count = 0 WHERE id = {$_GET['reset']}")) {
      die('Update Failed' . mysqli_error($connection));
    }
    header('Location: posts.php');
  }
  ?>
  </tbody>
</table>
</form>
