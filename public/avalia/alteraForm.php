<?php
foreach ($parametro as $p) {
?>

    <tr>

        <td>
            <form action="/sugest_filmes/avalia/alterar" method="POST">
                <input type="text" name="nota" value="<?= $p["nota"] ?>">
                <input type="hidden" name="id" value="<?= $p["id"] ?>">
                <button>CONFIRMAR</button>
            </form>
        </td>
    </tr>
<?php
}
?>