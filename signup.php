<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        * {
            box-sizing: border-box;
            font-family: Tahoma;
        }
        form {
            border: 1px solid blue;
            border-radius:5px;
            padding:14px;
            margin:auto;
            width:214px;
        }
        div{
            margin-bottom:25px;
        }
    </style>
</head>
<?php
    $name = $username = $password = $success = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $name = htmlspecialchars($_POST["name"]);
        $username = htmlspecialchars($_POST["username"]);
        $tmp = htmlspecialchars($_POST["password"]);
        $password = md5($tmp);
        $conn = new mysqli("localhost","root","","ticketingdb");
        if($conn->connect_error){
            die("Connection to database failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        $sql = "INSERT INTO `users` (name, username, password) VALUES ('$name','$username','$password');";
        if($conn->query($sql) == TRUE){
            $success = "ثبت نام شما انجام شد. اکنون می توانید وارد شوید." . " <a href='login.php'>صفحه ورود</a>";
        }
        else{
            $success = "error: " . $conn->error;
        }
        $conn->close();
    }
?>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <div>
        <p>نام خود را به فارسی وارد نمایید:</p>
        <p><input type="text" name="name" placeholder="نام"></p>
        </div>
        <div>
        <p>نام کاربری و گذرواژه را به انگلیسی وارد نمایید:</p>
        <p><input type="text" name="username" placeholder="نام کاربری"></p>
        <p><input type="password" name="password" placeholder="گذرواژه"></p>
        </div>
        <p><input type="submit" name="submit" value="ثبت نام"></p>
        <p><?php echo $success; ?></p>
    </form>
</body>
</html>