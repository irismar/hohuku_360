<?php
  $img_r = imagecreatefromjpeg($_GET['img']);
  $dst_r = ImageCreateTrueColor( $_GET['w'], $_GET['h'] );
 
  imagecopyresampled($dst_r, $img_r, 0, 0, $_GET['x'], $_GET['y'], $_GET['w'], $_GET['h'], $_GET['w'],$_GET['h']);
  
 /// header('Content-type: image/jpeg');
 //var_dump( imagejpeg($dst_r));


  
  exit();

?>   <img src="<?=$_GET['img'];?>" alt="">
  <a href=""></a>