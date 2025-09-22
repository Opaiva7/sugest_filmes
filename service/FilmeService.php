<?php

namespace service;

use dao\mysql\FilmeDAO;

class FilmeService extends FilmeDAO
{

    public function listarFilmes()
    {
        return parent::listarFilmes();
    }

    public function inserir($titulo, $ano_lancamento)
    {
        return parent::inserir($titulo, $ano_lancamento);
    }

    public function alterar($id, $titulo, $ano_lancamento)
    {
        return parent::alterar($id, $titulo, $ano_lancamento);
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
