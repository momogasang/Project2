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
$sql = "select * from travelimage where ImageID ='{$_POST['ImageID']}' limit 1";
$result = $conn->query($sql);

if($result->num_rows > 0) {
}else {
    echo json_encode(['status' => 0]);
    die;
}

 $sql="delete from travelimagefavor where UID = '{$arr['UID']}' and ImageID ='{$_POST['ImageID']}'";
 $result=$conn->query($sql);
 if ($result)
 {
     echo json_encode(['status' => 1]);
 }else{
     echo json_encode(['status' => 0]);
     die;
 }
// 关闭
$conn->close();