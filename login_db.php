<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signin'])) {
        $username = $_POST['STUDENT_LOG'];
        $password = $_POST['STUDENT_PW'];

      
        if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: login.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: login.php");
        } else if (strlen($_POST['STUDENT_PW']) > 20 || strlen($_POST['STUDENT_PW']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: login.php");
        } else {
            try {

                $check_data = $conn->prepare("SELECT * FROM regis_user WHERE STUDENT_LOG = :username");
                $check_data->bindParam(":username", $username);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);

                if ($check_data->rowCount() > 0) {

                    if ($username == $row['STUDENT_LOG']) {
                        if (password_verify($password, $row['STUDENT_PW'])) {
                            if ($row['urole'] == 'admin') {
                                $_SESSION['admin_login'] = $row['STUDENT_ID'];
                                header("location: admin_add.php");
                            } 
                
                            
                            else if ($row['urole'] == 'user'){
                                $_SESSION['user_login'] = $row['STUDENT_ID'];
                                header("location: user.php");
                            }
                        } else {
                            $_SESSION['error'] = 'รหัสผ่านไม่ถูกต้อง';
                            header("location: login.php");
                        }
                    } else {
                        $_SESSION['error'] = 'อีเมลไม่ถูกต้อง';
                        header("location: login.php");
                    }
                } else {
                    $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                    header("location: login.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>