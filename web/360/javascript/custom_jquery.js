  
                                




var erro=false;
var carga=false;
var largura = window.innerWidth;
if(largura > 600){
    largura=600;
}

      
      _debug = false;

function dbg(msg) {
    if (_debug)
        console.log (msg);
}                     

var windowHeight = window.innerHeight;

$(document).ready(function() {

    
      console.log('até aqui');
if ('geolocation' in navigator) {   
  navigator.geolocation.getCurrentPosition(

   
        function (position) {
        var lat = position.coords.latitude;
        var lng = position.coords.longitude;
       
        $.ajax({
            dataType : "html",
            url: "360/jquery-masterLoader.php?lat="+lat+"&&lng="+lng+"&&largura="+largura,
            success: function(html){
               

            
            $("#postedComments").html(html);
             }});    
    },
        function (error) {       
     erro=true;
      $.ajax({
          dataType : "html",
          url: "360/not-localizacao.php?lat=null&&lng=null&&largura="+largura,	
         success: function(html){ 
           
             $("#postedComments").html(html);
           }});   } ) } else {



    console.log('geolocation indisponivel');
  
}





  


    
    doMouseWheel = 1 ;
    $("#postedComments").append( "<p id='last'></p>" );
   
    
    $(window).scroll(function() {
      

        if (!doMouseWheel)
            return;

         var distanceTop =$('#last').offset().top - $(window).height()-500;
     
        if  ($(window).scrollTop() > distanceTop) {
          
            $('div#loadMoreComments').show();
            doMouseWheel = 0 ;
            
          

             
              if(erro){
                ////////////////////////se nao permitir gps////////////////////
            console.log(erro)
           $.ajax({
            dataType : "html",

            url: "360/not_localizacao_2.php?lastComment="+$(".postedComment:last").attr('id')+"&&largura="+largura,
            success: function(html) {

                    carga=true;
                doMouseWheel = 1	 ;
                if(html){
                    $("#postedComments").append(html); 
                    $("#last").remove();
                    $("#postedComments").append( "<p id='last'></p>" );
                    $('div#loadMoreComments').hide();
                } else {
                    //Disable Ajax when result from PHP-script is empty (no more DB-results )
                     $('div#loadMoreComments').replaceWith( "<center><div class='topo'>Fim</div>" );
                    doMouseWheel = 0 ;
                }    
             }
        });/////////////////////se nao permitir gps fim /////////////////
             } else {               
             $.ajax({
                dataType : "html",
                url: "360/jquery-loadMoreComments.php?lastComment="+ $(".postedComment:last").attr('id')+"&&lat="+$(".lat:last").attr('id')+"&&lng="+$(".lng:last").attr('id')+"&&largura="+largura,
                success: function(html) {
                   carga=true;          
                doMouseWheel = 1	 ;
                   if(html){
                    $("#postedComments").append(html); 
                    $("#last").remove();
                    $("#postedComments").append( "<p id='last'></p>" );
                    $('div#loadMoreComments').hide();
                } else {
                    //Disable Ajax when result from PHP-script is empty (no more DB-results )
                     $('div#loadMoreComments').replaceWith( "<center><div class='topo'>Fim</div>" );
                    doMouseWheel = 0 ;
                }
                }
            });

          }
        }
    });
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
