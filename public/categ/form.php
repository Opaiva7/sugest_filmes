<form action="/sugest_filmes/categ/inserir" method="POST">

    <label>NOME DA CATEGORIA</label>
    <input type="text" name="nome"
        value="<?= ($parametro != null) ? $parametro[0]["nome"] : "" ?>" />
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