<?php
    session_start();
    $success = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $answer = htmlspecialchars($_POST["answer"]);
        $userid = $_SESSION["userid"];
        $sr_id = $_POST["srid"];
        $sql = "INSERT INTO reply (userid, request_id, answer) VALUES ('$userid', '$sr_id', '$answer');";
        $sql2 = "UPDATE support_request SET `state` = 'پاسخ داده شده' WHERE `id`=$sr_id;";
        $conn2 = new mysqli("localhost","root","","ticketingdb");
        if($conn2->connect_error){
            die("Connection to database failed: " . $conn2->connect_error);
        }else{
            $conn2->set_charset("utf8mb4");
            $conn2->query($sql);
            $conn2->query($sql2);
        }
    }
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
	<meta charset="utf-8">
    <style>
        * {
            box-sizing: border-box;
            font-family: Tahoma;
        }
        table, th, td {
            border: 1px solid #111;
            border-collapse:collapse;
        }
        th, td {
            padding: 10px;
        }
    </style>
</head>
<body>
    <h1>پیشخوان مدیر</h1>
    <?php
        if(!isset($_SESSION["name"])){
            die("شما باید ابتدا وارد حساب خود شوید. <a href='login.php'>صفحه ورود به حساب</a>");
        }
        $name = $_SESSION["name"];
        
        echo "<h2>"."سلام ". $name . "</h2>";
        $conn = new mysqli("localhost","root","","ticketingdb");
        if($conn->connect_error){
            die("Connection to database failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        $sql ="SELECT sr.id, `text`, `name` FROM (SELECT `id`, `userid`, `text` FROM `support_request` WHERE `state`='در انتظار پاسخ') as sr JOIN `users` on sr.userid=`users`.`id`;";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table>";
            while($row = $result->fetch_assoc()) {
                $srid=$row["id"];
                echo "<tr>"."<td>".$row["name"]."</td>". 
                "<td>".$row["text"]."</td>";
                echo <<<EOT
<td><form method='post' action='adminpanel.php'>
<textarea rows="5" cols="60" placeholder="پاسخ را اینجا بنویسید" name="answer"></textarea>
<input type="hidden" name="srid" value="$srid">
<input type="submit" name="submit" value="ثبت پاسخ">
</form></td></tr>
EOT;
            }
            echo "</table>";
        }else{
            echo "نتیجه‌ای یافت نشد.";
        }
        $conn->close();
    ?>
</body>
</html>