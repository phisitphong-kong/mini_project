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
$id = $_GET['ROOM_ID'];
$stmt = $conn->prepare("DELETE FROM admin_add WHERE ROOM_ID=$id");
$stmt->execute();

//  sweet alert 
echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  if($stmt->rowCount() ==1){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ลบข้อมูลสำเร็จ",
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
$conn = null;
} //isset*/
?>