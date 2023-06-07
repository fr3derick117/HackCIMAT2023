let idEliminar;
let idActualizar;
let idVer;

//alert("Hola");

function actionRead() {
    //alert("Funcionando");
    $.ajax({
      method:"POST",
      url: "propios/real.php",
      data: {
        accion : "read"
      },
      success: function( respuesta ) {
        JSONRespuesta = JSON.parse(respuesta);
        //alert(JSONRespuesta);
        if (JSONRespuesta.estado == 1) {
          //Mostrar los registros (categorias) en la tabla
          document.getElementById('tipo_cultivo').innerHTML = JSONRespuesta.cultivo.tipo_cultivo;
          document.getElementById('tipo_huerto').innerHTML = JSONRespuesta.cultivo.tipo_huerto;
          document.getElementById('tipo_suelo').innerHTML = JSONRespuesta.cultivo.tipo_suelo;
          document.getElementById('etapa').innerHTML = JSONRespuesta.cultivo.etapa;
          document.getElementById('ph').data-rel = JSONRespuesta.cultivo.ph;
          document.getElementById('nitrogeno').data-rel = JSONRespuesta.cultivo.tipo_cultivo;
          document.getElementById('potasio').data-rel = JSONRespuesta.cultivo.potasio;
          document.getElementById('fosforo').data-rel = JSONRespuesta.cultivo.fosforo;
          document.getElementById('fertilizante').data-rel = JSONRespuesta.cultivo.fertilizante;
          document.getElementById('temperatura').data-rel = JSONRespuesta.cultivo.temperatura;
          document.getElementById('humedad').data-rel = JSONRespuesta.cultivo.tipo_cultivo;
        }
        console.log(respuesta);
        alert("Respuesta del servidor: "+respuesta);
      },
  });
  //alert($.ajax[method]);
  //alert("trabajando en ello");
}

function actionUpdate() {
  let tipo_entrega = document.getElementById("tipo_entrega_actualizar").value;
  //alert(tipo_entrega);
  //let nombre_archivo = document.getElementById("archivo_nombre_actualizar").value;
  //alert(nombre_archivo);
  var formData = new FormData();
  var files = $('#archivo_subir_actualizar')[0].files[0];
  //alert(files);
  formData.append('file',files);
  formData.append('id',idActualizar);
  formData.append('nombre_entrega',tipo_entrega);
  formData.append('accion','update');

  $.ajax({
    method:"POST",
    url: "propios/real.php",
    data: formData,
    contentType: false,
    processData: false,
    success: function( respuesta ) {
      //alert(respuesta);
      JSONRespuesta = JSON.parse(respuesta);
      
      if (JSONRespuesta.estado == 1) {
        let Botones = '<button type="button" class="btn btn-info btn-lg text-white" data-toggle="modal" data-target="#Modal_Ver" onclick="identificarVer('+JSONRespuesta.id+')"> Ver</button>';
          Botones += '<button type="button" class="btn btn-primary btn-lg text-white" data-toggle="modal" data-target="#Modal_Actualizar" onclick="identificarActualizar('+JSONRespuesta.id+')" href="#">Edit </button>';
          Botones += '<button type="button" class="btn btn-danger btn-lg text-white" data-toggle="modal" data-target="#Modal-Eliminar" onclick="identificarEliminar('+JSONRespuesta.id+')" href="#">Del</button>';

        
        let tabla = $("#zero_config").DataTable();
        var temp = tabla.row("#renglon_"+idActualizar).data();
        //Nombre
        temp[0] = JSONRespuesta.nombre_entrega;
        //Descripcion
        temp[1] = JSONRespuesta.fecha_entrega;
        temp[2] = Botones;
        tabla.row("#renglon_"+idActualizar).data(temp).draw();
        //location.reload();
        toastr.success(JSONRespuesta.mensaje);
        //alert(JSONRespuesta.mensaje);
      }
      //alert("Respuesta del servidor: "+respuesta);
      //alert(respuesta);
    },
  });
}
