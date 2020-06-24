<?php
include 'mysqli.php';

// echo '首页<br/>';

// echo $_COOKIE['username'];
if(isset($_COOKIE['username'])){
    echo json_encode(['status' => 1,'msg'=>$_COOKIE['username']]);
    exit; 
}else{
    echo json_encode(['status' => 0]);
    exit;
}




// // 设置sql 语句，查询全部数据 
// $sql = "select * from traveluser where UserName='{$_POST['UserName']}' and pass='{$_POST['pass']}'";

// // 发送sql语句，获得查询结果
// $result = $conn->query($sql);

// if($result->num_rows > 0) {
//     setcookie("username",$_POST['UserName'],time()+86400);
//     echo '登陆校验成功，正在跳转……';
//     Header("Location: /src/Homepage.html"); 
//     exit; 
// }else {
//     echo "暂无数据";
// }

// // 关闭
// $conn->close();