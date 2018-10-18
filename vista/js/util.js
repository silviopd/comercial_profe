function validarNumeros(evento){
    var tecla = (evento.which) ? evento.which : evento.keyCode;
    if (tecla >= 48 && tecla <= 57){
      return true;
    }
    
    return false;
}