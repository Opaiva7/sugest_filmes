<?php 
foreach ($parametro as $p) {
?>

    <tr>

        <td>
            <form action="/sugest_filmes/categ/alterar" method="POST">
                <label>NOME CATEGORIA</label>
                <input type="text" name="nome" value="<?= $p["nome"] ?>">
                <input type="hidden" name="id" value="<?= $p["id"] ?>">
                <button>CONFIRMAR</button>
            </form>
        </td>
</tr>
<?php 
}
?>