function check(){

    if( $( "#check_dest").is(':checked') ){
      $( "#nom_dest").attr("disabled", true);
    }else{
      $( "#nom_dest").attr("disabled", false);
    }
}

$(document).ready(function(){
	$('.removeAccount').on("click", function(){
		if(confirm("Voulez vous vraiment supprimer votre compte?"))
			return true;
	   	else 
	     	return false;
	});
});
