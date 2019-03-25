<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body bgcolor="#000">
<div style=" margin-top:70px;color:#FFF; font-size:23px; text-align:center">Welcome&nbsp;&nbsp;&nbsp;<font
            color="#FF0000">Sql_inject</font><br>
    <font size="3" color="#FFFF000">
        <?php
        include __DIR__.'/../sql-connections/sql-connections.php';
        error_reporting(0);
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $fp = fopen('result.txt', 'a');
            fwrite($fp, 'ID:'.$id."\n");
            fclose($fp);

            $sql = "SELECT * FROM users WHERE id='$id' LIMIT 0,1";
            echo $sql.'<br>';
            $result = mysqli_query($con, $sql);
            $row = mysqli_fetch_array($result);
            # var_dump($row);
            if ($row) {
                echo '<font size="5" color=""#99ff00>';
                echo 'username:'.$row['username'];
                echo '<br>';
                echo 'password:'.$row['password'];
            } else {
                echo '<font color="#ffff00">';
                print_r(mysqli_error($con));
                echo '</font>';
            }
        }
        ?>


    </font>
</body>
</html>