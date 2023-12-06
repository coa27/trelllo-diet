<?php

require_once("services/rutas.service.php");
require_once("services/tableros.service.php");
require_once("services/auth.service.php");

require_once("models/tableros.php");
require_once("models/auth.php");
require_once("models/roles.php");

$rutas = new RutasService();
$rutas->index();

