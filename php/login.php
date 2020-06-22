<?php
include 'mysqli.php';

echo '登陆<br/>';

if($_POST['UserName'] == "" || $_POST['pass'] == ""){
    echo '参数有误';
    Header("Location: /index.html");
    exit; 
}


// 设置sql 语句，查询全部数据
$sql = "select * from traveluser where UserName='{$_POST['UserName']}' and pass='{$_POST['pass']}'";

// 发送sql语句，获得查询结果

$result = $conn->query($sql);

if($result->num_rows > 0) {
    setcookie("username",$_POST['UserName'],time()+86400);
    echo '登陆校验成功，正在c跳转……';
    Header("Location: /src/Homepage.html"); 
    exit; 
}else {
    echo "暂无数据";
}

// 关闭
$conn->close();