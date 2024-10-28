<?php

require "admin/template/inc/header.php";

$limit = 3; // Numero di post per pagina
$page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
if (!$page || $page <= 0) {
	$page = 1;
}
$offset = ($page - 1) * $limit; // Calcola l'offset per la query SQL

$total_rows = 0; // Inizializza il numero totale di righe

$cat_id = filter_input(INPUT_GET, "cat");

$post->table = 'post';
$catPage = "";

if (filter_input(INPUT_GET, "cat")) {
	$post->category_id = $cat_id;
	$stmt = $post->showAllWhere('id', ['category_id'], $limit, $offset);
	$catPage = "&cat=$cat_id";
	$post->category_id = $cat_id;
	$total_rows = $post->countItem('category_id');
} else {
	$stmt = $post->showAll('id', $limit, $offset);
	$post->table = 'post';
	$total_rows = $post->countAll();
}

// Calcola il numero totale di pagine
$total_pages = ceil($total_rows / $limit);

?>
<div id="bottomContainer">
	<div id="content">
		<div id="blog">
			<?php
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
				extract($row);

				$catArr = explode(",", $row['category_id']);

				$time = $row['created'];
				$newTime = date("d/m/Y", strtotime($time));
			?>
				<h1><?= $row['title'] ?></h1>

				<p class="metainfo">*** <?= $blog_cat ?>:
					<?php
					foreach ($catArr as $arr) {
						$post->table = 'post_categories';
						$post->id = $arr;
						$stmt_cat = $post->showAllWhere('id', ['id']);
						$row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC);
						extract($row_cat);
					?>
						<b><a href="blog.php?cat=<?= $row_cat['id'] ?>"><?= $row_cat['category_name'] ?></a></b>
					<?php
					}

					?>
					*** <?= $blog_date ?>: <?= $newTime ?> ***
					<?php
					$account->id = $row['author'];
					$author_stmt = $account->showAllWhere('id', ['id']);
					$author_row = $author_stmt->fetch(PDO::FETCH_ASSOC);
					extract($author_row);
					?>
					*** <?= $blog_author ?>: <b><?= $author_row['username'] ?></b> ***
				</p>
				<div class="blog_content border-bottom">
					<?php
					if ($row['main_img'] != NULL) {
					?>
						<div class="row">
							<div class="col px-5">
								<img src="uploads/img/<?= $row['main_img'] ?>" class="post_img justify-content-center mx-auto"><br>
							</div>
						</div>
					<?php
					}
					?>
					<?php
					$post->content = $row['content'];
					$post->post_link = 'post.php?id=' . $row['id'] . $catPage . '';
					$post->limit = 400;
					$post->more = $blog_more;
					echo $post->readMore();
					?>
					<!-- <a href="post.php?id=<?= $row['id'] ?>&title=<?= $row['title'] ?><?= $catPage ?>">Continua a leggere -></a> -->
				</div>
			<?php
			}
			if ($total_pages > 1) {
			?>
				<!-- Paginazione -->
				<div class="pagination text-center">
					<ul>
						<?php if ($page > 1): ?>
							<li class="page-item"><a class="page-link" href="?page=1<?= $cat_id ? '&cat=' . $cat_id : '' ?>"><?= $blog_first ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?= $page - 1 ?><?= $cat_id ? '&cat=' . $cat_id : '' ?>"><?= $blog_previous ?></a></li>
						<?php endif; ?>

						<?php for ($i = 1; $i <= $total_pages; $i++): ?>
							<li class="page-item<?= $i == $page ? ' active' : '' ?>"><a class="page-link" href="?page=<?= $i ?><?= $cat_id ? '&cat=' . $cat_id : '' ?>"><?= $i ?></a></li>
						<?php endfor; ?>

						<?php if ($page < $total_pages): ?>
							<li class="page-item"><a class="page-link" href="?page=<?= $page + 1 ?><?= $cat_id ? '&cat=' . $cat_id : '' ?>"><?= $blog_next ?></a></li>
							<li class="page-item"><a class="page-link" href="?page=<?= $total_pages ?><?= $cat_id ? '&cat=' . $cat_id : '' ?>"><?= $blog_last ?></a></li>
						<?php endif; ?>
					</ul>
				</div>
			<?php
			}
			?>
		</div>
		<?php

		require "sidebar.php";

		?>
		<div class="clearfix"></div>
		<?php
		require "admin/template/inc/footer.php";

		?>