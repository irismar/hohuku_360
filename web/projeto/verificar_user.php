<?php

//Cabecalhos obrigatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

//Incluir a conexao

$host="mysql873.umbler.com";
$user="360";
$pass="irisMAR100";
$dtb="360";
$conn = new PDO("mysql:host=$host;dbname=" . $dtb, $user, $pass);
$connection = mysqli_connect("mysql873.umbler.com","360","irisMAR100","360") or die("Error " . mysqli_error($connection));
$usuario= $_GET['user'];
$sql = "select * from   usuario  WHERE    usuario='".trim($usuario)."' ";
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));

 $n= mysqli_num_rows( $result );
 if($n =='0'){

        $response = [
        "erro" => false,
        "messagem" =>$n
    ];  
    } else {
      $response = [
      "erro" => true,
      "messagem" =>$n
                  ];
  }
 
    //Resposta com status 200
    http_response_code(200);

    //Retornar os produtos em formato json
   echo json_encode(  $response );



