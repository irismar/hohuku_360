<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"><?php 
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
set_exception_handler('exception_handler') ;
$config = parse_ini_file("config/my.ini") ;
$db=new mysqli($config['dbLocation'] , $config['dbUser'] , $config['dbPassword'] , $config['dbName']);
if(mysqli_connect_error()) {
 throw new Exception("<b>Could not connect to database</b>") ;
}
$getid=$_GET['id'];$filtered =trim($getid);
if (!$result = $db->query('SELECT * FROM produtos WHERE id =' .$filtered .' ORDER BY id DESC LIMIT 0 , 1')) {
    throw new Exception("<b>Could not read data from the table </b>") ;
}
$altura=trim($_GET['largura']);

while ($data = $result->fetch_object()) {
   $id = $data->id;
   $code=$data->code; 
   $telefone=trim($data->telefone);
   $telefone= str_replace(' ', '', $telefone);
   $endereco= mb_substr( $data->endereco, 0, 50, 'UTF-8' );
    $agora= diasDatas($data->data);
  
    if( $data_distancia < 1){
        $km= floor(  $data_distancia*1000)." "."metros";
    } else{
    $km=floor( $data_distancia)." "."Km";
    }
    $preco=" <div class='preco2'>  <button  class='share2'><i class='material-icons'>paid</i>$data->preco</button></div>";

      
  

    

     $compartilhar="  <div class='preco2'>  <button onClick='share($id )' class='share2'><i class='material-icons'>share</i>  Compartilhar </button></div>";

    $mapa=" <div class='mapa'>
         <i class='material-icons'>route</i><p class='post-time'>distancia $km  </p>   
        <p class='mapa_texto'> <a href='https://www.google.com/maps/dir/$data->lat,$data->log/$lat,$lng/8&travelmode=walking'>GPS</p></a></div>";
     

     $data->id_anunciante;

        $url= '<iframe    width="100%" height='."$altura".' src='." $data->urlcode".' frameborder="0" allowfullscreen></iframe>';
        /////////////////////////acessar banco de dados com caracteristica do imovel 

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
    
    echo "

    <div class='postedComment' id=\"$data->id \"></div>
    <div class='url_perfil' id=\"$data->id_anunciante \"></div>
    <section class='main'>
     <div class='wrapper'>     
      <div class='post2'>
          
   <div class='info2'>
     
    <div class='mapa2'>
   <p class='mapa_texto2    '> </p>
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
    <div class='post-content2'>
    <div class='reaction-wrapper'>  $preco      $compartilhar  </div>
      
        <p class='likes'>$data->titulo</p>
        <p class='description'><span></span>$data->descricao</p>
        <p class='post-time'>$agora    visualalizações </p>
    </div>  
</div>
<p id='last'></p>
</div>
</section>



<script type='text/javascript'>
function share(data){
    if (navigator.share !== undefined) {
        navigator.share({
           
              url: 'https://www.anuncio360.com/'+data,
        })
        .then(() => console.log('Successful share'))
        .catch((error) => console.log('Error sharing', error));
    }
}</script>
   " ;
 
   
////codigo log acesso 
////codigo log acesso 

      ?>  

      <meta name="description" content="<?echo $data->descricao;?> /><?
/* close connection */



if(!isset($_SESSION['id_anuncio']) OR ($_SESSION['id_anuncio']!=$id)){ 
    include_once'configuracoes.php';
    /////log acesso////
    if(!isset($_COOKIE['user'])){
        $COOKIE=session_id();
        setcookie("user", $COOKIE, $expira);
        $codigo= $COOKIE;   
    } else{
         $codigo=$_COOKIE['user'];
    }
    $mensagem="Acesso sucesso aunucio " ." ".$id;
    acao($mensagem,$codigo,$lat,$lng);
    $_SESSION['id_anuncio']=$id;
      }
      ////////////FIM DO CODIGO LOG//// 
      ////////////FIM DO CODIGO LOG//// 

    
        } 
$db->close();
function exception_handler($exception) {
  echo "Exception cached : " , $exception->getMessage(), "";
}

?>



