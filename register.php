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
<h3>สมัครสมาชิก</h3>
        <hr>
        <form action="register_db.php" method="post">
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

            <div class="mb-3">
                <label for="firstname" class="n">First name</label>
                <input type="text" class="name" name="STUDENT_FNAME" aria-describedby="firstname">
            </div>
            <div class="mb-3">
                <label for="lastname" class="l">Last name</label>
                <input type="text" class="last" name="STUDENT_LNAME" aria-describedby="lastname">
            </div>
            <div class="mb-3">
                <label for="username" class="us">Username</label>
                <input type="text" class="use" name="STUDENT_LOG" aria-describedby="username">
            </div>
            <div class="mb-3">
                <label for="password" class="p">Password</label>
                <input type="password" class="" name="STUDENT_PW">
            </div>
            <div class="mb-3">
                <label for="confirm password" class="rp">Confirm Password</label>
                <input type="password" class="repass" name="c_password">
            </div>
            <div class="mb-3">
                <label for="sex" class="sex">Sex</label>
                <input type="radio" name="STUDENT_SEX" value="ชาย">male
                <input type="radio" name="STUDENT_SEX" value="หญิง">female
            </div>
            <div class="mb-3">
                <label for="Dept" class="">Dept</label>
                <input type="text" class="" name="STUDENT_DEPT">
            </div>
            <button type="submit" name="signup" class="btn-primary">Sign Up</button>
        </form>
        <a href='login.php' class="g_login">หากคุณเป็นสมาชิกอยู่แล้ว</a>
        <hr>
        
        
        
    </div>
    
</body>
</html>