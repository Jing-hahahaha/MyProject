<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-7-2
 * Time: 10:47
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';


//首页分类帖子
if(isset($_POST['value'])) {
    $sql = "SELECT * FROM bbs_send WHERE bbs_type='{$_POST['value']}' ORDER BY bbs_send_time DESC";
}

$result=$con->query($sql);
if(!!$num=$result->num_rows){
    for($i=0;$i<$num;$i++){
        $row=$result->fetch_assoc();

        $sql2="SELECT * FROM bbs_user WHERE bbs_id={$row['bbs_user_id']}";
        $result2=$con->query($sql2);
        if(!!$num2=$result2->num_rows){
            $row2=$result2->fetch_assoc();
        }else{
            echo "用户名查找失败";
        }

//            读取评论量
        $sql3="SELECT * FROM bbs_respond WHERE bbs_article_id='{$row['bbs_id']}'";
        $result3=$con->query($sql3);
        $num3=$result3->num_rows;

        echo "
            <div class='article'>
                <h3 class='title'><a href='detailed.php?topicID={$row['bbs_id']}' target='_blank' title='{$row['bbs_title']}' value='{$row['bbs_id']}'>{$row['bbs_title']}</a></h3>
                <div class='content'>{$row['bbs_send_content']}</div>
                <div class='article_img'>
                    <img src='image/img1.jpg'>
                    <img src='image/img2.jpg'>
                    <img src='image/img3.jpg'>
                </div>
                <div class='article_bottom'>
                    <div class='article_bottom_left'>
                        <span class='author'><a href='personal.php?personID={$row2['bbs_id']}' target='_blank' title='作者'>{$row2['bbs_username']}</a></span>
                        <span class='time' style='color: #a5a9a3;'>{$row['bbs_send_time']}</span>
                    </div>
                    <div class='article_bottom_right'>
                        <span class='readcount'><span class='glyphicon glyphicon-eye-open'></span>{$row['bbs_read_count']}</span>
                        <span class='commentcount'><span class='glyphicon glyphicon-comment'></span>$num3</span>
                    </div>
                    <div style='clear:both;height:0;overflow:hidden;'></div>
                </div>
            </div>
        ";
    }
}else{
    echo "读取帖子失败";
}

?>