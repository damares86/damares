<div class="col-xl-4">
				<div class="card border-0 ">
					<div class="card-body p-4">
						<div>
							<div>
								<div class="h6 fw-bolder"><?= $blog_cat ?></div>
								<ul>
									<?php
									$post->table = "post_categories";
									$all_cat = $post->showAll('id');
									while ($row_all_cat = $all_cat->fetch(PDO::FETCH_ASSOC)) {

										extract($row_all_cat);
									?>
										<li><a href="blog.php?cat=<?= $row_all_cat['id'] ?>"><?= $row_all_cat['category_name'] ?></a></li>
									<?php

									}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>