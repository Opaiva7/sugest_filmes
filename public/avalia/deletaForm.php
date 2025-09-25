<?php
foreach($parametro as $p){
?>
    <tr>
        <td><?= $p["id"] ?></td>
        <td><?= $p["nota"] ?></td>
        <button><a href="/sugest_filmes/avalia/deletar?id=<?= $p["id"] ?>">CONFIRMAR</a></button>
    </tr>
<?php
}
?>