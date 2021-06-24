<?php

$connection = mysqli_connect('localhost', 'root', '', 'cms_project');
if(!$connection) {
  die('Connect failed' . mysqli_error($connection));
}
