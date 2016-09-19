<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-25
 * Time: 19:54
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

//回复帖子
$arr=array();
$arr['article_id']=$_POST['topicID'];
$arr['from_user_id']=$_POST['from_userID'];
$arr['to_user_id']=$_POST['to_userID'];
$arr['respond_content']=$_POST['text_content'];
//var_dump($arr);


$sql="INSERT INTO bbs_respond (bbs_article_id,bbs_to_user_id,bbs_from_user_id,bbs_respond_content,bbs_respond_time)
      VALUES ('{$arr['article_id']}','{$arr['to_user_id']}','{$arr['from_user_id']}','{$arr['respond_content']}',NOW())";

$result=$con->query($sql);
if(!!$num=$con->affected_rows){
//    echo '回复成功';
//    以下两种方法是返回上一页并刷新
    header('Location: '.$_SERVER['HTTP_REFERER']);
//    echo "<script>javascript:window.location.href=document.referrer; </script>";
}else{
    echo '回复失败';
}




?>
