<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-7-5
 * Time: 0:44
 */
define('IN_BBS',true);
require 'include/MyDB.php';


//查找用户
if(isset($_POST['search_user'])){
    $sql="SELECT * FROM bbs_user WHERE bbs_username='{$_POST['search_user']}'";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){
        $arr=array();
        $row=$result->fetch_assoc();
        array_push($arr,
            "<tr>
                <td style='width: 20px'><input type='checkbox' name='user_check[]' value='{$row['bbs_id']}'></td>
                <td style='width: 40px'>{$row['bbs_id']}</td>
                <td style='width: 150px' title='{$row['bbs_username']}'>{$row['bbs_username']}</td>
                <td style='width: 140px' title='{$row['bbs_password']}'>{$row['bbs_password']}</td>
                <td style='width: 40px'>{$row['bbs_sex']}</td>
                <td style='width: 140px' title='{$row['bbs_face']}'>{$row['bbs_face']}</td>
                <td style='width: 150px' title='{$row['bbs_signature']}'>{$row['bbs_signature']}</td>
                <td style='width: 140px'>{$row['bbs_register_time']}</td>
            </tr>"
        );
        echo json_encode($arr);
    }else{
        echo json_encode('用户查找失败');
    }
}


//查找帖子
if(isset($_POST['search_article'])){
    $sql="SELECT * FROM bbs_send WHERE bbs_title='{$_POST['search_article']}'";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){
        $arr=array();
        $row=$result->fetch_assoc();

        $sql2="SELECT * FROM bbs_user WHERE bbs_id={$row['bbs_user_id']}";
        $result2=$con->query($sql2);
        if(!!$num2=$result2->num_rows){
            $row2=$result2->fetch_assoc();
        }
        array_push($arr,
            "<tr>
                <td style='width: 20px'><input type='checkbox' name='article_check[]' value='{$row['bbs_id']}'></td>
                <td style='width: 40px'>{$row['bbs_id']}</td>
                <td style='width: 150px' title='{$row['bbs_title']}'>{$row['bbs_title']}</td>
                <td style='width: 200px' title='{$row['bbs_send_content']}'>{$row['bbs_send_content']}</td>
                <td style='width: 100px' title='{$row2['bbs_username']}'>{$row2['bbs_username']}</td>
                <td style='width: 140px'>{$row['bbs_send_time']}</td>
                <td style='width: 60px'>{$row['bbs_read_count']}</td>
                <td style='width: 100px'>{$row['bbs_type']}</td>
            </tr>"
        );
        echo json_encode($arr);
    }else{
        echo json_encode('帖子查找失败');
    }
}






//新增用户
if(isset($_POST['modify_name']) && isset($_POST['modify_pwd']) && isset($_POST['modify_sex']) && isset($_POST['modify_signature'])){
    $sql="INSERT INTO bbs_user (bbs_username,bbs_password,bbs_sex,bbs_signature,bbs_register_time)
          VALUE ('{$_POST['modify_name']}','{$_POST['modify_pwd']}','{$_POST['modify_sex']}','{$_POST['modify_signature']}',NOW())";
    $result=$con->query($sql);
    if(!!$num=$con->affected_rows){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}


//编辑用户
if(isset($_POST['user_id']) && isset($_POST['edit_name']) && isset($_POST['edit_pwd'])){
    $sql="UPDATE bbs_user SET bbs_username='{$_POST['edit_name']}',bbs_password='{$_POST['edit_pwd']}',bbs_sex='{$_POST['edit_sex']}',bbs_face='{$_POST['edit_face']}',
          bbs_signature='{$_POST['edit_signature']}',bbs_register_time='{$_POST['edit_register_time']}' WHERE bbs_id='{$_POST['user_id']}'";
    $result=$con->query($sql);
    if(!!$num=$con->affected_rows){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}



//删除用户
if(isset($_POST['user_check'])){
    foreach($_POST['user_check'] as $arr){
        $sql="DELETE FROM bbs_user WHERE bbs_id='{$arr}'";
        $result=$con->query($sql);
        if(!!$num=$con->affected_rows){
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}



//新增帖子
if(isset($_POST['insert_user']) && isset($_POST['title']) && isset($_POST['textarea'])){
    $sql="SELECT * FROM bbs_user WHERE bbs_username='{$_POST['insert_user']}'";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){
        $row=$result->fetch_assoc();
    }


    $sql2="INSERT INTO bbs_send (bbs_user_id,bbs_title,bbs_type,bbs_send_content,bbs_send_time)
          VALUE ('{$row['bbs_id']}','{$_POST['title']}','{$_POST['select']}','{$_POST['textarea']}',NOW())";
    $result2=$con->query($sql2);
    if(!!$num2=$con->affected_rows){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}


//编辑帖子
if(isset($_POST['edit_article_id']) && isset($_POST['edit_article_user'])){
    $sql="SELECT * FROM bbs_user WHERE bbs_username='{$_POST['edit_article_user']}'";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){
        $row=$result->fetch_assoc();
    }


    $sql2="UPDATE bbs_send SET bbs_user_id='{$row['bbs_id']}',bbs_type='{$_POST['edit_select']}',bbs_read_count='{$_POST['edit_read_count']}',
            bbs_send_time='{$_POST['edit_send_time']}' WHERE bbs_id='{$_POST['edit_article_id']}'";
    $result2=$con->query($sql2);
    if(!!$num2=$con->affected_rows){
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}


//删除帖子
if(isset($_POST['article_check'])){
    foreach($_POST['article_check'] as $arr){
        $sql="DELETE FROM bbs_send WHERE bbs_id='{$arr}'";
        $result=$con->query($sql);
        if(!!$num=$con->affected_rows){
            header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    }
}



?>
