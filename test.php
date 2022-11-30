<?php
session_start();
require_once 'config/db.php';?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href='test.css'>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="popup" onclick="myFunction()"><button>Click me!</button> 
  <span class="popuptext" id="myPopup">Popup text...</span>
</div>
    
    <?php
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
    }//isset
    echo 'a='.$room_id;
    ?>
    
    <h3>correct</h3>
</body>
</html>