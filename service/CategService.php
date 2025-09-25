<?php

namespace service;

use dao\mysql\CategDAO;

class CategService extends CategDAO
{

    public function listarCategorias()
    {
        return parent::listarCategorias();
    }

    public function inserir($nome)
    {
        return parent::inserir($nome);
    }

    public function alterar($id, $nome)
    {
        return parent::alterar($id, $nome);
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
