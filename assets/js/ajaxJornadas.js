$(document).ready(function () {
    limpiarFormulario();
    $("#form").addClass("d-none");
    listadoJornadas();

    // Submit del formulario
    $("#formulario").submit(function (e) {
        e.preventDefault();
        let id = $("#id").val();
        let jornada= $("#jornada").val();
        let fecha= $("#fecha").val();
        const info = {
            // id: id,
            jornada: jornada,
            fecha: fecha,
        };
        //console.log(info);
        if (id == "0") {
            guardarJornada(info); //nuevo
        } else {
            actualizarJornada(id, info); //modificar
        }
        MostarListado();
    });

    // Botón editar
    $(document).on("click", "#editar", function (e) {
        let id = $(this).attr("value");
        //console.log("id",id);
        obtenerJornada(id);
        MostarForm();
    });

    // Botón eliminar
    $(document).on("click", "#eliminar", function (e) {
        let id = $(this).attr("value");
        console.log("id",id);
        Swal.fire({
            title: '¿Seguro que desea borrar?',
            text: `El registro ${id} será borrado`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
          }).then((result) => {
            if (result.value) {
                eliminarJornada(id);
            }
        })
    });

    // Ir al formulario desde el listado
    $(document).on("click", "#nuevo", function (e) {
        MostarForm();
    });

    // Volver al listado desde formulario
    $(document).on("click", "#volver", function (e) {
        MostarListado();
    });
    
});

// Funciones AJAX

function listadoJornadas() {
    $.ajax({
        type: "GET",
        url: "/ajaxjornadas",
        dataType: "json",
        success: function (response) {
            html = "";
            response.forEach( (element) => {
                fecha = element.fecha.substr(8, 2) + "/" + element.fecha.substr(5, 2) + "/" + element.fecha.substr(0, 4);
                // <td>${element.fecha}</td>
                html += `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.jornada}</td>
                    <td>${fecha}</td>
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

function obtenerJornada(id) {
    console.log("id:", id);
    $.ajax({
        type: "GET",
        url: "/ajaxjornadas/"+id,
        dataType: "json",
        success: function (response) {
            response = response[0];
            $("#id").val(response.id);
            $("#jornada").val(response.jornada);
            $("#fecha").val(response.fecha);
            $("#jornada").focus();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}
    
function guardarJornada(params) {
    $.ajax({
        type: "POST",
        url: "/ajaxjornadas",
        data: params,
        dataType: "json",
        success: function (response) {
            listadoJornadas();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

function actualizarJornada(id, params) {
    $.ajax({
        type: "PUT",
        url: "/ajaxjornadas/"+id,
        data: params,
        dataType: "json",
        success: function (response) {
            listadoJornadas();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

function eliminarJornada(id) {
    $.ajax({
        type: "DELETE",
        url: "/ajaxjornadas/"+id,
        dataType: "json",
        success: function (response) {
            listadoJornadas();
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
    $("#jornada").val("0");
    $("#fecha").val("");
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
