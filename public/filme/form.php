<form method="POST" action="/sugest_filmes/filme/inserir">

    <label>FILME: </label>
    <input type="text" name="titulo"
        value="<?= ($parametro != null) ? $parametro[0]["titulo"] : "" ?>" />
    <br />

    <label>ANO LANÇAMENTO: </label>
    <input type="text" name="ano_lancamento"
        value="<?= ($parametro != null) ? $parametro[0]["ano_lancamento"] : "" ?>" />
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