<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8">
    <style>
        * {box-sizing: border-box;}
        form {
            border: 1px solid blue;
            border-radius:5px;
            padding:10px;
            margin:auto;
            width:194px;
        }
    </style>
</head>
<?php
    $username = $password = $error = "";
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = htmlspecialchars($_POST["username"]);
        $tmp = htmlspecialchars($_POST["password"]);
        $password = md5($tmp);
        $conn = new mysqli("localhost","root","","ticketingdb");
        if($conn->connect_error){
            die("Connection to database failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        $sql = "SELECT * FROM `users` WHERE username = '$username'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if($row){
            if($password != $row["password"]){
                $error = "گذرواژه اشتباه است.";
            }else{
                $_SESSION["name"] = $row["name"];
                $_SESSION["userid"] = $row["id"];
                if($row["role"] == "admin"){
                    echo "<script>location.href = 'adminpanel.php';</script>";
                }else{
                    echo "<script>location.href = 'userpanel.php';</script>";
                }
            }
        }else{
            $error = "نام کاربری اشتباه است.";
        }
        
        $conn->close();
    }
?>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <p><input type="text" name="username" placeholder="username"></p>
        <p><input type="password" name="password" placeholder="password"></p>
        <p><input type="submit" name="submit" value="ورود"></p>
        <?php echo $error; ?>
    </form>
</body>
</html>