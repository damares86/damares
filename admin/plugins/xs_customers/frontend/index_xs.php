<?php

session_start();

spl_autoload_register('autoloader');

function autoloader($class)
{
	include("admin/class/$class.php");
}

$database = new Database();
$db = $database->getConnection();

// recall of all the classes
$files = glob("admin/class/*.php", GLOB_BRACE);
rsort($files);

// creation of the file with all the initialization of the classes
if (!is_file('admin/inc/class_initialize.php')) {
	$file_handle = fopen('inc/class_initialize.php', 'w');
	fwrite($file_handle, '<?php');
	fwrite($file_handle, "\n");
	foreach ($files as $filename) {
		$nomefile = pathinfo($filename);
		$file = $nomefile['filename'];
		if ($file != "PhpXlsxGenerator") {
			$file_var = strtolower($file);
			fwrite($file_handle, '$' . $file_var . ' = new ' . $file . '($db);');
			fwrite($file_handle, "\n");
		}
	}
	if ($prefix) {
		fwrite($file_handle, '$common->prx = "' . $prefix . '_";');
		fwrite($file_handle, "\n");
	}
	fwrite($file_handle, "?>");
	chmod('admin/inc/class_initialize.php', 0777);
}

include "admin/inc/class_initialize.php";

$setting->name = "debug";
$dbg = $setting->showAllWhere('id', ['name']);
$row_debug = $dbg->fetch(PDO::FETCH_ASSOC);
extract($row_debug);

if ($row_debug['value'] == 1) {
	require 'admin/vendor/autoload.php';		// If installed via composer
	$debug = new \bdk\Debug(array(
		'collect' => true,
		'output' => true,
	));
}

$setting->name = "lang";
$stmt = $setting->showByName();
$lang = 'en';
if (filter_input(INPUT_GET, "l")) {
	$lang = filter_input(INPUT_GET, "l");
}

foreach (glob("locale/$lang/*.php") as $row) {
	require "$row";
}

// echo "Err";
// exit;	
if (!isset($_SESSION['customer_loggedin'])) {
	//   require 'admin/inc/customer_check_cookie.php';
	header('Location: login.php?err=noLogin');
	exit;
}
// else if (isset($_COOKIE['damares-customer-login']))
// {

//     $pieces = explode(",", $_COOKIE['damares-customer-login']);
//     $customer->id = $pieces[0];
//     $id = $pieces[0];
//     $customer->auth_token = $pieces[1];
//     if (!$customer->checkCookie() > 0) {
//       header("Location: login.php?err=noLogin");
//       exit;
//     }

//       // redirect tofix
//       // $plugin->pluginname = "role_redirect";

//       // if ($plugin->itemExists('pluginname') && $plugin->isActive() == 1) {
//       //   $stmt = $role->showAllWhere('id', ['id']);
//       //   foreach ($stmt as $row) {
//       //     if ($row['redirect'] != "none") {
//       //       header("Location: " . $row['redirect'] . "");
//       //       exit;
//       //     }
//       //   }
//       // }

//       // header("Location: index_xs.php");
//       // exit;

//   }


?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
	<meta name="robots" content="noindex, nofollow">

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="SemiColonWeb" />

	<!-- Stylesheets
			============================================= -->
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="davidemasera" />
	<!-- <link rel="icon" href="../assets/img/Xstream_Logo_Picto_Circ_Small.png" type="image/png"/> -->
	<link rel="icon" href="assets/img/Xstream_Logo_Picto_Circ_Small.png" type="image/png" />

	<!-- Stylesheets
			============================================= -->
	<link href="https://fonts.googleapis.com/css?family=Cairo:300,400,400i,700|Cairo:300,400,500,600,700|PT+Serif:400,400i&display=swap" rel="stylesheet" type="text/css" />
	<!-- <link rel="stylesheet" href="../assets/css/bootstrap.css" type="text/css" />
			<link rel="stylesheet" href="../assets/style.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/swiper.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/dark.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/font-icons.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/animate.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/magnific-popup.css" type="text/css" />
			<link rel="stylesheet" href="../assets/css/custom.css" type="text/css" /> -->
	<link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
	<link rel="stylesheet" href="assets/style.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/swiper.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/dark.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/font-icons.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/animate.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="assets/css/custom.css" type="text/css" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />


	<!-- Document Title
			============================================= -->
	<title>Area Riservata - Xstream-Labs</title>

</head>

<body class="stretched">
	<!-- Document Wrapper
	============================================= -->
	<div id="wrapper" class="clearfix">

		<!-- Header
		============================================= -->
		<header id="header" class="header-size-md" data-sticky-shrink="false">
			<div id="header-wrap">
				<div class="container">
					<div class="header-row justify-content-between">

						<!-- Logo
						============================================= -->
						<div id="logo" class="me-lg-0">
							<!-- <a href="../index.php" class="standard-logo"><img src="../assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a>
							<a href="../index.php" class="retina-logo"><img src="../assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a> -->
							<a href="../index.php" class="standard-logo"><img src="assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a>
							<a href="../index.php" class="retina-logo"><img src="assets/img/XStream_logo_horizontal.png" alt="Canvas Logo"></a>
						</div><!-- #logo end -->

						<div id="primary-menu-trigger">
							<svg class="svg-trigger" viewBox="0 0 100 100">
								<path d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20"></path>
								<path d="m 30,50 h 40"></path>
								<path d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20"></path>
							</svg>
						</div>

						<!-- Primary Navigation
						============================================= -->


						<nav class="primary-menu with-arrows">

							<ul class="menu-container">
								<li class="menu-item">
									<?php
									$lang_folder = "";
									if ($lang != "it") {
										$lang_folder = "$lang/";
									}
									?>
									<a href="../<?= $lang_folder ?>index.php" class="button button-xlarge button-circle button-border button-xstream">
										<i class="icon-arrow-left2"></i>Torna al sito
									</a>
								</li>

								<li class="menu-item">
									<a class="button button-xlarge button-circle button-border button-xstream" data-bs-toggle="modal" data-bs-target="#myModal">
										<b><i class="icon-line-log-out"></i></b>Logout
									</a>

								</li>




							</ul>

						</nav><!-- #primary-menu end -->


					</div>
				</div>
			</div>
			<div class="header-wrap-clone"></div>
		</header><!-- #header end -->



		<section>
			<div class="content-wrap noPadding" id="azienda">
				<div class="container clearfix login p-0">
					<img src="assets/img/XStream_Login_Cover.png" class="desktopVisual">
					<img src="assets/img/XStream_Login_Cover.png" class="mobileVisual">
					<!-- <img src="../assets/img/XStream_Login_Cover.png" class="desktopVisual">	
							<img src="../assets/img/XStream_Login_Cover.png" class="mobileVisual"> -->
					<div class="clear"></div>
				</div>
			</div>
		</section> <!-- #header end -->
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title" id="myModalLabel">Sei sicuro?</h4>
						<button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-hidden="true"></button>
					</div>
					<div class="modal-body">

						<p>Se confermi uscirai dall'area riservata</p>


					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
						<button type="button" class="btn btn-primary"><a href="admin/core/customer_logout.php?lang=<?= $lang ?>" class="modalOk">Conferma</a></button>
					</div>
				</div>
			</div>
		</div>
		<!-- Content
				============================================= -->
		<section id="content" class="mb-5">
			<div class="container login clearfix py-5 px-0">
				<h1 class="text-center">Area Riservata Clienti</h1>
				<p class="my-5 text-center">
					Benvenuto <strong> <?= $_SESSION['customer_name'] ?></strong><br>
					Qui puoi scaricare aggiornamenti e documentazione dei tuoi prodotti.
				</p>

				<div class="row px-5 mb-3">
					<div class="col-12 text-center">
						<h1>Prodotti</h1>
					</div>
				</div>
				<?php

				$xsproduct->table = 'product_permissions';
				$xsproduct->customers_id = $_SESSION['customer_id'];
				$stmt = $xsproduct->showAllWhere('id', ['customers_id']);

				while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
					extract($row);

					$prod_id = $row['product_id'];

					$xsproduct->table = 'product';
					$xsproduct->id = $prod_id;
					$stmt1 = $xsproduct->showAllWhere('id', ['id']);
					$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
					extract($row1);
				?>

					<div class="row prod_res_area rounded mx-5 mb-5 p-3">
						<div class="col-12 text-center">
							<img src="assets/img/products/XStream_<?= $row1['product_name'] ?>_Box.png">
						</div>
						<?php

						$xsproduct->table = "product_files_cat";
						$stmt3 = $xsproduct->showAll('id');

						while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {

							$xsproduct->table = 'product_files';
							$xsproduct->product_files_cat_id = $row3['id'];
							$xsproduct->product_id = $prod_id;

							$stmt4 = $xsproduct->showAllWhere('id', ['product_files_cat_id', 'product_id']);

							if ($stmt4->rowCount() > 0) {

								extract($row3);
								$category = ucfirst($row3['cat_name']);
						?>
								<div class="col-md-12 p-3 ">
									<div class="row prod_res_area_block">
										<div class="col-md-12 px-5 py-2 rounded mx-3">

											<h1><?= $category ?></h1>

											<table class="table table-bordered w-100">
												<thead class="thead-light">
													<th>File</th>
													<th>Download</th>
												</thead>
												<tbody>
													<?php


													while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
													?>
														<tr>
															<td><?= $row4['product_files_label'] ?></td>
															<td>
																<a href="product/download.php?user=<?= $_SESSION['customer_username'] ?>&cat=<?= $row3['cat_name'] ?>&product=<?= $row1['product_name'] ?>&filename=<?= $row4['product_files_name'] ?>" class="button button-small button-circle button-border button-xstream">
																	<i class="icon-arrow-down2"></i>Download
																</a>
															</td>
														</tr>
													<?php
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
						<?php
							}
						}
						?>
					</div>
				<?php
				}
				?>
			</div>


		</section>
		<!-- Footer
		============================================= -->
		<footer id="footer" class="grafite" data-scrollto-settings="{&quot;offset&quot;:100,&quot;speed&quot;:1250,&quot;easing&quot;:&quot;easeOutQuad&quot;}">
			<!-- Copyrights
			============================================= -->
			<div id="copyrights">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-6 mb-3">
							<div class="col-12 col-lg-auto text-center text-lg-left order-last order-lg-first">
								<!-- <img src="../assets/img/XStream_logo_horizontal.png" alt="XStream Labs Logo" class="mb-2"><br> -->
								<img src="assets/img/XStream_logo_horizontal.png" alt="XStream Labs Logo" class="mb-2"><br>
								Copyright 2018 - <?php echo date('Y'); ?> © XStream Labs
							</div>
						</div>

						<div class="col-6 col-md-3">
							<div>
								<address>
									<strong>Indirizzo</strong><br>
									XStream S.r.l.<br>
									Corso Svizzera, 185<br>
									10149 Torino<br>
								</address>
								<div class="pointer" data-toggle="modal" data-target=".bs-privacy-modal-scrollable">Privacy Policy</div>
							</div>
						</div>

						<div class="col-6 col-md-3">
							<strong>Telefono</strong>
							+39 011 0168800<br>
							<strong>Email</strong>
							company@xstream-labs.com<br>
							<strong>VAT</strong>
							11975670016
							<div class="widget clearfix">
								<a href="https://it.linkedin.com/company/xstream-labs" target="_blank" class="social-icon si-small si-rounded si-linkedin">
									<i class="icon-linkedin"></i>
									<i class="icon-linkedin"></i>
								</a>
								&nbsp; &nbsp;
								<a href="https://twitter.com/Xstream_Labs" target="_blank" class="social-icon si-small si-rounded si-twitter">
									<i class="icon-twitter"></i>
									<i class="icon-twitter"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div><!-- #copyrights end -->
		</footer>

	</div><!-- #wrapper end -->

	<!-- Go To Top
	============================================= -->
	<div id="gotoTop" class="icon-angle-up"></div>

	<!-- JavaScripts
	============================================= -->
	<script src="js/jquery.js"></script>
	<script src="js/plugins.min.js"></script>
	<script src="js/cookiealert.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TypewriterJS/2.18.0/core.min.js"></script>
	<script src="js/typewriter.js"></script>
	<!-- <script src="../js/jquery.js"></script>
	<script src="../js/plugins.min.js"></script>
	<script src="../js/cookiealert.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/TypewriterJS/2.18.0/core.min.js"></script>
	<script src="../js/typewriter.js"></script> -->

	<!-- Footer Scripts
	============================================= -->
	<script src="js/functions.js"></script>
	<!-- <script src="../js/functions.js"></script> -->


</body>

</html>