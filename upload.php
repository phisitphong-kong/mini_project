<?php 

    session_start();
    require_once 'config/db.php';

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <title>Basic Upload PHP PDO by devbanban.com 2021</title>
        <!-- sweet alert  -->
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
    </head>
    <body>
        
        <div class="container">
            <div class="row">
                <div class="col-md-7"> <br>
                    <h3>PHP PDO Basic Upload Image File</h3>
                    <form action="cona.php" method="post" enctype="multipart/form-data">
                        <input type="text" name="img_name" required class="form-control" placeholder="ชื่อภาพ"> <br>
                         <font color="red">*อัพโหลดได้เฉพาะ .jpeg , .jpg , .png </font>
                        <input type="file" name="img_file" required   class="form-control" accept="image/jpeg, image/png, image/jpg"> <br>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    <h3>รายการภาพ </h3>
                    <table class="table table-striped  table-hover table-responsive table-bordered">
                        <thead>
                            <tr>
                                <th width="5%">ลำดับ</th>
                                <th width="65%">ชื่อภาพ</th>
                                <th width="30%">ภาพ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //คิวรี่ข้อมูลมาแสดงในตาราง
                           
                            $stmt = $conn->prepare("SELECT* FROM tbl_uploads");
                            $stmt->execute();
                            $result = $stmt->fetchAll();
                            foreach($result as $k) {
                            ?>
                            <tr>
                                <td><?= $k['no'];?></td>
                                <td><?= $k['img_name'];?></td>
                                <td><img src="upload/<?= $k['img_file'];?>" width="70px"></td>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br>
                    <center>Basic Upload PHP PDO by devbanban.com 2021</center>
                </div>
            </div>
        </div>
        
    </body>
</html>
