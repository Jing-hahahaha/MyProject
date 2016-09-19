<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-29
 * Time: 22:02
 */

//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

//更新个人资料
$sql="UPDATE bbs_user SET bbs_username='{$_POST['modify_name']}',bbs_password='{$_POST['modify_pwd']}',
      bbs_sex='{$_POST['modify_sex']}',bbs_face='{$_POST['modify_face']}',bbs_signature='{$_POST['modify_signature']}' WHERE bbs_id='{$_POST['user_id']}'";

$result=$con->query($sql);
if(!!$num=$con->affected_rows){
//    echo "更新个人资料成功";
    require 'exit.php';
}else{
    echo "更新个人资料失败";
}



?>
