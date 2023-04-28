<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quinielas</title>
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" 
        rel="stylesheet">
</head>
<body>
<?php include "fragments/navbar.php"; ?>
    <div class="container">
        <div class="row justify-content-center p-5">
            <div class="col-sm-8">
                <section id="form" class="d-nones">
                    <h5>Formulario Jornadas</h5>
                    <hr />
                    <form id="formulario">
                        <input type="hidden" id="id" />

                        <label for="jornada">Jornada</label>
                        <input
                            type="number"
                            class="form-control"
                            id="jornada"
                            value="0"
                        />
                        <br />
                        <label for="fecha">Fecha</label>
                        <input
                            type="date"
                            class="form-control"
                            id="fecha"
                            value=""
                        />
                        <br />
                        <div>
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-danger" id="volver">Volver</button>
                        </div>
                    </form>
                </section>
                <br />
                <section id="lista">
                    <h5>Listado Jornadas</h5>
                    <hr />
                    <div>
                        <button type="button" class="btn btn-primary" id="nuevo">Nuevo</button>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Jornada</th>
                                <th>Fecha</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </section>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="../assets/js/ajaxJornadas.js"></script>
</body>
</html>
