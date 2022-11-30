<?php 
session_start();
require_once 'config/db.php';

if (isset($_SESSION['admin_login'])) {
    $admin_id = $_SESSION['admin_login'];
    $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $admin_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}


if(isset($_GET['ROOM_ID'])){

//ประกาศตัวแปรรับค่าจาก param method get
$add_id = $_GET['ROOM_ID'];
$status = 'ว่าง';
//sql update
$stmt = $conn->prepare("UPDATE  admin_add SET ROOM_STATUS = '$status'  WHERE ROOM_ID='$add_id'");
$stmt->execute();
$do = $conn->prepare("DELETE FROM reserve WHERE room_id=$add_id");
$do->execute();
//  sweet alert 
echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  if($stmt->rowCount() ==1 && $do->rowCount() ==1){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ยกเลิกข้อมูลสำเร็จ",
                  type: "success"
              }, function() {
                  window.location = "admin_status.php"; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "admin_status.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
$conn = null;
} //isset*/
?>