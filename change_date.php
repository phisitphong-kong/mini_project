<?php 
session_start();
require_once 'config/db.php';


if (isset($_SESSION['user_login'])) {
    $user_id = $_SESSION['user_login'];
    $stmt = $conn->query("SELECT * FROM regis_user WHERE STUDENT_ID = $user_id");
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
}

if(isset($_GET['ID'])){
//ประกาศตัวแปรรับค่าจาก param method get
$change = $_GET['ID'];
$stmt = $conn->prepare("DELETE FROM reserve WHERE ID = $change");
$stmt->execute();
header("location: reser_date.php");
}

 //isset*/
?>