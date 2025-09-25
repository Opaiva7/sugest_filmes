<button><a href="/sugest_filmes/categ/formulario">CADASTRAR CATEGORIA</a></button>
<td><button><a href="/sugest_filmes/">PAGINA INICIAL</a></button></td>
<br><br><br>
<table>

    <tr>
        <th>ID</th>
        <th>NOME DA CATEGORIA</th>
        <th>AÇÕES</th>
    </tr>

    <?php
    foreach ($parametro as $p) {
    ?>
        <tr>
            <td><?= $p["id"] ?></td>
            <td><?= $p["nome"] ?></td>

            <td><button><a href="/sugest_filmes/categ/formularioalterar?id=<?= $p["id"] ?>">ALTERAR</a></button></td>
            <td><button><a href="/sugest_filmes/categ/formulariodeletar?id=<?= $p["id"] ?>">DELETAR</a></button></td>
        </tr>
    <?php
    }
    ?>