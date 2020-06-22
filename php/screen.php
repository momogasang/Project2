<?php
include 'mysqli.php';

// 设置sql 语句，查询全部数据 
$sql = "select * from travelimage limit 6";

// 发送sql语句，获得查询结果
$result = $conn->query($sql);

$arr = [];
if($result->num_rows > 0) {
    while($row = $result->fetch_assoc()){
        $arr[] = $row;
    }
}else {
    echo "暂无数据";
}

$arr = array_chunk($arr, 3);
// echo '<pre>';
// print_r($arr);
echo json_encode(['status' => 1,'msg'=>$arr]);

// 关闭
$conn->close();