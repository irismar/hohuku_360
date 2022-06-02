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
    function calculo($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo)
    {
        $rad = M_PI / 180;
        //Calculate distance from latitude and longitude
        $theta = $longitudeFrom - $longitudeTo;
        $dist = sin($latitudeFrom * $rad) 
            * sin($latitudeTo * $rad) +  cos($latitudeFrom * $rad)
            * cos($latitudeTo * $rad) * cos($theta * $rad);
    
        return acos($dist) / $rad * 60 *  1.853;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);
      
        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
      }    
session_start();      
error_reporting(0);
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
    $altura='600';
}

$lat=trim($_GET['lat']); 
$lng=trim($_GET['lng']); 
$filtered = filter_input(INPUT_GET, "lastComment", FILTER_SANITIZE_URL);
$url_perfil = filter_input(INPUT_GET, "url_perfil", FILTER_SANITIZE_URL);
$busca="SELECT * FROM produtos WHERE   id_anunciante ='$url_perfil'  AND  id < '$filtered'    ORDER BY id DESC LIMIT 0 ,2";
$result = $db->query($busca);


$total = $result->num_rows;
if($total > 0 ){ 
 
while ($data = $result->fetch_object()) {
    $id = $data->id;
   $code=$data->code; 
   $endereco= mb_substr( $data->endereco, 0, 50, 'UTF-8' );
    $agora= diasDatas($data->data);
    $data_distancia= calculo($data->lat,$data->log,$lat,$lng);
    if( $data_distancia < 1){
        $km= floor(  $data_distancia*1000)." "."metros";
    } else{
    $km=floor( $data_distancia)." "."Km";
    }
    
    $preco="<div class='preco'>
    <img src='img/preco.png' class='icon' alt=''><span class='preco_texto'>$data->preco</span>
    </div >";
if(isset($_SESSION['id'])){ 

   if($_SESSION['id']==$data->id_anunciante) {

  ////////////////esse é meu anuncio mostrar visualizaçoes////////////////

  $ver="  <div class='preco'>  <button  class='share'><i class='material-icons'>edit</i><a href=https://www.anuncio360.com/360/atualizar_produto.php?id=$code> editar Anúncio </a></button></div>";
   }else{
   $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$data->telefone&amp;text=Oi Vi seu anúncio e queria saber mais +https://www.anuncio360.com/$data->id'>
     $data->telefone </a></button></div>";
   }

 }else{
   $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$data->telefone&amp;text=Oi Vi seu anúncio e queria saber mais +https://www.anuncio360.com/$data->id'>
     $data->telefone </a></button></div>";
 }



$compartilhar="  <div class='preco'>  <button onClick='share( $id)' class='share'><i class='material-icons'>share</i> <a href=#> Compartilhar</a></button></div>";

$mapa=" <div class='mapa'>
     <i class='material-icons'>route</i><p class='post-time'>distancia $km  </p>   
    <p class='mapa_texto'> <a href='https://www.google.com/maps/dir/$data->lat,$data->log/$lat,$lng/'>GPS</p></a></div>";
 



  /////////////////////////acessar banco de dados com caracteristica do imovel 
  $categoria=$data->categoria;
  if($categoria=="imovel"){
   
    $imo = $db->query("SELECT * FROM imovel WHERE   id_anuncio= $id  ORDER BY id DESC LIMIT 1");
      
    while ($imovel = $imo->fetch_object()) {
         
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
   ///////////////fim codigo para imóveis//////////////////// 
 $url= '<iframe    width="100%" height='."$altura".' src='." $data->urlcode".' frameborder="0" allowfullscreen></iframe>';

    echo "
        <link href='https://fonts.googleapis.com/icon?family=Material+Icons' rel='stylesheet'>
    <div class='postedComment' id=\"$data->id \"></div>
     <div class='url_perfil' id=\"$data->id_anunciante \"></div>
     <div class='lat' id=\"$lat\"></div>
    <div class='lng' id=\"$lng\"></div>

     <section class='main'>
     <div class='wrapper'>     
      <div class='post'>
            <div class='info'>
               <div class='user'> 
                    <div class='profile-pic'><img src='$data->avatar' alt=''></div>
                    <p class='username'>$data->nome_anunciante</p>
                       
               </div>  
               $mapa
       
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
    $anuncios
    <div class='post-content'>
    <div class='reaction-wrapper'>  $preco    $ver   $compartilhar  </div>
      
        <p class='likes'>$data->titulo</p>
        <p class='description'><span></span>$data->descricao</p>
        <p class='post-time'>$agora</p>
    </div>  
</div>
<p id='last'></p>
</div>
</section>
<script type='text/javascript'>function share(){
    if (navigator.share !== undefined) {
        navigator.share({
           
            url: 'https://anuncio360.com/$id',
        })
        .then(() => console.log('Successful share'))
        .catch((error) => console.log('Error sharing', error));
    }
} </script>
 " ;
    
		
/* close connection */
$db->close();
    }  }

 ?>
