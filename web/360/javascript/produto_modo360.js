_debug = true;

function dbg(msg) {
    if (_debug)
        console.log (msg);
}
var erro=false;
var carga=false;
var largura = window.innerWidth;
if(largura > 600){
    largura=600;
}
  var windowHeight = window.innerHeight;

$(document).ready(function() {
   $("#id_anuncio").append( "<p id='last'></p>" );
if ('geolocation' in navigator) {


  navigator.geolocation.getCurrentPosition(
    function (position) {

        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
        $.ajax({
            dataType : "html",
            url: "/360/carregar_produto360.php?lat="+lat+"&&lng="+lng+"&&id="+$(".id_anuncio:last").attr('id')+"&&largura="+largura,
           success: function(html){
                   
               $("#postedComments").html(html);
             }});   
    
             
    },
    function (error) {
     
      
     erro=true;
      $.ajax({
          dataType : "html",
          url: "/360/carregar_produto360.php?lat=null&&lng=null&&id="+$(".id_anuncio:last").attr('id')+"&&largura="+largura,
         success: function(html){
            
        
             $("#postedComments").html(html);
           }});   


    }
  )
} else {
  Alert('ops')
}





  


    
    doMouseWheel = 1 ;
    $("#postedComments").append( "<p id='last'></p>" );
    dbg("Document Ready");
    

});



function mostrar_360(id){
 
  var visao='visao_'+id; 
  var foto_360='foto_360_'+id; 
  var video='video_'+id; 
  console.log(visao);
  document.getElementById(visao).style.display = "none";
  document.getElementById(foto_360).style.display = "block";
  document.getElementById(video).style.display = "none";
  
}
function mostrar_video(id){
  
  var visao='visao_'+id; 
  var foto_360='foto_360_'+id; 
  var video='video_'+id; 
  console.log(visao);
  document.getElementById(visao).style.display = "none";
  document.getElementById(foto_360).style.display = "none";
  document.getElementById(video).style.display = "block";

}

function mostrar_visao(id){

  var visao='visao_'+id; 
  var foto_360='foto_360_'+id; 
  var video='video_'+id; 
  console.log(visao);
  document.getElementById(visao).style.display = "block";
  document.getElementById(foto_360).style.display = "none";
  document.getElementById(video).style.display = "none";
 

}function autoResize(iframe) {
    $(iframe).height($(iframe).contents().find('html').height());
}
