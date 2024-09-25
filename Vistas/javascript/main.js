// Basic example
$(document).ready(function () {
	//Datatables
	$('#dtBasicExample').DataTable({
	    pagingType: "simple", // "simple" option for 'Previous' and 'Next' buttons only
		language: {
        "sProcessing":    "Procesando...",
        "sLengthMenu":    "Mostrar _MENU_ registros",
        "sZeroRecords":   "No se encontraron resultados",
        "sEmptyTable":    "Ningún dato disponible en esta tabla",
        "sInfo":          "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":     "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":   "",
        "sSearch":        "Buscar:",
        "sUrl":           "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":    "Último",
            "sNext":    "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }
		/*language: {
                url: '../locales/spanish.json' //Ubicacion del archivo con el json del idioma. Problemas con CORS en localhost
            }*/
	});
	$('.dataTables_length').addClass('bs-select');
	
	bsCustomFileInput.init(); //Hace el FileInput dinámico: https://www.npmjs.com/package/bs-custom-file-input

	  //Pasar datos a Modal con input hidden
	
	$("#add_file").click( function() {

	        $("#add_file_modal input[name=custom_file]").val("");
	        $("#add_file_modal input[name=movie]").val("");
	        $("#add_file_modal input[name=uuid]").val("").prop("disabled", true);
	});

	$("#add_folder").click( function() {

	        $("#add_folder_modal input[name=folder_name]").val("");
	        $("#add_folder_modal input[name=uuid]").val("").prop("disabled", true);
	});
    
    $(".edit-item").click( function(){
	      
		item_name = $(this).find(".item_name").html(); //rellenar find() con dato del campo nombre de archivo o carpeta
		uuid = $(this).find(".uuid").html(); //uuid
        type = $(this).find(".type").html();//tipo del elemento
        $("#edit_item_modal input[name=type]").val(type);
		$("#edit_item_modal input[name=item_name]").val(item_name);
		$("#edit_item_modal input[name=uuid]").val(uuid).prop("disabled", false);
	});
	
	$(".delete-item").click( function(){
	      
		uuid = $(this).find(".uuid").html(); //uuid
        type = $(this).find(".type").html();//tipo del elemento
		$("#delete_item_modal input[name=uuid]").val(uuid);
        $("#delete_item_modal input[name=type]").val(type);
	});
	
    $(".share-item").click(function(){
		uuid = $(this).find(".uuid").html();
		var item = $("#link").text('raspi-anxo.duckdns.org:14081/Controller/Main_controller.php?action=sharedFile&file='+uuid);
		//Otra posible forma
		//var link = document.getElementById('link');
		//link.innerHTML ="raspi-anxo.duckdns.org:14081/Controller/Main_controller.php?action=shared&file="+uuid;
	});
    
    

});

 //Asigno el evento "click" del botón para provoar el copiado
    document.getElementById('btn-copy').addEventListener('click', copiarAlPortapapeles);

    //Función que lanza el copiado del código
    function copiarAlPortapapeles(ev){
        var codigoACopiar = document.getElementById('link');    //Elemento a copiar
        //Debe estar seleccionado en la página para que surta efecto, así que...
        var seleccion = document.createRange(); //Creo una nueva selección vacía
        seleccion.selectNodeContents(codigoACopiar);    //incluyo el nodo en la selección
        //Antes de añadir el intervalo de selección a la selección actual, elimino otros que pudieran existir (sino no funciona en Edge)
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(seleccion);  //Y la añado a lo seleccionado actualmente
        try {
            var res = document.execCommand('copy'); //Intento el copiado
            if (res)
                exito();
            else
                fracaso();

            mostrarAlerta();
        }
        catch(ex) {
            excepcion();
        }
        window.getSelection().removeRange(seleccion);
    }

///////
// Auxiliares para mostrar y ocultar mensajes
///////
    var divAlerta = document.getElementById('alerta');
    
    function exito() {
        divAlerta.innerText = '¡¡Código copiado al portapapeles!!';
        divAlerta.classList.add('alert-success');
    }

    function fracaso() {
        divAlerta.innerText = '¡¡Ha fallado el copiado al portapapeles!!';
        divAlerta.classList.add('alert-warning');
    }

    function excepcion() {
        divAlerta.innerText = 'Se ha producido un error al copiar al portapaples';
        divAlerta.classList.add('alert-danger');
    }

    function mostrarAlerta() {
        divAlerta.classList.remove('invisible');
        divAlerta.classList.add('visible');
        setTimeout(ocultarAlerta, 1500);
    }

    function ocultarAlerta() {
        divAlerta.innerText = '';
        divAlerta.classList.remove('alert-success', 'alert-warning', 'alert-danger', 'visible');
        divAlerta.classList.add('invisible');
    }

