function popUpBanco() {
  alert(
    "Pues puedes irte derechito al banco todo qlero 😡\n" +
      "Exactamente por tomar malas decisiones como estas es que estás como estás😠"
  );
}

function popUpLinea() {
  alert(
    "Hiciste una buena elección... La mejór elección, de hecho... 😊\n" +
      "Estámos orgullosos de tí 🔥🔥🔥"
  );
}

// $(document).ready(function(){
//   $('#busquedaPoliza').click(function(e){
//     let search = $('#idPoliza').val();
//     $.ajax({
//       url: "https://www.loremipsum.syswebgroup.online/poliza-search.php",
//       type: 'POST',
//       data: { search },
//       success: function(response) {
//         console.log(response);
//       }
//     })
//   })
// });

/*$(document).ready(function() {
    // Global Settings
    let edit = false;
  
    // Testing Jquery
    $('#resultadoPoliza').hide();
  
  
    // Prueba 1 de busqueda
    $('#busquedaPoliza').click(function() {
      if($('#idPoliza').val()) {
        let search = $('#idPoliza').val();
        $.ajax({
          //url: 'https://aduana.yapasenosinge.syswebgroup.online/application/modules/aduanas/busqueda/busquedaController.php',
          url: '../proyecto_aduana/application/modules/aduanas/busqueda/consulta_poliza',
          data: {search},
          type: 'POST',
          success: function (response) {
            if(!response.error) {
              let polizas = JSON.parse(response);
              let template = '';
              polizas.forEach(poliza => {
                template += `
                       <li><a href="#" class="task-item">${poliza.producto}</a></li>
                      ` 
              });
              $('#resultadoPoliza').show();
              $('#containerPoliza').html(template);
            }
          } 
        })
      }
    });
  
    // Prueba 2 de busqueda
    function fetchTasks() {
      $.ajax({
        url: base_url+'application/modules/aduanas/busqueda/busquedaPoliza.php',
        type: 'GET',
        success: function(response) {
          const tasks = JSON.parse(response);
          let template = '';
          tasks.forEach(task => {
            template += `
                    <tr taskId="${task.id}">
                    <td>${task.id}</td>
                    <td>
                    <a href="#" class="task-item">
                      ${task.name} 
                    </a>
                    </td>
                    <td>${task.description}</td>
                    <td>
                      <button class="task-delete btn btn-danger">
                       Delete 
                      </button>
                    </td>
                    </tr>
                  `
          });
          $('#tasks').html(template);
        }
      });
    }
  
    // Get a Single Task by Id 
    $(document).on('click', '.task-item', (e) => {
      const element = $(this)[0].activeElement.parentElement.parentElement;
      const id = $(element).attr('taskId');
      $.post('task-single.php', {id}, (response) => {
        const task = JSON.parse(response);
        $('#name').val(task.name);
        $('#description').val(task.description);
        $('#taskId').val(task.id);
        edit = true;
      });
      e.preventDefault();
    });
  });*/

/*$(document).ready(function() {
    $("#busquedaPoliza").click(function() {
      var id = $("#idPoliza").val();
      $.ajax({
        url: "../proyecto_aduana/application/modules/aduanas/busqueda/busquedaController.php",
        type: "POST",
        dataType: "json",
        data: { accion: "obtenerDatos", id: id },
        success: function(datos) {
          // Limpiar la tabla
          $("#tablaPoliza").find("tr:gt(0)").remove();
          // Agregar los datos a la tabla
          $.each(datos, function(i, dato) {
            $("#tablaPoliza").append("<tr><td>" + dato.id_poliza + "</td><td>" + dato.id_manifiesto + "</td><td>" + dato.cliente + "</td><td>" + dato.id_detalle + "</td><td>" + dato.tipo_producto + "</td><td>" + dato.producto + "</td><td>" + dato.precio + "</td><td>" + dato.porcentaje + "</td><td>" + dato.color + "</td><td>" + dato.pagado + "</td></tr>");
          });
        },
        error: function(xhr, status, error) {
          console.log(xhr.responseText);
        }
      });
    });
  });
  */

//Mirror progra iv
/*$(document).ready(function(e){
  $("#busquedaPoliza").click(function(){
    //console.log(base_url+"aduanas/aduana/consultar_poliza");
    //console.log(base_url+"application/aduanas/aduana/consultar_poliza");  
		$.ajax({
		url: "http://jacobgt.syswebgroup.online/conexion.php"
		,method:"POST"
		,data: {}
		,async: false
		,success: function(data){
			resultado = JSON.parse(data);
			datos = resultado.datos;
			var html = "<div class='cardImg'";
			for(i = 0; i < datos.length ; i++){
				if(datos[i].publicar == 'S'){
					html+="<img src='"+ base_url + "images/" +datos[i].imagen+".png'";
					html+="<br/>";
					var concepto = datos[i].concepto.split("_").join(" ");
					html+="<h1>"+datos[i].descripcion+"</h1>";
					html+="<br/>";
					html+="<p class='priceImg'>$"+datos[i].precio+"</p>";
					html+="<br/>";
					html+="<p style='font-size: 16px'>"+concepto+"</p>";
					html+="<hr/>";
				}
			}
			html += "</div>";
			$("#imageView").append(html);
			}
			,error: function(XMLHttpRequest, textStatus, errorThrown){
				alert(XMLHttpRequest);
        alert(textStatus);
        alert(errorThrown);
			}
		});
	});
});*/
