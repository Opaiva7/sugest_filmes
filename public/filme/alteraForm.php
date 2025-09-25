<?php
foreach ($parametro as $p) {
?>

    <tr>
        <td>
            <form action="/sugest_filmes/filme/alterar" method="POST">
                <input type="text" name="titulo" value="<?= $p["titulo"] ?>"> 
                <input type="text" name="ano_lancamento" value="<?= $p["ano_lancamento"] ?>">
                <input type="hidden" name="id" value="<?= $p["id"] ?>">
                
                <button>CONFIRMAR</button>
            </form>
        </td>
    </tr>
<?php
}
?>