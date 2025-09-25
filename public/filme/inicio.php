<?php
/******************************************************
 * Configuração de Banco (XAMPP padrão)
 *****************************************************/
const DB_HOST = '127.0.0.1';
const DB_NAME = 'sugest_filmes';
const DB_USER = 'root';
const DB_PASS = ''; // XAMPP padrão

// Limites da UI
const GRID_QTD = 4;  // Filmes populares da semana (4 cards)
const TOP_QTD  = 5;  // Ranking Top 5

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

function fetchRandomBannerMovie()
{
    $stmt = pdo()->query("SELECT id, titulo, ano_lancamento, poster_url, sinopse FROM filmes ORDER BY RAND() LIMIT 1");
    return $stmt->fetch() ?: null;
}

function fetchGridMovies($limit = GRID_QTD)
{
    $stmt = pdo()->prepare("SELECT id, titulo, ano_lancamento, poster_url, sinopse FROM filmes ORDER BY titulo ASC LIMIT :lim");
    $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function fetchTopMovies($limit = TOP_QTD)
{
    $sql = "
        SELECT f.id, f.titulo, f.ano_lancamento, f.poster_url, f.sinopse,
               AVG(a.nota)  AS media,
               COUNT(a.id)  AS votos
        FROM filmes f
        JOIN avaliacoes a ON a.filme_id = f.id
        GROUP BY f.id
        HAVING votos > 0
        ORDER BY media DESC, votos DESC
        LIMIT :lim
    ";
    $stmt = pdo()->prepare($sql);
    $stmt->bindValue(':lim', (int)$limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

// Render de estrelas (cheias/vazias) — 0–5
function renderStars($avg = null)
{
    if ($avg === null) return '<span class="text-white/70 text-sm">—</span>';
    $rating = max(0, min(5, (float)$avg));
    $filled = (int) floor($rating);
    $empty  = 5 - $filled;

    $svgFilled = '<svg aria-hidden="true" class="w-4 h-4 inline-block text-yellow-400" viewBox="0 0 24 24" fill="currentColor"><path d="M12 .587l3.668 7.431L24 9.748l-6 5.848 1.417 8.264L12 19.771l-7.417 4.089L6 15.596 0 9.748l8.332-1.73L12 .587z"/></svg>';
    $svgEmpty  = '<svg aria-hidden="true" class="w-4 h-4 inline-block text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 17.27l6.18 3.73-1.64-7.03L21.5 9.24l-7.19-.61L12 2 9.69 8.63 2.5 9.24l4.96 4.73-1.64 7.03L12 17.27z"/></svg>';

    $html = '<div class="inline-flex align-middle">';
    for ($i = 0; $i < $filled; $i++) $html .= $svgFilled;
    for ($i = 0; $i < $empty;  $i++) $html .= $svgEmpty;
    $html .= '</div>';
    return $html;
}

// Poster final: usa poster_url se existir, senão placeholder
function posterUrlFinal($id, $poster_url = null)
{
    if ($poster_url && filter_var($poster_url, FILTER_VALIDATE_URL)) return $poster_url;
    $seed = ($id % 5) + 1;
    return "http://static.photos/black/640x360/{$seed}";
}

/******************************************************
 * Carrega dados
 *****************************************************/
$bannerMovie = null;
$gridMovies  = [];
$topMovies   = [];
$errorMsg    = null;

try {
    $bannerMovie = fetchRandomBannerMovie();
    $gridMovies  = fetchGridMovies(GRID_QTD);
    $topMovies   = fetchTopMovies(TOP_QTD);
} catch (Throwable $e) {
    $errorMsg = "Não foi possível conectar ao banco. Importe o SQL e inicie o MySQL no XAMPP.";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <title>CineRate | Avalie Filmes</title>

  <!-- Tailwind (CDN) -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Feather (ícones) -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Tailwind Custom Theme -->
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            purple: { 500: '#8A2BE2', 600: '#7B1FA2' }
          }
        }
      }
    }
  </script>

  <!-- CSS externo -->
  <link rel="stylesheet" href="/sugest_filmes/Front-and/css/PaginaPrincipal.css">
  <style>
    /* Garantir que o texto do banner fique acima do blur */
    .banner-card { position: relative; }
    .banner-card .gradient-overlay { z-index: 10; }
    .banner-card .banner-text { position:absolute; bottom:0; left:0; right:0; z-index:20; }
  </style>
</head>
<body class="min-h-screen">

  <!-- Navbar (preto sólido) -->
  <nav class="bg-black border-b border-purple-500/30 fixed w-full z-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <div class="flex items-center">
          <span class="text-2xl font-bold gradient-text select-none">CineCritic</span>
          <div class="hidden md:block">
            <div class="ml-10 flex items-baseline space-x-4">
              <a href="/sugest_filmes/" class="text-white px-3 py-2 rounded-md text-sm font-medium">Início</a>
              <a href="/sugest_filmes/filme/listar" class="text-white/80 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Filmes</a>
              <a href="/sugest_filmes/avalia/listar" class="text-white/80 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Avaliações</a>
              <a href="#" class="text-white/80 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Sobre</a>
            </div>
          </div>
        </div>

        <div class="hidden md:block">
          <button class="bg-transparent border border-purple-500/50 hover:border-purple-500 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center">
            <i data-feather="user" class="mr-2 w-4 h-4"></i> Entrar
          </button>
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

    <!-- Mobile menu -->
    <div id="mobileMenu" class="md:hidden hidden bg-black border-t border-white/10">
      <div class="px-2 pt-2 pb-3 space-y-1">
        <a href="/sugest_filmes/" class="block text-white px-3 py-2 rounded-md text-base font-medium">Início</a>
        <a href="/sugest_filmes/filme/listar" class="block text-white/80 hover:text-white px-3 py-2 rounded-md text-base font-medium">Filmes</a>
        <a href="/sugest_filmes/avalia/listar" class="block text-white/80 hover:text-white px-3 py-2 rounded-md text-base font-medium">Avaliações</a>
        <a href="#" class="block text-white/80 hover:text-white px-3 py-2 rounded-md text-base font-medium">Sobre</a>
      </div>
    </div>
  </nav>

  <!-- Hero / Banner (filme aleatório) -->
  <section class="pt-28 pb-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="grid lg:grid-cols-12 lg:gap-8 items-center">
        <div class="lg:col-span-6">
          <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-white">
            <span class="block">Compartilhe sua</span>
            <span class="block gradient-text">opinião sobre filmes</span>
          </h1>
          <p class="mt-4 text-lg text-white/80 max-w-2xl">
            Junte-se à comunidade de críticos de cinema e descubra novos filmes baseados em avaliações reais.
          </p>
          <div class="mt-8 flex flex-wrap gap-3">
            <a href="/sugest_filmes/filme/listar" class="inline-flex items-center justify-center px-8 py-3 border border-purple-500/60 text-base font-medium rounded-md text-white bg-transparent hover:bg-white/5">
              Comece a avaliar
            </a>
            <a href="/sugest_filmes/filme/listar" class="inline-flex items-center justify-center px-8 py-3 border border-white/20 text-base font-medium rounded-md text-white bg-transparent hover:bg-white/5">
              Explorar filmes
            </a>
          </div>
        </div>

        <div class="mt-10 lg:mt-0 lg:col-span-6">
          <div class="banner-card relative mx-auto w-full max-w-md rounded-lg overflow-hidden">
            <?php if ($bannerMovie): ?>
              <img class="w-full h-[420px] object-cover rounded-lg"
                   src="<?= htmlspecialchars(posterUrlFinal($bannerMovie['id'], $bannerMovie['poster_url'] ?? null)); ?>"
                   alt="Filme em destaque">
              <!-- Borrão/gradiente lateral (esquerda->direita) -->
              <div class="gradient-overlay absolute inset-0 rounded-lg" style="
                  background: linear-gradient(90deg, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.25) 45%, rgba(0,0,0,0) 70%);
                  backdrop-filter: blur(2px);
              "></div>

              <div class="banner-text p-5">
                <h3 class="text-xl font-bold text-white drop-shadow-md">
                  <?= htmlspecialchars($bannerMovie['titulo']); ?>
                  <span class="text-white/80 text-base"> (<?= (int)$bannerMovie['ano_lancamento']; ?>)</span>
                </h3>
                <?php if (!empty($bannerMovie['sinopse'])): ?>
                  <p class="mt-2 text-white/90 text-sm drop-shadow">
                    <?= htmlspecialchars(mb_strimwidth($bannerMovie['sinopse'], 0, 150, '...')); ?>
                  </p>
                <?php endif; ?>
                <div class="mt-3">
                  <button class="bg-transparent border border-purple-500/60 hover:border-purple-500 text-white px-4 py-2 rounded-md text-sm font-medium flex items-center"
                          onclick="location.href='/sugest_filmes/avalia/formulario?filme_id=<?= $bannerMovie['id'] ?>'">
                    <i data-feather='edit-2' class='mr-2 w-4 h-4'></i> Avaliar este filme
                  </button>
                </div>
              </div>
            <?php else: ?>
              <div class="w-full h-[420px] rounded-lg ring-1 ring-white/10 flex items-center justify-center text-center p-6">
                <p class="text-white/80">
                  Nenhum filme cadastrado ainda.<br/>Cadastre um filme para aparecer aqui.
                </p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <?php if ($errorMsg): ?>
        <div class="mt-6 text-red-400 text-sm"><?= htmlspecialchars($errorMsg); ?></div>
      <?php endif; ?>
    </div>
  </section>

  <!-- Top 5 (Ranking estilo Netflix) -->
  <section class="py-6 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="flex items-end justify-between">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Mais populares (Top <?= TOP_QTD; ?>)</h2>
      </div>

      <div class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 lg:grid-cols-5 gap-4">
        <?php
        $topCount = 0;
        if (!empty($topMovies)) {
            foreach ($topMovies as $idx => $m) {
                $topCount++;
                ?>
                <div class="movie-card group rounded-lg overflow-hidden">
                  <div class="relative">
                    <div class="absolute -left-2 -top-2 z-10 bg-black/70 px-2 py-1 rounded-md border border-white/10">
                      <span class="text-white font-bold text-sm"><?= $idx + 1; ?></span>
                    </div>
                    <img src="<?= htmlspecialchars(posterUrlFinal($m['id'], $m['poster_url'] ?? null)); ?>" alt="Poster"
                         class="w-full h-[220px] object-cover rounded-lg ring-1 ring-white/10" />
                  </div>
                  <div class="mt-2">
                    <h3 class="text-white text-sm font-semibold line-clamp-2"><?= htmlspecialchars($m['titulo']); ?></h3>
                    <div class="flex items-center gap-2 mt-1">
                      <?= renderStars($m['media']); ?>
                      <span class="text-white/70 text-xs">
                        <?= number_format((float)$m['media'], 1, ',', '.'); ?> (<?= (int)$m['votos']; ?>)
                      </span>
                    </div>
                    <div class="mt-3">
                      <button class="w-full bg-transparent hover:bg-white/5 text-white py-2 px-4 rounded border border-white/15 flex items-center justify-center"
                              onclick="location.href='/sugest_filmes/avalia/formulario?filme_id=<?= $m['id'] ?>'">
                        <i data-feather="edit-2" class="mr-2 w-4 h-4"></i> Avaliar
                      </button>
                    </div>
                  </div>
                </div>
                <?php
            }
        }
        // Placeholders até completar TOP_QTD
        for ($i = $topCount; $i < TOP_QTD; $i++) {
            ?>
            <div class="movie-card rounded-lg overflow-hidden">
              <div class="relative">
                <div class="absolute -left-2 -top-2 z-10 bg-black/70 px-2 py-1 rounded-md border border-white/10">
                  <span class="text-white font-bold text-sm"><?= $i + 1; ?></span>
                </div>
                <div class="w-full h-[220px] rounded-lg ring-1 ring-white/10 flex items-center justify-center text-center p-3">
                  <p class="text-white/80 text-xs">
                    Ainda não há filmes suficientes<br/>para o ranking.
                  </p>
                </div>
              </div>
              <div class="mt-2">
                <div class="h-[40px] w-full rounded-md ring-1 ring-white/10 flex items-center justify-center">
                  <span class="text-white/60 text-xs">Aguardando cadastro</span>
                </div>
              </div>
            </div>
            <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- Filmes populares da semana (4) -->
  <section class="py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="lg:text-center">
        <h2 class="text-base text-white/90 font-semibold tracking-wide uppercase">Em alta</h2>
        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-white sm:text-4xl">
          Filmes populares esta semana
        </p>
      </div>

      <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <?php
        $gridCount = 0;
        foreach ($gridMovies as $m) {
            $gridCount++;
            ?>
            <div class="movie-card rounded-lg overflow-hidden">
              <img class="w-full h-[300px] object-cover rounded-lg ring-1 ring-white/10"
                   src="<?= htmlspecialchars(posterUrlFinal($m['id'], $m['poster_url'] ?? null)); ?>" alt="Poster do filme">
              <div class="pt-3">
                <h3 class="text-xl font-bold text-white line-clamp-2"><?= htmlspecialchars($m['titulo']); ?></h3>
                <div class="flex items-center gap-2 mt-1">
                  <?= renderStars(null); ?>
                  <span class="text-white/70 text-sm">(<?= (int)$m['ano_lancamento']; ?>)</span>
                </div>
                <?php if (!empty($m['sinopse'])): ?>
                  <p class="text-white/70 text-sm mt-2">
                    <?= htmlspecialchars(mb_strimwidth($m['sinopse'], 0, 120, '...')); ?>
                  </p>
                <?php endif; ?>
                <div class="mt-4">
                  <button class="w-full bg-transparent hover:bg-white/5 text-white py-2 px-4 rounded border border-white/15 flex items-center justify-center"
                          onclick="location.href='/sugest_filmes/avalia/formulario?filme_id=<?= $m['id'] ?>'">
                    <i data-feather="edit-2" class="mr-2 w-4 h-4"></i> Avaliar
                  </button>
                </div>
              </div>
            </div>
            <?php
        }
        // Placeholders para completar 4 cards
        for ($i = $gridCount; $i < GRID_QTD; $i++) {
            ?>
            <div class="movie-card rounded-lg overflow-hidden">
              <div class="w-full h-[300px] rounded-lg ring-1 ring-white/10 flex items-center justify-center text-center p-4">
                <p class="text-white/80 text-sm">Ainda não há filmes cadastrados<br/>para preencher a grade.</p>
              </div>
              <div class="pt-3">
                <div class="h-[28px] w-full rounded-md ring-1 ring-white/10 flex items-center justify-center">
                  <span class="text-white/60 text-xs">Aguardando cadastro</span>
                </div>
              </div>
            </div>
            <?php
        }
        ?>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-14 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="rounded-xl p-8 md:p-12 border border-white/10 bg-transparent">
        <div class="md:flex md:items-center md:justify-between gap-6">
          <div class="md:w-2/3">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
              <span class="block">Pronto para compartilhar</span>
              <span class="block gradient-text">suas opiniões sobre filmes?</span>
            </h2>
            <p class="mt-3 text-lg text-white/80">
              Em breve você poderá cadastrar filmes e avaliar cada um.
            </p>
          </div>
          <div class="mt-8 md:mt-0 md:ml-8">
            <a class="w-full md:w-auto bg-transparent hover:bg-white/5 text-white px-6 py-3 rounded-lg text-lg font-medium border border-white/15 flex items-center justify-center"
               href="/sugest_filmes/filme/formulario">
              <i data-feather="user-plus" class="mr-2 w-5 h-5"></i> Cadastrar filme
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer vazio (apenas espaço em branco) -->
  <footer class="bg-transparent">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8"></div>
  </footer>

  <!-- Scripts -->
  <script>
    feather.replace();

    // Mobile menu
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
