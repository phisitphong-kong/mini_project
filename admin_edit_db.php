<?php
session_start();
require_once 'config/db.php';
 //ถ้ามีค่าส่งมาจากฟอร์ม
 if (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $admin_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_POST['ROOM_ID']) && isset($_POST['ROOM_DETAIL']) && isset($_POST['detail']) && isset($_POST['ROOM_PRICE'])) {
    //ไฟล์เชื่อมต่อฐานข้อมูล
    
//ประกาศตัวแปรรับค่าจากฟอร์ม
$add_id = $_POST['ROOM_ID'];
$type_room = $_POST['ROOM_DETAIL'];
$detail = $_POST['detail'];
$price = $_POST['ROOM_PRICE'];
//sql update
$stmt = $conn->prepare("UPDATE  admin_add SET ROOM_DETAIL='$type_room', detail='$detail', ROOM_PRICE='$price' WHERE ROOM_ID=$add_id");
$stmt->execute();

// sweet alert 
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

 if($stmt->rowCount() >= 0){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "แก้ไขข้อมูลสำเร็จ",
                  type: "success"
              }, function() {
                  window.location = "admin_add.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }else{
       echo '<script>
             setTimeout(function() {
              swal({
                  title: "เกิดข้อผิดพลาด",
                  type: "error"
              }, function() {
                  window.location = "admin_add.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
$conn = null; //close connect db
} //isset
?>