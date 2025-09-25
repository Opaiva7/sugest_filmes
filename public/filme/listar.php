<!-- public/filme/listar.php -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Filmes (Grade) | CineRate</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    :root { --roxo:#8A2BE2; }
    * { box-sizing: border-box; }
    body {
      margin:0; padding:32px 20px; min-height:100vh;
      background:#000; color:#fff; font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
    }
    h1{
      margin:0 0 16px; text-align:center; font-weight:800; font-size:28px;
      background:linear-gradient(90deg,var(--roxo) 0%, #fff 100%);
      -webkit-background-clip:text; background-clip:text; color:transparent;
    }
    .topbar{
      max-width:1200px; margin:0 auto 18px; display:flex; gap:10px; justify-content:space-between; align-items:center;
    }
    .topbar a, .topbar button{
      display:inline-flex; align-items:center; justify-content:center;
      padding:10px 14px; border-radius:10px; text-decoration:none; cursor:pointer;
      border:1px solid rgba(255,255,255,.18); color:#fff; background:transparent; font-weight:600;
    }
    .topbar a:hover, .topbar button:hover { background:rgba(255,255,255,.06); }
    .topbar .primary { border-color: rgba(138,43,226,.7); }
    .container{ max-width:1200px; margin:0 auto; }

    /* Grade responsiva */
    .grid{
      display:grid;
      grid-template-columns: repeat(2, minmax(0,1fr));
      gap:18px;
    }
    @media (min-width:640px){ .grid{ grid-template-columns: repeat(3, minmax(0,1fr)); } }
    @media (min-width:1024px){ .grid{ grid-template-columns: repeat(4, minmax(0,1fr)); } }

    /* Card */
    .card{
      border:1px solid rgba(255,255,255,.12);
      border-radius:14px; overflow:hidden; background:rgba(255,255,255,.02);
      transition:transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    }
    .card:hover{ transform: translateY(-4px); box-shadow:0 18px 32px rgba(0,0,0,.45); border-color:rgba(138,43,226,.45); }

    /* Poster 2:3 mantendo tamanho */
    .poster-wrap{
      position:relative; width:100%;
      /* altura auto via aspect-ratio (2:3). mantém o banner proporcional em qualquer largura */
      aspect-ratio: 2 / 3;
      background:#111;
    }
    .poster{
      position:absolute; inset:0;
      width:100%; height:100%;
      object-fit:cover; object-position:center;
      display:block;
    }

    .content{ padding:12px 12px 14px; }
    .title{ font-weight:700; font-size:16px; line-height:1.25; margin:4px 0 6px; }
    .meta{ color:#cfcfcf; font-size:13px; }
    .sinopse{
      margin-top:8px; color:#e5e5e5; font-size:13px; line-height:1.35;
      display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;
      min-height:54px;
    }

    .actions{
      display:flex; gap:8px; margin-top:12px;
    }
    .btn{
      flex:1; padding:8px 10px; border-radius:10px; font-weight:700;
      text-align:center; text-decoration:none; border:1px solid rgba(255,255,255,.18);
      color:#fff; background:transparent; transition:.18s;
    }
    .btn.edit { border-color:rgba(138,43,226,.7); }
    .btn.edit:hover { background:rgba(138,43,226,.18); }
    .btn.del  { border-color:#d33; }
    .btn.del:hover{ background:rgba(211,51,51,.18); }

    /* Mensagem vazia */
    .empty{
      border:1px dashed rgba(255,255,255,.25); border-radius:14px;
      padding:28px; text-align:center; color:#bbb; background:rgba(255,255,255,.03);
    }
  </style>
</head>
<body>

  <h1>Filmes (Grade)</h1>

  <div class="topbar">
    <a class="primary" href="/sugest_filmes/filme/formulario">+ Cadastrar Filme</a>
    <a href="/sugest_filmes/">Página Inicial</a>
  </div>

  <div class="container">
    <?php if (empty($parametro)): ?>
      <div class="empty">Nenhum filme cadastrado ainda.</div>
    <?php else: ?>
      <div class="grid">
        <?php foreach ($parametro as $p): ?>
          <?php
            $img = $p['poster_url'] ?: "http://static.photos/black/640x360/" . (($p['id'] % 5) + 1);
            $ano = htmlspecialchars($p['ano_lancamento']);
            $titulo = htmlspecialchars($p['titulo']);
            $sinopse = trim((string)($p['sinopse'] ?? ''));
          ?>
          <article class="card">
            <div class="poster-wrap">
              <img class="poster" src="<?= htmlspecialchars($img) ?>" alt="Poster de <?= $titulo ?>">
            </div>
            <div class="content">
              <div class="title"><?= $titulo ?></div>
              <div class="meta"><?= $ano !== '' ? "($ano)" : '—' ?></div>
              <p class="sinopse">
                <?= $sinopse === '' ? 'Sem sinopse.' : htmlspecialchars(mb_strimwidth($sinopse, 0, 180, '…')) ?>
              </p>
              <div class="actions">
                <a class="btn edit" href="/sugest_filmes/filme/formularioalterar?id=<?= $p['id'] ?>">Alterar</a>
                <a class="btn del"  href="/sugest_filmes/filme/formulariodeletar?id=<?= $p['id'] ?>">Deletar</a>
              </div>
            </div>
          </article>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>

</body>
</html>
