$(document).ready(function () {
    let jornada = 0;
    let idlocal = 0;
    let idvisitante = 0;
    limpiarFormulario();
    $("#form").addClass("d-none");
    listadoPartidos();

    // Submit del formulario
    $("#formulario").submit(function (e) {
        e.preventDefault();
        let id = $("#id").val();
        let jornada = $("#jornada").val();
        let orden = $("#orden").val();
        //let fecha = $("#fecha").val();
        let fecha = $( "#jornada option:selected" ).text();
        let idlocal = $("#idlocal").val();
        let idvisitante = $("#idvisitante").val();
        let goleslocal = $("#goleslocal").val();
        let golesvisitante = $("#golesvisitante").val();
        const info = {
            // id: id,
            jornada: jornada,
            orden: orden,
            fecha: fecha,
            idlocal: idlocal,
            idvisitante: idvisitante,
            goleslocal: goleslocal,
            golesvisitante: golesvisitante,
        };
        if (id == "0") {
            guardarPartido(info); //nuevo
        } else {
            actualizarPartido(id, info); //modificar
        }
        MostarListado();
    });

    // Botón editar
    $(document).on("click", "#editar", function (e) {
        let id = $(this).attr("value");
        obtenerPartido(id);
        MostarForm();
        obtenerJornadas(1);
        obtenerEquipos(1);
    });

    // Botón eliminar
    $(document).on("click", "#eliminar", function (e) {
        let id = $(this).attr("value");
        Swal.fire({
            title: '¿Seguro que desea borrar?',
            text: `El registro ${id} será borrado`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
          }).then((result) => {
            if (result.value) {
                eliminarPartido(id);
            }
        })
    });

    // Ir al formulario desde el listado
    $(document).on("click", "#nuevo", function (e) {
        MostarForm();
        obtenerJornadas(0);
        obtenerEquipos(0);
    });

    // Volver al listado desde formulario
    $(document).on("click", "#volver", function (e) {
        MostarListado();
    });
    
});

// Funciones AJAX

function listadoPartidos() {
    $.ajax({
        type: "GET",
        url: "/ajaxpartidos",
        dataType: "json",
        success: function (response) {
            html = "";
            response.forEach( (element) => {
                fecha = element.fecha.substr(8, 2) + "/" + element.fecha.substr(5, 2) + "/" + element.fecha.substr(0, 4);
                // <td>${element.fecha}</td>
                html += `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.jornada}-${element.orden}</td>
                    <td>${fecha}</td>
                    <td>${element.idlocal} ${element.local}</td>
                    <td>${element.idvisitante} ${element.visitante}</td>
                    <td>${element.goleslocal}-${element.golesvisitante}</td>
                    <td>
                        <a class="btn btn-success" id="editar" value="${element.id}">Editar</a>
                        <a class="btn btn-danger" id="eliminar" value="${element.id}">Eliminar</a>
                    </td>
                </tr>
                `;
            });
            $("#tbody").html(html); // id del tbody de la tabla
        },
        error: function (req, status, error) {
            var err = req.responseText;
            console.log(err);
            alert(err.Message);
        }
    });
}

function obtenerPartido(id) {
    $.ajax({
        type: "GET",
        url: "/ajaxpartidos/"+id,
        dataType: "json",
        success: function (response) {
            response = response[0];
            $("#id").val(response.id);
            $("#jornada").val(response.jornada);
            $("#orden").val(response.orden);
            $("#fecha").val(response.fecha);
            $("#idlocal").val(response.idlocal);
            $("#idvisitante").val(response.idvisitante);
            $("#goleslocal").val(response.goleslocal);
            $("#golesvisitante").val(response.golesvisitante);
            jornada = response.jornada;
            idlocal = response.idlocal;
            idvisitante = response.idvisitante;
            $("#jornada").focus();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}
    
function guardarPartido(params) {
    $.ajax({
        type: "POST",
        url: "/ajaxpartidos",
        data: params,
        dataType: "json",
        success: function (response) {
            listadoPartidos();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

function actualizarPartido(id, params) {
    $.ajax({
        type: "PUT",
        url: "/ajaxpartidos/"+id,
        data: params,
        dataType: "json",
        success: function (response) {
            listadoPartidos();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

function eliminarPartido(id) {
    $.ajax({
        type: "DELETE",
        url: "/ajaxpartidos/"+id,
        dataType: "json",
        success: function (response) {
            listadoPartidos();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

// Funciones de utilidad

function limpiarFormulario() {
    $("#id").val("0");
    $("#jornada").val("");
    $("#orden").val("");
    $("#fecha").val("");
    $("#idlocal").val("");
    $("#idvisitante").val("");
    $("#goleslocal").val("");
    $("#golesvisitante").val("");
    $("#jornada").focus();
    document.getElementById("jornada").focus();
}

function MostarListado()
{
    $("#lista").removeClass("d-none");
    $("#form").addClass("d-none");
}

function MostarForm()
{
    $("#lista").addClass("d-none");
    $("#form").removeClass("d-none");
    limpiarFormulario();
}

//=============================

function obtenerJornadas(id) {
    $.ajax({
        type: "GET",
        url: "/ajaxjornadas",
        dataType: "json",
        success: function (response) {
            // let jornada = $("#jornada").val();
            $('#jornada').empty();
            html = '<option selected>Elegir jornada</option>';
            if (id == 0)   $('#jornada').append(html);
            response.forEach( (element) => {
                fecha = element.fecha.substr(8, 2) + "/" + element.fecha.substr(5, 2) + "/" + element.fecha.substr(0, 4);
                html = '<option value="' + element.jornada + '">' + fecha + '</option>';
                $('#jornada').append(html);
            });
            if (id > 0)  $('#jornada').val(jornada);
        },
        error: function (req, status, error) {
            var err = req.responseText;
            console.log(err);
            alert(err.Message);
        }
    });
}

//=============================

function obtenerEquipos(id) {
    $.ajax({
        type: "GET",
        url: "/ajaxequipos",
        dataType: "json",
        success: function (response) {
            // local
            $('#idlocal').empty();
            html = '<option selected>Elegir equipo local</option>';
            if (id == 0)   $('#idlocal').append(html);
            response.forEach( (element) => {
                html = '<option value="' + element.id + '">' + element.nombre + '</option>';
                $('#idlocal').append(html);
            });
            if (id > 0)   $('#idlocal').val(idlocal);

            // visitante
            $('#idvisitante').empty();
            html = '<option selected>Elegir equipo visitante</option>';
            if (id == 0)   $('#idvisitante').append(html);
            response.forEach( (element) => {
                html = '<option value="' + element.id + '">' + element.nombre + '</option>';
                $('#idvisitante').append(html);
            });
            if (id > 0)   $('#idvisitante').val(idvisitante);
        },
        error: function (req, status, error) {
            var err = req.responseText;
            console.log(err);
            alert(err.Message);
        }
    });
}
