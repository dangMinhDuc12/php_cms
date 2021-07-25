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
          <?php
            if(isset($_GET['source'])) {
                $source = $_GET['source'];
            } else {
                $source = '';
            }
            switch ($source) {
              case "add_post": {
                  include './includes/add_post.php';
                  break;
              }
              case "edit_post": {
                  include './includes/edit_post.php';
                  break;
              }
              case "200": {
                echo "Nice 200";
                break;
              }
              default: {
                  include './includes/view-all-posts.php';
                  break;
              }
            }
          ?>
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 200
        });
    });
</script>
<script src="./js/post.js"></script>

</body>

</html>


