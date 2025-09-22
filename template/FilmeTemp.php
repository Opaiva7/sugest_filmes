<?php

namespace template;
use template\ITemplate;

class FilmeTemp implements ITemplate
{

    public function cabecalho()
    {
        echo "<div> CABEÇALHO </div>";
    }
    
    public function rodape()
    {
        echo "<div> RODAPÉ </div>";
    }

    public function layout($caminho, $parametro = null)
    {
        $this->cabecalho();
        include $_SERVER["DOCUMENT_ROOT"]."\\sugest_filmes". $caminho;
        $this->rodape();
    }
}
