<?php
$servername = "127.0.0.1";
// 数据库服务器
 $username = "root";
//数据库名称，一般为root
 $password = "huanrui123";
//数据库密码
//连接数据库
$dbname = "project";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}