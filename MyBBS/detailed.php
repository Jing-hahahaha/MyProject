<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-23
 * Time: 15:44
 */

//防止直接访问  $_SERVER['HTTP_REFERER']获取前一个页面的URL
if($_SERVER['HTTP_REFERER'] == ''){
    header('location:index.php');
}

//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

define('filename','detailed');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>帖子</title>
    <?php
    require 'include/title.php';
    ?>
</head>
<body>

<?php
require 'include/header.php';
?>

<!--帖子详细内容-->
<div id="container" class="container">
<!--    标题置顶  fixed 相对浏览器-->
    <?php
    $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
    $result1=$con->query($sql1);
    if(!!$num1=$result1->num_rows){
        $row1=$result1->fetch_assoc();
    }

    $sql="SELECT * FROM bbs_send WHERE bbs_id={$_GET['topicID']}";
    $result=$con->query($sql);
    if(!!$num=$result->num_rows){
        $row=$result->fetch_assoc();

//        根据发帖人ID从用户表中查找用户信息
        $sql2="SELECT * FROM bbs_user WHERE bbs_id={$row['bbs_user_id']}";
        $result2=$con->query($sql2);
//        echo "<script>alert($number)</script>";

        if(!!$num2=$result2->num_rows){
            $row2=$result2->fetch_assoc();

            $arr=array();
            $arr['username']=$row2['bbs_username'];
            $arr['face']=$row2['bbs_face'];
            $arr['sex']=$row2['bbs_sex'];
            $arr['signature']=$row2['bbs_signature'];

//            print_r($rows);

        }else{
            echo "用户信息查找失败";
        }

        echo "
            <div id='title'>{$row['bbs_title']}</div>
<!--    除了标题以外的以下部分-->
    <div style='margin-top: 50px'>
<!--        左边个人信息部分-->
        <div id='person'>
            <img src={$arr['face']} alt='头像'>
            <div style='text-align: center;margin-top: 10px'>
                <span><a href='personal.php?personID={$row['bbs_user_id']}' target='_blank'>{$arr['username']}</a></span><span>&nbsp;&nbsp;{$arr['sex']}</span>
                <div style='margin-top: 10px'>{$arr['signature']}</div>
            </div>
        </div>
<!--        右边帖子详细内容部分-->
        <div id='article'>
            <pre id='content'>{$row['bbs_send_content']}</pre>
            <div id='article_bottom'>
                <span style='margin-right: 30px'>{$row['bbs_send_time']}</span>
                <span class='comment'>收起回复</span>
            </div>
            <!--        以下是回复内容-->
            <div id='article_comment'>
                <form id='reply_form' action='respond.php' method='post'>
                    <span id='second'></span>
                    ";
                    if(isset($_SESSION['username'])){
                        echo "<button id='reply_btn' type='button' class='btn btn-warning'>我也说一句</button>";
                    }else{
                        echo "<button id='reply_btn' type='button' class='btn btn-warning' disabled>我也说一句</button>";
                    }
                echo "
                    <textarea id='text_area' name='text_content'></textarea>
                    <input type='hidden' name='from_userID' value='{$row1['bbs_id']}'>
                    <input type='hidden' name='to_userID' value='{$row['bbs_user_id']}'>
                    <input type='hidden' name='topicID' value='{$_GET['topicID']}'>
                </form>
                ";
    }else{
        echo "帖子详细内容显示失败";
    }

    ?>
                <?php
//                    从回复表中读取回复信息
                $sql="SELECT * FROM bbs_respond WHERE bbs_article_id={$_GET['topicID']}";
                $result=$con->query($sql);
                if(!!$num=$result->num_rows){
//                        echo "<script>alert($num2)</script>";

                    for($n=0;$n<$num;$n++){
                        $row=$result->fetch_assoc();

                        $arr=array();
                        $arr['to_user_id']=$row['bbs_to_user_id'];
                        $arr['from_user_id']=$row['bbs_from_user_id'];
                        $arr['respond_content']=$row['bbs_respond_content'];
                        $arr['respond_time']=$row['bbs_respond_time'];

//                        根据回复人ID和被回复人ID从用户表中读取用户信息
                        $sql2 ="SELECT * FROM bbs_user WHERE bbs_id={$arr['from_user_id']}";
                        $result2=$con->query($sql2);
                        if(!!$num2=$result2->num_rows){
                            $row2=$result2->fetch_assoc();

                            $arr2=array();
                            $arr2['bbs_id']=$row2['bbs_id'];
                            $arr2['bbs_face']=$row2['bbs_face'];
                            $arr2['bbs_username']=$row2['bbs_username'];
                        }

                        $sql3 ="SELECT * FROM bbs_user WHERE bbs_id={$arr['to_user_id']}";
                        $result3=$con->query($sql3);
                        if(!!$num3=$result3->num_rows){
                            $row3=$result3->fetch_assoc();

                            $arr3=array();
                            $arr3['bbs_username']=$row3['bbs_username'];
                        }

                        echo "
                            <div class='comment_list'>
                                <img src='{$arr2['bbs_face']}'>
                                <div style='width:555px;float: right'>
                                    <div class='comment_content'>
                                        <a href='personal.php?personID={$arr2['bbs_id']}'>{$arr2['bbs_username']}</a> 回复 <a href='personal.php?personID={$arr['to_user_id']}'>{$arr3['bbs_username']}</a></span>：
                                        <span class='reply_content'>{$arr['respond_content']}</span>
                                    </div>
                                    <div style='text-align: right'>
                                        <span style='margin-right: 30px'>{$arr['respond_time']}</span>
                                        <span class='reply' name='{$arr2['bbs_id']}' value='{$arr2['bbs_username']}'>回复</span>
                                    </div>
                                </div>
                                <!--        增加一个空的div，使得父级div.comment_list自动扩充高度-->
                                <div style='clear: both'></div>
                            </div>
                        ";
                    }
                }else{
//                    echo "回复信息读取失败";
//                    echo "暂无回复";
                }
                ?>
            </div>
        </div>
    </div>
</div>


<?php
require 'include/footer.php';
?>
</body>
</html>