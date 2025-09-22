<?php 

include "generic/Autoload.php";
use generic\Controller;

    $rota = $_GET['param']??"sugest_filmes/inicio";
    $controller = new Controller();
    $controller->verificarChamadas($rota);


?>