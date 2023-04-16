$(document).ready(function(){
	$('#enviar_mail').click(function(){
		
		var correo = $('#correo').val();
		var asunto = $('#asunto').val();
		var mensaje = $('#mensaje').val();
		
		/*var texto = "hola amigos como te va, blah. ñ"
		var result = texto.replace(/ /g, "ñlp");*/
		
		if (correo=='' || asunto=='' || mensaje=='') {
			alert('Favor de ingresar los datos para continuar');
		}else{
			asunto = asunto.split(" ").join("spc");
			asunto = asunto.split(".").join("pnt");
			asunto = asunto.split(",").join("cma");
			asunto = asunto.split("?").join("qst");
			asunto = asunto.split("!").join("excl");
			asunto = asunto.split("-").join("hyph");
			asunto = asunto.split("_").join("lohyph");
			asunto = asunto.split(";").join("pntcma");
			asunto = asunto.split(":").join("cln");
			
			asunto = asunto.split("0").join("nuul");
			asunto = asunto.split("1").join("odin");
			asunto = asunto.split("2").join("dva");
			asunto = asunto.split("3").join("tri");
			asunto = asunto.split("4").join("cetyre");
			asunto = asunto.split("5").join("pjat");
			asunto = asunto.split("6").join("sest");
			asunto = asunto.split("7").join("sem");
			asunto = asunto.split("8").join("vosem");
			asunto = asunto.split("9").join("devjat");
			
			asunto = asunto.split("ñ").join("n");
			asunto = asunto.split("ó").join("o");
			asunto = asunto.split("á").join("a");
			asunto = asunto.split("ú").join("u");
			asunto = asunto.split("é").join("e");
			asunto = asunto.split("ü").join("u");
			asunto = asunto.split("í").join("i");
			asunto = asunto.split("´").join(" ");
			
			
			
			var message = mensaje.split(" ").join("spc");
			message = message.split(".").join("pnt");
			message = message.split(",").join("cma");
			message = message.split("?").join("qst");
			message = message.split("!").join("excl");
			message = message.split("-").join("hyph");
			message = message.split("_").join("lohyph");
			message = message.split(";").join("pntcma");
			message = message.split(":").join("cln");
			
			message = message.split("0").join("nuul");
			message = message.split("1").join("odin");
			message = message.split("2").join("dva");
			message = message.split("3").join("tri");
			message = message.split("4").join("cetyre");
			message = message.split("5").join("pjat");
			message = message.split("6").join("sest");
			message = message.split("7").join("sem");
			message = message.split("8").join("vosem");
			message = message.split("9").join("devjat");
			
			message = message.split("ñ").join("n");
			message = message.split("ó").join("o");
			message = message.split("á").join("a");
			message = message.split("ú").join("u");
			message = message.split("é").join("e");
			message = message.split("ü").join("u");
			message = message.split("í").join("i");
			
			message = message.split("´").join(" ");
			
			window.open(base_url+'correos/correo/enviar_correo/'+correo+'/'+asunto+'/'+message, '_blank').focus();
		}
	});
});