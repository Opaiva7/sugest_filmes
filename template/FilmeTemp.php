<?php

namespace template;

class FilmeTemp implements ITemplate
{
    public function cabecalho() { /* opcional */ }

    public function rodape() { /* opcional */ }

    public function layout($caminho, $parametro = null)
    {
        $base = rtrim($_SERVER['DOCUMENT_ROOT'], "/\\") . DIRECTORY_SEPARATOR . 'sugest_filmes';
        $rel  = ltrim(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $caminho), DIRECTORY_SEPARATOR);
        $full = $base . DIRECTORY_SEPARATOR . $rel;

        $this->cabecalho();

        if (is_file($full)) {
            // Torna $parametro acessível no include
            $parametro = $parametro;
            include $full;
        } else {
            echo "<pre style='color:#f66'>Arquivo não encontrado:\n{$full}\n</pre>";
        }

        $this->rodape();
    }
}
