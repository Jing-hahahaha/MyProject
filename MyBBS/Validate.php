<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-21
 * Time: 13:23
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

//验证验证码是否正确
if(isset($_POST['check'])){
    if($_POST['check'] != $_SESSION['code']){
        echo json_encode('验证码错误');
    }else{
        echo json_encode('验证码正确');
    }
}else if(isset($_POST['password']) && isset($_POST['name'])){
    //检查用户名和密码是否匹配
    $sql="SELECT * FROM bbs_user WHERE bbs_username='{$_POST['name']}' AND bbs_password='{$_POST['password']}'";
    $result=$con->query($sql);
    if(!!$row=$result->num_rows){
        echo json_encode('存在');
        die;
    }else{
        echo json_encode('不存在');
    }
}else{
    //检查是否已经存在该用户名
    $sql="SELECT bbs_username FROM bbs_user WHERE bbs_username='{$_POST['name']}'";
    $result=$con->query($sql);
    if(!!$row=$result->num_rows){
        echo json_encode('存在');
        die;
    }else{
        echo json_encode('不存在');
    }
}

?>
