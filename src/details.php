<?php
include 'mysqli.php';

if($_POST['ImageID'] == ""){
    echo '参数有误';
    exit; 
}

// 发送sql语句，获得查询结果
$sql = "select * from travelimage where ImageID ='{$_POST['ImageID']}' limit 1";
$result = $conn->query($sql);

$arr = [];
// $arrs = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr['data'] = $row;
    }
}else {
    $arr['data'] = "";
}


// 发送sql语句，获得查询结果
$sql = "select * from traveluser where UID ='{$arr['data']['UID']}' limit 1";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr['UserName'] = $row['UserName'];
    }
}else {
    $arr['UserName'] = "";
}


// 发送sql语句，获得查询结果
$sql = "select * from travelimagefavor where ImageID ='{$arr['data']['ImageID']}'";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr['Number'] = count($row);
    }
}else {
    $arr['Number'] = "0";
}

// 发送sql语句，获得查询结果
$sql = "select * from geocountries where ISO ='{$arr['data']['CountryCodeISO']}' limit 1";
$result = $conn->query($sql);

if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr['Country'] = $row['CountryName'];
        $arr['City'] = $row['Capital'];
    }
}else {
    $arr['Country'] = "China";
    $arr['City'] = "Shanghai";
}


// echo '<pre>';
// print_r($arr['Country']);

echo json_encode(['status' => 1,'msg'=>$arr]);


// // 关闭
// $conn->close();