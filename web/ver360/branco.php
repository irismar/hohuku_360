<?require 'classes/TutsupRedimensionaImagem.php';
require 'conexao.php';
require 'WideImage.php'
?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Adionar Anúncio</title>
  </head>
  <body><div class="container">
  <!-- Content here -->

    <h1  >Adicionar anuncio procuto 360</h1>
    <form enctype="multipart/form-data" method="POST" >
    <div class="col-8">
    <label for="exampleInputEmail1" class="form-label">Id do Usurio</label>
    <input type="number" class="form-control" name="id_usuario">
    <div id="emailHelp" class="form-text">id do usuario</div>
    </div><div class="col-8">
    <label for="exampleInputEmail1" class="form-label">Id do Anúncio</label>
    <input type="number" class="form-control" name="id_anuncio">
    <div id="emailHelp" class="form-text">Id do anúncio.</div>
  </div>
  <div class="col-8">
  <label for="formFileDisabled" class="form-label">Selecionar arquivos</label>
  <input class="form-control" type="file" name="arquivo[]" multiple="multiple">
  </div>
  <div class="col-8"><br>
  <button type="submit" name="enviar" type="submit" value="Enviar" class="btn btn-primary">Submit</button>
  </div>
</form>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
 
 <?php
 if(isset( $_POST['id_usuario']) && (isset($_POST['id_anuncio'] ))){
     
     $pasta=trim("user".$_POST['id_usuario']."post".$_POST['id_anuncio']);
    if(!is_dir($pasta)){ 
    @mkdir(__DIR__.'/imagens/'.$pasta.'/', 0777, true);
    @mkdir(__DIR__.'/imagens/'.$pasta.'VR2'.'/', 0777, true);
    } else { ?> <div class="col-8">
    <div class="alert alert-primary" role="alert">
 já existe uma pasta para esse anúncio
</div></div>
<? }
//diretório para salvar as imagens
///////verificar se ja existe um post para esse id///////////////////
$id_usuario=$_POST['id_usuario'];
$id_anuncio=$_POST['id_anuncio']; $sql2 ="  SELECT id FROM produto360  WHERE  id_usuario=".$id_usuario."  AND  id_anuncio=".$id_anuncio."   ORDER BY pasta DESC  ";  
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
 <a href="<?=$_SERVER['SERVER_NAME']?>/ver360/galeria360.php?code=<?=$code;?>"> acessar galeria</a> </div></div>
<?
$diretorio = "imagens/";
////criar posta 
//Verificar a existência do diretório para salvar as imagens e informa se o caminho é um diretório
  
    $arquivo = isset($_FILES['arquivo']) ? $_FILES['arquivo'] : FALSE;
    //loop para ler as imagens
    for ($controle = 0; $controle < count($arquivo['name']); $controle++){    
      if(    ($controle <= 36 )){ 
        echo "sou Coluna1";

      }
      if(    ($controle > 36 ) && ($controle <= 72)){ 
        echo "sou Coluna2";

      }
      if(    ($controle > 72 )){ 
        echo "sou Coluna3";

      }
      


        $tipo=str_replace('image/', '', $arquivo['type'] );
        if( $controle < 9){      
          $endereco= $diretorio."/".'00'.($controle+1).".".$tipo[$controle];
          $foto= $endereco= '00'.($controle+1).".".$tipo[$controle];
          $foto2= $endereco= 'eu_sou_foto2.00'.($controle+1).".".$tipo[$controle];
          }          
          elseif(  ($controle =='9') OR  ($controle < 99 )){ 
                $endereco= $diretorio."/".'0'.($controle+1).".".$tipo[$controle];
                $foto='0'.($controle+1).".".$tipo[$controle];
                $foto2='eu_sou_foto2.0'.($controle+1).".".$tipo[$controle];
              
            } else{ 
                $endereco= $diretorio."/".($controle+1).".".$tipo[$controle];
                $foto=($controle+1).".".$tipo[$controle]; 
                $foto2=($controle+1)."eu_sou_foto2.".$tipo[$controle]; 
               }   
        $destino =  $endereco;            
       //realizar o upload da imagem em php
      //move_uploaded_file — Move um arquivo enviado para uma nova localização
  
      if(move_uploaded_file($arquivo['tmp_name'][$controle], $destino)){  
        $caminho_imagem =  $endereco;
        $image = WideImage::load($caminho_imagem);
        $resized = $image->resize(500, 400, true);       
        $resized->saveToFile($diretorio.$pasta.'/'.$foto);  
        
        $caminho_imagem =  $endereco;
        $image = WideImage::load($caminho_imagem);
        $resized = $image->resize(500, 400, true);       
        $resized->saveToFile($diretorio.$pasta.'VR2'.'/'.$foto2);   
$caminho_nova_imagem1 = $diretorio.$pasta.'/'.$foto;





//////////////////////////////////////fim////////////////////////////////////
// Cria a imagem e sobrescreve a original?>
<div class="card" style="width: 18rem;">
  <img src="<?=$caminho_nova_imagem1?>" class="card-img-top" alt="...">
  <div class="card-body">
  
  
    <p class="card-text"><?=$caminho_nova_imagem1;?></p>
   
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