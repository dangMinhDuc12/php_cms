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
                            <td><a style='margin-right: 10px' href='posts.php?delete={$postId}'>Delete</a><a href='posts.php?source=edit_post&p_id={$postId}'>Edit</a></td>
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
