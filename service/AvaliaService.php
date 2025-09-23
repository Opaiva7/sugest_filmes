<?php

namespace service;

use dao\mysql\AvaliaDAO;

class AvaliaService extends AvaliaDAO
{


    public function listarAvaliacoes()
    {
        return parent::listarAvaliacoes();
    }

    public function inserir($filme_id, $categoria_id, $nota)
    {
        return parent::inserir($filme_id, $categoria_id, $nota);
    }

    public function alterar($id, $filme_id, $categoria_id, $nota)
    {
        return parent::alterar($id, $filme_id, $categoria_id, $nota);
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
