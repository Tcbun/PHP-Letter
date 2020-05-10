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

    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE `username` = '$username' ";

    $result = $conn->query($sql);

    if(!$result){
        echo '用户不存在！';
    } else {
        $row = $result->fetch_assoc();
        // var_dump($row);
        if($row["password"] === $password){
            echo '登录成功';
            header('Location:user.php?'.$username);
        } else {
            echo '密码错误';
        }
    }

    $conn->close();