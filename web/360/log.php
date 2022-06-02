<?

function log_latitude($valor,$lat,$log,$id){
$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$agente = $_SERVER["HTTP_USER_AGENT"];
$dbname = "360";
$host="mysql873.umbler.com";
$user="360";
$pass="irisMAR100";
$agora = date('Y/m/d H:i:s');
$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);


    $query_produto = "INSERT INTO log (valor,ip,data,agente,lat,log,id_anucio) VALUES (:valor,:ip,:data,:agente,:lat,:log,:id_anucio)";
    $cad_produto = $conn->prepare($query_produto);
    $cad_produto->bindParam(':valor', $valor, PDO::PARAM_STR);
    $cad_produto->bindParam(':ip', $ip, PDO::PARAM_STR);
    $cad_produto->bindParam(':data', $agora, PDO::PARAM_STR);
    $cad_produto->bindParam(':agente', $agente, PDO::PARAM_STR);
    $cad_produto->bindParam(':lat', $lat, PDO::PARAM_STR);
    $cad_produto->bindParam(':log', $log, PDO::PARAM_STR);
    $cad_produto->bindParam(':id_anucio', $id, PDO::PARAM_STR);
    

    $cad_produto->execute();

   
}

  ?>