/*
funciones de javascript para comprobar formularios
funcion para comprobar CI ecuatoriana

*/

function validar(formulario,mandar) {
	var campos  = formulario.getElementsByTagName("input");
	var listaErrores = document.getElementById("lista-errores");
	limpiarNodo(listaErrores);
	modificado = esModificado();
	longitud = campos.length;	

	for (i=0; i<longitud; i++) {
		var campo = new clsCampo( campos.item(i) );

		if( campo.type == "text" )
			if ( !( campo.esObligatorio() && campo.vacio() ) ) {					
			  switch ( campo.tipo ) {
                                case 'v': campo.ci();break;
				case 't': campo.soloTexto(); break;
				case 'n': campo.natural(); break;
				case 'z': campo.entero(); break;
				case 'q': campo.realPositivo(); break;
				case 'r': campo.numeroReal(); break;
				case 'e': campo.correo(); break;
                               
			  }
			}
		else if ( ( campo.type == "file" ) || ( campo.type == "password" ) )
			if ( !modificado && campo.esObligatorio() ) campo.vacio();
		if ( campo.error )
		  listaErrores.appendChild( crearLI( campo.error ) );
	}
	campos = formulario.getElementsByTagName("textarea");
	longitud = campos.length;
	for (i=0; i<longitud; i++) {
		var campo = new clsCampo( campos.item(i) );
		if ( campo.esObligatorio() && campo.vacio() )
		  listaErrores.appendChild( crearLI( campo.error ) );
	}
	campos = formulario.getElementsByTagName("select");
	longitud = campos.length;
	for (i=0; i<longitud; i++) {
		var campo = new clsCampo( campos.item(i) );
		if ( campo.esObligatorio() && !campo.estaSeleccionado() )
		  listaErrores.appendChild( crearLI( campo.error ) );
	}
	formValido = !listaErrores.getElementsByTagName("li").length;
	if ( formValido && mandar ) enviar(formulario);
	
	return formValido;
}
/***/
function clsCampo (campo) {
	this.campo = campo;
	//this.campo.value = campo.value;
	this.type = this.campo.getAttribute("type");
	this.tipo = this.campo.name.charAt(0).toLowerCase();
	this.error = false;
}
clsCampo.prototype.esObligatorio = function esObligatorio() {
	var chr = this.campo.name.charAt(0);
	if ( chr.search('[A-Z]') || (chr == 'W') ) return false;
	return true;
}
clsCampo.prototype.vacio = function vacio() {
	valor = trim(this.campo.value);
	if ( valor.length!=0 ) return false;
	this.error = 'Debe completar el campo "'+this.formatoNombre()+'"';
	return true;
}
clsCampo.prototype.natural = function natural() {
	if( this.campo.value.search('[^0-9]') == -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros enteros'; //sin signo
	return false;
}
clsCampo.prototype.entero = function entero() {
	if( this.campo.value.search('^-?[0-9]+$') != -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros enteros';
	return false;
}
clsCampo.prototype.realPositivo = function realPositivo() {
	if( this.campo.value.search('[^0-9.]') == -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros';	//sin signo
	return false;
}
clsCampo.prototype.numeroReal = function numeroReal() {
	if( this.campo.value.search('[^0-9.-]') == -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener numeros';
	return false;
}
clsCampo.prototype.soloTexto = function soloTexto() {
	if( this.campo.value.search('^[a-z A-Z]+$') != -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" solo puede tener texto';
	return false;
}
clsCampo.prototype.correo = function correo() {
	if( this.campo.value.toLowerCase().search('(^[a-z][a-z0-9\-_.]+[@][a-z0-9\-_.]+[.][a-z]+$)') != -1 ) return true;
	this.error = 'el campo "'+this.formatoNombre()+'" debe ser un correo valido';
	return false;
}



clsCampo.prototype.estaSeleccionado = function estaSeleccionado() {
	var valor = parseInt(this.campo.options[this.campo.selectedIndex].value);
	if ( isNaN(valor) || valor ) return true;
	this.error =  'debe eligir un valor del combo "'+this.formatoNombre()+'"';
	return false;
}
/***/
clsCampo.prototype.formatoNombre = function formatoNombre() {
	nombre = this.campo.name;
	return nombre.charAt(1).toUpperCase()+nombre.replace(/_/g,' ').substr(2);
}


clsCampo.prototype.ci  = function ci() {

    var numero = this.campo.value;
	  /* alert(numero); */

      var suma = 0;
      var residuo = 0;
      var pri = false;
      var pub = false;
      var nat = false;
      var numeroProvincias = 22;
      var modulo = 11;

      /* Verifico que el campo no contenga letras */
      var ok=1;
      for (i=0; i<numero.length && ok==1 ; i++){
         var n = parseInt(numero.charAt(i));
         if (isNaN(n)) ok=0;
      }
      if (ok==0){
         this.error ='"ci/ruc" acepta solo digitos';
         return false;
      }

      if (numero.length < 10 ){
         this.error ='El numero de "CI/RUC" es incorrecto';
         return false;
      }

      /* Los primeros dos digitos corresponden al codigo de la provincia */
      var provincia = numero.substr(0,2);
      if (provincia < 1 || provincia > numeroProvincias){
         this.error ='El numero de "CI/RUC" es incorrecto';
		 return false;
      }

      /* Aqui almacenamos los digitos de la cedula en variables. */
      var d1  = numero.substr(0,1);
      var d2  = numero.substr(1,1);
      var d3  = numero.substr(2,1);
      var d4  = numero.substr(3,1);
      var d5  = numero.substr(4,1);
      var d6  = numero.substr(5,1);
      var d7  = numero.substr(6,1);
      var d8  = numero.substr(7,1);
      var d9  = numero.substr(8,1);
      var d10 = numero.substr(9,1);

      /* El tercer digito es: */
      /* 9 para sociedades privadas y extranjeros   */
      /* 6 para sociedades publicas */
      /* menor que 6 (0,1,2,3,4,5) para personas naturales */

      if (d3==7 || d3==8){
         this.error ='El numero de "CI/RUC" es incorrecto';
         return false;
      }

      /* Solo para personas naturales (modulo 10) */
      if (d3 < 6){
         nat = true;
         var p1 = d1 * 2;  if (p1 >= 10) p1 -= 9;
         var p2 = d2 * 1;  if (p2 >= 10) p2 -= 9;
         var p3 = d3 * 2;  if (p3 >= 10) p3 -= 9;
         var p4 = d4 * 1;  if (p4 >= 10) p4 -= 9;
         var p5 = d5 * 2;  if (p5 >= 10) p5 -= 9;
         var p6 = d6 * 1;  if (p6 >= 10) p6 -= 9;
         var p7 = d7 * 2;  if (p7 >= 10) p7 -= 9;
         var p8 = d8 * 1;  if (p8 >= 10) p8 -= 9;
         var p9 = d9 * 2;  if (p9 >= 10) p9 -= 9;
         modulo = 10;
      }

      /* Solo para sociedades publicas (modulo 11) */
      /* Aqui el digito verficador esta en la posicion 9, en las otras 2 en la pos. 10 */
      else if(d3 == 6){
         pub = true;
         p1 = d1 * 3;
         p2 = d2 * 2;
         p3 = d3 * 7;
         p4 = d4 * 6;
         p5 = d5 * 5;
         p6 = d6 * 4;
         p7 = d7 * 3;
         p8 = d8 * 2;
         p9 = 0;
      }

      /* Solo para entidades privadas (modulo 11) */
      else if(d3 == 9) {
         pri = true;
         p1 = d1 * 4;
         p2 = d2 * 3;
         p3 = d3 * 2;
         p4 = d4 * 7;
         p5 = d5 * 6;
         p6 = d6 * 5;
         p7 = d7 * 4;
         p8 = d8 * 3;
         p9 = d9 * 2;
      }

      suma = p1 + p2 + p3 + p4 + p5 + p6 + p7 + p8 + p9;
      residuo = suma % modulo;

      /* Si residuo=0, dig.ver.=0, caso contrario 10 - residuo*/
      var digitoVerificador = residuo==0 ? 0: modulo - residuo;

      /* ahora comparamos el elemento de la posicion 10 con el dig. ver.*/
      if (pub==true){
         if (digitoVerificador != d9){
            this.error ='El numero de "CI/RUC" es incorrecto';
            return false;
         }
         /* El ruc de las empresas del sector publico terminan con 0001*/
         if ( numero.substr(9,4) != '0001' ){
            this.error ='El numero de "CI/RUC" es incorrecto';
            return false;
         }
      }
      else if(pri == true){
         if (digitoVerificador != d10){
            this.error ='El numero de "CI/RUC" es incorrecto';
            return false;
         }
         if ( numero.substr(10,3) != '001' ){
            this.error ='El numero de "CI/RUC" es incorrecto';
            return false;
         }
      }

      else if(nat == true){
         if (digitoVerificador != d10){
            this.error ='El numero de "CI/RUC" es incorrecto';
            return false;
         }
         if (numero.length >10 && numero.substr(10,3) != '001' ){
            this.error ='El numero de "CI/RUC" es incorrecto';
            return false;
         }
      }
      return true;


}











function enviar(formulario) {	
//	formulario.boton.setAttribute('disabled','disabled');
	formulario.submit();
}
function esModificado() {
	if ( parseInt( document.getElementById('id').value ) ) return true;
	else return false;
}
function trim(str) {
	return str.replace(/^\s*|\s*$/g,"");
}
/* DOM */
function crearLI(txt){
	var objLI = document.createElement('li');
	objLI.appendChild( document.createTextNode( txt ) );
	return objLI;
}
function limpiarNodo(nodo){
	while( nodo.hasChildNodes() ) nodo.removeChild(nodo.firstChild);
}