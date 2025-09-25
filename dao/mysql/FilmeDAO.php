<?php

namespace dao\mysql;

use dao\IFilmeDAO;
use generic\MysqlFactory;

class FilmeDAO extends MysqlFactory implements IFilmeDAO
{
    public function listarFilmes()
    {
        $sql = "SELECT id, titulo, ano_lancamento, poster_url, sinopse FROM filmes";
        return $this->banco->executar($sql);
    }

    public function listarId($id)
    {
        $sql = "SELECT id, titulo, ano_lancamento, poster_url, sinopse FROM filmes WHERE id = :id";
        $param =  [":id" => $id];
        return $this->banco->executar($sql, $param);
    }

    public function inserir($titulo, $ano_lancamento, $poster_url = null, $sinopse = null)
    {
        $sql = "INSERT INTO filmes (titulo, ano_lancamento, poster_url, sinopse)
                VALUES (:titulo, :ano_lancamento, :poster_url, :sinopse)";
        $param = [
            ":titulo"         => $titulo,
            ":ano_lancamento" => $ano_lancamento,
            ":poster_url"     => $poster_url,
            ":sinopse"        => $sinopse
        ];
        return $this->banco->executar($sql, $param);
    }

    public function alterar($id, $titulo, $ano_lancamento, $poster_url = null, $sinopse = null)
    {
        $sql = "UPDATE filmes
                   SET titulo = :titulo,
                       ano_lancamento = :ano_lancamento,
                       poster_url = :poster_url,
                       sinopse = :sinopse
                 WHERE id = :id";
        $param = [
            ":titulo"         => $titulo,
            ":ano_lancamento" => $ano_lancamento,
            ":poster_url"     => $poster_url,
            ":sinopse"        => $sinopse,
            ":id"             => $id
        ];
        return $this->banco->executar($sql, $param);
    }

    public function deletar($id)
    {
        $sql = "DELETE FROM filmes WHERE id = :id";
        $param = [":id" => $id];
        return $this->banco->executar($sql, $param);
    }
}
