<?php 

    session_start();
    require_once 'config/db.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hotal</title>
</head>
<body>
<div >
        ยินดีต้อนรับเข้าสู่ระบบ
    </div>
    <form action="login_db.php" method="post">
    <?php if(isset($_SESSION['error'])) { ?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])) { ?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success'];
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning'];
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
    <log class="login">
    <div class="u">Username</div>
    <input class="user" type="text" name="STUDENT_LOG" aria-describedby="Username">

    <div class="p">Password</div>
    <input class="pass" type="password" name="STUDENT_PW" aria-describedby="Password">
    

   
    <button type="submit" name="signin" class="btn-submit" value="เข้าสู่ระบบ" >เข้าสู่ระบบ</button>
    </form>
    
    </log>
</body>
</html>