/**
 * Created by Jing on 2016-6-27.
 */
$(function(){
    //修改关注状态
    $('#focus').click(function () {
        //alert($(this).attr('status'));
        if($(this).html() == '关注'){
            $(this).html('取消关注').attr('status','1');
        }else{
            $(this).html('关注').attr('status','0');
        }
        $.ajax({
            url:'focus.php',
            type:'post',
            data:{state:$(this).attr('status'),fromID:$(this).attr('name'),toID:$(this).attr('value')},
            dataType:'json',
            success: function (data) {
                if(data == 'success'){
                    //alert('关注成功');
                }else if(data == 'fault'){
                    //alert('取消成功');
                }
            },
            error:function(){alert('执行失败');}
        });
    });




    //点击私信按钮弹出编辑私信模态框
    $('#message').click(function () {
        $('#edit_message').modal();
    });


    //帖子删除、置顶操作
    $('.article_operate').change(function(){
        /*alert($(this).attr('index'));
        alert($('.article_operate option:selected').val());*/
        $.ajax({
            url:'article.php',
            type:'post',
            data:{id:$(this).attr('index'),operate:$(this).val()},
            dataType:'json',
            success:function(data){
                alert(data);
                window.location.reload(); //刷新当前页面
            }
        });
    });




    //删除我的回复
    $('.reply_top a').click(function(){
        //alert($(this).attr('index'));
        $.ajax({
            url:'article.php',
            data:{reply_id:$(this).attr('index')},
            type:'post',
            dataType:'json',
            success:function(data){
                alert(data);
                window.location.reload(); //刷新当前页面
            }
        });
    });




    //全选状态
    $('#all_delete').click(function () {
        //alert($(this).is(':checked'));
        $("input[type='checkbox']").prop('checked',$(this).is(':checked'));

    });





    //修改私信的状态
    $('.showLetter').click(function () {
        $('#letter_container').html($(this).html());
        $.ajax({
            url:'message.php',
            type:'post',
            data:{isread:true,letterID:$(this).attr('value')}
        });
    });



    //表情写入多行文本区域
    $('.feeling_pic').click(function () {
        var str=$('#message_textarea').val();

        /*var title='['+$(this).attr('title')+']';
         str += title;*/
        //$('#edit_textarea').val(str);

        var outerHTML=$(this).prop('outerHTML');
        str += outerHTML;
        $('#message_textarea').val(str);
        //alert($('#edit_textarea').val());
    });



    //提交发布，验证标题、类型和内容是否为空
    $('#btn_sub_message').click(function () {
        if($.trim($('#message_textarea').val()) == ''){
            $('#tip_message').addClass('glyphicon glyphicon-remove').html('内容不能为空');
        }
        else{
            $('#tip_message').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
            //alert($('#select').val());
            $('#message_form').submit();
        }
    });


    //点击头像弹出新窗口
    $('#myface').click(function () {
        $('#faceModal').modal('show');
    });

    $('#face_cantainer img').click(function(){
        $('#myface').attr('src',$(this).attr('src'));
    });


/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    //验证修改个人资料表单
    var ok1=false;
    var ok2=false;

    //验证用户名
    $('#modify_name').focus(function () {
        $('#tip_modify_user').removeClass('glyphicon glyphicon-ok').removeClass('glyphicon glyphicon-remove').html('用户名在2-20位之间');
    }).blur(function () {
        $.ajax({
            url:'Validate.php',
            type:'post',
            dataType:'json',
            data:{name:$(this).val()},
            success:function(data){
                if(data == '存在'){
                    $('#tip_modify_user').removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove').html("该用户名已经注册");
                    ok1=false;
                }
            },
            error:function(){alert('ajax操作失败');}
        });
        if($.trim($(this).val()).length < 2 || $.trim($(this).val()).length > 20){
            $('#tip_modify_user').removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove').html("用户名在2-20位之间");
        }else {
            $('#tip_modify_user').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
            ok1=true;
        }
    });

    //验证密码
    $('#modify_pwd').focus(function () {
        $('#tip_modify_pwd').removeClass('glyphicon glyphicon-ok').removeClass('glyphicon glyphicon-remove').html('密码在6-14位之间且不能有空格');
    }).blur(function () {
        var regNull=/\s/;
        if(regNull.test($(this).val())){
            $('#tip_modify_pwd').removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove').html('密码不能有空格');
        }else if($(this).val().length < 6 || $(this).val().length > 14){
            $('#tip_modify_pwd').removeClass('glyphicon glyphicon-ok').addClass('glyphicon glyphicon-remove').html('密码在6-14位之间');
        }else{
            $('#tip_modify_pwd').removeClass('glyphicon glyphicon-remove').addClass('glyphicon glyphicon-ok').html('');
            ok2=true;
        }
    });

    //提交按钮，所有验证通过方可提交
    $('#modify_btn').click(function(){
        if(ok1 && ok2){
            $('#basic_form').submit();
        }else{
            return false;
        }
    });

});

