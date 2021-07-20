<?php
if(isset($_GET['p_id'])) {
  $idPostEdit = $_GET['p_id'];
  $postEdit = mysqli_query($connection, "SELECT * FROM posts WHERE id = $idPostEdit");
  while($row = mysqli_fetch_assoc($postEdit)) {
    $postId = $row['id'];
    $postAuthor = $row['author'];
    $postTitle = $row['title'];
    $postCatId = $row['category_id'];
    $postStatus = $row['status'];
    $postImage = $row['image'];
    $postTag = $row['tags'];
    $postCommentCount = $row['comment_count'];
    $postDate = $row['date'];
    $postContent = $row['content'];
  }

}
?>

<?php
if(isset($_POST['update_post'])) {
  $postTitle = $_POST['title'];
  $postCategoryId = $_POST['post_category_id'];
  $postAuthor = $_POST['author'];
  $postStatus = $_POST['post_status'];
  $postTags = $_POST['post_tags'];
  $postContent = $_POST['post_content'];
  $postImage = $_FILES['image']['name'];
  $postDate = date('Y-m-d');
  $postCommentCount = 3;
  move_uploaded_file($_FILES['image']['tmp_name'], "../images/$postImage");

  if(empty($postImage)) {
    $postHasImage = mysqli_query($connection, "SELECT * FROM posts WHERE id = $idPostEdit");
    while($row = mysqli_fetch_assoc($postHasImage)) {
      $postImage = $row['image'];

    }
  }

  $updatePost = mysqli_query($connection, "
    UPDATE posts
    SET title = '$postTitle', category_id = $postCategoryId,
        author = '$postAuthor', status = '$postStatus',
        tags = '$postTags', content = '$postContent',
        image = '$postImage', date = '$postDate',
        comment_count = '$postCommentCount'
    WHERE id = $idPostEdit
    
  ");
  if(!$updatePost) {
      die('Update failed' . mysqli_error($connection));
  }
  header('Location:posts.php');
}
?>





<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo $postTitle; ?>">
  </div>
  <div class="form-group">
    <label for="post_category_id">Post Category Id</label>
    <select name="post_category_id" id="" class="form-control">
        <?php
            $categories = mysqli_query($connection, "SELECT * FROM category");
            if(!$categories) {
                die('Query failed' . mysqli_error($connection));
            }
            while ($row = mysqli_fetch_assoc($categories)) {
                $catId = $row['id'];
                $catTitle = $row['title'];
                echo $catId;
                echo $postCatId;
                if($catId === $postCatId) {
                    echo " <option value='{$catId}' selected>{$catTitle}</option>";
                } else {
                  echo "
                    <option value='{$catId}'>{$catTitle}</option>
                ";
                }
            }

        ?>
    </select>
  </div>
  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" class="form-control" name="author" value="<?php echo $postAuthor; ?>">
  </div>
  <div class="form-group">
    <label for="post_status">Post status</label>
      <select name="post_status" class="form-control">
        <?php
            if($postStatus === 'publish') {
                echo "
                    <option value='publish' selected>Publish</option>
                    <option value='draft'>Draft</option>
                ";
            } else {
              echo "
                    <option value='publish' >Publish</option>
                    <option value='draft' selected>Draft</option>
                ";
            }
        ?>
      </select>
  </div>
  <div class="form-group">
      <img width="100" src="<?php if(str_contains($postImage, 'http')) {
          echo $postImage;
      } else {
          echo "../images/$postImage";
      }?>" alt="">
      <input type="file" name="image" style="margin-top: 10px">
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" class="form-control" name="post_tags" value="<?php echo $postTag; ?>">
  </div>
  <div class="form-group">
    <label for="post_content">Post content</label>
    <textarea name="post_content" id="" cols="30" rows="10" class="form-control" style="resize: none">
        <?php echo $postContent; ?>
    </textarea>
  </div>
  <div class="form-group">
    <input type="submit" name="update_post" class="btn btn-primary" value="Update post">
  </div>

</form>
