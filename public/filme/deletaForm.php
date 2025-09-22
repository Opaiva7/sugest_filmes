<?php

foreach ($parametro as $p) {
?>

    <tr>
        <td><?= $p["id"] ?></td>
        <td><?= $p["titulo"] ?></td>
        <td><?= $p["ano_lancamento"] ?></td>
        <button><a href="/sugest_filmes/filme/deletar?id=<?= $p["id"] ?>">CONFIRMAR</a></button>
    </tr>
<?php
}
?>




