<?php 

namespace dao;

interface IFilmeDAO {

    public function listarFilmes();
    public function inserir($titulo, $ano_lancamento, $poster_url = null, $sinopse = null);
    public function listarId($id);
    public function alterar($id, $titulo, $ano_lancamento, $poster_url = null, $sinopse = null);
    public function deletar($id);
}

?>
