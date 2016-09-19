<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-28
 * Time: 21:31
 */

//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

//发私信
if(isset($_POST['textarea'])){
    $arr=array();
    $arr['fromID']=$_POST['fromID'];
    $arr['toID']=$_POST['toID'];
    $arr['content']=$_POST['textarea'];

    $sql="INSERT INTO bbs_message (bbs_from_user_id,bbs_to_user_id,bbs_message_content,bbs_state,bbs_message_time)
      VALUES ('{$arr['fromID']}','{$arr['toID']}','{$arr['content']}','未读',NOW())";
    $result=$con->query($sql);
    if(!!$num=$con->affected_rows){
//        echo "发信成功";
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }else{
        echo "发信失败";
    }
}



//修改私信状态
if($_POST['isread']==true){
    $sql2="UPDATE bbs_message SET bbs_state='已读' WHERE bbs_id='{$_POST['letterID']}'";
    $result2=$con->query($sql2);
}


//删除私信
if(isset($_POST['check'])){
    foreach($_POST['check'] as $message_id){
        $sql="DELETE FROM bbs_message WHERE bbs_id=$message_id";
        $result=$con->query($sql);
        if(!!$num=$con->affected_rows){
//            echo "删除成功";
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }else{
            echo "删除失败";
        }
    }
}



?>
