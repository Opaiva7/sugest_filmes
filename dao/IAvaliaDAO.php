<?php 

namespace dao;

interface IAvaliaDAO{

    public function listarAvaliacoes();
    public function inserir($filme_id, $categoria_id, $nota);
    public function listarId($id);
    public function alterar($id, $filme_id, $categoria_id, $nota);

}


?>