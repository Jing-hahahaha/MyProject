<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-21
 * Time: 18:01
 */
session_start();

session_destroy();
header('location:index.php');

?>
