<?php 

    session_start();
    require_once 'config/db.php';

    
    if (isset($_SESSION['user_login'])) {
        $user_id = $_SESSION['user_login'];
        $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $user_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
    }
   if(empty($_POST['reser_date'])){
    echo '
       <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
   
    echo '<script>
                setTimeout(function() {
                 swal({
                     title: "กรุณากรอกวัน",
                     type: "error"
                 }, function() {
                     window.location = "reser_date.php"; //หน้าที่ต้องการให้กระโดดไป
                 });
               }, 1000);
           </script>';

   }
   else{
   $reser_date = $_POST['reser_date'];
   $reser_end = date ("Y-m-d", strtotime("+30 day", strtotime($reser_date)));

   if(isset($_SESSION['reserve_id'])){
    $reser_id = $_SESSION['reserve_id'];
    $no = $conn->query("SELECT reservedetail.reserve_id,admin_add.ROOM_ID,admin_add.ROOM_STATUS
                          FROM reservedetail 
                          INNER JOIN admin_add ON reservedetail.room_id = admin_add.ROOM_ID
                          WHERE reservedetail.reserve_id = $reser_id;");
    $no->execute();
    $dno = $no->fetch(PDO::FETCH_ASSOC);
    $reser_id = $dno['reserve_id'];
    $room_id = $dno['ROOM_ID'];
    $status = $dno['ROOM_STATUS'];

    //ไฟล์เชื่อมต่อฐานข้อมูล
    
    //sql insert
    $sql = $conn->query("INSERT INTO reserve
    (
      reserve_id,
      reserve_date,
      reserve_expiredate,
      reserve_status,
      student_id,
      room_id

    )
    VALUES
    (
    '$reser_id',
    '$reser_date',
    '$reser_end',
    '$status',
    '$user_id',
    '$room_id'   
    )
    ");
   }
       echo '
       <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
   
     if($sql->rowCount() ==1){
           echo '<script>
                setTimeout(function() {
                 swal({
                     title: "จองวันสำเร็จ",
                     type: "success"
                 }, function() {
                     window.location = "detail_user.php"; //หน้าที่ต้องการให้กระโดดไป
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
                     window.location = "reser_date.php"; //หน้าที่ต้องการให้กระโดดไป
                 });
               }, 1000);
           </script>';
       }}
   
    ?>