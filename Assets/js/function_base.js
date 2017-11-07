function check(){

    if( $( "#check_dest").is(':checked') ){
      $( "#nom_dest").attr("disabled", true);
    }else{
      $( "#nom_dest").attr("disabled", false);
    }
}
