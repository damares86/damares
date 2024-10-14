                <?php
					$style_wrapper="";
					if($file_name=="index.php"){
						$style_wrapper="style=\"margin-bottom:0;\"";
					}
				?>
				
				<div id="header-wrapper" <?=$style_wrapper?>>
					<header id="header" class="container">
						<?php
						if($file_name=="index.php"){
							?>
							<!-- Logo -->
								<div id="logoIndex">
								<a href="<?=$root?>index.php">
										<img src="<?=$root?>assets/themes/<?=$mc_settings['mc_theme']?>/img/logo.png">
								</a><br>
								<h2 class="mb-5">Istituto Virginia Agnelli</h2>
								</div>
	
							<?php
						}else{
						?>
						<!-- Logo -->
							<div id="logo">
							<a href="<?=$root?>index.php">
                          		  <img src="<?=$root?>assets/themes/<?=$mc_settings['mc_theme']?>/img/logo.png">
                       	 </a>
							</div>

						<!-- Nav -->
		
							<nav id="nav">
                            <?php
                                require "".$root."admin/template/inc/menu.php";
                            ?>
							</nav>
							<?php
						}
						?>
					</header>

					<div class="clearfix"></div>
				</div>