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
                            <small><?php echo $_SESSION['login_user_name']?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $queryPosts = mysqli_query($connection, "
                                        SELECT * FROM posts
                                        
                                        ");
                                        $numberPosts = mysqli_num_rows($queryPosts);
                                        echo "<div class='huge'>$numberPosts</div>";
                                        ?>




                                        <div>Posts</div>
                                    </div>
                                </div>
                            </div>
                            <a href="./posts.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                      <?php
                                      $queryComments = mysqli_query($connection, "
                                        SELECT * FROM comments
                                        
                                        ");
                                      $numberComments = mysqli_num_rows($queryComments);
                                      echo "<div class='huge'>$numberComments</div>";
                                      ?>
                                        <div>Comments</div>
                                    </div>
                                </div>
                            </div>
                            <a href="comments.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                      <?php
                                      $queryUsers = mysqli_query($connection, "
                                        SELECT * FROM users
                                        
                                        ");
                                      $numberUsers = mysqli_num_rows($queryUsers);
                                      echo "<div class='huge'>$numberUsers</div>";
                                      ?>
                                        <div> Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                      <?php
                                      $queryCategory = mysqli_query($connection, "
                                        SELECT * FROM category
                                        
                                        ");
                                      $numberCategory = mysqli_num_rows($queryCategory);
                                      echo "<div class='huge'>$numberCategory</div>";
                                      ?>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
              <?php
              $queryPostsDraft = mysqli_query($connection, "
                                        SELECT * FROM posts WHERE status = 'draft'
                                        
                                        ");
              $numberPostsDraft = mysqli_num_rows($queryPostsDraft);


              $queryCommentsUnapproved = mysqli_query($connection, "
                                        SELECT * FROM comments WHERE comment_status = 'unapproved'
                                        
                                        ");
              $numberCommentsUnapproved = mysqli_num_rows($queryCommentsUnapproved);

              $queryUsersSubscriber = mysqli_query($connection, "
                                        SELECT * FROM users WHERE user_role = 'subscriber'
                                        
                                        ");
              $numberUsersSubscriber = mysqli_num_rows($queryUsersSubscriber);
              ?>



                <div class="row">
                    <div id="columnchart_material" style="width: auto; height: 500px;"></div>
                </div>
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
<script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Data', 'Count'],

            <?php
                $element_text = ['All Posts', 'Draft Posts', 'All Comments', 'Unapproved Comments', 'All Users', 'Subscriber Users', 'Categories'];
                $element_count = [$numberPosts, $numberPostsDraft, $numberComments, $numberCommentsUnapproved, $numberUsers, $numberUsersSubscriber, $numberCategory];
                for($i = 0; $i < count($element_count); $i++) {
                    echo "['$element_text[$i]', $element_count[$i]],";
                }
            ?>

        ]);

        var options = {
            chart: {
                title: '',
                subtitle: '',
            }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>

</body>

</html>
