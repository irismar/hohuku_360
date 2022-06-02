<?php
session_start();

// 30 Dias = Data atual + 60 minutos * 60 segundos * 24 horas * 30 dias
$expira = time() + ( 60 * 60 * 24 * 30*360 );


function acao($mensagem,$codigo,$lat,$log){
   

$ip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
$agente = $_SERVER["HTTP_USER_AGENT"];
$dbname = "360";
$host="mysql873.umbler.com";
$user="360";
$pass="irisMAR100";
$agora = date('Y/m/d H:i:s');
$conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);


    $query_produto = "INSERT INTO acesso (codigo,ip,data_criar,agente,acao,lat,log) VALUES (:codigo,:ip,:data,:agente,:acao,:lat,:log)";
    $cad_produto = $conn->prepare($query_produto);
    $cad_produto->bindParam(':codigo', $codigo, PDO::PARAM_STR);
    $cad_produto->bindParam(':ip', $ip, PDO::PARAM_STR);
    $cad_produto->bindParam(':data', $agora, PDO::PARAM_STR);
    $cad_produto->bindParam(':agente', $agente, PDO::PARAM_STR);
    $cad_produto->bindParam(':acao', $mensagem, PDO::PARAM_STR);
    $cad_produto->bindParam(':lat', $lat, PDO::PARAM_STR);
    $cad_produto->bindParam(':log', $log, PDO::PARAM_STR);
    

    $cad_produto->execute();

   
  


}

?>