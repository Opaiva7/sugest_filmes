<?php
include "generic/Autoload.php";
use generic\Controller;

$param = $_GET['param'] ?? "inicio";

$controller = new Controller();
$controller->verificarChamadas($param);
