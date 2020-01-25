<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <?php
        session_start();
        if(!isset($_SESSION['logged_in']))
            header('location: index.php');
        else{
            if(isset($_POST['signout'])){
                
                unset($_SESSION['logged_in']);
                header('location: index.php');
            }
        }
            
    ?>
<form action="" method="post">
    <button type="submit" name="signout">Logout</button>

</form>
</body>
</html>
