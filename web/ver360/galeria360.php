<? header("Access-Control-Allow-Origin: *"); ?>


<? 
   require("connect.php");

if(isset($_GET['code']) &&( $_GET['code']!='') ){
   $code=trim($_GET['code']);

   $query_events ="  SELECT *  FROM  produto360 
    WHERE code='".$_GET['code']."'   ORDER BY pasta DESC LIMIT 1  ";      
$resultado_events = $conn->prepare($query_events);
$resultado_events->execute();
  $count= $resultado_events->rowCount();
 if($count=='0'){
     echo "ERRO AO ACESSAR O LINK ERRO COD 003";
     exit();
 }
while($galeria = $resultado_events->fetch(PDO::FETCH_ASSOC)){               
 
   $pasta='../projeto/'.$galeria['pasta'];   $númerode_fotos=$galeria['fotos'];  
  }
   $linhas= ceil( $númerode_fotos/72);
$ncolunas=$númerode_fotos/$linhas;   ?>



    <script src='code.js' type='text/javascript'></script>
    <script src='jquery.reel.js' type='text/javascript'></script>
    <style>
    #preview-frame {width:100%; }</style>
    
    <!-- Common examples style (gray background, thin fonts etc.) -->
   
<style>.grade { {width:100%; 

} </style>


<div id="preview-frame"   class="grade">
   <img   id="preview-frame" src="<?=$pasta?>/001.jpg"   
      class="reel"
      id="image"
      data-images="<?=$pasta?>/###.jpg"
      data-frames="<?=$ncolunas;?>"
      data-frame="<?=$ncolunas;?>"
      data-rows="<?=$linhas;?>"
      data-row="<?=$linhas;?>"
     >

</div>
<? } ?>