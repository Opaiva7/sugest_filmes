<?php

namespace controller;

use service\CategService;
use template\FilmeTemp;
use template\ITemplate;

class Categ
{

    private ITemplate $template;

    public function __construct()
    {
        $this->template = new FilmeTemp();
    }

    public function listar()
    {

        $service = new CategService();
        $resultado = $service->listarCategorias();
        $this->template->layout("\\public\\categ\\listar.php", $resultado);
    }

    public function inserir()
    {

        $nome = $_POST["nome"];
        $service = new CategService();
        $resultado = $service->inserir($nome);
        header("location: /sugest_filmes/categ/listar?info=1");
    }

    public function formulario()
    {

        $this->template->layout("\\public\\categ\\form.php");
    }

    public function alteraForm()
    {

        $id = $_GET['id'];
        
        $service = new CategService();
        $resultado = $service->listarId($id);

        $this->template->layout("\\public\\categ\\alteraForm.php", $resultado);
    }

    public function deletaForm()
    {

        $id = $_GET['id'];
        $service = new CategService();
        $resultado = $service->listarId($id);

        $this->template->layout("\\public\\categ\\deletaForm.php", $resultado);
    }

    public function alterar()
    {

        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $service = new CategService();
        $resultado = $service->alterar($id, $nome);
        header("location: /sugest_filmes/categ/listar?info=2");
    }

    public function deletar()
    {

        $id = $_POST["id"];
        $service = new CategService();
        $resultado = $service->deletar($id);
        header("location: /sugest_filmes/categ/listar?info=3");
    }

    public function inicio()
    {

        $this->template->layout("\\public\\filme\\inicio.php");
    }
}
