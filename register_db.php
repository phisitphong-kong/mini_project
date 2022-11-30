<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_POST['signup'])) {
        $firstname = $_POST['STUDENT_FNAME'];
        $lastname = $_POST['STUDENT_LNAME'];
        $username = $_POST['STUDENT_LOG'];
        $password = $_POST['STUDENT_PW'];
        $c_password = $_POST['c_password'];
        $urole = 'user';
        $sex = $_POST['STUDENT_SEX'];
        $dept = $_POST['STUDENT_DEPT'];

        if (empty($firstname)) {
            $_SESSION['error'] = 'กรุณากรอกชื่อ';
            header("location: register.php");
        } else if (empty($lastname)) {
            $_SESSION['error'] = 'กรุณากรอกนามสกุล';
            header("location: register.php");
        } else if (empty($username)) {
            $_SESSION['error'] = 'กรุณากรอกอีเมล';
            header("location: register.php");
        } else if (strlen($_POST['STUDENT_LOG']) != 11) {
            $_SESSION['error'] = 'ต้องมีความยาว 11 ตัว';
            header("location: register.php");
        } else if (empty($password)) {
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header("location: register.php");
        } else if (strlen($_POST['STUDENT_PW']) > 20 || strlen($_POST['STUDENT_PW']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header("location: register.php");
        } else if (empty($c_password)) {
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header("location: register.php");
        } else if ($password != $c_password) {
            $_SESSION['error'] = 'รหัสผ่านไม่ตรงกัน';
            header("location: register.php");
        } else if (empty($sex)) {
            $_SESSION['error'] = 'กรุณาเลือกเพศ';
            header("location: register.php"); 
        } else if (empty($dept)) {
            $_SESSION['error'] = 'กรุณากรอกสาขา';
            header("location: register.php"); 
        } else {
            try {

                $check_log = $conn->prepare("SELECT STUDENT_LOG FROM regis_user WHERE STUDENT_LOG = $username");
                $check_log->execute();
                $row = $check_log->fetch(PDO::FETCH_ASSOC);
                if (isset($row['STUDENT_LOG'])) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='signin.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO regis_user(STUDENT_FNAME, STUDENT_LNAME, STUDENT_LOG, STUDENT_PW, urole, STUDENT_SEX,STUDENT_DEPT) 
                                            VALUES(:firstname, :lastname, :username, :password, :urole, :sex, :dept)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":username", $username);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->bindParam(":sex", $sex);
                    $stmt->bindParam(":dept", $dept);
                    $stmt->execute();
                    $_SESSION['success'] = "สมัครสมาชิกเรียบร้อยแล้ว!";
                    header("location: login.php");
                } else {
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location: index.php");
                }

            } catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }


?>