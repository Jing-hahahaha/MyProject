<?php
//防止直接访问  $_SERVER['HTTP_REFERER']获取前一个页面的URL
if($_SERVER['HTTP_REFERER'] == ''){
    header('location:index.php');
}

//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);

require 'include/MyDB.php';

define('filename','admin');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>管理中心</title>
    <?php
    require 'include/title.php';
    ?>
</head>
<body>

<?php
require 'include/header.php';
?>

<div id="container">
    <ul id="admin_menu" class="nav nav-tabs">
        <li id="user_li" class="active"><a href="#user_admin" data-toggle="tab">用户管理</a></li>
        <li id="article_li"><a href="#article_admin" data-toggle="tab">帖子管理</a></li>
    </ul>

    <div id="admin_content" class="tab-content">
        <!--用户管理-->
        <div class="tab-pane fade in active" id="user_admin">
            <form class="form-horizontal" role="form" action="" method="post">
                <div class="form-group">
                    <div class="col-sm-6">
                        <input id="search_user" type="text" class="form-control" name="search_user" placeholder="请输入用户名">
                    </div>
                    <div class="col-sm-2">
                        <button id="search_user_btn" type="button" class="btn btn-primary">搜索</button>
                    </div>
                </div>
            </form>
            <div class="admin_box">
                <form id="user_form" action="admin_operate.php" method="post">
                    <table id="user_table">
                        <tr>
                            <th style='width: 20px'>&nbsp;</th>
                            <th style='width: 40px'>序号</th>
                            <th style='width: 150px'>用户名</th>
                            <th style='width: 140px'>密码</th>
                            <th style='width: 40px'>性别</th>
                            <th style='width: 140px'>头像</th>
                            <th style='width: 150px'>个性签名</th>
                            <th style="width: 140px">注册时间</th>
                        </tr>
                    </table>
                    <div class="admin_bottom" id="user_bottom">
                        <div class="admin_bottom_left">
                            <label><input type="checkbox" id="all_user_delete" name="user_check[]" value="all">全选</label>
                            <button id="user_del" type="button" class="btn btn-danger">删除</button>
                            <button id="user_add" type="button" class="btn btn-success" data-toggle="modal" data-target="#useraddModal">新增</button>
                            <button id="user_edit" type="button" class="btn btn-warning" data-target="#usereditModal">编辑</button>
                        </div>
                        <div class="admin_bottom_right" id="user_page">
                            <ol class="pagination"></ol>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </form>
            </div>
        </div>

        <!--帖子管理-->
        <div class="tab-pane fade" id="article_admin">
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="search_article" placeholder="请输入帖子标题">
                    </div>
                    <div class="col-sm-2">
                        <button id="search_article_btn" type="button" class="btn btn-primary">搜索</button>
                    </div>
                </div>
            </form>
            <div class="admin_box">
                <form id="article_form" action="admin_operate.php" method="post">
                    <table id="article_table">
                        <tr>
                            <th style='width: 20px'>&nbsp;</th>
                            <th style='width: 40px'>序号</th>
                            <th style='width: 150px'>帖子标题</th>
                            <th style='width: 200px'>帖子内容</th>
                            <th style='width: 100px'>发帖人</th>
                            <th style='width: 140px'>发帖时间</th>
                            <th style='width: 60px'>阅读量</th>
                            <th style='width: 100px'>帖子类型</th>
                        </tr>
                    </table>
                    <div class="admin_bottom">
                        <div class="admin_bottom_left">
                            <label><input type="checkbox" id="all_article_delete" name="article_check[]" value="all">全选</label>
                            <button id="article_del" type="button" class="btn btn-danger">删除</button>
                            <button id="article_add" type="button" class="btn btn-success" data-toggle="modal" data-target="#articleaddModal">新增</button>
                            <button id="article_edit" type="button" class="btn btn-warning" data-target="#articleeditModal">编辑</button>
                        </div>
                        <div class="admin_bottom_right" id="article_page">
                            <ol class="pagination"></ol>
                        </div>
                        <div style="clear: both"></div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>


<!--模态框-->

<!--用户新增-->
<div class="modal fade" id="useraddModal" tabindex="-1" role="dialog" aria-labelledby="useraddModalLabel" aria-hidden="true" style="width: auto">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 700px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="useraddModalLabel">
                    用户新增
                </h4>
            </div>
            <div class="modal-body">
                <form id="basic_form" action="admin_operate.php" method="post" class="form-horizontal" role="form">
                    <div class='form-group'>
                        <label for='modify_name' class='col-sm-3 control-label'>用户名：</label>
                        <div class='col-sm-5'>
                            <input id='modify_name' type='text' class='form-control' name='modify_name'>
                        </div>
                        <div class='col-sm-4'>
                            <span id='tip_modify_user'></span>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='modify_pwd' class='col-sm-3 control-label'>密码：</label>
                        <div class='col-sm-5'>
                            <input id='modify_pwd' type='password' class='form-control' name='modify_pwd'>
                        </div>
                        <div class='col-sm-4'>
                            <span id='tip_modify_pwd'></span>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label class='col-sm-3 control-label'>性别：</label>
                        <div class='col-sm-5'>
                            <div class='radio'>
                                <label><input type='radio' name='modify_sex' value='男' checked>男</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input type='radio' name='modify_sex' value='女'>女</label>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='modify_signature' class='col-sm-3 control-label'>个性签名：</label>
                        <div class='col-sm-5'>
                            <input id='modify_signature' type='text' class='form-control' name='modify_signature'>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button id="modify_btn" type="button" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--用户编辑-->
<div class="modal fade" id="usereditModal" tabindex="-1" role="dialog" aria-labelledby="usereditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="width: 700px">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="usereditModalLabel">
                    用户编辑
                </h4>
            </div>
            <div class="modal-body">
                <form id="user_edit_form" action="admin_operate.php" method="post" class="form-horizontal">
                    <input id="user_id" type="hidden" name="user_id">
                    <div class='form-group'>
                        <label for='edit_name' class='col-sm-3 control-label'>用户名：</label>
                        <div class='col-sm-5'>
                            <input id='edit_name' type='text' class='form-control' name='edit_name'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='modify_pwd' class='col-sm-3 control-label'>密码：</label>
                        <div class='col-sm-5'>
                            <input id='edit_pwd' type='password' class='form-control' name='edit_pwd'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label class='col-sm-3 control-label'>性别：</label>
                        <div class='col-sm-5'>
                            <div class='radio'>
                                <label><input type='radio' name='edit_sex' value='男' checked>男</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                <label><input type='radio' name='edit_sex' value='女'>女</label>
                            </div>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='edit_face' class='col-sm-3 control-label'>头像：</label>
                        <div class='col-sm-5'>
                            <input id='edit_face' type="text" class='form-control' name='edit_face'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='edit_signature' class='col-sm-3 control-label'>个性签名：</label>
                        <div class='col-sm-5'>
                            <input id='edit_signature' type='text' class='form-control' name='edit_signature'>
                        </div>
                    </div>
                    <div class='form-group'>
                        <label for='edit_register_time' class='col-sm-3 control-label'>注册时间：</label>
                        <div class='col-sm-5'>
                            <input id='edit_register_time' type='text' class='form-control' name='edit_register_time' value=''>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button id="user_edit_btn" type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
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





<!--帖子新增-->
<div class="modal fade" id="articleaddModal" tabindex="-1" role="dialog" aria-labelledby="articleaddModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="articleaddModalLabel">
                    帖子新增
                </h4>
            </div>
            <div class="modal-body">
                <form action="admin_operate.php" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="insert_user" class="col-sm-2 control-label">发布人：</label>
                        <div class="col-sm-8">
                            <input id="insert_user" type="text" name="insert_user" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="insert_title" class="col-sm-2 control-label">标题：</label>
                        <div class="col-sm-8">
                            <input id="insert_title" type="text" name="title" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型：</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="insert_select" name="select" size="6">
                                <option value="社会">社会</option>
                                <option value="明星">明星</option>
                                <option value="科技">科技</option>
                                <option value="财经">财经</option>
                                <option value="汽车">汽车</option>
                                <option value="体育">体育</option>
                                <option value="情感">情感</option>
                                <option value="游戏">游戏</option>
                                <option value="动漫">动漫</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-8">
                            <textarea id="insert_textarea" name="textarea" class="form-control"></textarea>
                        </div>
                    </div>
                    <div id="insert_addition">
                        <a href="#insert_smile" data-toggle="modal" style="font-size: 30px">☺</a>
                        <a href="#insert_picture" class="glyphicon glyphicon-picture" data-toggle="modal"></a>
                        <a href="#insert_music" class="glyphicon glyphicon-music" data-toggle="modal"></a>
                        <a href="#insert_video" class="glyphicon glyphicon-facetime-video" data-toggle="modal"></a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">发布</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--表情，图片，音频，视频选择-->
<!--表情包选择-->
<div id="insert_smile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 455px;position: absolute;top:260px;left: 390px">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#default" data-toggle="tab">默认</a></li>
                    <li><a href="#white" data-toggle="tab">小白</a></li>
                    <li><a href="#hamu" data-toggle="tab">哈姆太郎</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="default">
                        <ul>
                            <?php
                            foreach(range(0,38) as $num){
                                echo "<li><img class='feeling_pic' src='image/feelings/default/$num.gif' alt='默认$num' title='默认$num'></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="white">
                        <ul>
                            <?php
                            foreach(range(0,14) as $num){
                                echo "<li><img class='feeling_pic' src='image/feelings/white/$num.gif' alt='小白$num' title='小白$num'></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="tab-pane fade" id="hamu">
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


<!--图片选择-->
<div id="insert_picture" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 455px;position: absolute;top:260px;left: 440px">
        <div class="modal-content">
            <div class="modal-body">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#local_pic" data-toggle="tab">本地图片</a></li>
                    <li><a href="#online_pic" data-toggle="tab">在线图片</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="local_pic">
                        111
                    </div>
                    <div class="tab-pane fade" id="online_pic">
                        222
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--音频选择-->
<div id="insert_music" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 455px;position: absolute;top:260px;left: 490px">
        <div class="modal-content">
            <div class="modal-body">
                <input type="url" style="width: 300px">
                <button type="button" class="btn btn-primary">插入音乐</button>
            </div>
        </div>
    </div>
</div>


<!--视频选择-->
<div id="insert_video" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 455px;position: absolute;top:260px;left: 540px">
        <div class="modal-content">
            <div class="modal-body">
                <input type="url" style="width: 300px">
                <button type="button" class="btn btn-primary">插入视频</button>
            </div>
        </div>
    </div>
</div>





<!--帖子编辑-->
<div class="modal fade" id="articleeditModal" tabindex="-1" role="dialog" aria-labelledby="articleeditModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="articleeditModalLabel">
                    帖子编辑
                </h4>
            </div>
            <div class="modal-body">
                <form action="admin_operate.php" method="post" class="form-horizontal" role="form">
                    <input id="edit_article_id" type="hidden" name="edit_article_id">
                    <div class="form-group">
                        <label for="edit_article_user" class="col-sm-3 control-label">发布人：</label>
                        <div class="col-sm-8">
                            <input id="edit_article_user" type="text" name="edit_article_user" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">类型：</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="edit_select" name="edit_select" size="6">
                                <option value="社会">社会</option>
                                <option value="明星">明星</option>
                                <option value="科技">科技</option>
                                <option value="财经">财经</option>
                                <option value="汽车">汽车</option>
                                <option value="体育">体育</option>
                                <option value="情感">情感</option>
                                <option value="游戏">游戏</option>
                                <option value="动漫">动漫</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_read_count" class="col-sm-3 control-label">阅读量：</label>
                        <div class="col-sm-8">
                            <input id="edit_read_count" type="text" name="edit_read_count" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_send_time" class="col-sm-3 control-label">发帖时间：</label>
                        <div class="col-sm-8">
                            <input id="edit_send_time" type="text" name="edit_send_time" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-primary">保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>





</body>
</html>
