/**
 * Created by Jing on 2016-6-28.
 */
$(function () {
    //验证注册表单
    var ok1=false;
    var ok2=false;
    var ok3=false;

    //验证用户名
    $('#user_input').focus(function () {
        $('#tip_user').removeClass('glyphicon glyphicon-remove').html('用户名在2-20位之间');
    }).blur(function () {
        $.ajax({
            url:'Validate.php',
            type:'post',
            dataType:'json',
            data:{name:$(this).val()},
            success:function(data){
                if(data == '存在'){
                    $('#tip_user').removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove').html("该用户名已经注册");
                    ok1=false;
                }
            },
            error:function(){alert('ajax操作失败');}
        });
        if($.trim($(this).val()).length < 2 || $.trim($(this).val()).length > 20){
            $('#tip_user').addClass('glyphicon glyphicon-remove').html("用户名在2-20位之间");
        }else {
            $('#tip_user').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
            ok1=true;
        }
    });

    //验证密码
    $('#pwd_input').focus(function () {
        $('#tip_pwd').removeClass('glyphicon glyphicon-remove').html('密码在6-14位之间且不能有空格');
    }).blur(function () {
        var regNull=/\s/;
        if(regNull.test($(this).val())){
            $('#tip_pwd').addClass('glyphicon glyphicon-remove').html('密码不能有空格');
        }else if($(this).val().length < 6 || $(this).val().length > 14){
            $('#tip_pwd').addClass('glyphicon glyphicon-remove').html('密码在6-14位之间');
        }else{
            $('#tip_pwd').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
            ok2=true;
        }
    });

    //验证验证码
    $('#check_input').focus(function(){
        $('#tip_check').removeClass('glyphicon glyphicon-remove').html('请输入验证码');
    }).blur(function () {
        $.ajax({
            url:'Validate.php',
            type:'post',
            dataType:'json',
            data:{check:$(this).val()},
            success: function (data) {
                if(data == '验证码错误'){
                    $('#tip_check').addClass('glyphicon glyphicon-remove').html("验证码错误");
                }else{
                    $('#tip_check').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
                    ok3=true;
                }
            },
            error: function () {alert('ajax 验证码验证失败');}
        });
    });

    //提交按钮，所有验证通过方可提交
    $('#btn_sub').click(function(){
        if(ok1 && ok2 && ok3){
            $('#register_form').submit();
        }else{
            return false;
        }
    });



////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    //验证登录表单
    var ok4=false;
    var ok5=false;
    var ok6=false;

    //验证用户名
    $('#user_input_login').blur(function () {
        $.ajax({
            url:'Validate.php',
            dataType:'json',
            type:'post',
            data:{name:$(this).val()},
            success:function(data){
                if(data == '不存在'){
                    $('#tip_user_login').addClass('glyphicon glyphicon-remove').html("该用户名不存在，请先注册");
                }else{
                    $('#tip_user_login').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
                    ok4=true;
                }
            },
            error:function(){alert('ajax 操作失败');}
        });
    });

    //验证密码
    $('#pwd_input_login').blur(function () {
        $.ajax({
            url:'Validate.php',
            dataType:'json',
            type:'post',
            data:{name:$('#user_input_login').val(),password:$(this).val()},
            success:function(data){
                if(data == '不存在'){
                    $('#tip_pwd_login').addClass('glyphicon glyphicon-remove').html("用户名或密码错误");
                }else{
                    $('#tip_pwd_login').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
                    ok5=true;
                }
            },
            error:function(){alert('ajax 操作失败');}
        });
    });

    //验证验证码
    $('#check_input_login').blur(function () {
        $.ajax({
            url:'Validate.php',
            type:'post',
            dataType:'json',
            data:{check:$(this).val()},
            success: function (data) {
                if(data == '验证码错误'){
                    $('#tip_check_login').addClass('glyphicon glyphicon-remove').html("验证码错误");
                }else{
                    $('#tip_check_login').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
                    ok6=true;
                }
            },
            error: function () {alert('ajax 验证码验证失败');}
        });
    });

    //提交按钮，所有验证通过方可提交
    $('#btn_sub_login').click(function(){
        if(ok4 && ok5 && ok6){
            $('#login_form').submit();
        }else{
            return false;
        }
    });



    //导航条个人中心鼠标悬浮显示菜单
    $('#personal').mouseenter(function(){
        $('#personal_menu').show();
    });
    $('#personal').mouseleave(function(){
        $('#personal_menu').hide();
    });



    //表情写入多行文本区域
    $('.feeling_pic').click(function () {
        var str=$('#edit_textarea').val();

        /*var title='['+$(this).attr('title')+']';
         str += title;*/
        //$('#edit_textarea').val(str);

        var outerHTML=$(this).prop('outerHTML');
        str += outerHTML;
        $('#edit_textarea').val(str);
        //alert($('#edit_textarea').val());
    });



///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    //提交发布，验证标题、类型和内容是否为空
    $('#btn_sub_edit').click(function () {
        if(($.trim($('#edit_title').val()) == '') || ($.trim($('#edit_textarea').val()) == '') || ($('#select').val() == null)){
            $('#tip_article').addClass('glyphicon glyphicon-remove').html('标题、类型和内容不能为空');
        }
        else{
            $('#tip_article').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
            //alert($('#select').val());
            $('#edit_form').submit();
        }
    });


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    //返回顶部
    $('#return_top').click(function pageScroll() {
        window.scrollBy(0,-10);
        scrolldelay=setTimeout('pageScroll()',100);
    });

    $('#return_top').mouseenter(function(){
        $(this).css('background-image','url(image/top2.png)');
    });

    $('#return_top').mouseleave(function(){
        $(this).css('background-image','url(image/top1.png)');
    });





});