<?php
session_start();

/******************************************************
 * Configuração de Banco (XAMPP padrão)
 *****************************************************/
const DB_HOST = '127.0.0.1';
const DB_NAME = 'sugest_filmes';
const DB_USER = 'root';
const DB_PASS = ''; // XAMPP padrão

/******************************************************
 * Conexão PDO + helpers
 *****************************************************/
function pdo()
{
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    }
    return $pdo;
}

function posterUrlFinal($id, $poster_url = null)
{
    if ($poster_url && filter_var($poster_url, FILTER_VALIDATE_URL)) return $poster_url;
    $seed = ($id % 5) + 1;
    return "http://static.photos/black/640x360/{$seed}";
}

/******************************************************
 * Carregar filmes (para o <select>) e filme focado
 *****************************************************/
$filmes = [];
try {
    $filmes = pdo()->query("SELECT id, titulo, ano_lancamento, poster_url FROM filmes ORDER BY titulo ASC")->fetchAll();
} catch (Throwable $e) {
    $filmes = [];
}

$filmeIdPre = isset($_GET['filme_id']) ? (int)$_GET['filme_id'] : null;

/******************************************************
 * POST: inserir avaliação
 *****************************************************/
$flash_ok = $flash_err = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filme_id     = (int)($_POST['filme_id'] ?? 0);
    $categoria_id = (int)($_POST['categoria_id'] ?? 1);
    $nota         = (int)($_POST['nota'] ?? 0);

    if ($filme_id <= 0 || $nota < 1 || $nota > 5) {
        $flash_err = "Escolha um filme e uma nota entre 1 e 5.";
    } else {
        try {
            $sql = "INSERT INTO avaliacoes (filme_id, categoria_id, nota) VALUES (:f,:c,:n)";
            $st  = pdo()->prepare($sql);
            $st->execute([
                ':f' => $filme_id,
                ':c' => $categoria_id ?: 1,
                ':n' => $nota
            ]);
            $flash_ok   = "Avaliação registrada com sucesso!";
            $filmeIdPre = $filme_id; // mantém o selecionado
        } catch (Throwable $e) {
            $flash_err = "Erro ao salvar: " . $e->getMessage();
        }
    }
}

/******************************************************
 * Buscar dados do filme selecionado (se houver)
 *****************************************************/
$filmeSelecionado = null;
if ($filmeIdPre) {
    foreach ($filmes as $f) {
        if ((int)$f['id'] === $filmeIdPre) { $filmeSelecionado = $f; break; }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>CineRate | Avaliar Filme</title>

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Feather -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- CSS das avaliações (corrigido o <link>) -->
  <link rel="stylesheet" href="/sugest_filmes/Front-and/css/avaliacoes.css" />

  <style>
    /* estrelas (inputs radio) simples */
    .stars { display: inline-flex; flex-direction: row-reverse; gap: 6px; }
    .stars input { display: none; }
    .stars label {
      cursor: pointer; font-size: 28px; line-height: 1;
      color: #666;
      transition: transform .1s ease-in-out;
    }
    .stars label:hover { transform: scale(1.1); }
    .stars input:checked ~ label,
    .stars label:hover,
    .stars label:hover ~ label { color: #facc15; } /* amarelo */
  </style>
</head>
<body class="min-h-screen bg-black text-white">
  <!-- Navbar -->
  <nav class="bg-black border-b border-purple-500/30 fixed w-full z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <span class="text-2xl font-bold gradient-text select-none">CineRate</span>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="/sugest_filmes/" class="text-white/80 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Início</a>
              <a href="/sugest_filmes/filme/listar" class="text-white/80 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Filmes</a>
              <a href="/sugest_filmes/avaliar.php" class="text-white px-3 py-2 rounded-md text-sm font-medium">Avaliações</a>
              <a href="#" class="text-white/80 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
            </div>
          </div>
        </div>
        <div class="-mr-2 flex md:hidden">
          <button id="btnMobileMenu" type="button" aria-controls="mobileMenu" aria-expanded="false"
                  class="inline-flex items-center justify-center p-2 rounded-md text-white/70 hover:text-white hover:bg-white/5 focus:outline-none">
            <i data-feather="menu"></i>
            <span class="sr-only">Abrir menu</span>
          </button>
        </div>
      </div>
    </div>
    <div id="mobileMenu" class="md:hidden hidden bg-black border-t border-white/10">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="/sugest_filmes/" class="block text-white/80 hover:text-white px-3 py-2 rounded-md text-base font-medium">Início</a>
        <a href="/sugest_filmes/filme/listar" class="block text-white/80 hover:text-white px-3 py-2 rounded-md text-base font-medium">Filmes</a>
        <a href="/sugest_filmes/avaliar.php" class="block text-white px-3 py-2 rounded-md text-base font-medium">Avaliações</a>
        <a href="#" class="block text-white/80 hover:text-white px-3 py-2 rounded-md text-base font-medium">Sobre</a>
      </div>
    </div>
  </nav>

  <main class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-3xl mx-auto">
    <h1 class="text-3xl font-extrabold">Avaliar Filme</h1>
    <p class="text-white/70 mt-1">Selecione o filme, escolha a nota e confirme.</p>

    <?php if ($flash_ok): ?>
      <div class="mt-4 border border-emerald-500/40 bg-emerald-500/10 text-emerald-200 rounded-md px-3 py-2">
        <?php echo htmlspecialchars($flash_ok); ?>
      </div>
    <?php endif; ?>
    <?php if ($flash_err): ?>
      <div class="mt-4 border border-red-500/40 bg-red-500/10 text-red-200 rounded-md px-3 py-2">
        <?php echo htmlspecialchars($flash_err); ?>
      </div>
    <?php endif; ?>

    <div class="mt-6 rounded-xl border border-white/10 p-5">
      <!-- action aponta para o próprio arquivo -->
      <form method="POST" action="/sugest_filmes/avaliar.php" class="space-y-4">
        <div>
          <label class="block text-sm text-white/80 mb-1">Filme</label>
          <select name="filme_id" required
                  class="w-full bg-black border border-white/15 rounded-md px-3 py-2 text-white">
            <option value="">Selecione…</option>
            <?php foreach ($filmes as $f): ?>
              <option value="<?php echo (int)$f['id']; ?>"
                <?php echo ($filmeIdPre && (int)$f['id'] === $filmeIdPre) ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($f['titulo']); ?> (<?php echo (int)$f['ano_lancamento']; ?>)
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="md:col-span-2">
            <label class="block text-sm text-white/80 mb-1">Categoria (opcional)</label>
            <input type="number" name="categoria_id" min="1" step="1" placeholder="1"
                   class="w-full bg-black border border-white/15 rounded-md px-3 py-2 text-white" />
            <p class="text-xs text-white/50 mt-1">Se não usar categorias, deixe como 1.</p>
          </div>

          <div>
            <label class="block text-sm text-white/80 mb-1">Nota</label>
            <div class="stars" aria-label="Nota de 1 a 5">
              <input type="radio" id="star5" name="nota" value="5"><label for="star5">★</label>
              <input type="radio" id="star4" name="nota" value="4"><label for="star4">★</label>
              <input type="radio" id="star3" name="nota" value="3"><label for="star3">★</label>
              <input type="radio" id="star2" name="nota" value="2"><label for="star2">★</label>
              <input type="radio" id="star1" name="nota" value="1" checked><label for="star1">★</label>
            </div>
          </div>
        </div>

        <?php if ($filmeSelecionado): ?>
          <div class="mt-4 flex items-center gap-4">
            <img src="<?php echo htmlspecialchars(posterUrlFinal($filmeSelecionado['id'], $filmeSelecionado['poster_url'] ?? null)); ?>"
                 alt="Poster" class="w-[160px] h-[96px] object-cover rounded-lg ring-1 ring-white/10">
            <div>
              <div class="font-semibold"><?php echo htmlspecialchars($filmeSelecionado['titulo']); ?></div>
              <div class="text-white/60 text-sm">(<?php echo (int)$filmeSelecionado['ano_lancamento']; ?>)</div>
            </div>
          </div>
        <?php endif; ?>

        <div class="pt-2">
          <button class="w-full bg-transparent hover:bg-white/5 text-white py-2 px-4 rounded border border-purple-500/60 flex items-center justify-center">
            <i data-feather="check" class="mr-2 w-4 h-4"></i> Confirmar avaliação
          </button>
        </div>
      </form>

      <div class="mt-3 text-center">
        <a href="/sugest_filmes/" class="text-white/70 hover:text-white text-sm">← Voltar</a>
      </div>
    </div>
  </main>

  <script>
    feather.replace();
    const btnMobile = document.getElementById('btnMobileMenu');
    const mobileMenu = document.getElementById('mobileMenu');
    btnMobile?.addEventListener('click', () => {
      const isHidden = mobileMenu.classList.contains('hidden');
      mobileMenu.classList.toggle('hidden');
      btnMobile.setAttribute('aria-expanded', String(isHidden));
    });
  </script>
</body>
</html>
