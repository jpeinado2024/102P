<?php
session_start();
session_unset();
session_destroy(); // Destruir la sesión
header("location: ../index.html");
