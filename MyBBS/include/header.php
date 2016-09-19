<?php
//防止恶意调用
if (!defined('IN_BBS')) {
    exit('Access Defined!');
}
?>


<!--导航条-->
<nav class="navbar navbar-default navbar-fixed-top" style="background: #FFFFFF;height: 55px;border-top: 3px solid orange">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <img alt="在线论坛系统" src="image/logo.jpg">
        </a>
        <form class="navbar-form navbar-left" role="search" action="#" method="post">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default glyphicon glyphicon-search"></button>
        </form>
        <?php
        if(isset($_SESSION['username'])){

            $sql1="SELECT * FROM bbs_user WHERE bbs_username='{$_SESSION['username']}'";
            $result1=$con->query($sql1);
            if(!!$num1=$result1->num_rows){
                $row1=$result1->fetch_assoc();
            }

            echo "
                     <a href='index.php' class='navbar-link navbar-text' style='color:black;font-size: 16px;margin-left: 60px;margin-right: 60px'><span class='glyphicon glyphicon-home'></span>&nbsp;首页</a>
                     <ul class='navbar-text' style='list-style: none;display: inline-block;padding: 0;position: absolute'>
                        <li id='personal'>
                            <a class='navbar-link' href='personal.php?personID={$row1['bbs_id']}' style='display: inline-block;color:black;font-size: 16px'>
                                <span class='glyphicon glyphicon-user'></span>&nbsp;{$_SESSION['username']}
                            </a>
                            <ul id='personal_menu'>
                                <li><a href='personal.php?personID={$row1['bbs_id']}' class='navbar-link'>账号设置</a></li>
                                <li><a href='personal.php?personID={$row1['bbs_id']}' class='navbar-link'>查看私信</a></li>
                                <li><a href='exit.php' class='navbar-link'>退出</a></li>
                            </ul>
                        </li>
                     </ul>";
            if($row1['bbs_identity'] == 1){
                echo "
                    <a href='admin.php' class='navbar-link navbar-text' style='color:black;font-size: 16px;margin-left: 140px'><span class='glyphicon glyphicon-cog'></span>&nbsp;管理中心</a>
                ";
            }
            echo "<a href='#edit' class='navbar-link navbar-text navbar-right' data-toggle='modal' style='background: #fa7d3c;padding: 3px'>
                    <span class='glyphicon glyphicon-edit' style='font-size:18px;color: white'></span>
                  </a>";
        }else{
            echo "<p class='navbar-text navbar-right'>";
            echo '<a class="navbar-link" href="#register" data-toggle="modal">注册</a>';
            echo '<span>|</span>';
            echo '<a class="navbar-link" href="#login" data-toggle="modal">登录</a>';
            echo "</p>";
        }
        ?>
    </div>
</nav>


<!--模态框-->
<!--注册-->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="registerLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="registerLabel">新用户注册账号</h4>
            </div>
            <div class="modal-body">
                <form id="register_form" class="bs-example bs-example-form" role="form" action="register.php" method="post">
                    <div id="user" class="input-group col-lg-12">
                        <div class="input-group col-lg-7" style="float: left">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="user_input" type="text" class="form-control" name="username" placeholder="用户名用于登录">
                        </div>
                        <span id="tip_user">&nbsp;</span>
                    </div><br />
                    <div id="pwd" class="input-group col-lg-12">
                        <div class="input-group col-lg-7" style="float: left">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="pwd_input" type="password" class="form-control" name="password" placeholder="密码">
                        </div>
                        <span id="tip_pwd">&nbsp;</span>
                    </div><br />
                    <div class="input-group col-lg-12">
                        <div class="input-group col-lg-7" style="float: left">
                            <span class="input-group-addon"><img src="image/sex.jpg" style="display: inline-block;width: 14px;height: 20px"></span>
                            <select class="form-control" name="sex">
                                <option value="男">男</option><option value="女">女</option>
                            </select>
                        </div>
                    </div><br />
                    <div id="check_code" class="input-group col-lg-12">
                        <div class="input-group col-lg-5" style="float: left">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-check"></i></span>
                            <input id="check_input" type="text" class="form-control" name="check" placeholder="验证码">
                        </div>
                        <img style="float: left;margin-left: 20px" src="code.php" onclick="javascript:this.src='code.php?tm='+Math.random();">
                        <span id="tip_check">&nbsp;</span>
                    </div>
                    <div class="input-group" style="clear: both;padding-top: 20px">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left: 420px">取消</button>
                        <button id="btn_sub" type="submit" class="btn btn-primary" style="margin-left: 30px">注册</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!--登录-->
<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="loginLabel">用户登录</h4>
            </div>
            <div class="modal-body">
                <form id="login_form" class="bs-example bs-example-form" role="form" action="login.php" method="post">
                    <div id="user_login" class="input-group col-lg-12">
                        <div class="input-group col-lg-7" style="float: left">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                            <input id="user_input_login" type="text" class="form-control" name="username" placeholder="请输入用户名">
                        </div>
                        <span id="tip_user_login">&nbsp;</span>
                    </div><br />
                    <div id="pwd_login" class="input-group col-lg-12">
                        <div class="input-group col-lg-7" style="float: left">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                            <input id="pwd_input_login" type="password" class="form-control" name="password" placeholder="请输入密码">
                        </div>
                        <span id="tip_pwd_login">&nbsp;</span>
                    </div><br />
                    <div id="check_code_login" class="input-group col-lg-12">
                        <div class="input-group col-lg-5" style="float: left">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-check"></i></span>
                            <input id="check_input_login" type="text" class="form-control" name="check" placeholder="请输入验证码">
                        </div>
                        <img style="float: left;margin-left: 20px" src="code.php" onclick="javascript:this.src='code.php?tm='+Math.random();">
                        <span id="tip_check_login">&nbsp;</span>
                    </div>
                    <div class="input-group" style="clear: both;padding-top: 20px">
                        <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-left: 420px">取消</button>
                        <button id="btn_sub_login" type="submit" class="btn btn-primary" style="margin-left: 30px">登录</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--编辑发帖-->
<div id="edit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="editLabel">发帖</h4>
            </div>
            <div class="modal-body">
                <form id="edit_form" action="article.php" method="post" class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="edit_title" class="col-sm-2 control-label">标题：</label>
                        <div class="col-sm-8">
                            <input id="edit_title" type="text" name="title" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">类型：</label>
                        <div class="col-sm-8">
                            <select class="form-control" id="select" name="select" size="6">
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
                            <textarea id="edit_textarea" name="textarea" class="form-control"></textarea>
                        </div>
                    </div>
                    <div id="addition">
                        <a href="#smile" data-toggle="modal" style="font-size: 30px">☺</a>
                        <a href="#picture" class="glyphicon glyphicon-picture" data-toggle="modal"></a>
                        <a href="#music" class="glyphicon glyphicon-music" data-toggle="modal"></a>
                        <a href="#video" class="glyphicon glyphicon-facetime-video" data-toggle="modal"></a>
                    </div>
                    <div style="height: 40px;line-height: 40px">
                        <span id="tip_article">&nbsp;</span>
                        <div style="display: inline-block;float: right">
                            <button type="button" class="btn btn-default" data-dismiss="modal" style="margin-right: 20px">取消</button>
                            <button id="btn_sub_edit" type="button" class="btn btn-primary">发布</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!--表情，图片，音频，视频选择-->
<!--表情包选择-->
<div id="smile" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
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
<div id="picture" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
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
<div id="music" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
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
<div id="video" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 455px;position: absolute;top:260px;left: 540px">
        <div class="modal-content">
            <div class="modal-body">
                <input type="url" style="width: 300px">
                <button type="button" class="btn btn-primary">插入视频</button>
            </div>
        </div>
    </div>
</div>