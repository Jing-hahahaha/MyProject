<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-7-1
 * Time: 21:57
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

if(isset($_POST['readnum']) && isset($_POST['id'])){
    $sql="UPDATE bbs_send SET bbs_read_count=bbs_read_count+1 WHERE bbs_id='{$_POST['id']}'";
    $result=$con->query($sql);
    if(!!$num=$con->affected_rows){
        echo "阅读量更新成功";
    }else{
        echo "阅读量更新失败";
    }
}



?>
