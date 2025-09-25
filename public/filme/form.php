<?php
// Pega o filme_id via GET (quando clica no botão Avaliar) ou do $parametro
$filme_id_url = $_GET['filme_id'] ?? null;
$filme_id_tpl = isset($parametro[0]['filme_id']) ? $parametro[0]['filme_id'] : null;
$filme_id     = $filme_id_url ?? $filme_id_tpl ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Avaliar Filme | CineRate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --roxo:#8A2BE2; }
    * { box-sizing:border-box; margin:0; padding:0; }
    body { font-family:'Inter',sans-serif; background:#000; color:#fff; min-height:100vh; display:flex; align-items:center; justify-content:center; padding:24px; }
    .wrap { width:100%; max-width:600px; background:rgba(255,255,255,.02); border:1px solid rgba(255,255,255,.12); border-radius:14px; padding:28px; }
    h1 { font-size:26px; font-weight:800; text-align:center; margin-bottom:6px;
         background:linear-gradient(90deg,var(--roxo) 0%,#fff 100%); -webkit-background-clip:text; background-clip:text; color:transparent; }
    .subtitle { text-align:center; color:#bdbdbd; margin-bottom:18px; font-size:14px;}
    label { display:block; margin:12px 0 6px; color:#d8d8d8; font-size:14px;}
    input, select { width:100%; padding:12px; border-radius:10px; background:#000; border:1px solid rgba(255,255,255,.18); color:#fff; font-size:15px; }
    input:focus, select:focus { outline:2px solid var(--roxo); }
    .actions { display:flex; gap:10px; margin-top:18px; }
    .btn { flex:1; padding:12px; border-radius:10px; font-weight:700; cursor:pointer; text-align:center; border:1px solid rgba(255,255,255,.18); background:transparent; color:#fff; }
    .btn-primary { border-color: rgba(138,43,226,.7); }
    .btn-primary:hover { background:rgba(138,43,226,.22); }
    .btn-ghost:hover { background:rgba(255,255,255,.06); }
    .back { text-align:center; margin-top:12px; font-size:14px; }
    .back a { color:#bda7ff; text-decoration:none; } .back a:hover { text-decoration:underline; }
    .hint { color:#9ad; font-size:12px; margin-top:4px; }
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Avaliar Filme</h1>
    <div class="subtitle">Defina a nota de 0 a 5</div>

    <form method="POST" action="/sugest_filmes/avalia/inserir">
      <label for="filme_id">ID do Filme</label>
      <input type="text" id="filme_id" name="filme_id" value="<?= htmlspecialchars($filme_id) ?>" readonly>
      <div class="hint">Este campo vem do botão "Avaliar" clicado na página inicial.</div>

      <label for="categoria_id">ID da Categoria</label>
      <input type="text" id="categoria_id" name="categoria_id" value="<?= isset($parametro[0]['categoria_id']) ? htmlspecialchars($parametro[0]['categoria_id']) : '' ?>" placeholder="Ex.: 1">

      <label for="nota">Nota (0 a 5)</label>
      <input type="number" id="nota" name="nota" min="0" max="5" step="0.1" value="<?= isset($parametro[0]['nota']) ? htmlspecialchars($parametro[0]['nota']) : '' ?>" required>

      <?php if (!empty($parametro[0]['id'])): ?>
        <input type="hidden" name="id" value="<?= htmlspecialchars($parametro[0]['id']) ?>">
      <?php endif; ?>

      <div class="actions">
        <button class="btn btn-primary" type="submit">Salvar Avaliação</button>
        <a class="btn btn-ghost" href="/sugest_filmes/">Cancelar</a>
      </div>
    </form>

    <div class="back"><a href="/sugest_filmes/avalia/listar">← Ver avaliações</a></div>
  </div>
</body>
</html>
