<?require 'classes/TutsupRedimensionaImagem.php';
require 'conexao.php';
require 'WideImage.php'
?>

 <?php
 if(isset( $_POST['id_usuario']) && (isset($_POST['id_anuncio'] ))){
     
     $pasta=trim($_POST['id_usuario']."/".$_POST['id_anuncio']);
    if(!is_dir($pasta)){ 
    @mkdir(__DIR__.'/imagens/'.$pasta.'/', 0777, true);
    @mkdir(__DIR__.'/imagens/'.$pasta.'VR2'.'/', 0777, true);
    } else { ?> 
   
<? }
//diretório para salvar as imagens
///////verificar se ja existe um post para esse id///////////////////
$id_usuario=$_POST['id_usuario'];
$id_anuncio=$_POST['id_anuncio'];
$sql2 ="  SELECT id FROM produto360  WHERE  id_usuario=".$id_usuario."  AND  id_anuncio=".$id_anuncio."   ORDER BY pasta DESC  ";  
$resultado_2 = $conn->prepare($sql2);
$resultado_2->execute();
 $count2 = $resultado_2->rowCount();
     
   if(  $count2 !=0){
    ?> <div class="col-8">
    <div class="alert alert-primary" role="alert">
 já existe Anuncio cadastrado para esse Id
</div></div>
<?  exit();  
}
$code=uniqid();
$stmt = $conexao->prepare("INSERT INTO  produto360(id_usuario,id_anuncio,pasta,code) VALUES (?,?,?,?)");
$stmt->bindParam(1, $_POST['id_usuario']);
$stmt->bindParam(2, $_POST['id_anuncio']);
$stmt->bindParam(3,  $pasta);
$stmt->bindParam(4,  $code );
$stmt->execute(); ?>
<div class="col-8">
    <div class="alert alert-primary" role="alert">
 <a href="http://localhost/ver360/galeria360.php?code=<?=$code;?>"> acessar galeria</a> </div></div>
<?
$diretorio = "imagens/";
////criar posta 
//Verificar a existência do diretório para salvar as imagens e informa se o caminho é um diretório
  
    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
    //loop para ler as imagens
    $tipo=str_replace('image/', '', $arquivo['type'] );
    for ($controle = 0; $controle < count($arquivo['name']); $controle++){    
      
      
        if( $controle < 9){      
          $endereco= $diretorio."/".'00'.($controle+1).".".$tipo[$controle];
          $foto= $endereco= '00'.($controle+1).".".$tipo[$controle];
        
          }          
          elseif(  ($controle =='9') OR  ($controle < 99 )){ 
                $endereco= $diretorio."/".'0'.($controle+1).".".$tipo[$controle];
                $foto='0'.($controle+1).".".$tipo[$controle];
              
              
            } else{ 
                $endereco= $diretorio."/".($controle+1).".".$tipo[$controle];
                $foto=($controle+1).".".$tipo[$controle]; 
             
               }   
        $destino =  $endereco;            
       //realizar o upload da imagem em php
      //move_uploaded_file — Move um arquivo enviado para uma nova localização
  
      if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){  
        $caminho_imagem =  $endereco;
        $image = WideImage::load($caminho_imagem);
     // $resized = $image->crop($_POST['x'], $_POST['y'], $_POST['w'],$_POST['h']);//->resize(640, 480, true);
        $resized = $image->resize(848, 848, true);//->rotate(-90);       
        $resized->saveToFile($diretorio.$pasta.'/'.$foto);  
       $caminho_nova_imagem3 =$diretorio.$pasta.'/'.$foto;  
        
        $caminho_imagem =  $endereco;
       $image = WideImage::load($caminho_imagem);
       $resized = $image->resize(848, 848, true);//->rotate(-90);  
      // $resized = $image->crop($_POST['x'], $_POST['y'], $_POST['w'],$_POST['h'])->resize(640, 480, true);
        $resized->saveToFile($diretorio.$pasta.'VR2'.'/'.$foto2);   
        $caminho_nova_imagem1 =$diretorio.$pasta.'VR2'.'/'.$foto2;  





//////////////////////////////////////fim////////////////////////////////////
// Cria a imagem e sobrescreve a original?>
<div class="card" style="width: 100px;">
 
  <div class="card-body">
  
  <img scr="<?="http://192.168.0.102/ver360".$caminho_nova_imagem3;?>">
    <p class="card-text"><?=$caminho_nova_imagem3;?></p>
   
  </div>
</div>
<?

$stmt = $conexao->prepare('UPDATE produto360  SET fotos=fotos+1 WHERE code= :code');
$stmt->execute(array( ':code'=>$code ));  
  
unlink($caminho_imagem );

       
      }else{
        
      }        
    
} }
?>
 </div></body>
</html>