<?php
session_start();
if (!isset($_SESSION['admi'])) {
    header("location: index.html");
    exit();
}
include_once 'backend/Destruir.php';
verificar_inactividad();
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
    <link rel="stylesheet" href="styles/style.css">
     <link rel="icon" href="img/icon.png">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
</head>
<body>
        <div class="top-bar">
        <img src="https://via.placeholder.com/150x60?text=LOGO+AQUÍ" alt="Logo" class="logo-img">
    </div>

    <div class="header">
        <h1 class="logo-102">102</h1>
        <span class="siglas-pl">Israel Romero</span>
    </div>
    <div id="view-admin" class="">
        <div class="container admin-wide">
            <div
                style="display:flex; justify-content:space-between; align-items:center; border-bottom:2px solid var(--rojo); padding-bottom:15px; flex-wrap:wrap; gap:10px;">
                <h2 style="margin:0;">DATOS DEL SONDEO (102 PL)</h2>
                <div>
                    <button onclick="exportarExcel()"
                        style="background:#1D6F42; color:white; border:none; padding:12px 25px; border-radius:8px; cursor:pointer; font-weight:bold;">📥
                        EXCEL</button>
                    <a href="backend/cerrarSesion.php" style="padding:10px; cursor:pointer; text-decoration: none; color: #656d68;">CERRAR</a>
                </div>
            </div>
            <div class="table-res">
                <table id="tabla-datos">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Código Propio</th>
                            <th>Invitado Por (Código)</th>
                        </tr>
                    </thead>
                    <tbody id="admin-table-body"></tbody>
                </table>
            </div>
        </div>
    </div>
     <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
</body>
</html>