<?php

namespace dao\mysql;

use dao\IAvaliaDAO;
use generic\MysqlFactory;

class AvaliaDAO extends MysqlFactory implements IAvaliaDAO
{
    public function listarAvaliacoes()
    {
        $sql = "SELECT id, filme_id, categoria_id, nota FROM avaliacoes";
        return $this->banco->executar($sql);
    }

    public function listarId($id)
    {
        $sql = "SELECT id, filme_id, categoria_id, nota FROM avaliacoes WHERE id = :id";
        $param = [":id" => $id];
        return $this->banco->executar($sql, $param);
    }

    public function inserir($filme_id, $categoria_id, $nota)
    {
        $sql = "INSERT INTO avaliacoes (filme_id, categoria_id, nota)
                VALUES (:filme_id, :categoria_id, :nota)";
        $param = [
            ":filme_id"     => $filme_id,
            ":categoria_id" => $categoria_id,
            ":nota"         => $nota
        ];
        return $this->banco->executar($sql, $param);
    }

    public function alterar($id, $filme_id, $categoria_id, $nota)
    {
        // >>> corrigido: coluna é categoria_id
        $sql = "UPDATE avaliacoes
                   SET filme_id = :filme_id,
                       categoria_id = :categoria_id,
                       nota = :nota
                 WHERE id = :id";
        $param = [
            ":filme_id"     => $filme_id,
            ":categoria_id" => $categoria_id,
            ":nota"         => $nota,
            ":id"           => $id
        ];
        return $this->banco->executar($sql, $param);
    }

    public function deletar($id)
    {
        $sql = "DELETE FROM avaliacoes WHERE id = :id";
        $param = [":id" => $id];
        return $this->banco->executar($sql, $param);
    }
}
