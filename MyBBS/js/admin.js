/**
 * Created by Jing on 2016-7-4.
 */
$(function(){
    //查找用户
    $('#search_user_btn').click(function(){
        $.ajax({
            url:'admin_operate.php',
            type:'post',
            dataType:'json',
            data:{search_user:$("input[name='search_user']").val()},
            success:function(data){
                $('#user_table').html($('#user_table tr:first-child'));
                $('#user_table').append(data);
            },
            error:function(){alert('error')}
        });
    });


    //查找帖子
    $('#search_article_btn').click(function(){
        $.ajax({
            url:'admin_operate.php',
            type:'post',
            dataType:'json',
            data:{search_article:$("input[name='search_article']").val()},
            success:function(data){
                $('#article_table').html($('#article_table tr:first-child'));
                $('#article_table').append(data);
            },
            error:function(){alert('error')}
        });
    });


    //用户分页
    $.ajax({
        url:'user_page.php',
        type:'post',
        dataType:'json',
        success:function(data){
            $('#user_page ol').html('');
            var n=Math.ceil(data[0]/5);  //计算有多少个分页
            for($i=1;$i<=n;$i++){
                $('#user_page ol').append("<li><a href='javascript:void(0);'>"+$i+"</a></li>");
            }
            $('#user_page ol li:first-child').addClass('active');
            data.shift();  //删除数组第一个元素
            //console.log(data);
            $('#user_table').html($('#user_table tr:first-child'));
            $('#user_table').append(data);


            //点击1,2,3,4...分页
            $('#user_page ol li a').click(function(){
                $(this).parent().addClass('active');
                $(this).parent().siblings().removeClass("active");//去掉原有的active

                $.ajax({
                    url:'user_page.php',
                    data:{page:$(this).text()},
                    type:'post',
                    dataType:'json',
                    success:function(data){
                        data.shift();  //删除数组第一个元素
                        //alert(data.length);
                        $('#user_table').html($('#user_table tr:first-child'));
                        $('#user_table').append(data);
                    }
                });

            });
        },
        error:function(){alert('error')}
    });




    //帖子分页
    $('#article_li').click(function(){
        $.ajax({
            url:'article_page.php',
            type:'post',
            dataType:'json',
            success:function(data){
                $('#article_page ol').html('');
                var n=Math.ceil(data[0]/5);  //计算有多少个分页
                for($i=1;$i<=n;$i++){
                    $('#article_page ol').append("<li><a href='javascript:void(0);'>"+$i+"</a></li>");
                }
                $('#article_page ol li:first-child').addClass('active');
                data.shift();  //删除数组第一个元素
                //console.log(data);
                $('#article_table').html($('#article_table tr:first-child'));
                $('#article_table').append(data);


                //点击1,2,3,4...分页
                $('#article_page ol li a').click(function(){
                    $(this).parent().addClass('active');
                    $(this).parent().siblings().removeClass("active");//去掉原有的active

                    $.ajax({
                        url:'article_page.php',
                        data:{page:$(this).text()},
                        type:'post',
                        dataType:'json',
                        success:function(data){
                            data.shift();  //删除数组第一个元素
                            //alert(data.length);
                            $('#article_table').html($('#article_table tr:first-child'));
                            $('#article_table').append(data);
                        }
                    });

                });
            },
            error:function(){alert('error')}
        });
    });


    //全选状态
    $('#all_user_delete').click(function () {
        //alert($(this).is(':checked'));
        $("input[type='checkbox']").not($("input[name='article_check[]']")).prop('checked',$(this).is(':checked'));

    });

    $('#all_article_delete').click(function () {
        //alert($(this).is(':checked'));
        $("input[type='checkbox']").not($("input[name='user_check[]']")).prop('checked',$(this).is(':checked'));

    });


    //判断是否选中一行数据，删除按钮才能提交表单
    $('#user_del').click(function(){
        if($("input[type='checkbox']").is(':checked') == false){
            alert('请选择数据');
        }else{
            $('#user_form').submit();
        }
    });

    $('#article_del').click(function(){
        if($("input[type='checkbox']").is(':checked') == false){
            alert('请选择数据');
        }else{
            $('#article_form').submit();
        }
    });


    //选中一行数据，编辑按钮才能激活模态框
    $('#user_edit').click(function () {
        if($("input[type='checkbox']").is(':checked') == false){
            alert('请选择数据');
        }else{
            $('#usereditModal').modal('show');
        }
    });


    $('#article_edit').click(function () {
        if($("input[type='checkbox']").is(':checked') == false){
            alert('请选择数据');
        }else{
            $('#articleeditModal').modal('show');
        }
    });



//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



    //验证用户新增表单
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
            $('#tip_modify_user').removeClass('glyphicon glyphicon-remove').html('');
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
            $('#tip_modify_pwd').removeClass('glyphicon glyphicon-remove').html('');
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


    //将选中行的id复制到表单的hidden里
    $('#user_edit').click(function () {
        //alert($("input[type='checkbox']").val());
        $('#user_id').val($("input[name='user_check[]']:checked").val());
    });


    //选择头像
    $('#edit_face').click(function(){
        $('#faceModal').modal('show');
    });

    $('#face_cantainer img').click(function(){
        $('#edit_face').val($(this).attr('src'));
    });


    //修改注册时间
    $('#edit_register_time').datetimepicker({
        //showOn: "button",
        //buttonImage: "./css/images/icon_calendar.gif",
        //buttonImageOnly: true,
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        stepHour: 1,
        stepMinute: 1,
        stepSecond: 1
    });



    //表情写入多行文本区域
    $('.feeling_pic').click(function () {
        var str=$('#insert_textarea').val();

        /*var title='['+$(this).attr('title')+']';
         str += title;*/
        //$('#edit_textarea').val(str);

        var outerHTML=$(this).prop('outerHTML');
        str += outerHTML;
        $('#insert_textarea').val(str);
        //alert($('#edit_textarea').val());
    });




    //将选中行的id复制到表单的hidden里
    $('#article_edit').click(function () {
        //alert($("input[type='checkbox']").val());
        $('#edit_article_id').val($("input[name='article_check[]']:checked").val());
    });



    //修改发帖时间
    $('#edit_send_time').datetimepicker({
        //showOn: "button",
        //buttonImage: "./css/images/icon_calendar.gif",
        //buttonImageOnly: true,
        showSecond: true,
        timeFormat: 'hh:mm:ss',
        stepHour: 1,
        stepMinute: 1,
        stepSecond: 1
    });







});
