<?php

namespace dao\mysql;

use dao\IAvaliaDAO;
use generic\MysqlFactory;

class AvaliaDAO extends MysqlFactory implements IAvaliaDAO
{



    public function listarAvaliacoes()
    {
        $sql = "SELECT id, filme_id, categoria_id, nota FROM avaliacoes";
        $retorno = $this->banco->executar($sql);
        return $retorno;
    }

    public function listarId($id)
    {
        $sql = "SELECT id, filme_id, categoria_id, nota FROM avaliacoes WHERE id =:id";
        $param = [
            ":id" => $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function inserir($filme_id, $categoria_id, $nota)
    {
        $sql = "INSERT INTO avaliacoes (filme_id, categoria_id, nota) VALUES (:filme_id,:categoria_id, :nota)";
        $param = [
            ":filme_id" => $filme_id,
            ":categoria_id" => $categoria_id,
            ":nota" => $nota
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function alterar($id, $filme_id, $categoria_id, $nota){

        $sql = "UPDATE avaliacoes SET filme_id = :filme_id, categoria = :categoria_id, nota = :nota WHERE id = :id";
        $param = [
            ":filme_id"=> $filme_id,
            ":categoria_id"=> $categoria_id,
            ":nota"=> $nota,
            ":id"=> $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function deletar($id){

        $sql = "DELETE FROM avaliacoes WHERE id=:id";
        $param=[
            ":id"=>$id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }



}
