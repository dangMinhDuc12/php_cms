
<form action="" method="post" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" class="form-control" name="title">
  </div>
  <div class="form-group">
    <label for="post_category_id">Post Category Id</label>
    <input type="text" class="form-control" name="post_category_id">
  </div>
  <div class="form-group">
    <label for="post_author">Post Author</label>
    <input type="text" class="form-control" name="author">
  </div>
  <div class="form-group">
    <label for="post_status">Post status</label>
    <input type="text" class="form-control" name="post_status">
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
    <textarea name="post_content" id="" cols="30" rows="10" class="form-control" style="resize: none"></textarea>
  </div>
  <div class="form-group">
    <input type="submit" name="create_post" class="btn btn-primary" value="Add post">
  </div>

</form>
