<form method="POST" action="/sugest_filmes/avalia/inserir">


    <label>ID DO FILME</label>
    <input type="text" name="filme_id"
        value="<?= ($parametro != null) ? $parametro[0]["filme_id"] : "" ?>" />
    <br />

    <label>ID DA CATEGORIA</label>
    <input type="text" name="categoria_id"
        value="<?= ($parametro != null) ? $parametro[0]["categoria_id"] : "" ?>" />
    <br />

    <label>NOTA</label>
    <input type="text" name="nota"
        value="<?= ($parametro != null) ? $parametro[0]["nota"] : "" ?>" />
    <br />

    <?php
    if ($parametro != null) {
    ?>
        <input type="hidden" name="id" value="<?= $parametro[0]["id"] ?>" />
    <?php
    }
    ?>

    <button>CADASTRAR</button>

</form>