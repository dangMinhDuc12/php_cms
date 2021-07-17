<?php
session_start();
session_unset(); //Remove các biến session khỏi bộ nhớ
header("Location: ../../index.php");