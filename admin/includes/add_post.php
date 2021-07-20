<?php
if(isset($_POST['create_post'])) {
    /*
     * Hàm move_uploaded_file sẽ check xem tệp tin tải lên liệu có được valid qua phương thức POST HTTP của form hay ko
     * nếu đúng sẽ trả về true và chuyển form đến địa chỉ file ở params số 2
     * (params thứ 1 là tên của nơi mà file được tải lên tạm thời là server của xampp làm trung gian)
     * */
    $postTitle = $_POST['title'];
    $postCategoryId = $_POST['post_category_id'];
    $postAuthor = $_POST['author'];
    $postStatus = $_POST['post_status'];
    $postTags = $_POST['post_tags'];
    $postContent = $_POST['post_content'];
    $postImage = $_FILES['image']['name'];
    $postDate = date('Y-m-d');
    $postCommentCount = 0;
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/$postImage");

    $createPost = mysqli_query($connection, "
        INSERT INTO posts (title, category_id, author, status, tags, content, image, date, comment_count)
        VALUES ('$postTitle', $postCategoryId, '$postAuthor', '$postStatus', '$postTags', '$postContent', '$postImage', '$postDate', '$postCommentCount')
    ");
    if(!$createPost) {
        die('Insert Failed' . mysqli_error($connection));
    }
}

?>



<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title">
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
            echo " <option value='{$catId}' selected>{$catTitle}</option>";
          }

          ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_author">Post Author</label>
        <input type="text" class="form-control" name="author">
    </div>
    <div class="form-group">
        <label for="post_status">Post status</label>
        <select name="post_status" class="form-control">
            <option value="publish">Publish</option>
            <option value="draft">Draft</option>
        </select>
    </div>
    <div class="form-group">
        <label for="post_image">Post Image</label>
        <input type="file"  name="image">
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">
    </div>
    <div class="form-group">
        <label for="post_content">Post content</label>
        <textarea name="post_content" id="summernote" cols="30" rows="10" class="form-control" style="resize: none"></textarea>
    </div>
    <div class="form-group">
        <input type="submit" name="create_post" class="btn btn-primary" value="Add post">
    </div>

</form>
