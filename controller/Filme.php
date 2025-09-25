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
        $service   = new FilmeService();
        $resultado = $service->listarFilmes();
        $this->template->layout("\\public\\filme\\listar.php", $resultado);
    }

    public function inserir()
    {
        $titulo  = $_POST["titulo"];
        $ano     = $_POST["ano_lancamento"];
        $poster  = $_POST["poster_url"] ?? null;
        $sinopse = $_POST["sinopse"] ?? null;

        $service = new FilmeService();
        // OBS: garanta que seu DAO/Service aceita (titulo, ano, poster, sinopse)
        $service->inserir($titulo, $ano, $poster, $sinopse);

        header("location: /sugest_filmes/filme/listar?info=1");
        exit;
    }

    public function formulario()
    {
        $this->template->layout("\\public\\filme\\form.php");
    }

    public function alteraForm()
    {
        $id       = $_GET['id'];
        $service  = new FilmeService();
        $resultado= $service->listarId($id);

        $this->template->layout("\\public\\filme\\alteraForm.php", $resultado);
    }

    public function deletaForm()
    {
        $id       = $_GET['id'];
        $service  = new FilmeService();
        $resultado= $service->listarId($id);

        $this->template->layout("\\public\\filme\\deletaForm.php", $resultado);
    }

    public function alterar()
    {
        $id      = $_POST["id"];
        $titulo  = $_POST["titulo"];
        $ano     = $_POST["ano_lancamento"];
        $poster  = $_POST["poster_url"] ?? null;
        $sinopse = $_POST["sinopse"] ?? null;

        $service = new FilmeService();
        // OBS: garanta que seu DAO/Service aceita (id, titulo, ano, poster, sinopse)
        $service->alterar($id, $titulo, $ano, $poster, $sinopse);

        header("location: /sugest_filmes/filme/listar?info=1");
        exit;
    }

    public function deletar()
    {
        $id      = $_GET["id"];
        $service = new FilmeService();
        $service->deletar($id);

        header("location: /sugest_filmes/filme/listar?info=1");
        exit;
    }

    public function inicio()
    {
        // Home (sua landing). Este arquivo deve existir:
        // C:\xampp\htdocs\sugest_filmes\public\filme\inicio.php
        $this->template->layout("\\public\\filme\\inicio.php");
        // Se preferir usar outra página:
        // $this->template->layout("\\public\\filme\\PaginaPrincipal.php");
    }
}
