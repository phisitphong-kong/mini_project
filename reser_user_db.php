<?php 

    session_start();
    require_once 'config/db.php';

    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $user_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
   
   $depo = $_SESSION['deposit'];
   $detail = $_SESSION['detail'];
   $room_id = $_SESSION['room_id'];
   
   $date1 = date("Ymd_His");
   //สร้างตัวแปรสุ่มตัวเลขเพื่อเอาไปตั้งชื่อไฟล์ที่อัพโหลดไม่ให้ชื่อไฟล์ซ้ำกัน
   $numrand = (mt_rand());
   $img_file = (isset($_POST['img_file']) ? $_POST['img_file'] : '');
   $upload=$_FILES['img_file']['name'];

   //มีการอัพโหลดไฟล์
   if($upload !='') {
   //ตัดขื่อเอาเฉพาะนามสกุล
   $typefile = strrchr($_FILES['img_file']['name'],".");

   //สร้างเงื่อนไขตรวจสอบนามสกุลของไฟล์ที่อัพโหลดเข้ามา
   if($typefile =='.jpg' || $typefile  =='.jpeg' || $typefile  =='.png'){

   //โฟลเดอร์ที่เก็บไฟล์
   $path="upload/";
   //ตั้งชื่อไฟล์ใหม่เป็น สุ่มตัวเลข+วันที่
   $newname = $numrand.$date1.$typefile;
   $path_copy=$path.$newname;
   //คัดลอกไฟล์ไปยังโฟลเดอร์
   move_uploaded_file($_FILES['img_file']['tmp_name'],$path_copy); 

   
    //ไฟล์เชื่อมต่อฐานข้อมูล
    
    //sql insert
    $stmt = $conn->prepare("INSERT INTO reservedetail
    (
      deposit,
      description,
      img_file,
      room_id

    )
    VALUES
    (
    '$depo',
    '$detail',
    '$newname',
    '$room_id'
    )
    ");
    $result = $stmt->execute();
    
    echo '
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

  if($stmt->rowCount() ==1){
        echo '<script>
             setTimeout(function() {
              swal({
                  title: "ชำระเงินเรียบร้อย",
                  type: "success"
              }, function() {
                  window.location = "reser_date.php"; //หน้าที่ต้องการให้กระโดดไป
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
                  window.location = "reser_user.php"; //หน้าที่ต้องการให้กระโดดไป
              });
            }, 1000);
        </script>';
    }
  }}
    $mysql = $conn->prepare("SELECT* FROM reservedetail WHERE ROOM_ID=$room_id");
    $mysql->execute();
    $my = $mysql->fetch(PDO::FETCH_ASSOC);
    $_SESSION['reserve_id'] = $my['reserve_id'];


    if(isset($_GET['ROOM_ID'])){
      $room_id = $_GET['ROOM_ID'];
      $stmt = $conn->prepare("SELECT* FROM admin_add WHERE ROOM_ID=$room_id");
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      //ถ้าคิวรี่ผิดพลาดให้กลับไปหน้า index

      if($stmt->rowCount() < 1){
          header('Location: admin_add.php');
          exit();
      }
    }
    $dol = $conn->prepare("UPDATE admin_add  SET ROOM_STATUS= 'จองแล้ว' WHERE ROOM_ID = $room_id;");
    $dol->execute();
    
 
    ?>