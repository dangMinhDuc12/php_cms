<?php
if(isset($_POST['checkBoxArray'])) {
    //Thêm name có dấu mảng [] thì trong biến $_POST['name mảng'] ta có thể lấy được tất cả các giá trị mà ta check vào ô checkbox
  foreach ($_POST['checkBoxArray'] as $checkBoxValue) {
      $bulk_option = $_POST['bulk_option'];
      switch ($bulk_option) {
        case 'publish': {
              $update_to_publish = mysqli_query($connection, "
              
                UPDATE posts SET status = 'publish' WHERE id = $checkBoxValue
              
              ");
              if(!$update_to_publish) {
                  die("update failed" . mysqli_error($connection));
              }
             break;
          }
        case 'draft': {
          $update_to_draft = mysqli_query($connection, "
              
                UPDATE posts SET status = 'draft' WHERE id = $checkBoxValue
              
              ");
          if(!$update_to_draft) {
            die("update failed" . mysqli_error($connection));
          }
          break;
        }
        case 'delete': {
            $delete_select_post = mysqli_query($connection, "
                DELETE FROM posts WHERE id = $checkBoxValue
            ");
            if(!$delete_select_post) {
                die('delete failed' . mysqli_error($connection));
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
                            <td>{$postCommentCount}</td>
                            <td>{$postDate}</td>
                            <td><a style='margin-right: 10px' href='posts.php?delete={$postId}'>Delete</a><a style='margin-right: 10px' href='posts.php?source=edit_post&p_id={$postId}'>Edit</a><a href='../post.php?p_id={$postId}'>Go to post</a></td>
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
</form>