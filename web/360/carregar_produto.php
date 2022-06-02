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
$lat=trim($_GET['lat']); 
$lng=trim($_GET['lng']); 
while ($data = $result->fetch_object()) {
   $id = $data->id;
   $code=$data->code; 
   $telefone=trim($data->telefone);
   $telefone= str_replace(' ', '', $telefone);
   $endereco= mb_substr( $data->endereco, 0, 50, 'UTF-8' );
    $agora= diasDatas($data->data);
    $data_distancia= calculo($data->lat,$data->log,$lat,$lng);
    if( $data_distancia < 1){
        $km= floor(  $data_distancia*1000)." "."metros";
    } else{
    $km=floor( $data_distancia)." "."Km";
    }
    $preco=" <div class='preco'>  <button  class='share'><i class='material-icons'>paid</i>$data->preco</button></div>";

    if(isset($_SESSION['id'])){ 

       if($_SESSION['id']==$data->id_anunciante) {

       //////////////////se eu for o dono do anuncio///// visualizr visualizações/////////////
       $visual = $db->query("SELECT * FROM imovel WHERE   id_anuncio= $id  ORDER BY id DESC LIMIT 1");
          
       while ($visualal = $visual->fetch_object()) {


       }
      




       ///////////////////////////////fim visualização///////////////////////////////////////



       $ver="  <div class='preco'>  <button  class='share'><i class='material-icons'>edit</i><a href=https://www.anuncio360.com/360/atualizar_produto.php?id=$code> editar Anúncio </a></button></div>";
       }else{
      $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$telefone&amp;text=https://www.anuncio360.com/$data->id>
         $data->telefone </a></button></div>";
       }

     }else{
       $ver="<div class='preco'>  <button  class='share'> <i class='material-icons'>whatsapp</i><a href=https://api.whatsapp.com/send?phone=+55$telefone&amp;text=https://www.anuncio360.com/$data->id>
         $data->telefone </a></button></div>";
     }

    

     $compartilhar="  <div class='preco'>  <button onClick='share($id )' class='share'><i class='material-icons'>share</i>  Compartilhar </button></div>";

    $mapa=" <div class='mapa'>
         <i class='material-icons'>place</i><p class='post-time'>distancia $km  </p>   
        <p class='mapa_texto'> <a href='https://www.google.com/maps/dir/$data->lat,$data->log/$lat,$lng/8&travelmode=walking'>GPS</p></a></div>";
     

     $data->id_anunciante;



        $url= '<iframe    width="100%" height='."$altura".' src='." $data->urlcode".' frameborder="0" allowfullscreen></iframe>';
        if(isset($data->url_tour)){ 
            $url_tour= '<iframe    width="100%" height='."$altura".' src='." $data->url_tour".' frameborder="0" allowfullscreen></iframe>';
            $icon_tour=" <img src='img/google_stret.png' class='visualizacao_icon' alt=''>";

        }

        if(isset($data->url_video)){ 
            $video='<video  width="100%" height='."$altura".' loop="true" autoplay="true" controls>
<source src='."$data->url_video".'  type=video/quicktime /></video>';

            $icon_video="<i class='material-icons'>video_library</i>";

        }
        
       
      


        /////////////////////////acessar banco de dados com caracteristica do imovel 

    if( $data->categoria=="imovel"){
   
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
                 <a href'#' onClick=mostrar_360($id) >  <i class='material-icons'>360</i></a>
             </div>  <div class='visualizacao'>     
                 <a href'#' onClick=mostrar_video($id) >  $icon_video</a>
             </div>  <div class='visualizacao'>    
                 <a href'#' onClick=mostrar_visao($id) >   $icon_tour</a>
             </div> 
       </div> "; 
   
       
       
       }
       ///////////////fim codigo para imóveis////////////////////
    
    echo "

    <div class='postedComment' id=\"$data->id \"></div>
    <div class='url_perfil' id=\"$data->id_anunciante \"></div>
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
         $video 
         </div> </div> 

    <div class='box-container' >
             <div id='visao_$id' style='display:none;'  >
             $url_tour  
    </div> </div>

    $anuncios
    <div class='post-content'>


    <div class='reaction-wrapper'>  $preco    $ver   $compartilhar  </div>
      
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



