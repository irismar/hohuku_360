<?php 
function formata_data_br_time($data) { 
	if ($data == "") return ""; 
		$corrige = explode("-",$data);
		$ano = explode(" ",$corrige[2]);
		$corrige = $ano[0]."/".$corrige[1]."/".	$corrige[0]." - ".$ano[1]; 
		return $corrige; 
	}
    function diasDatas($dtInicio) {
       

$dtFim = date('Y/m/d H:i:s');

$tsDiff = strtotime($dtFim) -strtotime($dtInicio);

$quantidadeDias =  $tsDiff /86400; // 86400 quantidade de segundos em um dia
if( $quantidadeDias < 1){
    $quantidadeDias= $quantidadeDias*24;
    $quantidadeDias=floor($quantidadeDias). " " ."Horas";
} else{
if( $quantidadeDias > 1 && $quantidadeDias < 2  ){
   
    $quantidadeDias="ontem";
} else{ 
/////////////////if dias/////////////
if( $quantidadeDias > 2 && $quantidadeDias < 7  ){
   
    $quantidadeDias=floor($quantidadeDias)." "."Dias";
} else {      $quantidadeDias="+ de 1 Semana "; }

////// mais de 1 semana ////////////
}
} 
return $quantidadeDias; // 31


    } 
session_start();       
error_reporting(0) ;
if($_GET['lastComment']){
set_exception_handler('exception_handler') ;
$config = parse_ini_file("config/my.ini") ;
$db=new mysqli($config['dbLocation'] , $config['dbUser'] , $config['dbPassword'] , $config['dbName']);
if(mysqli_connect_error()) {
 throw new Exception("<b>Could not connect to database</b>") ;
}
/*
This should never be used as your  code would be vulnerable to "SQL-Injection 
if (!$result = $db->query('SELECT * FROM world_country WHERE id >' .$_GET['lastComment'] .' ORDER BY id ASC LIMIT 0 , 30')) {
*/
$altura=trim($_GET['largura']);
if($altura > 600){
    $altura=='600';
}
$filtered = filter_input(INPUT_GET, "lastComment", FILTER_SANITIZE_URL);

$busca="SELECT * FROM produtos WHERE   id < '$filtered'    ORDER BY id DESC LIMIT 0 ,2";
$result = $db->query($busca);
 
while ($data = $result->fetch_object()) {
     $id = $data->id;
       $code=$data->code; 
   $telefone=trim($data->telefone);
   $telefone= str_replace(' ', '', $telefone);
   $endereco= mb_substr( $data->endereco, 0, 50, 'UTF-8' );
    $agora= diasDatas($data->data);
  
    $anunciante = $data->id_anunciante;
      $categoria=$data->categoria;


    if($data->categoria=="imovel"){
       
        /////////////////////////acessar banco de dados com caracteristica do imovel 
         $imo = $db->query("SELECT * FROM imovel WHERE   id_anuncio= $id  ORDER BY id ");
          
        while ($imovel = $imo->fetch_object()) {
      ////se anuncio ainda n??o tem foto //////////
              if($imovel->fotos_enviadas=="N"){
                if(isset($_SESSION['id'])){ 

                    if($_SESSION['id']==$data->id_anunciante) {

                        $anuncios =" <div class='reaction-wrapper'>
                        <div class='visualizacao_20'>     
                            <a  >   <button  class='share'><i class='material-icons'>pets</i>Enviar Fotos 360 do Anuncio</a>
                        </div> 
                  </div> "; 



                    } }       


      ///fim bloco codigo //////          
              }
          $anuncios =" <div class='reaction-wrapper'>
                <div class='visualizacao_20'>     
                    <a  >   <button  class='share'><i class='material-icons'>pets</i>$imovel->aceita_pet</a>
                </div>  <div class='visualizacao-20'>     
                    <a  >   <button  class='share'><i class='material-icons'>attach_money</i>$imovel->tipo_negocio_imovel </a>
                </div>  <div class='visualizacao_60'>    
                    <a  >  <button  class='share'><i class='material-icons'>other_houses</i>$imovel->tipo_imovel </a>
                </div> 
          </div> "; 
        
    
        }
    
       } else {
         
           $anuncios =" <div class='reaction-wrapper'>
             <div class='visualizacao'>     
                 <a href'#' onClick=mostrar_360($id) >  <img src='img/360.png' class='visualizacao_icon' alt=''></a>
             </div>  <div class='visualizacao'>     
                 <a href'#' onClick=mostrar_video($id) >  <img src='img/video.png' class='visualizacao_icon'   alt=''></a>
             </div>  <div class='visualizacao'>    
                 <a href'#' onClick=mostrar_visao($id) >  <img src='img/google_stret.png' class='visualizacao_icon' alt=''></a>
             </div> 
       </div> "; 
       
       }
       ///////////////fim codigo para im??veis////////////////////
   $preco="<div class='preco'>
        <img src='img/preco.png' class='icon' alt=''><span class='preco_texto'>$data->preco</span>
        </div >";
    if(isset($_SESSION['id'])){ 

       if($_SESSION['id']==$data->id_anunciante) {

        if($categoria=="imovel"){

            $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$telefone&amp;text=https://www.anuncio360.com/$data->id>
         $data->telefone </a></button></div>";

        }  else{   
       $ver="  <div class='preco'>  <button  class='share'><i class='material-icons'>edit</i><a href=https://www.anuncio360.com/360/atualizar_produto.php?id=$code&&categoria=$categoria> editar An??ncio </a></button></div>";
      } }else{
      $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$telefone&amp;text=https://www.anuncio360.com/$data->id>
         $data->telefone </a></button></div>";
       }

     }else{
       $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$telefone&amp;text=https://www.anuncio360.com/$data->id>
         $data->telefone </a></button></div>";
     }

     $compartilhar="  <div class='preco'>  <button onClick='share($id )' class='share'><i class='material-icons'>share</i>  Compartilhar </button></div>";


     $data->id_anunciante;
    if($data->urlcode){
        $url= '<iframe    width="100%" height='."$altura".' src='." $data->urlcode".' frameborder="0" allowfullscreen></iframe>';

    }else {

        $url= '<img src="img/FE5C64F8-DAEB-4146-9440-4688F874F63D.jpg" class="post-image" alt=""> '; 
    }
  
    echo "
     <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>

    <div class='url_perfil' id=\"$data->id_anunciante \"></div>
    <div class='postedComment' id=\"$data->id \"></div>
     <section class='main'>
     <div class='wrapper'>     
      <div class='post'>
            <div class='info'>
               <div class='user'> 
                      <div class='profile-pic'>  <a href='https://www.anuncio360.com/$data->nome_anunciante'><img src='$data->avatar' alt=''></a></div>
                    <p class='username'> <a href='https://www.anuncio360.com/$data->nome_anunciante'>$data->nome_anunciante</a></p>
                       
               </div>  
            
       
            </div>
   <div class='info2'>
     
    <div class='mapa2'>
   <p class='mapa_texto2    '> $endereco</p>
      </div> 
    </div>

    <div class='box-container'>
    <div id='foto_360_$id'>
    <div  class='post-image'>  
  $url
    </div></div>  
       </div>

    <div class='box-container' >
         <div id='video_$id'  style='display:none;' >            
            <img src='img/FE5C64F8-DAEB-4146-9440-4688F874F63D.jpg' class='post-image' alt=''>  
         </div> </div> 

    <div class='box-container' >
             <div id='visao_$id' style='display:none;'  >
                 <img src='img/4CB7B7BF-BAF2-4E7F-BF8E-9BF5587B4C38.jpg' class='post-image' alt=''>  
    </div> </div>
    <div class='post-content'>
    $anuncios
    <div class='reaction-wrapper'>  $preco    $ver   $compartilhar  </div>
      
        <p class='likes'>$data->titulo</p>
        <p class='description'><span></span>$data->descricao</p>
        <p class='post-time'>$agora</p>
    </div>  
</div>
<p id='last'></p>
</div>
</section>

<script type='text/javascript'>function share(id){
    if (navigator.share !== undefined) {
        navigator.share({
           
            url: 'https://anuncio360.com/'+id,
        })
        .then(() => console.log('Successful share'))
        .catch((error) => console.log('Error sharing', error));
    }
}</script>



" ;
    
		}
/* close connection */
$db->close();
	} else {
    header("Location: index.php");
    die("Denny access");
	}

function exception_handler($exception) {
  echo "Exception cached : " , $exception->getMessage(), "";
} ?>
