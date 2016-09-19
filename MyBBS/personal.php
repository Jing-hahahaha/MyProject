<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-14
 * Time: 11:56
 */

//防止直接访问  $_SERVER['HTTP_REFERER']获取前一个页面的URL
if($_SERVER['HTTP_REFERER'] == ''){
    header('location:index.php');
}

//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

define('filename','personal');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人中心</title>
    <?php
    require 'include/title.php';
    ?>
</head>
<body>

<?php
require 'include/header.php';
?>


<!--主体部分-->
<div id="container">
<!--    顶部-->
    <div id="top">
        <?php
        $sql="SELECT * FROM bbs_user WHERE bbs_id={$_GET['personID']}";
        $result=$con->query($sql);
        if(!!$num=$result->num_rows){
            $row=$result->fetch_assoc();

            echo "
                <div id='face'>
                    <img src='{$row['bbs_face']}'>
                </div>
                <div>
                    <span id='username'>{$row['bbs_username']}</span>&nbsp;&nbsp;<span id='sex'>{$row['bbs_sex']}</span>
                    <div id='signature'>{$row['bbs_signature']}</div>
                </div>
            ";
        }
        ?>

        <?php
        //
        $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
        $result1=$con->query($sql1);
        if(!!$num1=$result1->num_rows){
            $row1=$result1->fetch_assoc();
        }

        if($row1['bbs_id'] != $_GET['personID']){
//            判断用户关注状态
            $sql="SELECT * FROM bbs_focus WHERE bbs_from_user_id={$row1['bbs_id']} AND bbs_to_user_id={$_GET['personID']}";
            $result=$con->query($sql);
            if(!!$num=$result->num_rows) {  //存在关注
                echo "
                    <div style='margin-top: 20px'>
                        <button id='focus' class='btn btn-warning' name='{$row1['bbs_id']}' value='{$_GET['personID']}' status='1'>取消关注</button>
                        <button id='message' class='btn btn-warning' data-toggle='modal'>私信</button>
                    </div>";
            }else {
                if(isset($_SESSION['username'])){  //已登录，按钮可用
                    echo "
                    <div style='margin-top: 20px'>
                        <button id='focus' class='btn btn-warning' name='{$row1['bbs_id']}' value='{$_GET['personID']}' status='0'>关注</button>
                        <button id='message' class='btn btn-warning'>私信</button>
                    </div>
                ";
                }else{   //未登录，按钮不可用
                    echo "
                    <div style='margin-top: 20px'>
                        <button id='focus' class='btn btn-warning' name='{$row1['bbs_id']}' value='{$_GET['personID']}' status='0' disabled>关注</button>
                        <button id='message' class='btn btn-warning' disabled>私信</button>
                    </div>
                ";
                }
            }
        }
        ?>
    </div>
<!--    导航菜单-->
    <div style="text-align: center;height: 42px;border-bottom: 1px solid #ccc;">
        <ul id="menu" class="nav nav-tabs">
            <li class="active"><a href="#all" data-toggle="tab">帖子</a></li>
            <?php
            //
            $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
            $result1=$con->query($sql1);
            if(!!$num1=$result1->num_rows){
                $row1=$result1->fetch_assoc();
            }

            if($row1['bbs_id'] == $_GET['personID']){
                echo "<li><a href='#myedit' data-toggle='tab'>账号设置</a></li>";
                echo "<li><a href='#reply' data-toggle='tab'>我回复的</a></li>";
                echo "<li><a href='#message_content' data-toggle='tab'>查看私信</a></li>";
            }
            ?>
            <li><a href='#following' data-toggle='tab'>关注</a></li>
            <li><a href='#followed' data-toggle='tab'>粉丝</a></li>
        </ul>
    </div>

<!--    内容-->
    <div id="content_left" class="tab-content">

<!--        全部帖子-->
        <div class="tab-pane fade in active" id="all">
            <!--            从发帖表里读取用户全部帖子-->
            <?php
            $sql="SELECT * FROM bbs_send WHERE bbs_user_id={$_GET['personID']} ORDER BY bbs_send_time DESC";
            $result=$con->query($sql);
            if(!!$num=$result->num_rows){
                echo "<div class='article_num'>帖子{$num}条</div>";
                for($i=0;$i<$num;$i++){
                    $row=$result->fetch_assoc();
                    echo "
                        <div class='content_article'>
                            <div class='article_title'>
                                <a href='detailed.php?topicID={$row['bbs_id']}' target='_blank'>{$row['bbs_title']}</a>&nbsp;&nbsp;
                        ";
            ?>
                        <?php
                        $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
                        $result1=$con->query($sql1);
                        if(!!$num1=$result1->num_rows){
                            $row1=$result1->fetch_assoc();
                        }

                        if($row1['bbs_id'] == $_GET['personID']){
                            echo "
                                <select class='article_operate' style='float: right' index='{$row['bbs_id']}'>
                                    <option value='0'>更多</option>
                                    <option value='1'>删除</option>
                                    <option value='2'>置顶</option>
                                </select>
                            ";
                        }
                        ?>
                        <?php
                        echo "
                            </div>
                                <pre class='article_content'>{$row['bbs_send_content']}</pre>
                                <div class='article_time'>{$row['bbs_send_time']}</div>
                            </div>
                        ";
                }
            }else{
                echo "暂无内容";
            }
            ?>
        </div>

<!--        账号设置-->
        <div class="tab-pane fade" id="myedit">
            <div id="basic_introduce">基本资料</div>
            <form action="modify.php" method="post" id="basic_form" class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <?php
                        $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
                        $result1=$con->query($sql1);
                        if(!!$num1=$result1->num_rows){
                            $row1=$result1->fetch_assoc();
                        }

                        $sql="SELECT * FROM bbs_user WHERE bbs_id={$row1['bbs_id']}";
                        $result=$con->query($sql);
                        if(!!$num=$result->num_rows){
                            $row=$result->fetch_assoc();
                            echo "
                        <img src='{$row['bbs_face']}' id='myface' title='点击更换头像'>
                        <input id='modify_face' name='modify_face' type='hidden' value='{$row['bbs_face']}'>
                    </div>
                </div>
                <div class='form-group'>
                    <input type='hidden' name='user_id' value='{$row1['bbs_id']}'>
                    <label for='modify_name' class='col-sm-2 control-label'>用户名：</label>
                    <div class='col-sm-6'>
                        <input id='modify_name' type='text' class='form-control' name='modify_name' value='{$row['bbs_username']}'>
                    </div>
                    <div class='col-sm-3'>
                        <span id='tip_modify_user'></span>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='modify_pwd' class='col-sm-2 control-label'>密码：</label>
                    <div class='col-sm-6'>
                        <input id='modify_pwd' type='password' class='form-control' name='modify_pwd' value='{$row['bbs_password']}'>
                    </div>
                    <div class='col-sm-3'>
                        <span id='tip_modify_pwd'></span>
                    </div>
                </div>
                <div class='form-group'>
                    <label class='col-sm-2 control-label'>性别：</label>
                    <div class='col-sm-6'>
                        <div class='radio'>
                            <label><input type='radio' name='modify_sex' value='男' checked>男</label>&nbsp;&nbsp;&nbsp;&nbsp;
                            <label><input type='radio' name='modify_sex' value='女'>女</label>
                        </div>
                    </div>
                </div>
                <div class='form-group'>
                    <label for='modify_signature' class='col-sm-2 control-label'>个性签名：</label>
                    <div class='col-sm-6'>
                        <input id='modify_signature' type='text' class='form-control' name='modify_signature' value='{$row['bbs_signature']}'>
                    </div>
                </div>
                            ";
                        }
                        ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button id="modify_btn" type="button" class="btn btn-primary">保存</button>
                    </div>
                </div>
            </form>
        </div>

<!--        我的回复-->
        <div class="tab-pane fade" id="reply">
            <?php
            $sql="SELECT * FROM bbs_respond WHERE bbs_from_user_id={$_GET['personID']} ORDER BY bbs_respond_time DESC";
            $result=$con->query($sql);
            if(!!$num=$result->num_rows){
                echo "<div id='reply_num'>回复{$num}条</div>";
                for($i=0;$i<$num;$i++){
                    $row=$result->fetch_assoc();

                    $sql2="SELECT * FROM bbs_send WHERE bbs_id={$row['bbs_article_id']}";
                    $result2=$con->query($sql2);
                    if(!!$num2=$result2->num_rows){
                        $row2=$result2->fetch_assoc();

                        echo "
                            <div class='reply_list'>
                                <div class='reply_top'><span>{$row['bbs_respond_time']}</span>&nbsp;&nbsp;回复<a href='' class='delete' index='{$row['bbs_id']}'>删除</a></div>
                                <div class='my_content'>{$row['bbs_respond_content']}</div>
                                <div class='topic_title'>帖子：<a href='detailed.php?topicID={$row['bbs_article_id']}' target='_blank'>{$row2['bbs_title']}</a></div>
                            </div>
                        ";
                    }
                }
            }else{
                echo "暂无内容";
            }
            ?>
        </div>

<!--        查看私信-->
        <div class="tab-pane fade" id="message_content">
        <?php
            //                读取收信
            $sql="SELECT * FROM bbs_message WHERE bbs_to_user_id={$row1['bbs_id']} ORDER BY bbs_message_time DESC";
            $result=$con->query($sql);
            if(!!$num=$result->num_rows) {
                echo "
                <div id='message_num'>私信{$num}条</div>
                <div id='message_box'>
                    <form action='message.php' method='post'>
                        <table>
                            <tr>
                                <th style='width: 60px'>&nbsp;</th>
                                <th style='width: 60px'>序号</th>
                                <th style='width: 450px'>内容</th>
                                <th style='width: 50px'>状态</th>
                                <th style='width: 140px'>发信人</th>
                                <th style='width: 140px'>发信时间</th>
                            </tr>
                ";
                for ($i = 1; $i <= $num; $i++) {
                    $row = $result->fetch_assoc();

                    $sql2 = "SELECT * FROM bbs_user WHERE bbs_id={$row['bbs_from_user_id']}";
                    $result2 = $con->query($sql2);
                    if (!!$num2 = $result2->num_rows) {
                        $row2 = $result2->fetch_assoc();
                    }
                    echo "
                       <tr>
                            <td style='width: 60px'><input type='checkbox' name='check[]' value='{$row['bbs_id']}'></td>
                            <td style='width: 60px'>$i</td>
                            <td style='width: 450px'><a class='showLetter' href='#show_message_content' data-toggle='modal' value='{$row['bbs_id']}'>{$row['bbs_message_content']}</a></td>
                            <td style='width: 50px'>{$row['bbs_state']}</td>
                            <td style='width: 140px'><a href='personal.php?personID={$row['bbs_from_user_id']}' target='_blank'>{$row2['bbs_username']}</a></td>
                            <td style='width: 140px'>{$row['bbs_message_time']}</td>
                        </tr>
                        ";
                }
                echo "
                    </table>
                    <div style='margin-top: 20px;margin-left: 33px'>
                        <label><input id='all_delete' type='checkbox' name='check[]' value='all'>全选</label>
                        <button class='btn btn-primary' type='submit' style='margin-left: 50px'>删除</button>
                    </div>
                </form>
            </div>
           ";
            }else{
                echo "暂无内容";
            }
        ?>
        </div>

<!--        关注-->
        <div class="tab-pane fade" id="following">
        <?php
        $sql="SELECT * FROM bbs_focus WHERE bbs_from_user_id='{$_GET['personID']}'";
        $result=$con->query($sql);
        if(!!$num=$result->num_rows) {
            echo "
            <div id='following_num'>关注{$num}人</div>
            <div id='following_list'>
                <ol>
            ";
            for ($i = 0; $i < $num; $i++) {
                $row = $result->fetch_assoc();

                $sql2 = "SELECT * FROM bbs_user WHERE bbs_id={$row['bbs_to_user_id']}";
                $result2 = $con->query($sql2);
                if (!!$num2 = $result2->num_rows) {
                    $row2 = $result2->fetch_assoc();
                }
                echo "
                <li>
                    <div><img class='following_face' src='{$row2['bbs_face']}'></div>
                    <div style='margin-top: 10px'><span><a href='personal.php?personID={$row2['bbs_id']}'>{$row2['bbs_username']}</a></span>&nbsp;&nbsp;<span>{$row2['bbs_sex']}</span></div>
                </li>
                ";
            }
            echo "
            </ol >
            </div >
            ";
        }else{
            echo "暂无内容";
        }
        ?>
        </div>

<!--        粉丝-->
        <div class="tab-pane fade" id="followed">
        <?php
        $sql="SELECT * FROM bbs_focus WHERE bbs_to_user_id='{$_GET['personID']}'";
        $result=$con->query($sql);
        if(!!$num=$result->num_rows){
            echo "
            <div id='followed_num'>粉丝{$num}人</div>
            <div id='followed_list'>
                <ol>
            ";
            for($i=0;$i<$num;$i++){
                $row=$result->fetch_assoc();

                $sql2="SELECT * FROM bbs_user WHERE bbs_id={$row['bbs_from_user_id']}";
                $result2=$con->query($sql2);
                if(!!$num2=$result2->num_rows){
                    $row2=$result2->fetch_assoc();
                }
                echo "
                <li>
                    <div><img class='followed_face' src='{$row2['bbs_face']}'></div>
                    <div style='margin-top: 10px'><span><a href='personal.php?personID={$row2['bbs_id']}'>{$row2['bbs_username']}</a></span>&nbsp;&nbsp;<span>{$row2['bbs_sex']}</span></div>
                </li>
                ";
            }
            echo "
                </ol>
            </div>
                ";
        }else{
            echo "暂无内容";
        }
        ?>
        </div>
    </div>
</div>



<!--模态框-->
<!--编辑私信-->
<div class="modal fade" id="edit_message" tabindex="-1" role="dialog" aria-labelledby="messageLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="messageLabel">编辑私信</h4>
            </div>
            <div class="modal-body">
                <form id="message_form" action="message.php" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <div class="col-sm-8">
                            <input type="hidden" name="fromID" value='
                            <?php
                            $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
                            $result1=$con->query($sql1);
                            if(!!$num1=$result1->num_rows){
                                $row1=$result1->fetch_assoc();
                            }

                            echo $row1['bbs_id']?>'>
                            <input type="hidden" name="toID" value='<?php echo $_GET['personID']?>'>
                            <textarea id="message_textarea" name="textarea" class="form-control"></textarea>
                        </div>
                    </div>
                    <div id="message_addition">
                        <a href="#message_smile" data-toggle="modal" style="font-size: 30px">☺</a>
                    </div>
                    <div style="height: 40px;line-height: 40px">
                        <span id="tip_message">&nbsp;</span>
                        <div style="display: inline-block;float: right">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 20px">取消</button>
                            <button id="btn_sub_message" type="button" class="btn btn-primary">发送</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!--表情包选择-->
<div id="message_smile" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 455px;position: absolute;top:260px;left: 390px">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#message_default" data-toggle="tab">默认</a></li>
                    <li><a href="#message_white" data-toggle="tab">小白</a></li>
                    <li><a href="#message_hamu" data-toggle="tab">哈姆太郎</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="message_default">
                        <ul>
                            <?php
                            foreach(range(0,38) as $num){
                                echo "<li><img class='feeling_pic' src='image/feelings/default/$num.gif' alt='默认$num' title='默认$num'></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="message_white">
                        <ul>
                            <?php
                            foreach(range(0,14) as $num){
                                echo "<li><img class='feeling_pic' src='image/feelings/white/$num.gif' alt='小白$num' title='小白$num'></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="message_hamu">
                        <ul>
                            <?php
                            foreach(range(0,17) as $num){
                                echo "<li><img class='feeling_pic' src='image/feelings/hamu/$num.gif' alt='哈姆太郎$num' title='哈姆太郎$num'></li>";
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!--模态框-->
<!--显示私信内容-->
<div class="modal fade" id="show_message_content" tabindex="-1" role="dialog" aria-labelledby="letterLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="letterLabel">私信详情</h4>
            </div>
            <div class="modal-body">
                <div id="letter_container"></div>
            </div>
        </div>
    </div>
</div>

<!--头像模态框-->
<div class="modal fade" id="faceModal" tabindex="-1" role="dialog" aria-labelledby="faceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="faceModalLabel">
                    选择头像
                </h4>
            </div>
            <div class="modal-body">
                <div id="face_cantainer">
                    <ul>
                        <?php
                        foreach (range(1,10) as $num) {
                            echo "
                            <li><img src='image/faces/{$num}.jpg' alt='头像' title='头像{$num}' /></li>
                            ";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
require 'include/footer.php';
?>

</body>
</html>
