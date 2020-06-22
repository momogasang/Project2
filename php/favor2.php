<?php
include 'mysqli.php';

if($_POST['ImageID'] == "" || !isset($_COOKIE['username'])){
    echo '参数有误';
    exit; 
}

// 发送sql语句，获得查询结果
$sql = "select * from traveluser where UserName ='{$_COOKIE['username']}' limit 1";
$result = $conn->query($sql);

$arr = [];
// $arrs = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr['UID'] = $row['UID'];
    }
}else {
    echo '参数有误';
    echo json_encode(['status' => 0]);
    exit;
}


// 发送sql语句，获得查询结果
$sql = "select * from travelimagefavor where UID = '{$arr['UID']}' and ImageID = '{$_POST['ImageID']}' limit 1";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        echo json_encode(['status' => 0,'msg'=>1]);
        exit;
    }
}else {
    // 设置插入数据的sql语句
    $sql = "insert into travelimagefavor(UID,ImageID) values('{$arr['UID']}','{$_POST['ImageID']}')";
    // 发送sql 语句
    if($conn->query($sql) === TRUE){
        echo json_encode(['status' => 1]);
        exit;
    }else {
        echo "新记录添加失败，错误信息:";
        echo json_encode(['status' => 0]);
        exit;
    }
}

 // 关闭
 $conn->close();