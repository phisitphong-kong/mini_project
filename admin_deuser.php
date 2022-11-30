<?php 

session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!';
    header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>hotal</title>
    <!-- sweet alert  -->
    <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>
<body>
    <?php
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $admin_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col-md-7"> <br>
                <h3>หน้าสถานะต่างๆ</h3>
               
                <form action="admin_deuser.php" method="post" enctype="multipart/form-data">
                    
                    
                
                <label class="col-2 col-sm-1 col-form-label d-none d-sm-block">ค้นหาข้อมูล</label>
              <div class="col-7 col-sm-5">
               <input type="text" name="q" class="form-control" placeholder="ระบุชื่อสินค้าที่ต้องการค้นหา" value="<?php if (isset($_POST['q'])) { echo $_POST['q'];}?>">
              </div>
              <input type="radio" name="q"  value="ชาย">ชาย
              <input type="radio" name="q"  value="หญิง">หญิง
              <div class="col-2 col-sm-1">   
                <button type="submit" class="btn btn-primary">ค้นหา</button>
                <a  href="admin_deuser.php" class="btn btn-warning">Reset</a>
                </form>
               
        </div>

<?php  if (isset($_POST['q']) && $_POST['q']!='') {
 
 //ประกาศตัวแปรรับค่าจากฟอร์ม
 $q = $_POST['q'];

 //คิวรี่ข้อมูลมาแสดงจากการค้นหา
 $stmt = $conn->prepare("SELECT reserve.room_id,regis_user.STUDENT_LOG,regis_user.STUDENT_FNAME,regis_user.STUDENT_LNAME,regis_user.STUDENT_SEX,regis_user.STUDENT_DEPT,reserve.reserve_date,reserve.reserve_expiredate,admin_add.ROOM_STATUS FROM regis_user
 INNER JOIN reserve ON reserve.student_id = regis_user.STUDENT_ID
 INNER JOIN admin_add ON admin_add.ROOM_ID = reserve.room_id
 WHERE admin_add.ROOM_STATUS = 'จองแล้ว' AND reserve.room_id like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND regis_user.STUDENT_LOG like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND regis_user.STUDENT_FNAME like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND regis_user.STUDENT_LNAME like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND regis_user.STUDENT_SEX like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND regis_user.STUDENT_DEPT like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND reserve.reserve_date like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND reserve.reserve_expiredate like '%$q%' 
 or admin_add.ROOM_STATUS = 'จองแล้ว' AND admin_add.ROOM_STATUS like '%$q%' ");
 
 $stmt->execute();

 $result = $stmt->fetchAll();
}else{
  //คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
 $stmt = $conn->prepare("SELECT reserve.room_id,regis_user.STUDENT_LOG,regis_user.STUDENT_FNAME,regis_user.STUDENT_LNAME,regis_user.STUDENT_SEX,regis_user.STUDENT_DEPT,reserve.reserve_date,reserve.reserve_expiredate,admin_add.ROOM_STATUS FROM regis_user
 INNER JOIN reserve ON reserve.student_id = regis_user.STUDENT_ID
 INNER JOIN admin_add ON admin_add.ROOM_ID = reserve.room_id
 WHERE admin_add.ROOM_STATUS = 'จองแล้ว';");
 $stmt->execute();
 $result = $stmt->fetchAll();
}?>
 <?php 
                
                //แสดงข้อความที่ค้นหา
               if (isset($_POST['q']) && $_POST['q']!='') {
                echo '<font color="red"> ข้อมูลการค้นหา : '.$_POST['q'];
                echo ' *พบ '. $stmt->rowCount().' รายการ</font><br><br>';
               }?>

              


              
                <h3>รายการภาพ </h3>
                <table class="table table-striped  table-hover table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">เลขห้อง</th>
                            <th width="5%">รหัสนิสิต</th>
                            <th width="5%">ชื่อนิสิต</th>
                            
                            <th width="5%">นามสกุลนิสิต</th>
                            <th width="5%">เพศ</th>
                            <th width="5%">สาขา</th>
                            
                            <th width="10%">เวลาที่่จอง</th>
                            <th width="10%">สิ้นสุดการจอง</th>
                            <th width="10%">สถานะ</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //คิวรี่ข้อมูลมาแสดงในตาราง
                       
                        foreach($result as $row) {
                        ?>
                        <tr>
                        <td><?php echo $row['room_id'];?></td>                        
                        <td><?php echo $row['STUDENT_LOG']; ?></td>                     
                        <td><?php echo $row['STUDENT_FNAME']; ?></td>                     
                        <td><?php echo $row['STUDENT_LNAME']; ?></td>                     
                        <td><?php echo $row['STUDENT_SEX']; ?></td>                     
                        <td><?php echo $row['STUDENT_DEPT']; ?></td>                     
                        <td><?php echo $row['reserve_date']; ?></td>                     
                        <td><?php echo $row['reserve_expiredate']; ?></td>
                        
                        <td><?php echo $row['ROOM_STATUS']; ?></td>
                        
                                <br><br>
                               
                                
                        <?php } ?>
                    </tbody>
                </table>
                
                <a href="admin_add.php" class="btn btn-danger btn-sm">ย้อนกลับ</a>
            </div>
        </div>
    </div>
    
</body>
</html>
