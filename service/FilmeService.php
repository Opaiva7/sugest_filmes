<?php

namespace service;

use dao\mysql\FilmeDAO;

class FilmeService extends FilmeDAO
{
    public function listarFilmes()
    {
        return parent::listarFilmes();
    }

    public function inserir($titulo, $ano_lancamento, $poster_url = null, $sinopse = null)
    {
        return parent::inserir($titulo, $ano_lancamento, $poster_url, $sinopse);
    }

    public function alterar($id, $titulo, $ano_lancamento, $poster_url = null, $sinopse = null)
    {
        return parent::alterar($id, $titulo, $ano_lancamento, $poster_url, $sinopse);
    }

    public function listarId($id)
    {
        return parent::listarId($id);
    }

    public function deletar($id)
    {
        return parent::deletar($id);
    }
}
