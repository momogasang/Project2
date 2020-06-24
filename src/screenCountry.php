<?php
include 'mysqli.php';


if($_POST['country'] == ""){echo json_encode(['status' => 0]);exit;}

// 设置sql 语句，查询全部数据 
$sql = "select * from geocountries where CountryName = '{$_POST['country']}' limit 1";
$result = $conn->query($sql);
$arrs = "";
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arrs = $row;
    }
}else {
    // echo "暂无数据";
    echo json_encode(['status' => 0]);
    die;
}
// echo '<pre>';
// print_r($arrs);die;

// 发送sql语句，获得查询结果
$sql = "select * from travelimage where CountryCodeISO = '{$arrs['fipsCountryCode']}' limit 6";
$result = $conn->query($sql);

$arr = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr[] = $row;
    }
}else {
    echo json_encode(['status' => 0]);die;
}

$arr = array_chunk($arr, 3);
// echo '<pre>';
// print_r($arr);
echo json_encode(['status' => 1,'msg'=>$arr]);

// 关闭
$conn->close();