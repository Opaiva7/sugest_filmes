<button><a href="/sugest_filmes/avalia/formulario">CADASTRAR AVALIAÇÃO</a></button>
<td><button><a href="/sugest_filmes/">PAGINA INICIAL</a></button></td>
<br><br><br>
<table>

    <tr>
        <th>ID</th>
        <th>ID DO FILME</th>
        <th>ID DA CATEGORIA</th>
        <th>NOTA DO FILME</th>
        <th>AÇÕES</th>
    </tr>

    <?php
    foreach ($parametro as $p) {
    ?>
        <tr>
            <td><?= $p["id"] ?></td>
            <td><?= $p["filme_id"] ?></td>
            <td><?= $p["categoria_id"] ?></td>
            <td><?= $p["nota"] ?></td>

            <td><button><a href="/sugest_filmes/avalia/formularioalterar?id=<?= $p["id"] ?>">ALTERAR</a></button></td>
            <td><button><a href="/sugest_filmes/avalia/formulariodeletar?id=<?= $p["id"] ?>">DELETAR</a></button></td>
        </tr>
    <?php
    }
    ?>

</table>