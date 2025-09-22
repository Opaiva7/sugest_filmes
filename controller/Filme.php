<?php

namespace controller;

use service\FilmeService;
use template\FilmeTemp;
use template\ITemplate;


class Filme
{

    private ITemplate $template;
    
    public function __construct()
    {

        $this->template = new FilmeTemp();
    }

    public function listar()
    {

        $service = new FilmeService();
        $resultado = $service->listarFilmes();
        $this->template->layout("\\public\\filme\\listar.php", $resultado);
    }

    public function inserir()
    {
        $titulo = $_POST["titulo"];
        $ano = $_POST["ano_lancamento"];
        $service = new FilmeService();
        $resultado = $service->inserir($titulo, $ano);
        header("location: /sugest_filmes/filme/listar?info=1");
    }

    public function formulario()
    {

        $this->template->layout("\\public\\filme\\form.php");
    }

    public function alteraForm()
    {
        $id = $_GET['id'];
        $service = new FilmeService();
        $resultado = $service->listarId($id);

        $this->template->layout("\\public\\filme\\alteraForm.php", $resultado);
    }

    public function deletaForm()
    {
        $id = $_GET['id'];
        $service = new FilmeService();
        $resultado = $service->listarId($id);

        $this->template->layout("\\public\\filme\\deletaForm.php", $resultado);
    }


    public function alterar()
    {
        $id = $_POST["id"];
        $titulo = $_POST["titulo"];
        $ano = $_POST["ano_lancamento"];
        $service = new FilmeService();
        $resultado = $service->alterar($id, $titulo, $ano);
        header("location: /sugest_filmes/filme/listar?info=1");
    }

    public function deletar() 
    {
        $id = $_GET["id"];
        $service = new FilmeService();
        $resultado = $service->deletar($id);
        header("location: /sugest_filmes/filme/listar?info=1");
    }

    public function inicio(){

        $this->template->layout("\\public\\filme\\inicio.php");

    }

}
