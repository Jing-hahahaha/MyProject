<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-19
 * Time: 19:13
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

//注册插入新用户
$arr=array();
$arr['username']=$_POST['username'];
$arr['password']=$_POST['password'];
$arr['sex']=$_POST['sex'];

$sql="INSERT INTO bbs_user (bbs_username,bbs_password,bbs_sex,bbs_register_time)
      VALUES ('{$arr['username']}','{$arr['password']}','{$arr['sex']}',NOW())";
$result=$con->query($sql);
if(!!$row=$con->affected_rows){
//    echo '注册成功';
    $_SESSION['username']=$_POST['username'];
    header('location:index.php');
}else{
    echo '注册失败';
}


?>
