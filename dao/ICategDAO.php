<?php 

namespace dao;

interface ICategDAO{

    public function listarCategorias();
    public function inserir($nome);
    public function listarId($id);
    public function alterar($id, $nome);

}

?>