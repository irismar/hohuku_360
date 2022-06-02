		<?php

   echo  $base_url=$_SERVER['HTTP_HOST'];
		
			
		    if(isset($_GET['url'])){ 

         session_start();       
error_reporting(0) ;

set_exception_handler('exception_handler') ;
$config = parse_ini_file("config/my.ini") ;
$db=new mysqli($config['dbLocation'] , $config['dbUser'] , $config['dbPassword'] , $config['dbName']);
if(mysqli_connect_error()) {
 throw new Exception("<b>Could not connect to database</b>") ;
}


			$url= filter_input(INPUT_GET, "url", FILTER_SANITIZE_URL);
			$url = array_filter(explode('/',$url));
         $url2=trim($_SERVER["REQUEST_URI"] );
         $fotoperfil_url= explode('&&foto=', $url2);
         if(isset($fotoperfil_url)){  $fotoperfil=trim($fotoperfil_url[1]);  }
		    	$url_perfil = trim($url[0]);
         if($url_perfil=='cadastro-google'){ 
        
           $id= trim($url[1]);
           $nome=trim($url[2]);           
           $email=trim($url[3]);
           include '360/cadastro-google.php';exit();}
           if($url_perfil=='adicionar'){ 
           include '360/adicionar.php';exit();}

             if($url_perfil=='parasita'){ 
           include 'parasita.php';exit();}
        	  if($url_perfil=='configurar'){ 
        	  include '360/config.php';exit();}
           if($url_perfil=='entrar'){ 
          	include '360/login.php';exit();}

            if($url_perfil=='adicionar_endereco'){ 
           include '360/endereco.php';exit();}


             if($url_perfil=='adicionar_imovel'){ 
               $endereco= trim($url[1]);
               $latitude=trim($url[2]);           
               $longitude=trim($url[3]);

           include '360/adicionar_imoveis.php';exit();}



          	 if($url_perfil=='cadastro'){ 


          	include '360/cadastro.php';exit();}	  
			
			if( $url_perfil && $url_perfil!='' &&  is_numeric($url_perfil)){
             $url_perfil;
             $getid=trim($url[0]);
            
             if (!$result = $db->query('SELECT descricao,id_anunciante,avatar,id FROM produtos WHERE id =' .$getid .' ORDER BY id DESC LIMIT 0 , 1')) {
                   throw new Exception("<b>Could not read data from the table </b>") ; }
				   while ($data2 = $result->fetch_object()) {
                   $descricao = $data2->descricao; 
                   $foto_perfil = $data2->avatar; 
                   $id_anunciante=$data2->id_anunciante;            
                  
                  }	
                   
          if(isset($url[1])&& ($url[1]=="tour")){
           
            include '360/produto_modo360.php';exit();
          } else{
				   include '360/produto.php';exit();
          }

			}



            if( $url_perfil && $url_perfil!='' &&  !is_numeric($url_perfil)) {
            if(mysqli_connect_error()) {
            throw new Exception("<b>Could not connect to database</b>") ;}

  $result = $db->query("SELECT * FROM usuario WHERE usuario='$url_perfil' ORDER BY id DESC LIMIT 1");
  $n_perfil = mysqli_num_rows($result);

if($n_perfil =='0'){
   $aviso_perfil_0= '<p  class="username">Perfil não encontrado exibindo todos os resultados </p>';
				
  include '360/index.php';		}	else {	


  	while ($data = $result->fetch_object()) {
    $code= $data->token;
    $foto_perfil = $data->Foto_perfil; 
    $id_perfil = $data->id; 
    $endereco = $data->endereco; 
    $telefone = $data->telefone; 
	
}

        $maperar_prfol=true;


  		include '360/perfil.php'; 

exit();
  	}
			}else{
				include '360/index.php';
			}	
		
		
		}else{
			include '360/index.php';


			}		
		?>
