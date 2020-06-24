<?php
include 'mysqli.php';

// 设置sql 语句，查询全部数据
$sql = "select * from traveluser where UserName = '{$_COOKIE['username']}' limit 1";

// 发送sql语句，获得查询结果
$result = $conn->query($sql);

$id = "";
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $id = $row['UID'];
    }
}else {
    echo "暂无数据";die;
}


$sql = "select * from travelimagefavor where UID = '{$id}'";
$result = $conn->query($sql);

$arr = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr[] = $row['ImageID'];
    }
}else {
    echo json_encode(['status' => 0]);die;
}

$imageid = implode(',',$arr);


// 发送sql语句，获得查询结果
$sql = "select * from travelimage where ImageID in($imageid)";
$result = $conn->query($sql);

$arrs = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arrs[] = $row;
    }
}else {
    echo json_encode(['status' => 0]);die;
}

echo json_encode(['status' => 1,'msg'=>$arrs]);


// 关闭
$conn->close();