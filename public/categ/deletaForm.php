<?php 
foreach ($parametro as $p) {
?>
    <tr>
        <td>
            <label>ID DA CATEGORIA:</label>
            <?= $p["id"] ?></td><br><br>
            <td>
            <label>NOME DA CATEGORIA:</label>
            <?= $p["nome"] ?></td><br>
        <button><a href="/sugest_filmes/categ/deletar?id=<?= $p["id"] ?>">CONFIRMAR</a></button>
    </tr>
<?php 
}
?>