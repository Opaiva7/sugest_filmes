<a href="/sugest_filmes/filme/formulario"> CADASTRAR </a>

<table>

    <tr>
        <th>ID</th>
        <th>TITULO</th>
        <th>ANO DE LANÇAMENTO</th>
        <th>AÇÕES</th>
    </tr>

    <?php
    foreach ($parametro as $p) {
    ?>

        <tr>
            <td><?= $p["id"] ?></td>
            <td><?= $p["titulo"] ?></td>
            <td><?= $p["ano_lancamento"] ?></td>
           <td><button><a href="/sugest_filmes/filme/formularioalterar?id=<?= $p["id"] ?>">ALTERAR</a></button></td>

            <td><button><a href="/sugest_filmes/filme/formulariodeletar?id=<?= $p["id"] ?>">DELETAR</a></button></td>
        </tr>
    <?php
    }
    ?>

</table>