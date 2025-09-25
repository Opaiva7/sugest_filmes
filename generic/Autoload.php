<?php
spl_autoload_register(function ($class) {
    // Converte namespace em caminho de arquivo (Windows/Linux)
    $path = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $class) . '.php';

    // Se não existir, tenta um fallback simples (apenas nome do arquivo)
    if (!is_file($path)) {
        $fallback = basename($path);
        if (is_file($fallback)) {
            $path = $fallback;
        }
    }

    if (is_file($path)) {
        include $path;
    } else {
        // Ajuda a debugar autoload
        // echo "<pre style='color:#f66'>Autoload: não encontrei {$path} para {$class}</pre>";
    }
});
