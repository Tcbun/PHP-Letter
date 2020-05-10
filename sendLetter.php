<?php

$server = 'localhost:3306';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'letter';

$conn = new Mysqli($server,$dbuser,$dbpass,$dbname);

if($conn->connect_error){
    die('连接失败：' . $conn->connect_error);
};

$conn->set_charset('UTF-8');

$my_name = $_POST['my_name'];
$to_user = $_POST['to_user'];
$title = $_POST['title'];
$message = $_POST['message'];

$my_name_sql = "SELECT * FROM users WHERE username = '$my_name'";
$to_user_sql = "SELECT * FROM users WHERE username = '$to_user'";

$result_my_name = $conn->query($my_name_sql)->fetch_assoc();
$result_to_user = $conn->query($to_user_sql)->fetch_assoc();

$my_name_id = $result_my_name["id"];
$to_user_id = $result_to_user["id"];

$insert_letter_sql = "INSERT INTO letters (`from_userId`,`to_userId`,`title`,`message`,`status`) VALUES ('$my_name_id','$to_user_id','$title','$message','0')";

if(!$result_to_user){
    echo "<script>alert('接收者不存在');window.history.go(-1);</script>";
} else {
    if($conn->query($insert_letter_sql)){
        echo "<script>alert('发送成功');window.history.go(-1);</script>";
    } else {
        echo "发送私信出错：" . $conn->error;
    }
}

$conn->close();
