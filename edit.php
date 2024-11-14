<?php
    include 'connect.php';
    session_start();
    if (isset($_GET['edit_note'])){
        $_SESSION['noteid'] = $_GET['edit_note'];  //IDOR VULNERABILITY HERE !!!!!!!!
    }

    if ($_SERVER['REQUEST_METHOD'] == 'GET'){
        $noteid =$_SESSION['noteid'];
        $sqlgetinfo = "select * from `notes` where id = '$noteid'";
        $resault = mysqli_query($connect,$sqlgetinfo);
        if ($resault){
            $row = mysqli_fetch_assoc($resault);
            $title = $row['title'];
            $note = $row['note'];
        }
    }
    
    if (isset($_POST['submit']) && isset($_SESSION['noteid'])){
        $noteid = $_SESSION['noteid'];
        $newtitle = $_POST['newtitle'];
        $newnote =$_POST['newnote'];
        
        $sqledit = "update `notes` set title = '$newtitle' ,note = '$newnote' where id = $noteid";
        $resault = mysqli_query($connect,$sqledit);
        if ($resault){
            header("Location: home.php");
        }else{
            echo '<script>alert("error")</script>';
        }
        
    
    
    }
    
   
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=stylesheet href="css/edit.css">
    <title>NoteApp</title>
</head>
<body>
<div class= "form-container">
    <h1>Edit note</h1>

    <form action="edit.php" method="POST">
        <input type="text" placeholder='<?php echo "{$title}"?>' name="newtitle">
        <input type="text" placeholder="<?php echo "{$note}" ?>" name="newnote">
        <input type="submit" value="edit" name="submit">


    </form>
</div>
</body>
</html>