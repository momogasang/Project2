<?php
// include 'mysqli.php';

//设置cookie过期，跳转至登陆
if(isset($_COOKIE['username'])){
    setcookie("username","",time()-86400);
    Header("Location: /index.html");
    exit; 
}
