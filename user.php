<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户界面</title>
</head>

<body>

    <?php
        $server = 'localhost:3306';
        $dbuser = 'root';
        $dbpass = 'root';
        $dbname = 'letter';

        $conn = new Mysqli($server, $dbuser, $dbpass, $dbname);

        if ($conn->connect_error) {
            die('连接失败：' . $conn->connect_error);
        };

        $conn->set_charset('UTF-8');

        $username = $_SERVER["QUERY_STRING"];

        $user_id = $conn->query("SELECT * FROM users WHERE username = '$username' ")->fetch_assoc()['id'];

        $unreadMessage = $conn->query("SELECT * FROM letters WHERE to_userId = '$user_id' AND status='0'")->fetch_all();

    ?>

    <div>用户名: <?php echo $username ?></div>
    <br />
    <div>
        <div>《发私信》：</div>
        <br />
        <form action="sendLetter.php" method="POST">
            <input type="text" name="to_user" placeholder="接收者姓名">
            <input type="hidden" name="my_name" value="<?php echo $username ?>">
            <input type="text" name="title" placeholder="私信标题">
            <input type="text" name="message" placeholder="私信内容">
            <button type="submit">发送</button>
        </form>
        <br />
        <?php
            if(count($unreadMessage) > 0){
                echo "<div>你有". count($unreadMessage) . "条未读私信</div>";
                foreach($unreadMessage as $k => $v) {
                    // var_dump($unreadMessage);
                    $user_id = $v[1];
                    $result = $conn->query("SELECT username FROM users WHERE id = '$user_id'")->fetch_assoc();
                    echo "<br />" . "发件人：" . $result["username"] . " 标题：" . $v[3] . " 内容：" . $v[4] . "<br />";
                }
            } else {
                echo "<div>你没有私信</div>";
            }
        ?>
    </div>
</body>

</html>