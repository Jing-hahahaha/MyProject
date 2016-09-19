<?php
/**
 * Created by PhpStorm.
 * User: Jing
 * Date: 2016-6-20
 * Time: 12:20
 */
//防止恶意调用
if (!defined('IN_BBS')) {
    exit('Access Defined!');
}

session_start();


$con=new mysqli('127.0.0.1', 'root', '', 'my_bbs');
if($con->connect_errno){
    die('连接失败'.$con->connect_error);
}
//设置字符集
$con->query("SET NAMES 'UTF8'") or die('设置字符集错误');




?>
