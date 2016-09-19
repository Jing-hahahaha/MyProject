/**
 * Created by Jing on 2016-6-25.
 */
$(function () {
    //展开、收起回复
   $('.comment').click(function () {
       $('#article_comment').toggle('hide');
       $(this).html($(this).html()=='收起回复'?'展开回复':'收起回复');
   });

    //回复内容不能为空，才能提交表单
    $('#reply_btn').click(function () {
        if($('#text_area').val() != ''){
            $('#reply_form').submit();
        }
    });

    //alert($("input[name='to_userID']").val());

    $('.reply').click(function(){
        $("input[name='to_userID']").val($(this).attr('name'));
        $('#second').html('回复'+$(this).attr('value')+'：');
        //alert($("input[name='to_userID']").val($(this).attr('name')).val());
    });



});