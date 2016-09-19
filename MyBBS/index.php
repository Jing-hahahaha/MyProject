<?php
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

define('filename','index');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <?php
    require 'include/title.php';
    ?>
</head>
<body>

<?php
require 'include/header.php';
?>


<!--左边分类-->
<div id="left">
    <ul id="menu">
        <li value="社会"><span class="glyphicon glyphicon-star-empty"></span>社会</li>
        <li value="明星"><span class="glyphicon glyphicon-star-empty"></span>明星</li>
        <li value="科技"><span class="glyphicon glyphicon-star-empty"></span>科技</li>
        <li value="财经"><span class="glyphicon glyphicon-star-empty"></span>财经</li>
        <li value="汽车"><span class="glyphicon glyphicon-star-empty"></span>汽车</li>
        <li value="体育"><span class="glyphicon glyphicon-star-empty"></span>体育</li>
        <li value="情感"><span class="glyphicon glyphicon-star-empty"></span>情感</li>
        <li value="游戏"><span class="glyphicon glyphicon-star-empty"></span>游戏</li>
        <li value="动漫"><span class="glyphicon glyphicon-star-empty"></span>动漫</li>
    </ul>
</div>
<!--中间帖子部分-->
<div id="center">
    <div id="center_topic">
        <?php
        $sql="SELECT * FROM bbs_send ORDER BY bbs_send_time DESC";
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
    </div>
<!--    <div id="center_load"><img src="image/load.gif" style="width: 20px;height: 20px">&nbsp;&nbsp;加载更多</div>-->
</div>
<!--右边-->
<div style="float: right">
    <?php
    if(isset($_SESSION['username'])) {
        $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
        $result1=$con->query($sql1);
        if(!!$num1=$result1->num_rows){
            $row1=$result1->fetch_assoc();
        }

//        读取关注人数
        $sql="SELECT * FROM bbs_focus WHERE bbs_from_user_id='{$row1['bbs_id']}'";
        $result=$con->query($sql);
        $from_num=$result->num_rows;

//        读取粉丝人数
        $sql="SELECT * FROM bbs_focus WHERE bbs_to_user_id='{$row1['bbs_id']}'";
        $result=$con->query($sql);
        $to_num=$result->num_rows;

//        读取帖子数
        $sql="SELECT * FROM bbs_send WHERE bbs_user_id='{$row1['bbs_id']}'";
        $result=$con->query($sql);
        $send_num=$result->num_rows;

        echo "
        <div id='personal_introduce'>
            <div id='introduce_top'>
                <p><img id='introduce_face' src='{$row1['bbs_face']}'></p>
                 <span id='name'><a href='personal.php?personID={$row1['bbs_id']}'>{$_SESSION['username']}</a></span>&nbsp;&nbsp;
                 <span id='sex'>{$row1['bbs_sex']}</span>
                <div id='signature' title='{$row1['bbs_signature']}'>{$row1['bbs_signature']}</div>
            </div>
            <div id='introduce_bottom'>
                <div id='follow'><a href='personal.php?personID={$row1['bbs_id']}'>关注</a>&nbsp;{$from_num}</div>
                <div id='follower'><a href='personal.php?personID={$row1['bbs_id']}'>粉丝</a>&nbsp;{$to_num}</div>
                <div id='topic'><a href='personal.php?personID={$row1['bbs_id']}'>帖子</a>&nbsp;{$send_num}</div>
                <div style='clear:both;height:0;overflow:hidden;'></div>
            </div>
        </div>
    ";
    }
    ?>

    <!--右边推荐好友或个人中心-->
    <div id="right">
        <div id="right_top">
            <span>推荐好友</span>
<!--            <a id="refresh" href=""><span class="glyphicon glyphicon-refresh"></span>&nbsp;&nbsp;换一换</a>-->
        </div>
        <ul id="friend_list">
            <?php
            if(isset($_SESSION['username'])){
                $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
                $result1=$con->query($sql1);
                if(!!$num1=$result1->num_rows){
                    $row1=$result1->fetch_assoc();
                }

                $sql="SELECT * FROM bbs_user WHERE bbs_id !='{$row1['bbs_id']}' ORDER BY bbs_register_time LIMIT 0,6";
            }else{
                $sql="SELECT * FROM bbs_user ORDER BY bbs_register_time LIMIT 0,6";
            }
            $result=$con->query($sql);
            if(!!$num=$result->num_rows){
                for($i=0;$i<$num;$i++){
                    $row=$result->fetch_assoc();
                    echo "
                        <li>
                            <img class='face' src='{$row['bbs_face']}'>
                            <div class='friend'>
                                <span class='name'><a href='personal.php?personID={$row['bbs_id']}'>{$row['bbs_username']}</a></span>&nbsp;&nbsp;<span class='sex'>{$row['bbs_sex']}</span>
                                <div class='signature'>{$row['bbs_signature']}</div>
                            </div>
                        </li>
                    ";
                }
            }
            ?>
        </ul>
    </div>
</div>


<?php
require 'include/footer.php';
?>

</body>
</html>



