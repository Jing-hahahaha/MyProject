<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-7-4
 * Time: 16:13
 */
//定义个常量，用来授权调用include里面的文件
define('IN_BBS',true);
require 'include/MyDB.php';

$arr=array();


$sql="SELECT * FROM bbs_user WHERE bbs_identity=0 ORDER BY bbs_register_time DESC";
$result=$con->query($sql);
if(!!$num=$result->num_rows){
    array_push($arr,$num);
}


$records = 5;              //每页显示的记录个数
$page = 1;                 //表示显示的页码


if(isset($_POST['page'])){
    $page = $_POST['page'];//获得显示页码,如第一次访问则为1
}
$nStart = ($page - 1) * $records; //计算起始记录, 0 开始

$sql2=sprintf("SELECT * FROM bbs_user WHERE bbs_identity=0 ORDER BY bbs_register_time DESC LIMIT %d,%d",$nStart,$records);
$result2=$con->query($sql2);
if(!!$num2=$result2->num_rows){
    for($i=1;$i<=$num2;$i++){
        $row2=$result2->fetch_assoc();

        $n=$nStart+$i;
        array_push($arr,
            "<tr>
                <td style='width: 20px'><input type='checkbox' name='user_check[]' value='{$row2['bbs_id']}'></td>
                <td style='width: 40px'>{$n}</td>
                <td style='width: 150px' title='{$row2['bbs_username']}'>{$row2['bbs_username']}</td>
                <td style='width: 140px' title='{$row2['bbs_password']}'>{$row2['bbs_password']}</td>
                <td style='width: 40px'>{$row2['bbs_sex']}</td>
                <td style='width: 140px' title='{$row2['bbs_face']}'>{$row2['bbs_face']}</td>
                <td style='width: 150px' title='{$row2['bbs_signature']}'>{$row2['bbs_signature']}</td>
                <td style='width: 140px'>{$row2['bbs_register_time']}</td>
            </tr>"
        );
    }
    echo json_encode($arr);
}




?>
