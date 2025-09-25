<?php $p = isset($parametro[0]) ? $parametro[0] : (isset($parametro) ? $parametro : null); ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Alterar Filme | CineRate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --roxo:#8A2BE2; }
    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Inter',sans-serif; background:#000; color:#fff; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
    .wrap { width:100%; max-width:680px; background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.12); border-radius:14px; padding:28px; }
    h1 { font-size:26px; font-weight:800; text-align:center; margin-bottom:6px;
         background:linear-gradient(90deg,var(--roxo) 0%,#fff 100%); -webkit-background-clip:text; background-clip:text; color:transparent; }
    .subtitle { text-align:center; color:#bdbdbd; margin-bottom:18px; font-size:14px;}
    label { display:block; margin:12px 0 6px; color:#d8d8d8; font-size:14px;}
    input, textarea { width:100%; padding:12px; border-radius:10px; background:#000; border:1px solid rgba(255,255,255,.18); color:#fff; font-size:15px; }
    textarea { min-height:120px; resize:vertical; }
    input:focus, textarea:focus { outline:2px solid var(--roxo); }
    .row { display:grid; grid-template-columns: 1fr 180px 120px; gap:12px; }
    .actions { display:flex; gap:10px; margin-top:18px; }
    .btn { flex:1; padding:12px; border-radius:10px; font-weight:700; cursor:pointer; text-align:center; border:1px solid rgba(255,255,255,.18); background:transparent; color:#fff; }
    .btn-primary { border-color: rgba(138,43,226,.7); }
    .btn-primary:hover { background:rgba(138,43,226,.22); }
    .btn-ghost:hover { background:rgba(255,255,255,.06); }
    .empty { text-align:center; color:#bbb; padding:16px; border:1px dashed rgba(255,255,255,.25); border-radius:12px; background:rgba(255,255,255,.03); }
    .back { text-align:center; margin-top:12px; font-size:14px; }
    .back a { color:#bda7ff; text-decoration:none; } .back a:hover { text-decoration:underline; }
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Alterar Filme</h1>
    <div class="subtitle">Edite as informações e salve</div>

    <?php if (!$p): ?>
      <div class="empty">Nenhum registro encontrado.</div>
      <div class="back"><a href="/sugest_filmes/filme/listar">← Voltar</a></div>
    <?php else: ?>
      <form action="/sugest_filmes/filme/alterar" method="POST">
        <label for="titulo">Título</label>
        <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($p['titulo']) ?>" required>

        <div class="row">
          <div>
            <label for="ano">Ano</label>
            <input type="text" id="ano" name="ano_lancamento" value="<?= htmlspecialchars($p['ano_lancamento']) ?>" required>
          </div>
          <div>
            <label for="poster_url">URL do Pôster</label>
            <input type="url" id="poster_url" name="poster_url" value="<?= htmlspecialchars($p['poster_url'] ?? '') ?>">
          </div>
          <div>
            <label for="id">ID</label>
            <input type="text" id="id" value="<?= htmlspecialchars($p['id']) ?>" readonly>
            <input type="hidden" name="id" value="<?= htmlspecialchars($p['id']) ?>">
          </div>
        </div>

        <label for="sinopse">Sinopse</label>
        <textarea id="sinopse" name="sinopse"><?= htmlspecialchars($p['sinopse'] ?? '') ?></textarea>

        <div class="actions">
          <button class="btn btn-primary" type="submit">Salvar</button>
          <a class="btn btn-ghost" href="/sugest_filmes/filme/listar">Cancelar</a>
        </div>
      </form>
    <?php endif; ?>

    <div class="back"><a href="/sugest_filmes/">← Página Inicial</a></div>
  </div>
</body>
</html>
