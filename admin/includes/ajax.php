<?php

if(isset($_GET['onlineuser'])) {
  $object = [
    'name' => 'Duc',
    'age' => 20
  ];
  $arr = ['Nam', 'Duong'];
  echo json_encode($object);
}
