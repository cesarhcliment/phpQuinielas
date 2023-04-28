$(document).ready(function () {
    limpiarFormulario();
    $("#form").addClass("d-none");
    listadoEquipos();

    // Submit del formulario
    $("#formulario").submit(function (e) {
        e.preventDefault();
        let id = $("#id").val();
        let nombre= $("#nombre").val();
        const info = {
            // id: id,
            nombre: nombre,
        };
        //console.log(info);
        if (id == "0") {
            guardarEquipo(info); //nuevo
        } else {
            actualizarEquipo(id, info); //modificar
        }
        MostarListado();
    });

    // Botón editar
    $(document).on("click", "#editar", function (e) {
        let id = $(this).attr("value");
        //console.log("id",id);
        obtenerEquipo(id);
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
                eliminarEquipo(id);
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

function listadoEquipos() {
    $.ajax({
        type: "GET",
        url: "/ajaxequipos",
        dataType: "json",
        success: function (response) {
            html = "";
            response.forEach( (element) => {
                html += `
                <tr>
                    <td>${element.id}</td>
                    <td>${element.nombre}</td>
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

function obtenerEquipo(id) {
    console.log("id:", id);
    $.ajax({
        type: "GET",
        url: "/ajaxequipos/"+id,
        dataType: "json",
        success: function (response) {
            response = response[0];
            $("#id").val(response.id);
            $("#nombre").val(response.nombre);
            $("#nombre").focus();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}
    
function guardarEquipo(params) {
    $.ajax({
        type: "POST",
        url: "/ajaxequipos",
        data: params,
        dataType: "json",
        success: function (response) {
            listadoEquipos();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

function actualizarEquipo(id, params) {
    $.ajax({
        type: "PUT",
        url: "/ajaxequipos/"+id,
        data: params,
        dataType: "json",
        success: function (response) {
            listadoEquipos();
            limpiarFormulario();
        },
        error: function(){
            alert('Ha ocurrido un error');
        }
    });
}

function eliminarEquipo(id) {
    $.ajax({
        type: "DELETE",
        url: "/ajaxequipos/"+id,
        dataType: "json",
        success: function (response) {
            listadoEquipos();
            limpiarFormulario();
        },
        error: function(){
            alert('error occured');
        }
    });
}

// Funciones de utilidad

function limpiarFormulario() {
    $("#id").val("0");
    $("#nombre").val("");
    $("#nombre").focus();
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
