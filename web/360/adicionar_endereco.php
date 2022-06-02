
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBTCJwwUlXn00DQX19Tr89S6hfEERGxaNg&libraries=places"></script>
    <script>




         function log(valor){
      
                                    $.ajax({ 
                                    url: '360/log.php', 
                                    type: 'POST', 
                                    data:{"valor" :valor}, 
                                    success: function(data) {                
                                 console.log('ok tudo certo');  }  }); }
    </script><? 
session_start();
if(isset($_SESSION['id'])){ 
if(isset($_POST['acao'])){
var_dump($_SESSION);
var_dump($_POST);
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
///$codeurl='https://anuncio360.com/projeto/galeria360.php?code='.$code;
    $query_produto = "INSERT INTO produtos (titulo,categoria,estado,preco ,descricao,id_anunciante,nome_anunciante,avatar,endereco,lat,log,data,telefone,code) VALUES (:titulo, :categoria,:estado,:preco,:descricao,:id_anunciante,:nome_anunciante,:avatar,:endereco,:lat,:log,:data,:telefone,:code)";
    $cad_produto = $conn->prepare($query_produto);

    $cad_produto->bindParam(':titulo', $_POST['titulo'], PDO::PARAM_STR);
    $cad_produto->bindParam(':categoria', $_POST['categoria'], PDO::PARAM_STR);
    $cad_produto->bindParam(':estado', $_POST['estado'], PDO::PARAM_STR);
    $cad_produto->bindParam(':preco', $_POST['preco'], PDO::PARAM_STR);
    $cad_produto->bindParam(':descricao', $_POST['descricao'], PDO::PARAM_STR);
    $cad_produto->bindParam(':id_anunciante', $_SESSION['id'], PDO::PARAM_STR);
    $cad_produto->bindParam(':nome_anunciante', $_SESSION['nome'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':avatar', $_SESSION['foto_perfil'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':endereco', $_SESSION['endereco'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':lat', $_SESSION['latitude'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':log', $_SESSION['longitude'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':data', $agora, PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':telefone', $_SESSION['telefone'], PDO::PARAM_STR); ////id_anunciante
    $cad_produto->bindParam(':code', $code, PDO::PARAM_STR); ////id_anunciante
    //$cad_produto->bindParam(':urlcode', $codeurl, PDO::PARAM_STR); ////id_anunciante
    $cad_produto->execute(); 
    $id_anuncio=$conn->lastInsertId(); // returns last ID
    if($cad_produto->rowCount()){
    
     $codeurl='https://anuncio360.com/novo360/index.php?id='.$_SESSION['id'].'&&id_anuncio='.$id_anuncio;
        $stmt = $conn->prepare('UPDATE produtos  SET urlcode="'.$codeurl.'" WHERE id= :id');
        $stmt->execute(array( ':id'=>$id_anuncio ));  

 
          header('Location: https://anuncio360.com/web/index.html?id='.$_SESSION['id'].'&&code='.$code.'&&anuncio='.$id_anuncio);

    	echo "tudo certo jão";
    }else{
        $erro ="erro ao cadastrar produto Tente Novamente";
    }
    

}

	?>
 <link href="https://fonts.googleapis.com/css?family=Open+Sans:600" type="text/css" rel="stylesheet" />
        <link href="endereco/estilo.css" type="text/css" rel="stylesheet" />

    
        <script type="text/javascript" src="endereco/jquery.min.js"></script>
        <script >
            
var geocoder;
var map;
var marker;

function initialize() {
    var latlng = new google.maps.LatLng(-18.8800397, -47.05878999999999);
    var options = {
        zoom: 5,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    
    map = new google.maps.Map(document.getElementById("mapa"), options);
    
    geocoder = new google.maps.Geocoder();
    
    marker = new google.maps.Marker({
        map: map,
        draggable: true,
    });
    
    marker.setPosition(latlng);
}

$(document).ready(function () {

    initialize();
    
    function carregarNoMapa(endereco) {
        geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    var latitude = results[0].geometry.location.lat();
                    var longitude = results[0].geometry.location.lng();
        
                    $('#txtEndereco').val(results[0].formatted_address);
                    $('#txtLatitude').val(latitude);
                    $('#txtLongitude').val(longitude);
        
                    var location = new google.maps.LatLng(latitude, longitude);
                    marker.setPosition(location);
                    map.setCenter(location);
                    map.setZoom(16);
                }
            }
        })
    }
    
    $("#btnEndereco").click(function() {
        if($(this).val() != "")
            carregarNoMapa($("#txtEndereco").val());
    })
    
    $("#txtEndereco").blur(function() {
        if($(this).val() != "")
            carregarNoMapa($(this).val());
    })
    
    google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {  
                    $('#txtEndereco').val(results[0].formatted_address);
                    $('#txtLatitude').val(marker.getPosition().lat());
                    $('#txtLongitude').val(marker.getPosition().lng());
                }
            }
        });
    });
    
    $("#txtEndereco").autocomplete({
        source: function (request, response) {
            geocoder.geocode({ 'address': request.term + ', Brasil', 'region': 'BR' }, function (results, status) {
                response($.map(results, function (item) {
                    return {
                        label: item.formatted_address,
                        value: item.formatted_address,
                        latitude: item.geometry.location.lat(),
                        longitude: item.geometry.location.lng()
                    }
                }));
            })
        },
        select: function (event, ui) {
            $("#txtLatitude").val(ui.item.latitude);
            $("#txtLongitude").val(ui.item.longitude);
            var location = new google.maps.LatLng(ui.item.latitude, ui.item.longitude);
            marker.setPosition(location);
            map.setCenter(location);
            map.setZoom(16);
        }
    });
    
    $("form").submit(function(event) {
        event.preventDefault();
        
        var endereco = $("#txtEndereco").val();
        var latitude = $("#txtLatitude").val();
        var longitude = $("#txtLongitude").val();
        
        alert("Endereço: " + endereco + "\nLatitude: " + latitude + "\nLongitude: " + longitude);
    });

});


        </script>
        <script type="text/javascript" src="../endereco/jquery-ui.custom.min.js"></script>          
<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300&display=swap');
</style> 
<link rel="stylesheet" type="text/css"  href="360/styles.css" />
    </head>
    <body>
    
          <div class="caixa_centro">

<form action="?acao=cadastro" method="post">
    	<div  class="cadastro_produto">
   	<h1>Qual endereço do Imovel </h1>


      <div id="apresentacao">

          
    
            <form method="post" action="index.html">    
                <fieldset>

                    <legend>Google Maps API v3: Busca de endereço e Autocomplete - Demo</legend>    
            
                    <div class="campos">
                        <label for="txtEndereco">Endereço:</label>
                        <input type="text" id="txtEndereco" name="txtEndereco" />
                        <input type="button" id="btnEndereco" name="btnEndereco" value="Mostrar no mapa" />
                    </div>

                    <div id="mapa"></div>
                    
                    <input type="submit" value="Enviar" name="btnEnviar" />
                    
                    <input type="hidden" id="txtLatitude" name="txtLatitude" />
                    <input type="hidden" id="txtLongitude" name="txtLongitude" />

                </fieldset>
            </form>

            <div class="autores">
                <p>Criado por: <a href="http://twitter.com/rodolfoprr" target="_blank">Rodolfo Pereira</a> | Estilizado por: <a href="http://twitter.com/jofelipe_" target="_blank">Jonathan Felipe</a></p>
            </div>

        </div>

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
 
</html>