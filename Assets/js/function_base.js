function check(){
  if( $( "#check_dest").checked == true){
    $( "#nom_dest").disabled = true ;
  }else{
    $( "#nom_dest").disabled = false ;
  }
}
