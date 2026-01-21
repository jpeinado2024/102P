<?php
session_start();
if (! isset($_SESSION['admi'])) {
    header("location: index.html");
    exit();
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <link rel="stylesheet" href="styles/style.css">
    <link rel="icon" href="img/icon.png">
   
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1"
        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <!-- HEADER -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Ingreso del administrador
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <!-- DATOS DEL USUARIO -->
                    <div class="mb-3">
                        <p><strong>Nombre:</strong>
                            <span id="modal-nombre">—</span>
                        </p>
                        <p><strong>Documento:</strong>
                            <span id="modal-documento">—</span>
                        </p>
                    </div>

                    <hr>

                    <!-- TABLA DE INVITADOS -->
                    <h6>Invitados</h6>
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Documento</th>

                                </tr>
                            </thead>
                            <tbody id="modal-invitados">
                                <tr>
                                    <td colspan="3" class="text-center">
                                        Cargando invitados...
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>
    <!-- Final -->
    <header></header>
    <div class="top-bar">
        <img src="https://via.placeholder.com/150x60?text=LOGO+AQUÍ" alt="Logo" class="logo-img">
    </div>

    <div class="header">
        <h1 class="logo-102">102</h1>
        <span class="siglas-pl">Israel Romero</span>
    </div>
    </header>
    <main>
        <div id="view-admin" class="">
            <div class="container admin-wide">
                <div
                    style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--rojo); padding-bottom:15px; flex-wrap:wrap; gap:10px;">
                    <h2 style="margin:0;">DATOS DEL SONDEO (102 PL)</h2>
                    <div class="d-flex align-items-center gap-2 flex-wrap" style="gap: 10px">

                       

                        <!-- BOTÓN EXCEL -->
                        <button onclick="exportarExcel()"
                            style="background:var(--rojo); color:white; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; font-weight:bold;">
                            📥 EXCEL
                        </button>

                        <a href="backend/cerrarSesion.php"
                            style="padding:10px; cursor:pointer; text-decoration: none; color: #656d68;">
                            CERRAR
                        </a>
                    </div>

                </div>
                <div class="table-res">
                    <table id="Tabla_usarios" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Teléfono</th>
            <th>Dirección</th>
            <th>Código Propio</th>
        </tr>
    </thead>
    <tbody id="admin-table-body"></tbody>
</table>

                </div>
            </div>
        </div>
    </main>
   <!-- jQuery COMPLETO -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<!-- Tus scripts -->
 <script src="frontend/cargarsondeo.js"></script>
<script src="frontend/cargartabla.js"></script>

    
</body>

</html>