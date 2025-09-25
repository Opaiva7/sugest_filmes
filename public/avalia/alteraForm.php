<?php
foreach ($parametro as $p) {
?>

    <tr>
        <td>
            <form action="/sugest_filmes/avalia/alterar" method="POST">
                
                <label>ID DO FILME</label>
                <input type="text" name="filme_id" value="<?= $p["filme_id"] ?>">
                <label>ID DA CATEGORIA</label>
                <input type="text" name="categoria_id" value="<?= $p["categoria_id"] ?>">
                <label>NOTA</label>
                <input type="text" name="nota" value="<?= $p["nota"] ?>">
                <input type="hidden" name="id" value="<?= $p["id"] ?>">
                <button>CONFIRMAR</button>
            </form>
        </td>
    </tr>
<?php
}
?>