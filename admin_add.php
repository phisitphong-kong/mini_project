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
                <h3>หน้าแอดมิน</h3>
                <a href="admin_status.php">สถานะ</a>
                <a href="admin_deuser.php">รายละเอียดนิสิต</a>
                <form action="admin_add_db.php" method="post" enctype="multipart/form-data">
                    <input type="radio" name="ROOM_DETAIL"  value="ชาย">ชาย
                    <input type="radio" name="ROOM_DETAIL"  value="หญิง">หญิง
                    <input type="text" name="detail"  placeholder="รายละเอียด">
                    <input type="text" name="ROOM_PRICE"  placeholder="ราคาต่อเดือน">
                    
                    <font color="red">*อัพโหลดได้เฉพาะ .jpeg , .jpg , .png </font>
                    <input type="file" name="img_file" required   class="form-control" accept="image/jpeg, image/png, image/jpg"> <br>
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
                <h3>รายการภาพ </h3>
                <table class="table table-striped  table-hover table-responsive table-bordered">
                    <thead>
                        <tr>
                            <th width="5%">ลำดับ</th>
                            
                            <th width="5%">ประเภทหอ</th>
                            <th width="5%">รายละเอียด</th>
                            <th width="5%">ราคา</th>
                            
                            <th width="10%">ภาพ</th>
                            <th width="10%">สถานะ</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //คิวรี่ข้อมูลมาแสดงในตาราง
                       
                        $stmt = $conn->prepare("SELECT* FROM admin_add WHERE ROOM_STATUS = 'ว่าง'");
                        $stmt->execute();
                        $result = $stmt->fetchAll();
                        foreach($result as $k) {
                        ?>
                        <tr>
                            <td><?= $k['ROOM_ID'];?></td>
                            <td><?= $k['ROOM_DETAIL'];?></td>
                            <td><?= $k['detail'];?></td>
                            <td><?= $k['ROOM_PRICE'];?></td>
                            <td><img src="upload/<?= $k['img_file'];?>" width="70px"></td>
                            <td><?= $k['ROOM_STATUS'];?></td>
                            <td><a href="admin_edit.php?ROOM_ID=<?= $k['ROOM_ID']; $_SESSION['id'] = $k['ROOM_ID']?>" class="btn btn-warning btn-sm">แก้ไข</a></td>
                                <td><a href="admin_del.php?ROOM_ID=<?= $k['ROOM_ID']; $_SESSION['id'] = $k['ROOM_ID']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบข้อมูล !!');">ลบ</a></td>
                                
                        <?php } ?>
                    </tbody>
                </table>
                
                <a href="logout.php" class="btn btn-danger btn-sm">log out</a>
            </div>
        </div>
    </div>
    
</body>
</html>
