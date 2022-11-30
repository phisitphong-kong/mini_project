<?php 

session_start();
require_once 'config/db.php';
class room{

if (isset($_POST['img_name'])) {
    
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
    $img_name = $_POST['img_name'];
    
    //sql insert
    $stmt = $conn->prepare("INSERT INTO tbl_uploads (img_name, img_file)
    VALUES ('$img_name', '$newname')");
    
    $result = $stmt->execute();
    //เงื่อนไขตรวจสอบการเพิ่มข้อมูล
          
    }
    } // if($upload !='') {

    $conn = null; //close connect db
    } //isset
}
?>
