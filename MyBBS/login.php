<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-20
 * Time: 12:08
 */
session_start();

$_SESSION['username']=$_POST['username'];
header('location:index.php');

?>
