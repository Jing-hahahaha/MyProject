<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-22
 * Time: 16:15
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

//头部发帖
if(isset($_POST['textarea']) && isset($_POST['select']) && isset($_POST['title'])){
    $sql="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){
        $row=$result->fetch_assoc();
        $user_id=$row['bbs_id'];

//    echo $user_id;

        $arr=array();
        $arr['user_id']=$user_id;
        $arr['type']=$_POST['select'];
        $arr['title']=$_POST['title'];
        $arr['content']=$_POST['textarea'];

        $sql2="INSERT INTO bbs_send (bbs_user_id,bbs_title,bbs_type,bbs_send_content,bbs_send_time)
      VALUES ('{$arr['user_id']}','{$arr['title']}','{$arr['type']}','{$arr['content']}',NOW())";

        $result2=$con->query($sql2);
        if(!!$row2=$con->affected_rows){
//        echo '发帖成功';
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            echo '发帖失败';
        }
    }else{
        echo "用户ID查找失败";
    }
}


//个人中心删帖、置顶
if(isset($_POST['id']) && isset($_POST['operate'])){
    if($_POST['operate'] == 1){  //删除帖子
        $sql="DELETE FROM bbs_send WHERE bbs_id={$_POST['id']}";
        $result=$con->query($sql);
        if(!!$num=$con->affected_rows){
            echo json_encode("帖子删除成功");
        }else{
            echo "帖子删除失败";
        }
    }else if($_POST['operate'] == 2){  //帖子置顶,在当前时间加一年
        $sql="UPDATE bbs_send SET bbs_send_time=DATE_ADD(NOW(), INTERVAL 1 YEAR) WHERE bbs_id={$_POST['id']}";
        $result=$con->query($sql);
        if(!!$num=$con->affected_rows){
            echo json_encode("帖子置顶成功");
        }else{
            echo "帖子置顶失败";
        }
    }
}


//个人中心删除回复
if(isset($_POST['reply_id'])){
    $sql="DELETE FROM bbs_respond WHERE bbs_id={$_POST['reply_id']}";
    $result=$con->query($sql);
    if(!!$num=$con->affected_rows){
        echo json_encode("回复删除成功");
    }else{
        echo "回复删除失败";
    }
}


?>
