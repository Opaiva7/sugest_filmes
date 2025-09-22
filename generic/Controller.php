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
            "sugest_filmes/inicio" => new Acao("Filme", "inicio")
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