                <div id="header-wrapper">
					<header id="header" class="container">

						<!-- Logo -->
							<div id="logo">
							<a href="<?=$root?>index.php">
                          		  <img src="<?=$root?>assets/<?= $theme ?>/img/logo.svg">
                       	 </a>
							</div>

						<!-- Nav -->
							<nav id="nav">
                            <?php
                                require "".$root."admin/template/inc/menu.php";
                            ?>
							</nav>
					</header>
				</div>