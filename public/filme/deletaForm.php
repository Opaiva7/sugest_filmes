<?php
// espera $parametro vindo do controller/Filme.php -> deletaForm()
$p = isset($parametro[0]) ? $parametro[0] : (isset($parametro) ? $parametro : null);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Excluir Filme | CineRate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --roxo:#8A2BE2; }
    * { box-sizing:border-box; margin:0; padding:0; }
    body {
      font-family: 'Inter', sans-serif;
      background:#000;
      color:#fff;
      min-height:100vh;
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
    }
    .wrap {
      width:100%; max-width:560px;
      background:rgba(255,255,255,0.02);
      border:1px solid rgba(255,255,255,0.12);
      border-radius:14px;
      padding:28px;
      box-shadow:0 8px 24px rgba(0,0,0,0.45);
    }
    h1 {
      font-size:26px; font-weight:800; text-align:center; margin-bottom:8px;
      background: linear-gradient(90deg, var(--roxo) 0%, #fff 100%);
      -webkit-background-clip:text; background-clip:text; color:transparent;
    }
    .warning {
      margin:10px 0 18px;
      background:rgba(211,51,51,0.1);
      border:1px solid rgba(211,51,51,0.5);
      color:#ffbcbc;
      padding:12px; border-radius:10px; font-size:14px;
    }
    .card {
      padding:16px; border:1px solid rgba(255,255,255,0.12); border-radius:10px;
      background:rgba(255,255,255,0.03); margin-bottom:14px;
    }
    .row { display:grid; grid-template-columns: 120px 1fr; gap:10px; margin:6px 0; }
    .label { color:#bbb; }
    .value { color:#fff; font-weight:600; }
    .actions { display:flex; gap:10px; margin-top:14px; }
    .btn {
      flex:1; padding:12px; border-radius:10px; font-weight:700; cursor:pointer;
      text-align:center; text-decoration:none; border:1px solid rgba(255,255,255,0.18);
      background:transparent; color:#fff; transition:.2s;
    }
    .btn-danger { border-color:#d33; }
    .btn-danger:hover { background:rgba(211,51,51,0.2); }
    .btn-ghost:hover { background:rgba(255,255,255,0.06); }
    .back { text-align:center; margin-top:12px; font-size:14px; }
    .back a { color:#bda7ff; text-decoration:none; }
    .back a:hover { text-decoration:underline; }
    .empty {
      text-align:center; color:#bbb; padding:16px; border:1px dashed rgba(255,255,255,.25);
      border-radius:12px; background:rgba(255,255,255,0.03);
    }
  </style>
</head>
<body>
  <div class="wrap">
    <h1>Excluir Filme</h1>

    <?php if (!$p): ?>
      <div class="empty">Nenhum registro encontrado.</div>
      <div class="back"><a href="/sugest_filmes/filme/listar">← Voltar para Lista de Filmes</a></div>
    <?php else: ?>
      <div class="warning">
        Tem certeza que deseja <strong>excluir</strong> este filme? Esta ação não pode ser desfeita.
      </div>

      <div class="card">
        <div class="row"><div class="label">ID</div>      <div class="value"><?= htmlspecialchars($p['id']) ?></div></div>
        <div class="row"><div class="label">Título</div>  <div class="value"><?= htmlspecialchars($p['titulo']) ?></div></div>
        <div class="row"><div class="label">Ano</div>     <div class="value"><?= htmlspecialchars($p['ano_lancamento']) ?></div></div>
      </div>

      <div class="actions">
        <!-- seu controller/Filme.php usa $_GET['id'] para deletar -->
        <a class="btn btn-danger" href="/sugest_filmes/filme/deletar?id=<?= urlencode($p['id']) ?>">Confirmar Exclusão</a>
        <a class="btn btn-ghost" href="/sugest_filmes/filme/listar">Cancelar</a>
      </div>
    <?php endif; ?>

    <div class="back"><a href="/sugest_filmes/">← Página Inicial</a></div>
  </div>
</body>
</html>
