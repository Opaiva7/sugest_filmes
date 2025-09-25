<?php 


namespace dao\mysql;

use dao\ICategDAO;
use generic\MysqlFactory;

class CategDAO extends MysqlFactory implements ICategDAO
{

    public function listarCategorias()
    {
        $sql = "SELECT id, nome FROM categorias";
        $retorno = $this->banco->executar($sql);
        return $retorno;
    }

    public function listarId($id)
    {
        $sql = "SELECT id, nome FROM categorias WHERE id =:id";
        $param = [
            ":id" => $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function inserir($nome)
    {
        $sql = "INSERT INTO categorias (nome) VALUES (:nome)";
        $param = [
            ":nome" => $nome
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function alterar($id, $nome){

        $sql = "UPDATE categorias SET nome = :nome WHERE id = :id";
        $param = [
            ":nome"=> $nome,
            ":id"=> $id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }

    public function deletar($id){

        $sql = "DELETE FROM categorias WHERE id=:id";
        $param=[
            ":id"=>$id
        ];
        $retorno = $this->banco->executar($sql, $param);
        return $retorno;
    }


}


?>