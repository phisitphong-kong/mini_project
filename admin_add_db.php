<?php 

    session_start();
    require_once 'config/db.php';
    
    if (isset($_SESSION['admin_login'])) {
        $admin_id = $_SESSION['admin_login'];
        $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $admin_id");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
        
         //สร้างตัวแปรวันที่เพื่อเอาไปตั้งชื่อไฟล์ใหม่
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
    
         //ประกาศตัวแปรรับค่าจากฟอร์ม
        $type_room = $_POST['ROOM_DETAIL'];
        $detail = $_POST['detail'];
        $price = $_POST['ROOM_PRICE'];
        $status = "ว่าง";
        
        //sql insert
        $stmt = $conn->prepare("INSERT INTO admin_add (ROOM_DETAIL,detail,ROOM_PRICE, img_file, ROOM_STATUS)
        VALUES ('$type_room','$detail','$price', '$newname', '$status')");
        
        
        //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
        $result = $stmt->execute();
        }
        } // if($upload !='') {
    
        $conn = null; //close connect db
        //isset
        header("location: admin_add.php")
    ?>



