<?php
    session_start();
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
    <h1>پیشخوان کاربر</h1>
    <?php
        if(!isset($_SESSION["name"])){
            die("شما باید ابتدا وارد حساب خود شوید. <a href='login.php'>صفحه ورود به حساب</a>");
        }
        $name = $_SESSION["name"];
        echo "<h2>"."سلام ". $name . "</h2>";
    ?>
    <p><a href="add-request.php">ثبت درخواست جدید</a></p>
    <h2>درخواست‌های قبلی شما</h2>
    <?php
        $conn = new mysqli("localhost","root","","ticketingdb");
        if($conn->connect_error){
            die("Connection to database failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        $userid = $_SESSION["userid"];
        $sql = "SELECT `state`, `text` as q, `answer` as a FROM (SELECT * FROM `support_request` WHERE userid=$userid) as sr LEFT OUTER JOIN `reply` on `request_id`=sr.`id`";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<table><tr><th>سوال شما</th><th>وضعیت</th><th>پاسخ کارشناس</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>"."<td>".$row["q"]."</td>". 
                "<td>".$row["state"]."</td>".
                "<td>".$row["a"]."</td>";
                echo "</tr>";
            }
            echo "</table>";
        }else{
            echo "نتیجه‌ای یافت نشد.";
        }
        $conn->close();
    ?>
</body>
</html>