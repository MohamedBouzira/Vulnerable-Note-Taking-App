<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['button'])){
        include 'connect.php';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $conf_password = $_POST['conf_password']; 
        $email = $_POST['email'];  

        // Hash password
        $hash_password = md5($password);  // Insecure hashing
        
        // Check if passwords match
        $match = ($password === $conf_password);

        if (!$match){
            echo '<script>alert("Password does not match")</script>';
        } else {
            // Check if username already exists
            $sqlcheck = "SELECT * FROM `users` WHERE username = '$username'";
            $result = mysqli_query($connect, $sqlcheck);
            if ($result) {
                if(mysqli_num_rows($result) == 1){
                    echo '<script>alert("Username already exists");</script>';
                }else {
                // Insert new user
                $sqladd = "insert into `users` (username,password,email) values ('$username','$hash_password','$email')";
                $resault = mysqli_query($connect,$sqladd);
                if ($resault){
                    echo '<script> alert("data inserted successfully") </script>';    
                    }else{
                        die(mysqli_connect_error());
                    }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>NotesApp</title>
</head>
<body>
    <h1>Fill the form to get an account! </h1>

    <form action="register.php" method="POST">
        <div class="cred">
            <input type="text" id= "123" name="username" placeholder="username" required>    
            <input type="password" name="password" placeholder="password" required>
            <input type="password" name="conf_password" placeholder="confirm password" required>
            <input type="email" name="email" placeholder="email" required>
        </div>
        <div class="button">
            <input type="submit" value="register" name="button">
        </div>

        <a href="login.php">Already have an account?</a>
    </form>
</body>
</html>