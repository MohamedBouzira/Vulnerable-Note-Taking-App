<?php
    session_start();
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button'])){
        include 'connect.php';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $hash_password = md5($password);

            $sqlcheck = "select * from `users` where username = '$username' and password = '$hash_password'";  //SQL INJECTION VULNERABILITY HERE !!!!
            $resault = mysqli_query($connect,$sqlcheck);

            if ($resault){
                if (mysqli_num_rows($resault) == 1){
                    $sqlGetID = "select * from `users` where username = '$username'";  //counter the SQLI
                    $row = mysqli_fetch_assoc(mysqli_query($connect,$sqlGetID));
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: home.php");
                }
            }else{
                    echo '<script>alert("invalid credential")</script>';
                }
            
        
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>NotesApp</title>
</head>
<body>
    <h1>welcome to the best note app in the world wide web</h1>

    <form action="login.php" method=POST>
        <div class="cred">
            <input type="text" name="username" placeholder="username" required>    
            <input type="password" name="password" placeholder="password" required >
        </div>
        <div class="button">
            <input type="submit" value="login" name="button">
        </div>

        <a href="http://localhost:81/NotesApp/register.php"> you don't have an account? </a>
    </form>
    
    
</body>
</html>