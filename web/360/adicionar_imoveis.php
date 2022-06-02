
<? 

session_start();

///var_dump($_GET);

if(isset($_SESSION['id'])){ 

if(isset($_POST['acao'])){

//var_dump($_SESSION);

///var_dump($_POST);

$dbname = "360";

$host="mysql873.umbler.com";

$user="360";

$pass="irisMAR100";

$agora = date('Y/m/d H:i:s');



//Conexao com a porta

$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);

 function random_str(

  int $length = 64,

  string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'

): string {

  if ($length < 1) {

      throw new \RangeException("Length must be a positive integer");

  }

  $pieces = [];

  $max = mb_strlen($keyspace, '8bit') - 1;

  for ($i = 0; $i < $length; ++$i) {

      $pieces []= $keyspace[random_int(0, $max)];

  }

  return implode('', $pieces);

}

$code = random_str(12);
$imovel="imovel";
///$codeurl='https://anuncio360.com/projeto/galeria360.php?code='.$code;

    $query_produto = "INSERT INTO produtos (titulo,preco,descricao,endereco,lat,log,id_anunciante,data,telefone,code,avatar,nome_anunciante,categoria)
                                        VALUES (:titulo,:preco,:descricao,:endereco,:lat,:log,:id_anunciante,:data,:telefone,:code,:avatar,:nome_anunciante,:categoria)";

    $cad_produto = $conn->prepare($query_produto);
    $cad_produto->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
    $cad_produto->bindParam(':preco', $_POST['preco'], PDO::PARAM_STR);
    $cad_produto->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);

    /////prencher dads gerais ////////////////////////////////////////////////
    $cad_produto->bindParam(':endereco', $_POST['endereco'], PDO::PARAM_STR);
    $cad_produto->bindParam(':lat', $_POST['lat'], PDO::PARAM_STR);
    $cad_produto->bindParam(':log', $_POST['log'], PDO::PARAM_STR);
    $cad_produto->bindParam(':id_anunciante', $_SESSION['id'], PDO::PARAM_STR);
    $cad_produto->bindParam(':data', $agora, PDO::PARAM_STR);
    $cad_produto->bindParam(':telefone', $_SESSION['telefone'], PDO::PARAM_STR);
    $cad_produto->bindParam(':code', $code, PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':avatar', $_SESSION['foto_perfil'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':nome_anunciante',  $_SESSION['nome'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':categoria', $imovel, PDO::PARAM_STR); ////id_anunciante
    //$cad_produto->bindParam(':urlcode', $codeurl, PDO::PARAM_STR); ////id_anunciante

    $cad_produto->execute(); 

    $id_anuncio=trim($conn->lastInsertId()); // returns last ID

    if($cad_produto->rowCount()){
  
      ////////////////// povoar banco de dados imovel  
      $query_imovel = "INSERT INTO imovel (tipo_negocio_imovel,tipo_imovel,aceita_pet,quartos,banheiros,garagem,terreno,construcao,id_anuncio)
                                     VALUES (:tipo_negocio_imovel,:tipo_imovel,:aceita_pet,:quartos,:banheiros,:garagem,:terreno,:construcao,:id_anuncio)";

      $cad_imovel = $conn->prepare($query_imovel);
      $cad_imovel->bindParam(':tipo_negocio_imovel', $_POST['tipo_negocio_imovel'], PDO::PARAM_STR); ////id_anunciante
      $cad_imovel->bindParam(':tipo_imovel', $_POST['tipo_imovel'], PDO::PARAM_STR); ////id_anunciante
      $cad_imovel->bindParam(':aceita_pet', $_POST['aceita_pet'], PDO::PARAM_STR); ////id_anunciante
      $cad_imovel->bindParam(':quartos', $_POST['quartos'], PDO::PARAM_STR); ////id_anunciante
      $cad_imovel->bindParam(':banheiros', $_POST['banheiros'], PDO::PARAM_STR); ////garagem
      $cad_imovel->bindParam(':garagem', $_POST['garagem'], PDO::PARAM_STR); ////garagem
      $cad_imovel->bindParam(':terreno', $_POST['terreno'], PDO::PARAM_STR); ////garagem
      $cad_imovel->bindParam(':construcao', $_POST['construcao'], PDO::PARAM_STR); ////garagem
      //$cad_imovel->bindParam(':fotos_enviadas', $fotos_enviadas, PDO::PARAM_STR); ////garagem
      $cad_imovel->bindParam(':id_anuncio', $id_anuncio, PDO::PARAM_STR); ////garagem
      $cad_imovel->execute(); 
      $id_imovel=$conn->lastInsertId(); // returns last ID  
      if($cad_imovel->rowCount()){ ///////////////////////////////////////////// 
     $codeurl="https://www.anuncio360.com/img/logo_sem_fortos.gif";  
        $stmt = $conn->prepare('UPDATE produtos  SET urlcode="'.$codeurl.'" WHERE id= :id');
        $stmt->execute(array( ':id'=>$id_anuncio ));
        /////CRIAR PASTA PRA GUARDAR FOTOS 360///////

     echo    $pasta="./imob/".trim($_SESSION['id'])."/".trim($id_anuncio);
        if(!is_dir($pasta)){ 

            mkdir(__DIR__.$pasta.'/', 0777, true);
        
        
        
      echo       $pasta="./imob/".trim($_SESSION['id'])."/".trim($id_anuncio);
        
        if (!is_dir($pasta)) {
        
            mkdir($pasta, 0777, true);
        
        } } 
         

        /////////////////////////////////////////////
        //header('Location: https://anuncio360.com/'.$id_anuncio);
    	echo "tudo certo jão";
        exit();
       } else { echo    $erro ="erro cadastrar Babco 2";}
    }else{
     echo    $erro ="erro ao cadastrar Banco 1";  }
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
    <head>
    <meta property="og:site_name" content="sitename" />
    <meta property="og:title" content="Anuncio360">
    <meta property="og:description" content="Anúncio interrativo em fotos 360 graus">
    <meta property="og:image" itemprop="image" content="https://www.anuncio360.com/img/logo_login.png">
    <link itemprop="thumbnailUrl" href="https://www.anuncio360.com/img/logo_50.png"> 
    <meta property="og:image:type" content="image/png">
    <meta property="og:updated_time" content="updatedtime">
    <meta property="og:locale" content="pt-br" />
    <meta property="og:url" content="https://anuncio360.com">
    <meta property="og:type" content="website" />
    <meta property="og:image:width" content="300" />
    <meta property="og:image:height" content="300" />  
<title>Anuncio 360.com</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<meta name="description" content="Anúncio interrativo em fotos 360 graus" />
<meta name="keywords" content="anuncio interativo"/>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Language" content="pt-br">
<!--  Infinite scrolling is based on the JQuery library and a custom jquery script , include these files -->
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
<link rel="icon" href="../img/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js"></script>       
<style>@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap');</style> 
<link rel="stylesheet" type="text/css"  href="https://www.anuncio360.com/360/styles.css" />
    </head>
    <body>
    
          <div class="caixa_centro">
<form action="?acao=cadastro" method="post">
    	<div  class="cadastro_produto">
<div class="login">   	
<div class="topo_nome_login"> <label>Titulo Anuncio</label></label> <input type="text" name="titulo" class="search-box_cadastro"  placeholder="Nome Usuario"> </div> 
<div class="topo_nome_login"> <label>Endereço</label></label> <input id="searchTextField" type="text" name="endereco" class="search-box_cadastro" value="<?=$endereco;?>"  placeholder="Endereço"> </div> 
<div class="topo_nome_caixa">        

        <legend>Tipo de Negocio </legend>   </br> 
        <input class=" " type="radio" name="tipo_negocio_imovel" value="Venda">Venda </br></br>
        <input class="" type="radio" name="tipo_negocio_imovel" value="Alugel">Alugel<br>

</div>
<div class="topo_nome_caixa">  

        </br></br>

        <legend>Tipo de imóvel  </legend>   </br>   

        <input class=" " type="radio" name="tipo_imovel" value="Casa">Casa  </br></br>      

        <input class="" type="radio" name="tipo_imovel" value="Apartamento">Apartamento<br> </br> 

        <input class="" type="radio" name="tipo_imovel" value="Ponto Comercial">Ponto Comercial <br></br>  

        <input class="" type="radio" name="tipo_imovel" value="Sala escritório">Sala escritório <br></br>  

        <input class="" type="radio" name="tipo_imovel" value="Chácara sitio">Chácara sitio <br></br> 

        <input class="" type="radio" name="tipo_imovel" value="Galpão industria">Galpão industria <br>     
</div>

<div class="topo_nome_caixa"> 
           </br></br>
        <legend>Aceita PETS </legend></br> 
        <input class=" " type="radio" name="aceita_pet" value="Sim">Sim  </br></br>
        <input class="" type="radio" name="aceita_pet" value="Não">Não<br>  
</div>
 




<div class="topo_nome_login"> <label>Número De Quartos</label>
     <select class="search-box_cadastro" name="quartos">
<<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
</select>
     </div> 
     <div class="topo_nome_login"> <label>Número De Banheiros</label>
     <select class="search-box_cadastro" name="banheiros">
<<option value="1">1</option>
<option value="2">2</option>
<option value="3">3</option>
<<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
</select>
     </div>      

<div class="topo_nome_login"> <label>Vagas Garagem </label>
     <select class="search-box_cadastro" name="garagem">
<option value="1">1</option>
<option value="2">2</option>
<option value="+2">+2</option>
<option value="0">sem Vagas</option>
</select>
     </div>

<div class="topo_nome_login"> <label>Área Terreno   </label></label> <input type="number"  name="terreno" class="search-box_cadastro  "  placeholder="Área do Terreno"> </div> 
<div class="topo_nome_login"> <label>Área Construida   </label></label> <input type="number"  name="construcao" class="search-box_cadastro  "  placeholder="Área da Construção"> </div> 




 <input type="hidden"  value="<?=$endereco;?>"id="city2" name="city2" />

 <input type="hidden"  value="<?=$latitude;?>" id="cityLat" name="lat" />

 <input type="hidden"  value="<?=$longitude;?>" id="cityLng" name="log" />     

      <div class="topo_nome_login"> <label>Preço   </label></label> <input type="tel" id="preco" name="preco" class="search-box_cadastro dinheiro "  placeholder="Nome Usuario"> </div> 
      <div class="topo_nome_login"> <label>Descrição Fale sobre imóvel numero de quatos garagem... deixe que nossa IA classificarar o anuncio</label></label> <textarea id="w3review" name="descricao"  class="search-box_text_area" >
</textarea></div> 
       <script type="text/javascript">

    $('.dinheiro').mask('0.000.000.000,00', {reverse: true});

   

 </script>

               

            



              <? if(isset($erro)){ ?>

                    <div class="caixa_erro_login"><a href="#"><?php echo$erro;?></a></div>



                    

             <? } ?>

                 

                

                 

                  <input type=submit name="acao" class="salvar" value="Cadastrar">

                





                 



</div>







    	</div>



 </form> 

    </div>



</body>

</html>





<?



	

} else{echo 'eu não esou logado';

header('Location: https://www.anuncio360.com/entrar');

} ?>

</body>

</html>

 <script>











   $(function(){

$(".search-box").keyup(function() 

{ 

var searchid = $(this).val();

var dataString = 'search-box='+ searchid;

if(searchid!='')

{

    $.ajax({

    type: "POST",

    url: "../busca/proc_pesq_msg.php",  

    async : true,

    data: dataString,

    cache: false,

    success: function(html)

    {

    $("#result").html(html).show();

    }

    });

}return false;    

});







$('#searchid').click(function(){

    jQuery("#result").fadeIn();

});

});







   /////////////////////////////////////////////////////////



  

$(window).scroll(function(){

        

        

        if($(document).scrollTop() > 600){// se a rolagem passar de 200px esconde o elemento

        

            $('#exibir').fadeOut(); // Esconde usando fadeOut

            

        } else { // senão ele volta a ser visivel

        

            $('#exibir').fadeIn(); // Mostra usando fadeIn

            

        }

        

    });





</script>   

</html>