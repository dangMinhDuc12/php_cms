<?php include './includes/admin-header.php';?>

<div id="wrapper">

  <?php  include './includes/admin-navigation.php';?>

  <div id="page-wrapper">

    <div class="container-fluid">

      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome to admin page
            <small>Author</small>
          </h1>
          <!--  Add Category Form-->
          <div class="col-xs-6">
            <?php
                if (isset($_POST['submit'])) {
                   $categoryAdd = $_POST['cat_title'];
                   // Hàm empty check xem biến có giá trị hay không, nếu có trả về false, nếu không có giá trị, hoặc bằng null, bằng 0 thì trả về true
                   if ($categoryAdd === '' || empty($categoryAdd)) {
                       echo "This field should not be empty";
                   } else {
                       $categoryAddQuery = mysqli_query($connection, "INSERT INTO category (title) VALUES ('{$categoryAdd}')");
                       if(!$categoryAdd) {
                           die('Insert Failed' . mysqli_error($connection));
                       }
                   }
                }
            ?>


            <form action="" method="post">
              <div class="form-group">
                <label for="cat_title">Category name</label>
                <input type="text" class="form-control" name="cat_title">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Add category" name="submit">
              </div>
            </form>
          </div>
          <!--  Add Category Form-->
          
        <!--Table-->
          <div class="col-xs-6">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Category Title</th>
                </tr>
              </thead>
              <tbody>
                <?php

                $category = mysqli_query($connection, "SELECT * FROM category");
                while($row = mysqli_fetch_assoc($category)) {
                  $catTitle = $row['title'];
                  $catId = $row['id'];
                  echo "
                    <tr>
                      <td>{$catId}</td>
                      <td>{$catTitle}</td>
                    </tr>
                    ";
                }

                ?>
              </tbody>
            </table>
          </div> 
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

</body>

</html>
s
