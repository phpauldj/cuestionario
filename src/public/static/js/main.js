/*
	jStrap -> Drinpic
*/
var jStrap = function(){
    //Mail
    this.isMail = function(sVal){
        var ep = /^(([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+)?$/g;
        return ( ep.test(sVal) && (sVal != '') );
    };
}
$(function(){
	var jstrap = new jStrap();
    // Class
    var Suscriptor = function(){
        this.suscribir = function(){
            var aSuscribe = $('#submitN'),
			divSuscrib = $('#recibirNoti'),
			content = $('#formRegister'),
			divMensaje = $('#msjThanks');
            aSuscribe.bind('click', function(e){
                    e.preventDefault();
                    var t = $(this);					
					divMensaje.addClass('hide').removeClass('error success').text('');
					if(jstrap.isMail($.trim($('#inputN').val()))){
						var	frmData = $('#frmsuscripcion').serialize();
							t.attr('value','Enviando ...');
							t.attr('disbled','disabled');
						//ajax	
						$.ajax({
							url : '/suscriptor/home/registro-suscripcion/',
							type : 'POST',
							dataType : 'json',
							contentType: 'application/x-www-form-urlencoded',
							data : frmData,
							success : function(res){
								t.removeAttr('disabled');
								t.attr('value','Email Enviado.');  
								divMensaje.removeClass('hide error').addClass('success').text(res.msj);
								divSuscrib.slideUp('fast');
							},
							error : function(){
								t.attr('value','Fallo Envio.').css('color','red');
								divMensaje.removeClass('hide success').addClass('error').text('Ocurrio un error, vuelve a intentarlo.');
								recibirNoti.slideDown('fast', function(){
									recibirNoti.remove();
								});
                                t.removeAttr('disabled');
							}
						});								
					
					}else{
						divMensaje.removeClass('hide success').addClass('error').text('Ingresa un email válido.');	
					}
					
							
            });
        };
    };
    
    var objsu = new Suscriptor();
    objsu.suscribir();

	$('[placeholder]').focus(function() {
	  var input = $(this);
	  if (input.val() == input.attr('placeholder')) {
		input.val('');
		input.removeClass('placeholder');
	  }
	}).blur(function() {
	  var input = $(this);
	  if (input.val() == '' || input.val() == input.attr('placeholder')) {
		input.addClass('placeholder');
		input.val(input.attr('placeholder'));
	  }
	}).blur();	

});
