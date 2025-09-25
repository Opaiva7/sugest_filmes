<?php

namespace dao\mysql;

use dao\IFilmeDAO;
use generic\MysqlFactory;

class FilmeDAO extends MysqlFactory implements IFilmeDAO
{

    public function listarFilmes()
    {

        $sql = "SELECT id, titulo, ano_lancamento FROM filmes";
        $retorno = $this->banco->executar($sql);
        return $retorno;
    }

    public function listarId($id)
    {
        $sql = "SELECT id, titulo, ano_lancamento FROM filmes WHERE id =:id";
        $param =  [
            ":id" => $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function inserir($titulo, $ano_lancamento)
    {
        $sql = "INSERT INTO filmes (titulo, ano_lancamento) VALUES (:titulo, :ano_lancamento)";
        $param = [
            
            ":titulo" => $titulo,
            ":ano_lancamento" => $ano_lancamento
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function alterar($id, $titulo, $ano_lancamento)
    {
        $sql = "UPDATE filmes SET titulo = :titulo, ano_lancamento = :ano_lancamento WHERE id = :id";
        $param = [
            ":titulo" => $titulo,
            ":ano_lancamento" => $ano_lancamento,
            ":id" => $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function deletar($id)
    {
        $sql = "DELETE FROM filmes WHERE id = :id";
        $param = [
            ":id" => $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }
}
