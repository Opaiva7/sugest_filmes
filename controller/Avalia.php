<?php

namespace controller;

use service\AvaliaService;
use template\FilmeTemp;
use template\ITemplate;


class Avalia
{

    private ITemplate $template;

    public function __construct()
    {
        $this->template = new FilmeTemp();
    }

    public function listar()
    {

        $service = new AvaliaService();
        $resultado = $service->listarAvaliacoes();
        $this->template->layout("\\public\\avalia\\listar.php", $resultado);
    }

    public function inserir()
    {
       
        $filme_id = $_POST["filme_id"];
        $categoria_id = $_POST["categoria_id"];
        $nota = $_POST["nota"];
        $service = new AvaliaService();
        $resultado = $service->inserir($filme_id, $categoria_id, $nota);
        header("location: /sugest_filmes/avalia/listar?info=1");
    }

    public function formulario()
    {

        $this->template->layout("\\public\\avalia\\form.php");
    }

    public function alteraForm()
    {

        $id = $_GET['id'];
        $service = new AvaliaService();
        $resultado = $service->listarId($id);

        $this->template->layout("\\public\\avalia\\alteraForm.php", $resultado);
    }

    public function deletaForm()
    {

        $id = $_GET['id'];
        $service = new AvaliaService();
        $resultado = $service->listarId($id);

        $this->template->layout("\\public\\avalia\\deletaForm.php", $resultado);
    }

    public function alterar()
    {

        $id = $_POST["id"];
        $filme_id = $_POST["filme_id"];
        $categoria_id = $_POST["categoria_id"];
        $nota = $_POST["nota"];
        $service = new AvaliaService();
        $resultado = $service->alterar($id, $filme_id, $categoria_id, $nota);
        header("location: /sugest_filmes/avalia/listar?info=1");
    }

    public function deletar()
    {

        $id = $_GET['id'];
        $service = new AvaliaService();
        $resultado = $service->deletar($id);
        header("location: /sugest_filmes/avalia/listar?info=1");
    }

    public function inicio()
    {

        $this->template->layout("\\public\\filme\\inicio.php");
    }
}
