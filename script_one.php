<html>
<head>
    <title>anime-se</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilo_1.css">
    <link rel="stylesheet" href="responsivo.css">

    <?php
        include 'conexao.php';

        $itens_por_pagina = 4;
        $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $offset = ($pagina - 1) * $itens_por_pagina;

          $pesquisa = isset($_GET['search']) ? trim($_GET['search']) : '';
          $pesquisaPronta = '%' . $pesquisa . '%';

        //
        $sql = "SELECT * FROM animes WHERE nm_anime LIKE :search ORDER BY nm_anime ASC LIMIT :limit OFFSET :offset";
        $stmt = $pdo->prepare($sql);
			$stmt->bindValue(':search', $pesquisaPronta, PDO::PARAM_STR);
				$stmt->bindValue(':limit', $itens_por_pagina, PDO::PARAM_INT);
					$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $todos_os_dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
		//
		
        //
        $countSql = "SELECT COUNT(*) FROM animes WHERE nm_anime LIKE :search";
        $countStmt = $pdo->prepare($countSql);
			$countStmt->bindValue(':search', $pesquisaPronta, PDO::PARAM_STR);
				$countStmt->execute();
					$total_registros = $countStmt->fetchColumn();
        $total_paginas = ceil($total_registros / $itens_por_pagina);
		//
	?>
</head>

<body>
<section>
    <header id="titulo">
        <p>ANIME-SE</p>
    </header>

    <main>
        <p>
            Navegue através deste site, e encontre os seus animes favoritos.<br>
            Além disso, desfrute das sinopses que apresentam cada história.<br>
            VAMOS NESSA!!
        </p>
    </main>

    <form method="get" action="">
        <div class='pesquisar'>
            <input 
                type="search" 
                name="search" 
                class="busca" 
                placeholder="escreva o nome do anime"
                value="<?= htmlspecialchars($pesquisa) ?>"
            >
            <button type="submit">buscar</button>
        </div>
    </form>

    <nav>
        <h2>Minha Lista</h2>
        <div>
            <?php foreach($todos_os_dados as $item): ?>
                <div class="itemDescrito">
                    <img src="<?= $item['img_anime'] ?>" alt="Imagem do anime">
                    <p>
                        <?= htmlspecialchars($item['nm_anime']) ?><br><br>
                        <?= htmlspecialchars($item['ds_anime']) ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <div id="pagination">
            <?php for ($p = 1; $p <= $total_paginas; $p++): 
                $link = "?pagina={$p}" . ($pesquisa ? "&search=" . urlencode($pesquisa) : '');
            ?>
                <a href="<?= $link ?>"><?= $p ?></a>
            <?php endfor; ?>
        </div>
    </nav>
</section>

<footer>
</footer>
</body>
</html>