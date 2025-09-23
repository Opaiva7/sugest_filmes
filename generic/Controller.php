<?php 

namespace generic;

class Controller{

    private $arrChamadas = [];

    public function __construct(){

        $this->arrChamadas = [
            
            "filme/listar" => new Acao("Filme", "listar"),
            "filme/formulario" => new Acao("Filme", "formulario"),
            "filme/formularioalterar" => new Acao("Filme", "alteraForm"),
            "filme/formulariodeletar" => new Acao("Filme", "deletaForm"),
            "filme/inserir" => new Acao("Filme", "inserir"),
            "filme/alterar" => new Acao("Filme", "alterar"),
            "filme/deletar" => new Acao("Filme", "deletar"),
            "sugest_filmes/inicio" => new Acao("Filme", "inicio"),

            "avalia/listar" => new Acao("Avalia", "listar"),
            "avalia/formulario" => new Acao("Avalia", "formulario"),
            "avalia/formularioalterar" => new Acao("Avalia", "alteraForm"),
            "avalia/formulariodeletar" => new Acao("Avalia", "deletaForm"),
            "avalia/inserir" => new Acao("Avalia", "inserir"),
            "avalia/alterar" => new Acao("Avalia", "alterar"),
            "avalia/deletar" => new Acao("Avalia", "deletar"),

        ];
    }

    public function verificarChamadas($rota){

        if(isset($this->arrChamadas[$rota])){
            $acao = $this->arrChamadas[$rota];
            $acao->executar();
            return;
        }   
        echo "ROTA NÃO EXISTE";
    }
}



?>