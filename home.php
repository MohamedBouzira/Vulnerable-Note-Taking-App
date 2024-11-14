<?php

    session_start();
    include 'connect.php';

    if (!isset($_SESSION['id'])){
        header("Location: login.php");
        exit;
    }

    //Add note: 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])){
        $userid = $_SESSION['id'];
        $title = $_POST['title'];
        $note = $_POST['note'];
        

        $sqladdnote = "insert into `notes` (title,note,owner) values ('$title','$note','$userid')";
        $resault = mysqli_query($connect,$sqladdnote);
        if($resault){
            echo "<script>alert('{$title} added successfully')</script>";  //XSS VULNERABILITY HERE !!!!!
        }else{
            echo "<script>alert('error adding a note')</script>";
        }
    }

    //Delete note:
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_note'])) {
        $noteid = $_GET['delete_note'];
        $sqldeletenote = "delete from `notes` where id = '$noteid'";
        $resault = mysqli_query($connect,$sqldeletenote);
        if ($resault){
            echo "<script>alert('note deleted')</script>";
        }else{
            echo '<script>alert(error deleting note!")</script>';
        }
    }

    //log out:
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])){
        session_abort();
        header("Location: login.php");
    }
   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/hom.css" rel="stylesheet">

    <title>NoteApp</title>
</head>
<body>
<header>
        <h1>Welcome  <?= $_SESSION['username'] ?> </h1>
        <p>Keep your thoughts organized and accessible.</p>
    </header>
    <div class="container">
        <h2>Your Notes</h2>
        <div class="note">
        
            <ul>
                <?php
                    $userid = $_SESSION['id'];
                    $sqlgetnotes = "select * from `notes` where owner = '$userid'";
                    $resault = mysqli_query($connect,$sqlgetnotes);
                    if($resault){
                        while($row = mysqli_fetch_assoc($resault)){
                            echo "
                            <li>
                            <h4>{$row['title']}</h4>
                            
                            <p>{$row['note']}</p> 
                            
                            <a href='home.php?delete_note={$row['id']}'> delete </a>
                            <br>
                            <a href='edit.php?edit_note={$row['id']}' > edit </a> 
                            </li>
                            "; // IDOR here !!!!!!!!!!!
                        }
                    }

                ?>
            </ul>
            
        </div>
        <form class="add-note" action="home.php" method="POST">
            <input class="title" type="text" placeholder="Title" name="title">
            <textarea name="note" rows="4" placeholder="Write your note here..." required></textarea>
            <input type="submit" name="submit" value="Add Note" class="button">
        
        </form>
        <br>
        <br>
        <form method="POST" action="home.php"> 
        <input type="submit" value="log out" name="logout" id ='logout'>
        </form>
    </div>
    
</body>
</html>