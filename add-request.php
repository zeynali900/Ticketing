<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
	<meta charset="utf-8">
    <title>ثبت درخواست پشتیبانی</title>
</head>
<body>
    <?php
        $success = "";
        $name = $_SESSION["name"];
        $userid = $_SESSION["userid"];
        echo "<h1>ثبت درخواست پشتیبانی توسط کاربر: ".$name."</h1>";
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $text = htmlspecialchars($_POST["text"]);
            $conn = new mysqli("localhost","root","","ticketingdb");
            if($conn->connect_error){
                die("Connection to database failed: " . $conn->connect_error);
            }
            $conn->set_charset("utf8mb4");
            $sql = "INSERT INTO `support_request` (`userid`,`text`) VALUES('$userid','$text')";
            if($conn->query($sql) == TRUE){
                $success = "درخواست شما با موفقیت ثبت شد. کارشناسان ما در اسرع وقت رسیدگی می‌کنند.";
            }else{
                $success = "error: " . $conn->error;
            }
            $conn->close();
        }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <textarea placeholder="سوال یا مشکل را اینجا بنویسید" name="text" cols="100" rows="10"></textarea>
        <p><input type="submit" name="submit" value="ثبت"></p>
        <p><?php echo $success; ?></p>
    </form>
</body>
</html>