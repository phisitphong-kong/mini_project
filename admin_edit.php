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
  </head>
  <body>
    <?php
    if(isset($_GET['ROOM_ID'])){
      
      $stmt = $conn->prepare("SELECT* FROM admin_add WHERE ROOM_ID=?");
      $stmt->execute([$_GET['ROOM_ID']]);
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      //ถ้าคิวรี่ผิดพลาดให้กลับไปหน้า index
      if($stmt->rowCount() < 1){
          header('Location: admin_add.php');
          exit();
      }
    }//isset
    ?>
    <?php
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $sql = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $admin_id");
        $sql->execute();
        $mysql = $sql->fetch(PDO::FETCH_ASSOC);
    }
    ?>
    <div class="container">
      <div class="row">
        <div class="col-md-4"> <br>
          <h4>ฟอร์มแก้ไขข้อมูล</h4>
          <form action="admin_edit_db.php" method="post">
            <div class="mb-1">
              <label for="name" class="col-sm-2 col-form-label"> ประเภท ชาย/หญิง :  </label>
              <div class="col-sm-10">
                <input type="text" name="ROOM_DETAIL" class="form-control" required value="<?= $row['ROOM_DETAIL'];?>" minlength="3">
              </div>
            </div>
            <div class="mb-1">
              <label for="name" class="col-sm-2 col-form-label"> รายละเอียด :  </label>
              <div class="col-sm-10">
                <input type="text" name="detail" class="form-control" required value="<?= $row['detail'];?>" minlength="3">
              </div>
            </div>
            <div class="mb-1">
              <label for="name" class="col-sm-2 col-form-label"> ราคา :  </label>
              <div class="col-sm-10">
                <input type="text" name="ROOM_PRICE" class="form-control" required value="<?= $row['ROOM_PRICE'];?>" minlength="3">
              </div>
            </div>
            
            <input type="hidden" name="ROOM_ID" value="<?= $row['ROOM_ID'];?>">
            <input type="hidden" name="img_file" value="<?= $row['img_file'];?>">
            <button type="submit" class="btn btn-primary">แก้ไขข้อมูล</button>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>