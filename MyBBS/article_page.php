<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-7-4
 * Time: 21:38
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

$arr=array();

$sql="SELECT * FROM bbs_send ORDER BY bbs_send_time DESC";
$result=$con->query($sql);
if(!!$num=$result->num_rows){
    array_push($arr,$num);
}

$records = 5;              //每页显示的记录个数
$page = 1;



if (isset($_POST['page'])){
    $page = $_POST['page'];//获得显示页码,如第一次访问则为1
}

$nStart = ($page - 1) * $records; //计算起始记录, 0 开始

$sql2=sprintf("SELECT * FROM bbs_send ORDER BY bbs_send_time DESC LIMIT %d,%d",$nStart,$records);
$result2=$con->query($sql2);
if(!!$num2=$result2->num_rows){
    for($i=1;$i<=$num2;$i++){
        $row2=$result2->fetch_assoc();

        $sql3="SELECT * FROM bbs_user WHERE bbs_id={$row2['bbs_user_id']}";
        $result3=$con->query($sql3);
        if(!!$num3=$result3->num_rows){
            $row3=$result3->fetch_assoc();
        }

        array_push($arr,
            "<tr>
                <td style='width: 20px'><input type='checkbox' name='article_check[]' value='{$row2['bbs_id']}'></td>
                <td style='width: 40px'>{$i}</td>
                <td style='width: 150px' title='{$row2['bbs_title']}'>{$row2['bbs_title']}</td>
                <td style='width: 200px' title='{$row2['bbs_send_content']}'>{$row2['bbs_send_content']}</td>
                <td style='width: 100px' title='{$row3['bbs_username']}'>{$row3['bbs_username']}</td>
                <td style='width: 140px'>{$row2['bbs_send_time']}</td>
                <td style='width: 60px'>{$row2['bbs_read_count']}</td>
                <td style='width: 100px'>{$row2['bbs_type']}</td>
            </tr>"
        );
    }
    echo json_encode($arr);
}


?>
