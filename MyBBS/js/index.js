/**
 * Created by Jing on 2016-6-19.
 */
$(function(){
    //点击链接阅读量+1
    $('.title a').click(function () {
        //alert($(this).attr('value'));
        $.ajax({
            url:'updateNum.php',
            data:{readnum:1,id:$(this).attr('value')},
            type:'post'
        });
    });

    //选择类型显示帖子
    $('#menu li').click(function () {
        //alert($(this).attr('value'));
        $.ajax({
            url:'SelectArticle.php',
            type:'post',
            data:{value:$(this).attr('value')},
            success:function(data){
                $('#center_topic').html(data);

                //控制首页帖子内容显示字数不超过100个
                var arr=new Array();
                arr=document.getElementsByTagName('div');
                for(var i=0;i<arr.length;i++){
                    if(arr[i].className == 'content'){
                        var str=arr[i].innerText;
                        if(str.length > 100){
                            arr[i].innerText=str.substring(0,100)+'...';
                        }
                    }
                }
            }
        });
    });


    //控制首页帖子内容显示字数不超过100个
    var arr=new Array();
    arr=document.getElementsByTagName('div');
    for(var i=0;i<arr.length;i++){
        if(arr[i].className == 'content'){
            var str=arr[i].innerText;
            if(str.length > 100){
                arr[i].innerText=str.substring(0,100)+'...';
            }
        }
    }








});