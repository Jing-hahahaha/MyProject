<?php
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

if($_POST['state'] == '1'){
    $sql="INSERT INTO bbs_focus (bbs_from_user_id,bbs_to_user_id,bbs_focus_time)
          VALUE ('{$_POST['fromID']}','{$_POST['toID']}',NOW())";
    $result=$con->query($sql);
    if(!!$num=$con->affected_rows){
        echo json_encode('success');
    }
}else if($_POST['state'] == '0'){
    $sql="SELECT * FROM bbs_focus WHERE bbs_from_user_id={$_POST['fromID']} AND bbs_to_user_id={$_POST['toID']}";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){  //存在关注
        $sql2="DELETE FROM bbs_focus WHERE bbs_from_user_id={$_POST['fromID']} AND bbs_to_user_id={$_POST['toID']}";
        $result2=$con->query($sql2);
        if(!!$num2=$con->affected_rows){
            echo json_encode('fault');
        }
    }
}
?>